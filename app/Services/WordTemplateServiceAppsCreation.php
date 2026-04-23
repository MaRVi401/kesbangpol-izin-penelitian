<?php

namespace App\Services;

use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WordTemplateServiceAppsCreation
{
    /**
     * Generate dokumen Word dari MinIO berdasarkan kategori form.
     */
    public function generateDokumen($kategori, $detail, $noTiket)
    {
        $disk = Storage::disk('s3'); 
        
        // 1. Tentukan nama file template di MinIO
        // PENTING: Sesuaikan nama string ini dengan nama file yang benar-benar ada di MinIO-mu!
        if ($kategori === 'pembangunan_awal') {
            $minioPath = 'Template-Pembuatan-sistem-awal.docx'; 
        } else {
            $minioPath = 'Template-Pengembangan-fitur-apps.docx';
        }

        // Cek ketersediaan file di MinIO
        if (!$disk->exists($minioPath)) {
            Log::error("Template MinIO tidak ditemukan: " . $minioPath);
            abort(404, "Template dokumen tidak ditemukan di penyimpanan cloud (MinIO): " . $minioPath);
        }

        try {
            // 2. Tarik template dari MinIO dan buat file temporary lokal
            $tempTemplatePath = tempnam(sys_get_temp_dir(), 'Template_Apps_');
            file_put_contents($tempTemplatePath, $disk->get($minioPath));

            $templateProcessor = new TemplateProcessor($tempTemplatePath);

            // ==========================================================
            // MAPPING DATA UNTUK: PEMBANGUNAN AWAL SISTEM (PAS)
            // ==========================================================
            if ($kategori === 'pembangunan_awal') {
                
                $tanggalSurat = Carbon::parse($detail->ajuan_tgl)->locale('id')->translatedFormat('d F Y');
                
                $templateProcessor->setValue('tanggal_surat', $tanggalSurat);
                $templateProcessor->setValue('nomor_surat', $detail->ajuan_no_surat ?? '-');
                
                $templateProcessor->setValue('PAS_nama_ttd_dibawah_ini', $detail->ajuan_ttd_nama ?? '-');
                $templateProcessor->setValue('PAS_NIP_ttd_dibawah_ini', $detail->ajuan_ttd_nip ?? '-');
                
                $templateProcessor->setValue('PAS_nama_sistem', $detail->ajuan_nama_sistem ?? '-');
                $templateProcessor->setValue('PAS_keterangan_sistem', $detail->ajuan_ket_sistem ?? '-');
                
                $templateProcessor->setValue('PAS_nama_pejabat_1', $detail->ajuan_perintah_pj1_nama ?? '-');
                $templateProcessor->setValue('PAS_nip_pejabat_1', $detail->ajuan_perintah_pj1_nip ?? '-');
                $templateProcessor->setValue('PAS_jabatan_1', $detail->ajuan_perintah_pj1_jabatan ?? '-');
                
                $templateProcessor->setValue('PAS_nama_pejabat_2', $detail->ajuan_perintah_pj2_nama ?? '-');
                $templateProcessor->setValue('PAS_nip_2', $detail->ajuan_perintah_pj2_nip ?? '-');
                $templateProcessor->setValue('PAS_jabatan_2', $detail->ajuan_perintah_pj2_jabatan ?? '-');
                
                $templateProcessor->setValue('PAS_nama_skpd', $detail->ajuan_nama_skpd ?? '-');
                $templateProcessor->setValue('PAS_Ketrangan_fitur', $detail->ajuan_ket_fitur ?? '-');

                // Looping array fitur PAS
                $arrayFitur = $detail->ajuan_fitur ?? []; 
                for ($i = 1; $i <= 20; $i++) {
                    $nilaiFitur = isset($arrayFitur[$i - 1]) ? $arrayFitur[$i - 1] : '-';
                    $templateProcessor->setValue('PAS_nama_fitur_' . $i, $nilaiFitur);
                }
            } 
            // ==========================================================
            // MAPPING DATA UNTUK: PENGEMBANGAN FITUR (PPF)
            // ==========================================================
            else if ($kategori === 'pengembangan_fitur') {
                
                $tanggalSurat = Carbon::parse($detail->kembang_tgl)->locale('id')->translatedFormat('d F Y');
                
                $templateProcessor->setValue('tanggal_surat', $tanggalSurat);
                $templateProcessor->setValue('nomor_surat', $detail->kembang_no_surat ?? '-');
                
                $templateProcessor->setValue('PPF_nama_ttd_dibawah_ini', $detail->kembang_ttd_nama ?? '-');
                $templateProcessor->setValue('PPF_NIP_ttd_dibawah_ini', $detail->kembang_ttd_nip ?? '-');
                
                $templateProcessor->setValue('PPF_nama_sistem', $detail->kembang_nama_sistem ?? '-');
                $templateProcessor->setValue('PPF_keterangan_sistem', $detail->kembang_ket ?? '-');
                
                $templateProcessor->setValue('PPF_nama_pejabat_1', $detail->kembang_perintah_pj1_nama ?? '-');
                $templateProcessor->setValue('PPF_nip_pejabat_1', $detail->kembang_perintah_pj1_nip ?? '-');
                $templateProcessor->setValue('PPF_jabatan_1', $detail->kembang_perintah_pj1_jabatan ?? '-');
                
                $templateProcessor->setValue('PPF_nama_pejabat_2', $detail->kembang_perintah_pj2_nama ?? '-');
                $templateProcessor->setValue('PPF_nip_2', $detail->kembang_perintah_pj2_nip ?? '-');
                $templateProcessor->setValue('PPF_jabatan_2', $detail->kembang_perintah_pj2_jabatan ?? '-');
                
                $templateProcessor->setValue('PPF_nama_skpd', $detail->kembang_nama_skpd ?? '-');
                $templateProcessor->setValue('PPF_Ketrangan_fitur', $detail->kembang_ket_fitur ?? '-');

                // Looping array fitur PPF
                $arrayFitur = $detail->kembang_nama_fitur ?? []; 
                for ($i = 1; $i <= 20; $i++) {
                    $nilaiFitur = isset($arrayFitur[$i - 1]) ? $arrayFitur[$i - 1] : '-';
                    $templateProcessor->setValue('PPF_nama_fitur_' . $i, $nilaiFitur);
                }
            }

            // 3. Simpan hasil proses ke temporary lokal kedua
            $tempOutputPath = tempnam(sys_get_temp_dir(), 'Output_Apps_');
            $templateProcessor->saveAs($tempOutputPath);

            // Bersihkan format nama file (ubah spasi/slash jadi strip)
            $safeNoTiket = str_replace(['/', '\\', ' '], '-', $noTiket);
            $prefixName = ($kategori === 'pembangunan_awal') ? 'Pembangunan_Awal' : 'Pengembangan_Fitur';
            $fileName = 'Permohonan_' . $prefixName . '_' . $safeNoTiket . '.docx';

            // 4. Hapus file sumber (template mentah) dari temporary lokal
            unlink($tempTemplatePath);

            // 5. Download hasil dan otomatis hapus file output temporary setelah terkirim
            return response()->download($tempOutputPath, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            // Pembersihan ekstra jika terjadi error di tengah jalan
            if (isset($tempTemplatePath) && file_exists($tempTemplatePath)) unlink($tempTemplatePath);
            if (isset($tempOutputPath) && file_exists($tempOutputPath)) unlink($tempOutputPath);

            Log::error("Error Generate Dokumen S3 (Apps Creation): " . $e->getMessage());
            abort(500, "Gagal memproses dokumen pembuatan/pengembangan apps dari cloud storage.");
        }
    }
}