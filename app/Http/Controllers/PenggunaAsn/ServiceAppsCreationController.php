<?php

namespace App\Http\Controllers\PenggunaAsn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Tiket;
use App\Models\DetailTiketLayananPembuatanApp;
use App\Models\RiwayatStatusTiket;
use App\Models\Layanan;
use App\Services\WordTemplateServiceAppsCreation;
use App\Models\JejakAudit;

class ServiceAppsCreationController extends Controller
{
    public function index()
    {
        return view('pages.pengguna-asn.layanan.appscreation'); 
    }

    public function store(Request $request)
    {
        $kategori = $request->input('kategori_aktif');

        if (!in_array($kategori, ['pembangunan_awal', 'pengembangan_fitur'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori formulir tidak valid.'
            ], 422);
        }
        
        $this->validateInput($request, $kategori);

        DB::beginTransaction();
        try {
            $layanan = Layanan::where('nama', 'LIKE', 'Pembuatan & Pengembangan apps')->firstOrFail();
            
            $noTiket = 'TPA-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4));
            
            $jenisLayananDB = ($kategori === 'pembangunan_awal') ? 'Pembangunan Sistem Awal' : 'Pengembangan Fitur';
            
            $tiket = Tiket::create([
                'uuid'       => (string) Str::uuid(),
                'users_id'   => Auth::user()->uuid,
                'layanan_id' => $layanan->uuid,
                'no_tiket'   => $noTiket,
                'status'     => 'belum diajukan',
                'deskripsi'  => 'Pembuatan Apps - ' . $jenisLayananDB,
            ]);
        
            $this->storeDetail($tiket->uuid, $request, $kategori);
            
            RiwayatStatusTiket::create([
                'uuid'     => (string) Str::uuid(), 
                'tiket_id' => $tiket->uuid,
                'users_id' => Auth::user()->uuid, 
                'status'   => 'belum diajukan'
            ]);

            JejakAudit::create([
                'users_id' => Auth::id(),
                'aksi' => 'create',
                'nama_tabel' => 'tiket',
                'record_id' => $tiket->uuid,
                'data_baru' => $tiket->toArray(),
                'ip_address' => request()->ip()
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'uuid'   => $tiket->uuid,
                'no_tiket' => $tiket->no_tiket
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    private function validateInput($request, $kategori)
    {
        $messages = [
            'required' => 'Kolom :attribute wajib diisi.',
            'string'   => 'Kolom :attribute harus berupa teks.',
            'max'      => 'Kolom :attribute maksimal berisi :max karakter.',
            'numeric'  => 'Kolom :attribute hanya boleh berisi angka.',
            'digits'   => 'Kolom :attribute harus tepat berjumlah :digits digit angka.',
            'array'    => 'Format input :attribute tidak valid.',
            'min'      => 'Kolom :attribute minimal harus berisi :min item.'
        ];

        $attributes = [
            'ajuan_nama_skpd'            => 'Nama SKPD',
            'ajuan_ttd_nama'             => 'Nama Pejabat Penandatangan',
            'ajuan_ttd_nip'              => 'NIP Pejabat Penandatangan',
            'ajuan_perintah_pj1_nama'    => 'Nama Penanggung Jawab 1',
            'ajuan_perintah_pj1_nip'     => 'NIP Penanggung Jawab 1',
            'ajuan_perintah_pj1_jabatan' => 'Jabatan Penanggung Jawab 1',
            'ajuan_perintah_pj2_nama'    => 'Nama Penanggung Jawab 2',
            'ajuan_perintah_pj2_nip'     => 'NIP Penanggung Jawab 2',
            'ajuan_perintah_pj2_jabatan' => 'Jabatan Penanggung Jawab 2',
            'ajuan_nama_sistem'          => 'Nama Sistem Aplikasi',
            'ajuan_ket_sistem'           => 'Keterangan Sistem',
            'ajuan_fitur'                => 'Daftar Fitur',
            'ajuan_fitur.*'              => 'Isian Fitur', 
            'ajuan_ket_fitur'            => 'Keterangan Detail Fitur',

            'kembang_nama_skpd'            => 'Nama SKPD',
            'kembang_ttd_nama'             => 'Nama Pejabat Penandatangan',
            'kembang_ttd_nip'              => 'NIP Pejabat Penandatangan',
            'kembang_perintah_pj1_nama'    => 'Nama Penanggung Jawab 1',
            'kembang_perintah_pj1_nip'     => 'NIP Penanggung Jawab 1',
            'kembang_perintah_pj1_jabatan' => 'Jabatan Penanggung Jawab 1',
            'kembang_perintah_pj2_nama'    => 'Nama Penanggung Jawab 2',
            'kembang_perintah_pj2_nip'     => 'NIP Penanggung Jawab 2',
            'kembang_perintah_pj2_jabatan' => 'Jabatan Penanggung Jawab 2',
            'kembang_nama_sistem'          => 'Nama Aplikasi Saat Ini',
            'kembang_ket'                  => 'Keterangan Umum Pengembangan',
            'kembang_nama_fitur'           => 'Daftar Fitur',
            'kembang_nama_fitur.*'         => 'Isian Fitur', 
            'kembang_ket_fitur'            => 'Keterangan Detail Fitur',
        ];

        if ($kategori === 'pembangunan_awal') {
            $rules = [
                'ajuan_nama_skpd'            => 'required|string|max:255',
                'ajuan_ttd_nama'             => 'required|string|max:255',
                'ajuan_ttd_nip'              => 'required|numeric|digits:18', 
                'ajuan_perintah_pj1_nama'    => 'required|string|max:255',
                'ajuan_perintah_pj1_nip'     => 'required|numeric|digits:18', 
                'ajuan_perintah_pj1_jabatan' => 'required|string|max:255',
                'ajuan_perintah_pj2_nama'    => 'nullable|string|max:255',
                'ajuan_perintah_pj2_nip'     => 'nullable|numeric|digits:18', 
                'ajuan_perintah_pj2_jabatan' => 'nullable|string|max:255',
                'ajuan_nama_sistem'          => 'required|string|max:255',
                'ajuan_ket_sistem'           => 'required|string',
                'ajuan_fitur'                => 'required|array|min:1|max:20',
                'ajuan_fitur.*'              => 'required|string|max:255',
                'ajuan_ket_fitur'            => 'required|string',
            ];
        } else {
            $rules = [
                'kembang_nama_skpd'            => 'required|string|max:255',
                'kembang_ttd_nama'             => 'required|string|max:255',
                'kembang_ttd_nip'              => 'required|numeric|digits:18', 
                'kembang_perintah_pj1_nama'    => 'required|string|max:255',
                'kembang_perintah_pj1_nip'     => 'required|numeric|digits:18', 
                'kembang_perintah_pj1_jabatan' => 'required|string|max:255',
                'kembang_perintah_pj2_nama'    => 'nullable|string|max:255',
                'kembang_perintah_pj2_jabatan' => 'nullable|string|max:255',
                'kembang_perintah_pj2_nip'     => 'nullable|numeric|digits:18', 
                'kembang_nama_sistem'          => 'required|string|max:255',
                'kembang_ket'                  => 'required|string',
                'kembang_nama_fitur'           => 'required|array|min:1|max:20',
                'kembang_nama_fitur.*'         => 'required|string|max:255',
                'kembang_ket_fitur'            => 'required|string',
            ];
        }

        $request->validate($rules, $messages, $attributes);
    }

    private function storeDetail($tiketUuid, $request, $kategori)
    {
        $detail = new DetailTiketLayananPembuatanApp();
        $detail->uuid     = (string) Str::uuid();
        $detail->tiket_id = $tiketUuid;

        if ($kategori === 'pembangunan_awal') {
            $detail->ajuan_tgl = Carbon::now();
            $detail->ajuan_nama_sistem          = $request->ajuan_nama_sistem;
            $detail->ajuan_ket_sistem           = $request->ajuan_ket_sistem;
            $detail->ajuan_ttd_nama             = $request->ajuan_ttd_nama;
            $detail->ajuan_ttd_nip              = $request->ajuan_ttd_nip;
            $detail->ajuan_perintah_pj1_nama    = $request->ajuan_perintah_pj1_nama;
            $detail->ajuan_perintah_pj1_nip     = $request->ajuan_perintah_pj1_nip;
            $detail->ajuan_perintah_pj1_jabatan = $request->ajuan_perintah_pj1_jabatan;
            $detail->ajuan_perintah_pj2_nama    = $request->ajuan_perintah_pj2_nama;
            $detail->ajuan_perintah_pj2_nip     = $request->ajuan_perintah_pj2_nip;
            $detail->ajuan_perintah_pj2_jabatan = $request->ajuan_perintah_pj2_jabatan;
            $detail->ajuan_nama_skpd            = $request->ajuan_nama_skpd;
            $detail->ajuan_fitur                = $request->ajuan_fitur;
            $detail->ajuan_ket_fitur            = $request->ajuan_ket_fitur;
        } else {
            $detail->kembang_tgl = Carbon::now();
            $detail->kembang_ttd_nama             = $request->kembang_ttd_nama;
            $detail->kembang_ttd_nip              = $request->kembang_ttd_nip;
            $detail->kembang_nama_sistem          = $request->kembang_nama_sistem;
            $detail->kembang_ket                  = $request->kembang_ket;
            $detail->kembang_perintah_pj1_nama    = $request->kembang_perintah_pj1_nama;
            $detail->kembang_perintah_pj1_nip     = $request->kembang_perintah_pj1_nip;
            $detail->kembang_perintah_pj1_jabatan = $request->kembang_perintah_pj1_jabatan;
            $detail->kembang_perintah_pj2_nama    = $request->kembang_perintah_pj2_nama;
            $detail->kembang_perintah_pj2_nip     = $request->kembang_perintah_pj2_nip;
            $detail->kembang_perintah_pj2_jabatan = $request->kembang_perintah_pj2_jabatan;
            $detail->kembang_nama_skpd            = $request->kembang_nama_skpd;
            $detail->kembang_nama_fitur           = $request->kembang_nama_fitur;
            $detail->kembang_ket_fitur            = $request->kembang_ket_fitur;
        }
        
        $detail->save(); 
        
        return $detail;
    }

    public function download($uuid, WordTemplateServiceAppsCreation $wordService)
    {
        $tiket = Tiket::where('uuid', $uuid)->firstOrFail();
        
        $detail = DetailTiketLayananPembuatanApp::where('tiket_id', $tiket->uuid)->firstOrFail();

        $kategori = !empty($detail->ajuan_nama_skpd) ? 'pembangunan_awal' : 'pengembangan_fitur';

        return $wordService->generateDokumen($kategori, $detail, $tiket->no_tiket);
    }
}