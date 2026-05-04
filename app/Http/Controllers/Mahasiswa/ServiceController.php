<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

use App\Models\Tiket;
use App\Models\Layanan;
use App\Models\SuratPermohonanIzinPenelitian;
use App\Models\RiwayatStatusTiket;
use App\Models\JejakAudit;

class ServiceController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->uuid;
        
        $draft = Tiket::where('users_id', $userId)
                      ->where('status', 'draft')
                      ->whereHas('layanan', function($q) {
                          $q->where('nama', 'LIKE', '%Izin Penelitian%');
                      })
                      ->latest()
                      ->first();

        $payloadDraft = [];
        if ($draft && $draft->payload_draft) {
            // Jika payload_draft masih berupa string JSON (misal karena query raw atau error cast)
            if (is_string($draft->payload_draft)) {
                 $payloadDraft = json_decode($draft->payload_draft, true) ?? [];
            } else {
                 // Jika sudah array (berkat model casting)
                 $payloadDraft = (array) $draft->payload_draft;
            }
        }
        
        $tiketUuid = $draft ? $draft->uuid : null;

        return view('pages.mahasiswa.surat-izin-penelitian.index', compact('payloadDraft', 'tiketUuid'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tiket_uuid'            => 'nullable|uuid',
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
            'pas_foto'              => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nomor_mahasiswa'       => 'nullable|alpha_num|max:50',
            'nomor_pegawai'         => 'nullable|digits:18',
            'pekerjaan'             => 'nullable|string|max:255',
            'pekerjaan_pendidikan'  => 'required|string|max:255',
            'institusi_pendidikan'  => 'required|string|max:255',
            'semester'              => 'nullable|integer|min:1|max:14',
            'alamat_institusi'      => 'nullable|string',
            'alamat_kantor'         => 'nullable|string',
            'kegiatan'              => 'required|string|max:255',
            'dalam_rangka'          => 'required|string|max:255',
            'judul_pembicara'       => 'required|string|max:255',
            'lokasi_kegiatan'       => 'required|string|max:255',
            'tanggal_mulai'         => 'required|date',
            'tanggal_selesai'       => 'required|date|after_or_equal:tanggal_mulai',
            'penanggung_jawab_1'    => 'required|string|max:255',
            'penanggung_jawab_2'    => 'nullable|string|max:255',
            'banyak_peserta'        => 'required|integer|min:1',
            'tinggi_badan'          => 'nullable|integer|min:50|max:250',
            'bentuk_badan'          => 'nullable|string|max:255',
            'warna_kulit'           => 'nullable|string|max:255',
            'bentuk_rambut'         => 'nullable|string|max:255',
            'bentuk_hidung'         => 'nullable|string|max:255',
            'ciri_khusus'           => 'nullable|string|max:255',
            'hobi'                  => 'nullable|string|max:255',
        ], [
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
            $userId = Auth::user()->uuid;
            $file = $request->file('pas_foto');
            
            $fileHash = hash_file('sha256', $file->path());
            $fileName = $userId . '_' . $fileHash . '.webp';
            
            $image = Image::read($file);
            $encodedImage = $image->toWebp(80); 
            
            Storage::put('private/pas_foto/' . $fileName, (string) $encodedImage);

            $validatedData['path_pas_foto'] = $fileName;
            
            $tiketUuid = $request->input('tiket_uuid');
            unset($validatedData['pas_foto'], $validatedData['tiket_uuid']);
            
            $tiket = null;
            $layanan = Layanan::where('nama', 'LIKE', '%Izin Penelitian%')->firstOrFail();
            $noTiket = 'PEN-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4));
            $aksiAudit = 'create';

            if ($tiketUuid) {
                $tiket = Tiket::where('uuid', $tiketUuid)
                              ->where('users_id', $userId)
                              ->where('status', 'draft')
                              ->first();
            }

            if ($tiket) {
                $tiket->update([
                    'no_tiket' => $noTiket,
                    'status' => 'diajukan',
                    'deskripsi' => 'Permohonan Izin Penelitian: ' . $request->judul_pembicara,
                    'payload_draft' => null
                ]);
                $aksiAudit = 'update';
            } else {
                $tiket = Tiket::create([
                    'uuid'       => (string) Str::uuid(),
                    'users_id'   => $userId,
                    'layanan_id' => $layanan->uuid,
                    'no_tiket'   => $noTiket,
                    'status'     => 'diajukan',
                    'deskripsi'  => 'Permohonan Izin Penelitian: ' . $request->judul_pembicara,
                    'payload_draft' => null
                ]);
            }
        
            $validatedData['uuid'] = (string) Str::uuid();
            $validatedData['tiket_id'] = $tiket->uuid;
            $validatedData['kebangsaan'] = $request->input('kebangsaan', 'Indonesia');
            
            SuratPermohonanIzinPenelitian::create($validatedData);
            
            RiwayatStatusTiket::create([
                'uuid'      => (string) Str::uuid(), 
                'tiket_id'  => $tiket->uuid,
                'users_id'  => $userId, 
                'status'    => 'diajukan',
                'catatan'   => 'Permohonan Izin Penelitian berhasil diajukan oleh Mahasiswa'
            ]);
            
            JejakAudit::create([
                'uuid'       => (string) Str::uuid(),
                'users_id'   => $userId,
                'aksi'       => $aksiAudit,
                'nama_tabel' => 'tiket',
                'record_id'  => $tiket->uuid,
                'data_baru'  => $tiket->toArray(),
                'ip_address' => request()->ip()
            ]);

            DB::commit();

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



    public function autosave(Request $request)
    {
        // Hanya validasi field yang diperlukan untuk identifier
        $request->validate([
            'tiket_uuid' => 'nullable|uuid',
        ]);

        DB::beginTransaction();
        try {
            $userId = Auth::user()->uuid;
            $layanan = Layanan::where('nama', 'LIKE', '%Izin Penelitian%')->firstOrFail();
            
            // Ambil semua input form, KECUALI file foto dan token untuk disimpan sbg JSON
            $payload = $request->except(['_token', 'pas_foto', 'tiket_uuid']);
            
            $tiket = null;

            // Cek apakah sudah ada tiket draft milik user ini (Mencegah IDOR)
            if ($request->filled('tiket_uuid')) {
                $tiket = Tiket::where('uuid', $request->tiket_uuid)
                            ->where('users_id', $userId)
                            ->where('status', 'draft')
                            ->first();
            }

            if (!$tiket) {
                // CREATE Tiket Draft Baru
                $noTiket = 'DRAFT-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4));
                
                $tiket = Tiket::create([
                    'uuid'          => (string) Str::uuid(),
                    'users_id'      => $userId,
                    'layanan_id'    => $layanan->uuid,
                    'no_tiket'      => $noTiket,
                    'status'        => 'draft',
                    'deskripsi'     => 'Draft Izin Penelitian',
                    'payload_draft' => $payload // Simpan semua isian ke sini
                ]);

                RiwayatStatusTiket::create([
                    'uuid'      => (string) Str::uuid(), 
                    'tiket_id'  => $tiket->uuid,
                    'users_id'  => $userId, 
                    'status'    => 'draft',
                    'catatan'   => 'Sistem menyimpan draft otomatis'
                ]);
            } else {
                // UPDATE Tiket Draft yang sudah ada
                $tiket->update([
                    'payload_draft' => $payload // Timpa JSON lama dengan yang baru
                ]);
            }

            DB::commit();

            return response()->json([
                'status'     => 'success',
                'tiket_uuid' => $tiket->uuid,
                'message'    => 'Draft tersimpan jam ' . now()->format('H:i:s')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Gagal autosave'], 500);
        }
    }
}