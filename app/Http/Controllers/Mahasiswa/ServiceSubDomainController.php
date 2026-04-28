<?php

namespace App\Http\Controllers\PenggunaAsn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\Tiket;
use App\Models\RiwayatStatusTiket;
use App\Models\Layanan;
use App\Models\DetailTiketLayananSubdomain;
use App\Services\WordTemplateServiceSubdomain;
use App\Models\JejakAudit;

class ServiceSubDomainController extends Controller
{
    protected $wordTemplateService;

    public function __construct(WordTemplateServiceSubdomain $wordTemplateService)
    {
        $this->wordTemplateService = $wordTemplateService;
    }

    public function index()
    {
        return view('pages.pengguna-asn.layanan.subdomain'); 
    }

    public function store(Request $request)
    {
        $kategori = $request->input('kategori_aktif', 'perangkat_daerah'); 

        $this->validateInput($request);

        DB::beginTransaction();
        try {
            $layanan = Layanan::where('nama', 'LIKE', '%Subdomain%')->firstOrFail();
            
            $noTiket = 'TSD-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4));
            
            $tiket = Tiket::create([
                'uuid'       => (string) Str::uuid(),
                'users_id'   => Auth::user()->uuid,
                'layanan_id' => $layanan->uuid,
                'no_tiket'   => $noTiket,
                'status'     => 'belum diajukan',
                'deskripsi'  => 'Permohonan Subdomain: ' . $request->usulan_subdomain,
            ]);
        
            $this->storeDetail($tiket->uuid, $request);
            
            RiwayatStatusTiket::create([
                'uuid'      => (string) Str::uuid(), 
                'tiket_id'  => $tiket->uuid,
                'users_id'  => Auth::user()->uuid, 
                'status'    => 'belum diajukan',
                'catatan'   => 'Permohonan baru diajukan'
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

            $downloadUrl = url('services/subdomain/download/' . $tiket->uuid); 

            return response()->json([
                'status' => 'success',
                'uuid'   => $tiket->uuid,
                'no_tiket' => $tiket->no_tiket,
                'message'=> 'Permohonan berhasil, dokumen sedang diunduh...',
                'download_url' => $downloadUrl
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    private function validateInput($request)
    {
        $request->validate([
            'nama_perangkat_daerah' => 'required|string|max:255',
            'nama_kepala_instansi'  => 'required|string|max:255',
            'alamat_instansi'       => 'required|string',
            'no_telp_instansi'      => 'required|string|min:10|max:20|regex:/^[0-9]+$/',
            'email_instansi'        => 'required|email|max:255',
            'bidang_bagian'         => 'nullable|string|max:255',
            
            'nama_pj_admin'      => 'required|string|max:255',
            'nip_pj_admin'       => 'required|string|size:18|regex:/^[0-9]+$/',
            'jabatan_pj_admin'   => 'nullable|string|max:255',
            'email_pj_admin'     => 'required|email|max:255',
            'no_telp_pj_admin'   => 'required|string|min:10|max:20|regex:/^[0-9]+$/',

            'nama_pj_teknis'        => 'required|string|max:255',
            'instansi_pj_teknis'    => 'nullable|string|max:255',
            'alamat_pj_teknis'      => 'nullable|string',
            'email_pj_teknis'       => 'required|email|max:255',
            'no_telp_pj_teknis'     => 'required|string|min:10|max:20|regex:/^[0-9]+$/',

            'usulan_subdomain' => 'required|string|max:255|regex:/^[a-zA-Z0-9\-\.]+$/',
            'alamat_subdomain' => 'required|string|max:255',
            'alamat_ip'        => 'required|ip',
            'redirect_ip'      => 'nullable|string|max:255',
            'deskripsi_singkat'=> 'required|string',

            'jenis_aplikasi'   => 'required|in:permohonan baru,ganti nama sub domain,penghapusan sub domain',
        ], [
            'alamat_ip.ip' => 'Format IP Address tidak valid.',
            'usulan_subdomain.regex' => 'Format subdomain tidak boleh mengandung spasi atau karakter unik.',
            'nip_pj_admin.regex' => 'NIP hanya boleh berisi angka.',
            'nip_pj_admin.size' => 'NIP harus terdiri dari 18 digit.',
            'no_telp_instansi.regex' => 'Nomor Telepon Instansi hanya boleh berisi angka.',
            'no_telp_instansi.min' => 'Nomor Telepon Instansi minimal 10 digit.',
            'no_telp_instansi.max' => 'Nomor Telepon Instansi tidak boleh lebih dari 20 digit.',
            'no_telp_pj_admin.regex' => 'Nomor HP/WhatsApp PJ Administratif hanya boleh berisi angka.',
            'no_telp_pj_admin.min' => 'Nomor HP/WhatsApp PJ Administratif minimal 10 digit.',
            'no_telp_pj_admin.max' => 'Nomor HP/WhatsApp PJ Administratif tidak boleh lebih dari 20 digit.',
            'no_telp_pj_teknis.regex' => 'Nomor HP/WhatsApp PJ Teknis hanya boleh berisi angka.',
            'no_telp_pj_teknis.min' => 'Nomor HP/WhatsApp PJ Teknis minimal 10 digit.',
            'no_telp_pj_teknis.max' => 'Nomor HP/WhatsApp PJ Teknis tidak boleh lebih dari 20 digit.',
        ]);
    }

    private function storeDetail($tiketUuid, $request)
    {
        $detail = new DetailTiketLayananSubdomain();
        $detail->uuid = (string) Str::uuid();
        $detail->tiket_id = $tiketUuid;
        
        $detail->no_surat = 'SDN-' . Carbon::now()->format('YmdHis');
        $detail->tanggal = Carbon::now();
        $detail->halaman = 1;

        $detail->instansi_opd          = $request->nama_perangkat_daerah;
        $detail->instansi_bidang       = $request->bidang_bagian ?? '-';
        $detail->instansi_nama_kepala  = $request->nama_kepala_instansi;
        $detail->instansi_alamat       = $request->alamat_instansi;
        $detail->instansi_telp         = $request->no_telp_instansi;
        $detail->instansi_email        = $request->email_instansi;

        $detail->pj_admin_nama         = $request->nama_pj_admin;
        $detail->pj_admin_nip          = $request->nip_pj_admin;
        $detail->pj_admin_jabatan      = $request->jabatan_pj_admin;
        $detail->pj_admin_email        = $request->email_pj_admin;
        $detail->pj_admin_telp         = $request->no_telp_pj_admin;

        $detail->pj_teknis_nama        = $request->nama_pj_teknis;
        $detail->pj_teknis_instansi    = $request->instansi_pj_teknis;
        $detail->pj_teknis_alamat      = $request->alamat_pj_teknis;
        $detail->pj_teknis_email       = $request->email_pj_teknis;
        $detail->pj_teknis_telp        = $request->no_telp_pj_teknis;

        $detail->subdomain_jenis       = $request->jenis_aplikasi;
        $detail->subdomain_nama        = $request->usulan_subdomain;
        $detail->subdomain_alamat      = $request->alamat_subdomain;
        $detail->subdomain_ip          = $request->alamat_ip;
        $detail->subdomain_redirect    = $request->redirect_ip;
        $detail->subdomain_deskripsi   = $request->deskripsi_singkat;

        $detail->save(); 
        
        return $detail;
    }

    public function download($uuid)
    {
        $tiket = Tiket::where('uuid', $uuid)->firstOrFail();
        
        $detail = DetailTiketLayananSubdomain::where('tiket_id', $tiket->uuid)->firstOrFail();

        return $this->wordTemplateService->generateDokumen($detail, $tiket->no_tiket);
    }
}