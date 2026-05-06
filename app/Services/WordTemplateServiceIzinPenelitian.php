<?php

namespace App\Services;

use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\SuratPermohonanIzinPenelitian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PenandatanganSurat;

class WordTemplateServiceIzinPenelitian
{
    public function generateDokumen(SuratPermohonanIzinPenelitian $detail, $noTiket, ?PenandatanganSurat $penandatangan = null)
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
            $templateProcessor->setValue('kegiatan', $detail->kegiatan);
            $templateProcessor->setValue('dalam_rangka', $detail->dalam_rangka);
            $templateProcessor->setValue('tanggal_mulai', Carbon::parse($detail->tanggal_mulai)->locale('id')->translatedFormat('d F Y'));
            $templateProcessor->setValue('tanggal_selesai', Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y'));
            $templateProcessor->setValue('lokasi_kegiatan', $detail->lokasi_kegiatan);
            $templateProcessor->setValue('judul_pembicara', $detail->judul_pembicara);
            $templateProcessor->setValue('penanggung_jawab_1', $detail->penanggung_jawab_1);
            $templateProcessor->setValue('penanggung_jawab_2', $detail->penanggung_jawab_2 ?? '-');
            $templateProcessor->setValue('banyak_peserta', $detail->banyak_peserta);
            $templateProcessor->setValue('tanggal_surat', Carbon::now()->locale('id')->translatedFormat('d F Y'));
            $templateProcessor->setValue('nama_alias', $detail->nama_alias ?? '-');
            $templateProcessor->setValue('nama_panggilan', $detail->nama_panggilan ?? '-');
            $templateProcessor->setValue('jenis_kelamin', $detail->jenis_kelamin);
            $templateProcessor->setValue('tempat_tgl_lahir', $detail->tempat_lahir . ', ' . Carbon::parse($detail->tanggal_lahir)->locale('id')->translatedFormat('d F Y'));
            $templateProcessor->setValue('kebangsaan', $detail->kebangsaan ?? 'Indonesia');
            $templateProcessor->setValue('agama', $detail->agama);
            $templateProcessor->setValue('nama_wasnas', $penandatangan ? $penandatangan->nama : '-');
            $templateProcessor->setValue('nip_wasnas', $penandatangan ? $penandatangan->nip : '-');
            $templateProcessor->setValue('pekerjaan', $detail->pekerjaan ?? '-');
            $templateProcessor->setValue('status_perkawinan', $detail->status_perkawinan);
            $templateProcessor->setValue('alamat_lengkap', $detail->alamat_lengkap);
            $templateProcessor->setValue('tinggi_badan', $detail->tinggi_badan ? $detail->tinggi_badan . ' cm' : '-');
            $templateProcessor->setValue('bentuk_badan', $detail->bentuk_badan ?? '-');
            $templateProcessor->setValue('warna_kulit', $detail->warna_kulit ?? '-');
            $templateProcessor->setValue('bentuk_rambut', $detail->bentuk_rambut ?? '-');
            $templateProcessor->setValue('bentuk_hidung', $detail->bentuk_hidung ?? '-');
            $templateProcessor->setValue('ciri_khusus', $detail->ciri_khusus ?? '-');
            $templateProcessor->setValue('hobi', $detail->hobi ?? '-');
            $templateProcessor->setValue('no_hp', $detail->no_hp);

            $fullImagePath = 'private/pas_foto/' . $detail->path_pas_foto;
            $tempImagePath = null;

            if (!empty($detail->path_pas_foto) && Storage::disk('local')->exists($fullImagePath)) {
                $imagePath = Storage::disk('local')->path($fullImagePath);
                $extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));

                if ($extension === 'webp') {
                    $im = @imagecreatefromwebp($imagePath);
                    if ($im !== false) {
                        $tempImagePath = tempnam(sys_get_temp_dir(), 'Foto_Convert_') . '.png';
                        imagepng($im, $tempImagePath);
                        imagedestroy($im);
                        $imagePath = $tempImagePath;
                    }
                }

                $finalExtension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
                if (in_array($finalExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
                    $templateProcessor->setImageValue('foto', [
                        'path' => $imagePath,
                        'width' => 113,
                        'height' => 151,
                        'ratio' => false
                    ]);
                } else {
                    $templateProcessor->setValue('foto', '');
                }
            } else {
                $templateProcessor->setValue('foto', '');
            }

            $tempOutputPath = tempnam(sys_get_temp_dir(), 'Output_Izin_Penelitian_');
            $templateProcessor->saveAs($tempOutputPath);

            $cleanNoTiket = str_replace(['/', '\\', ' '], '-', $noTiket);
            $fileName = 'Permohonan_Izin_Penelitian_' . $cleanNoTiket . '.docx';

            unlink($tempTemplatePath);
            
            if ($tempImagePath && file_exists($tempImagePath)) {
                unlink($tempImagePath);
            }

            return response()->download($tempOutputPath, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            if (isset($tempTemplatePath) && file_exists($tempTemplatePath)) unlink($tempTemplatePath);
            if (isset($tempOutputPath) && file_exists($tempOutputPath)) unlink($tempOutputPath);
            if (isset($tempImagePath) && file_exists($tempImagePath)) unlink($tempImagePath);

            Log::error($e->getMessage());
            abort(500);
        }
    }

    public function generatePdfPreview(SuratPermohonanIzinPenelitian $detail, $noTiket, ?PenandatanganSurat $penandatangan = null)
    {
        try {
            $userId = auth()->id();
            $cleanNoTiket = str_replace(['/', '\\', ' '], '-', $noTiket);
            $savedPdfPath = "previews/{$userId}/Preview_{$cleanNoTiket}.pdf"; 
            
            $absoluteSavePath = Storage::disk('local')->path($savedPdfPath);
            
            if (!file_exists(dirname($absoluteSavePath))) {
                mkdir(dirname($absoluteSavePath), 0755, true);
            }

            $data = [
                'no_tiket' => $noTiket,
                'detail' => $detail,
                'tanggal_surat' => Carbon::now()->locale('id')->translatedFormat('d F Y'),
                // Data penandatangan disisipkan ke view PDF
                'nama_wasnas' => $penandatangan ? $penandatangan->nama : '-',
                'nip_wasnas' => $penandatangan ? $penandatangan->nip : '-',
            ];

            $pdf = Pdf::loadView('pdf.izin-penelitian', $data)
                    ->setPaper('a4', 'portrait')
                    ->setWarnings(false);

            $pdf->save($absoluteSavePath);

            return $savedPdfPath;

        } catch (\Exception $e) {
            Log::error('Error HTML to PDF: ' . $e->getMessage());
            abort(500);
        }
    }

    
}