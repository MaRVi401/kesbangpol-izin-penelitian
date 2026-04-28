<?php

namespace App\Http\Controllers\PenggunaAsn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use App\Models\Tiket;
use App\Models\Layanan;
use App\Models\RiwayatStatusTiket;
use App\Models\DetailTiketLayananPengaduanElektronik;
use App\Models\JejakAudit;

class ServiceComplaintSystemController extends Controller
{
    public function index()
    {
        return view('pages.pengguna-asn.layanan.complaint'); 
    }
 
    public function store(Request $request)
    {
        $this->validateInput($request);
        DB::beginTransaction();
        try {
            $layanan = Layanan::where('nama', 'LIKE', '%Pengaduan Sistem%')->firstOrFail();
            
            $noTiket = 'TKT-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4));
            $tiketUuid = (string) Str::uuid();

            $filePath = $this->processAndUploadImage($request);
            
            $tiket = Tiket::create([
                'uuid'       => $tiketUuid,
                'users_id'   => Auth::user()->uuid,
                'layanan_id' => $layanan->uuid,
                'no_tiket'   => $noTiket,
                'status'     => 'diajukan'
            ]);
        
            $this->storeDetail($tiket->uuid, $request, $filePath);
            
            RiwayatStatusTiket::create([
                'uuid'      => (string) Str::uuid(), 
                'tiket_id'  => $tiket->uuid,
                'users_id'  => Auth::user()->uuid, 
                'status'    => 'diajukan',
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
                'message' => 'Tiket Pengaduan Berhasil Dibuat!',
                'no_tiket' => $noTiket
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan pengaduan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function validateInput(Request $request)
    {
        $request->validate([
            'detail_pengaduan'    => 'required|string',
            'lampiran_screenshot' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ], [
            'lampiran_screenshot.mimes' => 'File harus berupa gambar (JPG, JPEG, PNG).',
            'lampiran_screenshot.image' => 'File yang diunggah harus berupa gambar.',
            'lampiran_screenshot.max'   => 'Ukuran gambar maksimal adalah 2MB.', 
        ]);
    }

    private function processAndUploadImage(Request $request)
    {
        if ($request->hasFile('lampiran_screenshot')) {
            $file = $request->file('lampiran_screenshot');
            
            $filename = Str::uuid() . '.webp';
            
            $manager = new ImageManager(new Driver());
            
            $image = $manager->read($file->getRealPath());
            
            $encodedImage = $image->toWebp(80);
            
            Storage::disk('s3')->put('pengaduan/' . $filename, $encodedImage->toString());
            
            return 'pengaduan/' . $filename;
        }

        return null;
    }

    private function storeDetail($tiketUuid, Request $request, $filePath)
    {
        $detail = new DetailTiketLayananPengaduanElektronik();
        $detail->uuid                = (string) Str::uuid();
        $detail->tiket_id            = $tiketUuid;
        $detail->detail_pengaduan    = $request->detail_pengaduan;
        $detail->lampiran_screenshot = $filePath;
        
        $detail->save(); 
        
        return $detail;
    }
}