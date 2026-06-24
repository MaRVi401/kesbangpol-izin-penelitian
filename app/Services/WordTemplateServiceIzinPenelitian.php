<?php

namespace App\Services;

use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\SuratPermohonanIzinPenelitian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class WordTemplateServiceIzinPenelitian
{
    public function generateDokumen(SuratPermohonanIzinPenelitian $detail, $noTiket, $penandatangan = null)
    {
        $templatePath = 'templates/Template-Izin-Penelitian.docx';

        if (!Storage::disk('local')->exists($templatePath)) {
            abort(404);
        }

        try {
            $tempTemplatePath = tempnam(sys_get_temp_dir(), 'Template_Src_');
            file_put_contents($tempTemplatePath, Storage::disk('local')->get($templatePath));

            $templateProcessor = new TemplateProcessor($tempTemplatePath);

            $templateProcessor->setValue('no_tiket', $noTiket);
            $templateProcessor->setValue('nama', $detail->nama);
            $templateProcessor->setValue('tempat_tanggal_lahir', $detail->tempat_lahir . ', ' . Carbon::parse($detail->tanggal_lahir)->locale('id')->translatedFormat('d F Y'));
            $templateProcessor->setValue('pekerjaan_pendidikan', $detail->pekerjaan_pendidikan);
            $templateProcessor->setValue('semester', $detail->semester ?? '-');
            $templateProcessor->setValue('institusi_pendidikan', $detail->institusi_pendidikan);
            $templateProcessor->setValue('alamat_kantor', $detail->alamat_kantor ?? '-');
            $templateProcessor->setValue('alamat_institusi', $detail->alamat_institusi ?? '-');
            $templateProcessor->setValue('nomor_mahasiswa', $detail->nomor_mahasiswa ?? '-');
            $templateProcessor->setValue('nomor_pegawai', $detail->nomor_pegawai ?? '-');
            $templateProcessor->setValue('yth_kepada', $detail->yth_kepada);
            $templateProcessor->setValue('yth_cq', $detail->yth_cq ?? '-');
            $templateProcessor->setValue('yth_di', $detail->yth_di ?? 'Tempat');
            $templateProcessor->setValue('kegiatan', $detail->kegiatan);
            $templateProcessor->setValue('dalam_rangka', $detail->dalam_rangka);
            $templateProcessor->setValue('tanggal_mulai', Carbon::parse($detail->tanggal_mulai)->locale('id')->translatedFormat('d F Y'));
            $templateProcessor->setValue('tanggal_selesai', Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y'));
            $templateProcessor->setValue('lokasi_kegiatan', $detail->lokasi_kegiatan);
            $templateProcessor->setValue('judul_pembicara', $detail->judul_pembicara);
            $templateProcessor->setValue('penanggung_jawab_1', $detail->penanggung_jawab_1);
            $templateProcessor->setValue('nip_penanggung_jawab_1', $detail->nip_penanggung_jawab_1 ?? '-');
            $templateProcessor->setValue('penanggung_jawab_2', $detail->penanggung_jawab_2 ?? '-');
            $templateProcessor->setValue('nip_penanggung_jawab_2', $detail->nip_penanggung_jawab_2 ?? '-');
            $templateProcessor->setValue('banyak_peserta', $detail->banyak_peserta);
            $templateProcessor->setValue('nama_alias', $detail->nama_alias ?? '-');
            $templateProcessor->setValue('nama_panggilan', $detail->nama_panggilan ?? '-');
            $templateProcessor->setValue('jenis_kelamin', $detail->jenis_kelamin);
            $templateProcessor->setValue('kebangsaan', $detail->kebangsaan);
            $templateProcessor->setValue('agama', $detail->agama);
            $templateProcessor->setValue('pekerjaan', $detail->pekerjaan ?? '-');
            $templateProcessor->setValue('status_perkawinan', $detail->status_perkawinan);
            $templateProcessor->setValue('alamat_lengkap', $detail->alamat_lengkap);
            $templateProcessor->setValue('tinggi_badan', $detail->tinggi_badan ?? '-');
            $templateProcessor->setValue('bentuk_badan', $detail->bentuk_badan ?? '-');
            $templateProcessor->setValue('warna_kulit', $detail->warna_kulit ?? '-');
            $templateProcessor->setValue('bentuk_rambut', $detail->bentuk_rambut ?? '-');
            $templateProcessor->setValue('bentuk_hidung', $detail->bentuk_hidung ?? '-');
            $templateProcessor->setValue('ciri_khusus', $detail->ciri_khusus ?? '-');
            $templateProcessor->setValue('hobi', $detail->hobi ?? '-');
            $templateProcessor->setValue('no_hp', $detail->no_hp);

            if ($detail->path_pas_foto && Storage::disk('public')->exists($detail->path_pas_foto)) {
                $templateProcessor->setImageValue('pas_foto', [
                    'path' => Storage::disk('public')->path($detail->path_pas_foto),
                    'width' => 100,
                    'height' => 120,
                    'ratio' => false
                ]);
            } else {
                $templateProcessor->setValue('pas_foto', '');
            }

            if ($penandatangan) {
                $templateProcessor->setValue('jabatan_atasan', $penandatangan->jabatan_atasan ?? '');
                $templateProcessor->setValue('jabatan_penandatangan', $penandatangan->jabatan_penandatangan);
                $templateProcessor->setValue('nama_pejabat', $penandatangan->user->nama ?? 'NAMA PEJABAT');
                $templateProcessor->setValue('nip_pejabat', $penandatangan->nip ?? '-');
            } else {
                $templateProcessor->setValue('jabatan_atasan', 'an. Kepala Badan Kesatuan Bangsa dan Politik Kabupaten Subang');
                $templateProcessor->setValue('jabatan_penandatangan', 'Kepala Bidang Ideologi Wawasan Kebangsaan dan Karakter Bangsa');
                $templateProcessor->setValue('nama_pejabat', 'NAMA PEJABAT');
                $templateProcessor->setValue('nip_pejabat', 'NIP. .........................');
            }

            $cleanNoTiket = str_replace(['/', '\\', ' '], '-', $noTiket);
            $fileName = "Surat_Izin_{$cleanNoTiket}.docx";
            
            $tempOutput = tempnam(sys_get_temp_dir(), 'Doc_');
            $templateProcessor->saveAs($tempOutput);

            $savedPath = "surat_keluar/{$fileName}";
            Storage::disk('local')->put($savedPath, file_get_contents($tempOutput));

            unlink($tempTemplatePath);
            unlink($tempOutput);

            return $savedPath;

        } catch (\Exception $e) {
            Log::error('Error Generate Dokumen: ' . $e->getMessage());
            abort(500);
        }
    }

    public function generatePDFKabid(SuratPermohonanIzinPenelitian $detail, $noTiket, $penandatangan = null, $qrCodeBase64 = null) 
    {
        try {
            $cleanNoTiket = str_replace(['/', '\\', ' '], '-', $noTiket);
            $savedPdfPath = "surat_keluar/Surat_Izin_{$cleanNoTiket}.pdf"; 
            $absoluteSavePath = Storage::disk('local')->path($savedPdfPath);
            
            if (!file_exists(dirname($absoluteSavePath))) {
                mkdir(dirname($absoluteSavePath), 0755, true);
            }

            $logoPath = public_path('images/logo-subang.png'); 

            $data = [
                'no_tiket' => $noTiket,
                'detail' => $detail,
                'tanggal_cetak_surat' => Carbon::now()->locale('id')->translatedFormat('d F Y'),
                'penandatangan' => $penandatangan,
                'logo_path' => $logoPath,
                'qrCodeBase64' => $qrCodeBase64
            ];

            $pdf = Pdf::loadView('pdf.surat-resmi', $data)
                    ->setPaper('a4', 'portrait')
                    ->setWarnings(false);

            $pdf->save($absoluteSavePath);

            return $savedPdfPath; 

        } catch (\Exception $e) {
            Log::error('Error Generate PDF Kabid: ' . $e->getMessage());
            abort(500);
        }
    }

    public function generatePDFKaban(SuratPermohonanIzinPenelitian $detail, $noTiket, $penandatangan = null, $qrCodeBase64 = null) 
    {
        try {
            $cleanNoTiket = str_replace(['/', '\\', ' '], '-', $noTiket);
            $savedPdfPath = "surat_keluar/Surat_Izin_{$cleanNoTiket}.pdf"; 
            $absoluteSavePath = Storage::disk('local')->path($savedPdfPath);
            
            if (!file_exists(dirname($absoluteSavePath))) {
                mkdir(dirname($absoluteSavePath), 0755, true);
            }

            $logoPath = public_path('images/logo-subang.png'); 

            $data = [
                'no_tiket' => $noTiket,
                'detail' => $detail,
                'tanggal_cetak_surat' => Carbon::now()->locale('id')->translatedFormat('d F Y'),
                'penandatangan' => $penandatangan,
                'logo_path' => $logoPath,
                'qrCodeBase64' => $qrCodeBase64
            ];

            $pdf = Pdf::loadView('pdf.surat-resmi', $data)
                    ->setPaper('a4', 'portrait')
                    ->setWarnings(false);

            $pdf->save($absoluteSavePath);

            return $savedPdfPath; 

        } catch (\Exception $e) {
            Log::error('Error Generate PDF Kaban: ' . $e->getMessage());
            abort(500);
        }
    }
}