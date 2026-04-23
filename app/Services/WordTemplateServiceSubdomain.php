<?php

namespace App\Services;

use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\DetailTiketLayananSubdomain;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class WordTemplateServiceSubdomain
{
    public function generateDokumen(DetailTiketLayananSubdomain $detail, $noTiket)
    {
        $disk = Storage::disk('s3'); 
        
        $minioPath = 'Template-Sub-Domain.docx';

        if (!$disk->exists($minioPath)) {
            Log::error("Template MinIO tidak ditemukan: " . $minioPath);
            return response()->json([
                'status' => 'error',
                'message' => 'Template dokumen tidak ditemukan di penyimpanan cloud (MinIO).'
            ], 404);
        }

        try {
            $tempTemplatePath = tempnam(sys_get_temp_dir(), 'Template_Src_');
            file_put_contents($tempTemplatePath, $disk->get($minioPath));

            $templateProcessor = new TemplateProcessor($tempTemplatePath);

            $noSurat = ($detail->no_surat == '-' || empty($detail->no_surat)) ? $noTiket : $detail->no_surat;
            $templateProcessor->setValue('no_surat', $noSurat);
            
            $tanggal = Carbon::parse($detail->tanggal)->locale('id')->translatedFormat('d F Y');
            $templateProcessor->setValue('tanggal_surat', $tanggal);
            $templateProcessor->setValue('halaman_surat', $detail->halaman ?? '1');

            $templateProcessor->setValue('DIP_OPD', $detail->instansi_opd);
            $templateProcessor->setValue('DIP_bidang_bagian_UPTD', $detail->instansi_bidang);
            $templateProcessor->setValue('DIP_Alamata', $detail->instansi_alamat); 
            $templateProcessor->setValue('DIP_No_Telp', $detail->instansi_telp);
            $templateProcessor->setValue('DIP_email', $detail->instansi_email);
            $templateProcessor->setValue('DIP_nama_kepala_dinas_bagian', $detail->instansi_nama_kepala); 

            $templateProcessor->setValue('PJA_Nama', $detail->pj_admin_nama);
            $templateProcessor->setValue('PJA_NIP', $detail->pj_admin_nip);
            $templateProcessor->setValue('PJA_Jabatan', $detail->pj_admin_jabatan);
            $templateProcessor->setValue('PJA_Email', $detail->pj_admin_email);
            $templateProcessor->setValue('PJA_No_Telp', $detail->pj_admin_telp);

            $templateProcessor->setValue('PJT_Nama', $detail->pj_teknis_nama);
            $templateProcessor->setValue('PJT_Instansi', $detail->pj_teknis_instansi);
            $templateProcessor->setValue('PJT_Alamat', $detail->pj_teknis_alamat);
            $templateProcessor->setValue('PJT_Email', $detail->pj_teknis_email);
            $templateProcessor->setValue('PJT_No_Telp', $detail->pj_teknis_telp);

            $templateProcessor->setValue('DSB_nama_sub_domain', $detail->subdomain_nama);
            $templateProcessor->setValue('DSB_alamat_sub_domain', $detail->subdomain_alamat);
            $templateProcessor->setValue('DSB_Alamat_ip', $detail->subdomain_ip);
            $templateProcessor->setValue('DSB_Redirect', $detail->subdomain_redirect ?? '-');
            $templateProcessor->setValue('DSB_deskripsi_singkat', $detail->subdomain_deskripsi);
            $templateProcessor->setValue('DSB_jenis_layanan', ucwords($detail->subdomain_jenis));

            $tempOutputPath = tempnam(sys_get_temp_dir(), 'Output_Subdomain_');
            $templateProcessor->saveAs($tempOutputPath);

            $fileName = 'Permohonan_Subdomain_' . str_replace(['/', '\\', ' '], '-', $noTiket) . '.docx';

            unlink($tempTemplatePath);

            return response()->download($tempOutputPath, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            if (isset($tempTemplatePath) && file_exists($tempTemplatePath)) unlink($tempTemplatePath);
            if (isset($tempOutputPath) && file_exists($tempOutputPath)) unlink($tempOutputPath);

            Log::error("Error Generate Dokumen S3: " . $e->getMessage());
            abort(500, "Gagal memproses dokumen dari cloud storage.");
        }
    }
}