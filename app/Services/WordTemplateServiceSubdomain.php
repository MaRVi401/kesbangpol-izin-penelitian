<?php

namespace App\Services;

use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\SuratPermohonanIzinPenelitian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class WordTemplateServiceIzinPenelitian
{
    public function generateDokumen(SuratPermohonanIzinPenelitian $detail, $noTiket)
    {
        $disk = Storage::disk('s3'); 
        
        // Pastikan Anda mengunggah template ini ke MinIO/S3 Anda
        $minioPath = 'Template-Izin-Penelitian.docx';

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

            // 1. Informasi Umum Surat
            $templateProcessor->setValue('no_tiket', $noTiket);
            $tanggalSekarang = Carbon::now()->locale('id')->translatedFormat('d F Y');
            $templateProcessor->setValue('tanggal_cetak', $tanggalSekarang);

            // 2. Identitas Pribadi
            $templateProcessor->setValue('Nama', $detail->nama);
            $templateProcessor->setValue('Nama_Alias', $detail->nama_alias ?? '-');
            $templateProcessor->setValue('Tempat_Lahir', $detail->tempat_lahir);
            
            $tglLahir = Carbon::parse($detail->tanggal_lahir)->locale('id')->translatedFormat('d F Y');
            $templateProcessor->setValue('Tanggal_Lahir', $tglLahir);
            
            $templateProcessor->setValue('Jenis_Kelamin', $detail->jenis_kelamin);
            $templateProcessor->setValue('Kebangsaan', $detail->kebangsaan ?? 'Indonesia');
            $templateProcessor->setValue('Agama', $detail->agama);
            $templateProcessor->setValue('Status_Perkawinan', $detail->status_perkawinan);
            $templateProcessor->setValue('Alamat_Lengkap', $detail->alamat_lengkap);
            $templateProcessor->setValue('No_HP', $detail->no_hp);

            // 3. Pekerjaan & Pendidikan
            $templateProcessor->setValue('Pekerjaan_Pendidikan', $detail->pekerjaan_pendidikan);
            $templateProcessor->setValue('Institusi', $detail->institusi_pendidikan);
            $templateProcessor->setValue('Semester', $detail->semester ?? '-');
            $templateProcessor->setValue('Alamat_Institusi', $detail->alamat_institusi ?? '-');
            $templateProcessor->setValue('No_Mhs', $detail->nomor_mahasiswa ?? '-');
            $templateProcessor->setValue('No_KTP', $detail->nomor_ktp ?? '-');

            // 4. Detail Kegiatan
            $templateProcessor->setValue('Judul_Penelitian', $detail->judul_pembicara);
            $templateProcessor->setValue('Kegiatan', $detail->kegiatan);
            $templateProcessor->setValue('Dalam_Rangka', $detail->dalam_rangka);
            $templateProcessor->setValue('Lokasi', $detail->lokasi_kegiatan);
            
            $tglMulai = Carbon::parse($detail->tanggal_mulai)->locale('id')->translatedFormat('d F Y');
            $tglSelesai = Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y');
            $templateProcessor->setValue('Tanggal_Mulai', $tglMulai);
            $templateProcessor->setValue('Tanggal_Selesai', $tglSelesai);
            
            $templateProcessor->setValue('PJ_1', $detail->penanggung_jawab_1);
            $templateProcessor->setValue('PJ_2', $detail->penanggung_jawab_2 ?? '-');
            $templateProcessor->setValue('Jml_Peserta', $detail->banyak_peserta);

            // 5. Ciri Fisik (Opsional)
            $templateProcessor->setValue('Tinggi', $detail->tinggi_badan ? $detail->tinggi_badan . ' cm' : '-');
            $templateProcessor->setValue('Bentuk_Badan', $detail->bentuk_badan ?? '-');
            $templateProcessor->setValue('Warna_Kulit', $detail->warna_kulit ?? '-');
            $templateProcessor->setValue('Rambut', $detail->bentuk_rambut ?? '-');
            $templateProcessor->setValue('Ciri_Khusus', $detail->ciri_khusus ?? '-');

            // Simpan file sementara
            $tempOutputPath = tempnam(sys_get_temp_dir(), 'Output_Izin_Penelitian_');
            $templateProcessor->saveAs($tempOutputPath);

            // Bersihkan nama file dari karakter terlarang
            $cleanNoTiket = str_replace(['/', '\\', ' '], '-', $noTiket);
            $fileName = 'Permohonan_Izin_Penelitian_' . $cleanNoTiket . '.docx';

            // Hapus file template sementara
            unlink($tempTemplatePath);

            // Kembalikan response download
            return response()->download($tempOutputPath, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            if (isset($tempTemplatePath) && file_exists($tempTemplatePath)) unlink($tempTemplatePath);
            if (isset($tempOutputPath) && file_exists($tempOutputPath)) unlink($tempOutputPath);

            Log::error("Error Generate Dokumen S3: " . $e->getMessage());
            abort(500, "Gagal memproses dokumen dari cloud storage.");
        }
    }
}