<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
        // Akan menampilkan form Izin Penelitian
        return view('pages.mahasiswa.surat-izin-penelitian.index');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input berdasarkan skema database
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
            'no_hp'                 => 'required|string|max:20',
            'alamat_lengkap'        => 'required|string',
            
            // Dokumen & Pekerjaan/Pendidikan
            'nomor_ktp'             => 'nullable|string|max:50',
            'nomor_mahasiswa'       => 'nullable|string|max:50',
            'nomor_pegawai'         => 'nullable|string|max:50',
            'pekerjaan'             => 'nullable|string|max:255',
            'pekerjaan_pendidikan'  => 'required|string|max:255',
            'institusi_pendidikan'  => 'required|string|max:255',
            'semester'              => 'nullable|string|max:50',
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
            'tinggi_badan'          => 'nullable|integer',
            'bentuk_badan'          => 'nullable|string|max:255',
            'warna_kulit'           => 'nullable|string|max:255',
            'bentuk_rambut'         => 'nullable|string|max:255',
            'bentuk_hidung'         => 'nullable|string|max:255',
            'ciri_khusus'           => 'nullable|string|max:255',
            'hobi'                  => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Ambil Layanan berdasarkan nama (Sesuaikan nama layanan dengan yang ada di DB kamu)
            // Misalnya: 'Surat Izin Penelitian'
            $layanan = Layanan::where('nama', 'LIKE', '%Izin Penelitian%')->firstOrFail();
            
            // Buat Nomor Tiket (Misal format: PEN-12052026-ABCD)
            $noTiket = 'PEN-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4));
            
            // 2. Insert ke tabel `tiket`
            $tiket = Tiket::create([
                'uuid'       => (string) Str::uuid(),
                'users_id'   => Auth::user()->uuid,
                'layanan_id' => $layanan->uuid,
                'no_tiket'   => $noTiket,
                'status'     => 'diajukan', // Sesuai enum di tabel tiket
                'deskripsi'  => 'Permohonan Izin Penelitian: ' . $request->judul_pembicara,
            ]);
        
            // 3. Insert ke tabel `surat_permohonan_izin_penelitian`
            $validatedData['uuid'] = (string) Str::uuid();
            $validatedData['tiket_id'] = $tiket->uuid;
            $validatedData['kebangsaan'] = $request->input('kebangsaan', 'Indonesia'); // Default Indonesia jika kosong
            
            SuratPermohonanIzinPenelitian::create($validatedData);
            
            // 4. Insert Riwayat Status
            RiwayatStatusTiket::create([
                'uuid'      => (string) Str::uuid(), 
                'tiket_id'  => $tiket->uuid,
                'users_id'  => Auth::user()->uuid, 
                'status'    => 'diajukan',
                'catatan'   => 'Permohonan Izin Penelitian berhasil diajukan oleh Mahasiswa'
            ]);
            
            // 5. Insert Jejak Audit
            JejakAudit::create([
                'uuid'       => (string) Str::uuid(), // Jangan lupa UUID untuk jejak audit
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