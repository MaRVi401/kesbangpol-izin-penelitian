<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image; // Pastikan library ini sudah terinstal

// Pastikan Model di-import
use App\Models\Tiket;
use App\Models\Layanan;
use App\Models\SuratPermohonanIzinPenelitian;
use App\Models\RiwayatStatusTiket;
use App\Models\JejakAudit;

class ServiceController extends Controller
{
    public function index()
    {
        
        return view('pages.mahasiswa.surat-izin-penelitian.index');
    }

    public function store(Request $request)
    {
  
        $validatedData = $request->validate([
            // Identitas Pribadi
            'nama'                  => 'required|string|max:255',
            'nama_alias'            => 'nullable|string|max:255',
            'nama_panggilan'        => 'nullable|string|max:255',
            'tempat_lahir'          => 'required|string|max:255',
            'tanggal_lahir'         => 'required|date',
            'jenis_kelamin'         => 'required|in:Laki-laki,Perempuan',
            'agama'                 => 'required|string|max:255',
            'kebangsaan'            => 'nullable|string|max:255',
            'status_perkawinan'     => 'required|in:Kawin,Belum Kawin',
            'no_hp'                 => 'required|digits_between:10,15',
            'alamat_lengkap'        => 'required|string',
            
            // Pas Foto Baru
            'pas_foto'              => 'required|image|mimes:jpeg,png,jpg|max:2048',
            
            // Dokumen & Pekerjaan/Pendidikan
            'nomor_mahasiswa'       => 'nullable|alpha_num|max:50',
            'nomor_pegawai'         => 'nullable|digits:18',
            'pekerjaan'             => 'nullable|string|max:255',
            'pekerjaan_pendidikan'  => 'required|string|max:255',
            'institusi_pendidikan'  => 'required|string|max:255',
            'semester'              => 'nullable|integer|min:1|max:14',
            'alamat_institusi'      => 'nullable|string',
            'alamat_kantor'         => 'nullable|string',
            
            // Detail Kegiatan
            'kegiatan'              => 'required|string|max:255',
            'dalam_rangka'          => 'required|string|max:255',
            'judul_pembicara'       => 'required|string|max:255',
            'lokasi_kegiatan'       => 'required|string|max:255',
            'tanggal_mulai'         => 'required|date',
            'tanggal_selesai'       => 'required|date|after_or_equal:tanggal_mulai',
            'penanggung_jawab_1'    => 'required|string|max:255',
            'penanggung_jawab_2'    => 'nullable|string|max:255',
            'banyak_peserta'        => 'required|integer|min:1',
            
            // Ciri Fisik (Opsional)
            'tinggi_badan'          => 'nullable|integer|min:50|max:250',
            'bentuk_badan'          => 'nullable|string|max:255',
            'warna_kulit'           => 'nullable|string|max:255',
            'bentuk_rambut'         => 'nullable|string|max:255',
            'bentuk_hidung'         => 'nullable|string|max:255',
            'ciri_khusus'           => 'nullable|string|max:255',
            'hobi'                  => 'nullable|string|max:255',
        ], [
            // --- KUSTOMISASI PESAN ERROR ---
            'no_hp.digits_between'  => 'Kolom No. HP/WhatsApp harus antara 10 hingga 15 digit.',
            'pas_foto.image'        => 'File pas foto harus berupa gambar.',
            'pas_foto.max'          => 'Ukuran pas foto tidak boleh lebih dari 2MB.',
            'nomor_mahasiswa.alpha_num' => 'Nomor Mahasiswa (NIM) hanya boleh berisi huruf dan angka.',
            'nomor_pegawai.digits'  => 'Nomor Pegawai (NIP) harus tepat 18 digit.',
            'semester.integer'      => 'Semester harus berupa angka bulat.',
            'semester.min'          => 'Semester tidak boleh kurang dari 1.',
            'semester.max'          => 'Semester tidak boleh lebih dari 14.',
            'tanggal_selesai.after_or_equal' => 'Tanggal Selesai harus sama atau setelah Tanggal Mulai.',
            'banyak_peserta.min'    => 'Banyak peserta minimal 1 orang.',
            'tinggi_badan.min'      => 'Tinggi badan minimal 50 cm.',
            'tinggi_badan.max'      => 'Tinggi badan maksimal 250 cm.',
            'required'              => 'Kolom :attribute wajib diisi.'
        ]);

        
        DB::beginTransaction();
        try {
            // 2. Proses Konversi & Penyimpanan Foto
            $file = $request->file('pas_foto');
            $fileName = 'pas_foto_' . Str::uuid() . '.webp';
            
            // Membaca gambar, mengubah format, dan menyimpan ke storage/app/private
            $image = Image::read($file);
            $encodedImage = $image->toWebp(80); // Kualitas 80%
            
            Storage::put('private/pas_foto/' . $fileName, (string) $encodedImage);

            // Menambahkan path_pas_foto untuk dimasukkan ke database dan membuang key pas_foto agar tidak error di Mass Assignment
            $validatedData['path_pas_foto'] = 'private/pas_foto/' . $fileName;
            unset($validatedData['pas_foto']);

            // 3. Ambil Layanan berdasarkan nama (Sesuaikan nama layanan dengan yang ada di DB kamu)
            $layanan = Layanan::where('nama', 'LIKE', '%Izin Penelitian%')->firstOrFail();
            
            // Buat Nomor Tiket (Misal format: PEN-12052026-ABCD)
            $noTiket = 'PEN-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4));
            
            // 4. Insert ke tabel `tiket`
            $tiket = Tiket::create([
                'uuid'       => (string) Str::uuid(),
                'users_id'   => Auth::user()->uuid,
                'layanan_id' => $layanan->uuid,
                'no_tiket'   => $noTiket,
                'status'     => 'diajukan', // Sesuai enum di tabel tiket
                'deskripsi'  => 'Permohonan Izin Penelitian: ' . $request->judul_pembicara,
            ]);
        
            // 5. Insert ke tabel `surat_permohonan_izin_penelitian`
            $validatedData['uuid'] = (string) Str::uuid();
            $validatedData['tiket_id'] = $tiket->uuid;
            $validatedData['kebangsaan'] = $request->input('kebangsaan', 'Indonesia'); // Default Indonesia jika kosong
            
            SuratPermohonanIzinPenelitian::create($validatedData);
            
            // 6. Insert Riwayat Status
            RiwayatStatusTiket::create([
                'uuid'      => (string) Str::uuid(), 
                'tiket_id'  => $tiket->uuid,
                'users_id'  => Auth::user()->uuid, 
                'status'    => 'diajukan',
                'catatan'   => 'Permohonan Izin Penelitian berhasil diajukan oleh Mahasiswa'
            ]);
            
            // 7. Insert Jejak Audit
            JejakAudit::create([
                'uuid'       => (string) Str::uuid(),
                'users_id'   => Auth::id(),
                'aksi'       => 'create',
                'nama_tabel' => 'tiket',
                'record_id'  => $tiket->uuid,
                'data_baru'  => $tiket->toArray(),
                'ip_address' => request()->ip()
            ]);

            DB::commit();

            // Respon JSON untuk ditangkap oleh Javascript frontend
            return response()->json([
                'status'   => 'success',
                'uuid'     => $tiket->uuid,
                'no_tiket' => $tiket->no_tiket,
                'message'  => 'Permohonan berhasil diajukan.',
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }
}