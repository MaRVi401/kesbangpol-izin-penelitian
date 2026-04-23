<?php

namespace App\Services;

use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class WordTemplateServiceEmailGov
{
   
    public function generateDokumen($kategori, $detail, $noTiket)
    {
        
        if ($kategori === 'asn') {
            $templateName = 'Template-email-asn.docx';
        } else {
            $templateName = 'Template-Email-Instansi.docx';
        }
        $localTemplatePath = $this->fetchTemplateFromMinio($templateName);

        if (!$localTemplatePath) {
            return redirect()->back()->with('error', "Gagal mengambil template: $templateName dari MinIO.");
        }

        if ($kategori === 'asn') {
            return $this->processAsn($detail, $noTiket, $localTemplatePath);
        } else {
            return $this->processPd($detail, $noTiket, $localTemplatePath);
        }
    }

    private function fetchTemplateFromMinio($filename)
    {
        $disk = Storage::disk('s3');

        if (!$disk->exists($filename)) {
            Log::error("Template tidak ditemukan di MinIO: " . $filename);
            return false;
        }

        $content = $disk->get($filename);

        $tempPath = storage_path('app/public/temp/source_' . $filename);
        
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

      
        file_put_contents($tempPath, $content);

        return $tempPath;
    }

    /**
     * PROSES ASN
     */
    private function processAsn($detail, $noTiket, $templatePath)
    {
        $templateProcessor = new TemplateProcessor($templatePath);

        // Header
        $templateProcessor->setValue('no_surat', $detail->asn_no_surat);
        $templateProcessor->setValue('tanggal_surat', Carbon::parse($detail->asn_tgl)->locale('id')->isoFormat('D MMMM Y'));
        $templateProcessor->setValue('halaman_surat', $detail->asn_hal ?? '1');

        // Data Pemohon
        $templateProcessor->setValue('dp_nama_lengkap', $detail->asn_nama_lengkap);
        $templateProcessor->setValue('dp_nip', $detail->asn_nip);
        $templateProcessor->setValue('dp_jabatan', $detail->asn_jabatan);
        $templateProcessor->setValue('dp_instansi', $detail->asn_instansi);
        $templateProcessor->setValue('dp_no_hp_no_wa', $detail->asn_kontak);
        $templateProcessor->setValue('dp_jenis_layanan', ucwords($detail->asn_jenis_layanan));

        // Kirim ke fungsi download (bawa path template untuk dihapus nanti)
        return $this->downloadFile($templateProcessor, $noTiket, $templatePath);
    }

    /**
     * PROSES PERANGKAT DAERAH (PD)
     */
    private function processPd($detail, $noTiket, $templatePath)
    {
        $templateProcessor = new TemplateProcessor($templatePath);

        // Header
        $templateProcessor->setValue('no_surat', $detail->pd_no_surat);
        $templateProcessor->setValue('tanggal_surat', Carbon::parse($detail->pd_tgl)->locale('id')->isoFormat('D MMMM Y'));
        $templateProcessor->setValue('halaman_surat', $detail->pd_hal ?? '1');

        // Data Instansi
        $templateProcessor->setValue('dip_nama_perangkat', $detail->pd_instansi_nama);
        $templateProcessor->setValue('dip_bidang_bagian_uptd', $detail->pd_bidang ?? '-');
        $templateProcessor->setValue('dip_alamat', $detail->pd_alamat ?? '-');
        $templateProcessor->setValue('dip_no_telepon', $detail->pd_telp ?? '-');
        $templateProcessor->setValue('dip_email', $detail->pd_email ?? '-');
        $templateProcessor->setValue('dip_nama_kepala_dinas', $detail->pd_nama_kepala_instansi);

        // Data PJ
        $templateProcessor->setValue('dpje_nama', $detail->pd_pj_nama);
        $templateProcessor->setValue('dpje_nip', $detail->pd_pj_nip ?? '-');
        $templateProcessor->setValue('dpje_jabatan', $detail->pd_pj_jabatan ?? '-');
        $templateProcessor->setValue('dpje_email', $detail->pd_pj_email ?? '-');
        $templateProcessor->setValue('dpje_no_hp_no_wa', $detail->pd_pj_kontak);

        // Data Akun
        $templateProcessor->setValue('da_alasan_hapus_akun', $detail->pd_alasan_hapus_akun ?? ' ');
        $templateProcessor->setValue('da_alasan_ganti_nama_akun', $detail->pd_alasan_ganti_nama ?? ' ');
        $templateProcessor->setValue('da_usulan_nama_email', $detail->pd_usulan_email ?? ' ');
        $templateProcessor->setValue('da_jenis_layanan', $detail->pd_jenis_layanan ?? ' ');
        

        return $this->downloadFile($templateProcessor, $noTiket, $templatePath);
    }

    /**
     * FINAL STEP: Simpan Hasil, Hapus Source, Download
     */
    private function downloadFile($templateProcessor, $noTiket, $sourceTemplatePath)
    {
        $fileName = 'Formulir_' . $noTiket . '.docx';
        $tempPath = storage_path('app/public/temp/' . $fileName);
        
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        // 1. Simpan hasil generate
        $templateProcessor->saveAs($tempPath);

        // 2. HAPUS Template Mentahan
        if (file_exists($sourceTemplatePath)) {
            unlink($sourceTemplatePath);
        }

        // 3. Download dan hapus hasil generate setelah dikirim ke user
        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}