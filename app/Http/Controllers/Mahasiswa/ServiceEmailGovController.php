<?php

namespace App\Http\Controllers\PenggunaAsn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Tiket;
use App\Models\DetailTiketLayananEmailGov;
use App\Models\RiwayatStatusTiket;
use App\Models\Layanan;
use App\Services\WordTemplateServiceEmailGov;
use App\Models\JejakAudit;

class ServiceEmailGovController extends Controller
{
    protected $wordTemplateService;

    public function __construct(WordTemplateServiceEmailGov $wordTemplateService)
    {
        $this->wordTemplateService = $wordTemplateService;
    }

    public function index()
    {
        return view('pages.pengguna-asn.layanan.email-e-gov'); 
    }

    public function store(Request $request)
    {
        $kategori = $request->input('kategori_aktif');

        if (!in_array($kategori, ['asn', 'perangkat_daerah'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori formulir tidak valid.'
            ], 422);
        }
        
        $this->validateInput($request, $kategori);

        DB::beginTransaction();
        try {
            $layanan = Layanan::where('nama', 'LIKE', '%Email%')->firstOrFail();
            
            $noTiket = 'TEG-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4));
            
            $jenisLayananMap = [
                'baru' => 'permohonan baru', 'reset' => 'reset password',
                'hapus' => 'hapus akun', 'ganti' => 'ganti nama akun'
            ];
            
            $jenisRaw = ($kategori === 'asn') ? $request->asn_jenis_layanan : $request->jenis_permohonan;
            $jenisLayananDB = $jenisLayananMap[$jenisRaw] ?? 'permohonan baru';
            
            $tiket = Tiket::create([
                'uuid'       => (string) Str::uuid(),
                'users_id'   => Auth::user()->uuid,
                'layanan_id' => $layanan->uuid,
                'no_tiket'   => $noTiket,
                'status'     => 'belum diajukan',
                'deskripsi'  => ucfirst($kategori) . ' - ' . ucfirst($jenisLayananDB),
            ]);
        
            $detail = $this->storeDetail($tiket->uuid, $request, $kategori, $jenisLayananDB);
            
            RiwayatStatusTiket::create([
                'uuid' => (string) Str::uuid(), 'tiket_id' => $tiket->uuid,
                'users_id' => Auth::user()->uuid, 'status' => 'belum diajukan'
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
        $rules = [];
        if ($kategori === 'asn') {
            $rules = [
                'nama_lengkap' => 'required|string|max:255',
                'nip' => 'required|string|max:50',
                'jabatan' => 'required|string|max:255',
                'unit_kerja' => 'required|string|max:255',
                'no_hp' => 'required|string|max:20',
                'asn_jenis_layanan' => 'required|in:baru,reset,hapus',
            ];
        } else {
            $rules = [
                'nama_perangkat_daerah' => 'required|string|max:255',
                'nama_kepala_instansi'  => 'required|string|max:255',
                'nama_pj' => 'required|string|max:255',
                'no_hp_pj' => 'required|string|max:20',
                'jenis_permohonan' => 'required|in:baru,reset,hapus,ganti',
                'alasan_permohonan' => 'required_if:jenis_permohonan,hapus,ganti',
                'usulan_nama_email' => 'required_if:jenis_permohonan,ganti',
            ];
        }
        $request->validate($rules);
    }

    private function storeDetail($tiketUuid, $request, $kategori, $jenisLayananDB)
    {
        $detail = new DetailTiketLayananEmailGov();
        $detail->uuid = (string) Str::uuid();
        $detail->tiket_id = $tiketUuid;
        
        $detail->pd_no_surat = '-';  
        $detail->pd_tgl = now();      
        
        $detail->asn_no_surat = '-'; 
        $detail->asn_tgl = now();     

        if ($kategori === 'asn') {
            
            $detail->asn_nama_lengkap  = $request->nama_lengkap;
            $detail->asn_nip           = $request->nip;
            $detail->asn_jabatan       = $request->jabatan;
            $detail->asn_instansi      = $request->unit_kerja;
            $detail->asn_kontak        = $request->no_hp;
            $detail->asn_jenis_layanan = $jenisLayananDB;

        } else {
          
            $detail->pd_instansi_nama        = $request->nama_perangkat_daerah;
            $detail->pd_nama_kepala_instansi = $request->nama_kepala_instansi;
            $detail->pd_bidang               = $request->bidang_bagian; 
            $detail->pd_alamat               = $request->alamat_instansi;
            $detail->pd_telp                 = $request->no_telp_instansi;
            $detail->pd_email                = $request->email_instansi;
            
            $detail->pd_pj_nama       = $request->nama_pj;
            $detail->pd_pj_nip        = $request->nip_pj;
            $detail->pd_pj_jabatan    = $request->jabatan_pj;
            $detail->pd_pj_email      = $request->email_pj;
            $detail->pd_pj_kontak     = $request->no_hp_pj;
            $detail->pd_jenis_layanan = $jenisLayananDB;

            if ($request->jenis_permohonan == 'hapus') {
                $detail->pd_alasan_hapus_akun = $request->alasan_permohonan;
            } elseif ($request->jenis_permohonan == 'ganti') {
                $detail->pd_alasan_ganti_nama = $request->alasan_permohonan;
                $detail->pd_usulan_email      = $request->usulan_nama_email;
            }
        }
        
        $detail->save(); 
        $detail->refresh(); 
        
        return $detail;
    }

    public function download($uuid, WordTemplateServiceEmailGov $wordService)
    {
        
        $tiket = Tiket::where('uuid', $uuid)->firstOrFail();
        
        $detail = DetailTiketLayananEmailGov::where('tiket_id', $tiket->uuid)->firstOrFail();

      
        $kategori = !empty($detail->asn_nip) ? 'asn' : 'perangkat_daerah';

       
        return $wordService->generateDokumen($kategori, $detail, $tiket->no_tiket);
    }
}