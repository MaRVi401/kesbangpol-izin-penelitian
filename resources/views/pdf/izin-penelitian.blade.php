<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preview Izin Penelitian</title>
    <style>
        @page {
            margin: 1cm 2cm; 
        }
        body {
            font-family: 'DejaVu Serif', serif; 
            font-size: 11pt; 
            line-height: 1.15; 
            text-rendering: optimizeLegibility;
        }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .underline { text-decoration: underline; }
        .mb-2 { margin-bottom: 10px; }
        
        table.form-table { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
        table.form-table td { vertical-align: top; padding: 0.5px 0; word-wrap: break-word; } 
        .col-label { width: 35%; }
        .col-colon { width: 3%; text-align: center; }
        .col-value { width: 62%; }
        
        .signature-container { width: 100%; margin-top: 15px; } 
        .signature-right { float: right; width: 40%; text-align: center; }
        .clear { clear: both; }

        /* Pengaturan Halaman Kedua */
        .page-break { page-break-before: always; }
        table.biodata-table { width: 100%; border-collapse: collapse; font-size: 11pt; margin-top: 20px;}
        table.biodata-table td { vertical-align: top; padding: 2px 1px; }
        
        .photo-signature-table { width: 100%; margin-top: 40px; }
        .wasnas-signature-table { width: 100%; margin-top: 30px; }
    </style>
</head>
<body>

    <!-- HALAMAN PERTAMA -->
    <div class="text-center font-bold mb-2">
        <span class="underline">SURAT PERMOHONAN IZIN PENELITIAN</span>
    </div>

    <p>Yang bertandatangan dibawah ini, Saya :</p>

    <table class="form-table">
        <tr>
            <td class="col-label">Nama</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $detail->nama }}</td>
        </tr>
        <tr>
            <td class="col-label">Tempat dan Tanggal Lahir</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $detail->tempat_lahir }}, {{ \Carbon\Carbon::parse($detail->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="col-label">Pekerjaan dan Pendidikan</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $detail->pekerjaan_pendidikan }}</td>
        </tr>
        <tr>
            <td class="col-label">Semester</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $detail->semester ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Sekolah / Universitas</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $detail->institusi_pendidikan }}</td>
        </tr>
        <tr>
            <td class="col-label">Alamat Kantor / Dinas</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $detail->alamat_kantor ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Alamat Sekolah / Universitas</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $detail->alamat_institusi ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Nomor Kartu Mahasiswa</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $detail->nomor_mahasiswa ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Nomor Kartu Pegawai</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $detail->nomor_pegawai ?? '-' }}</td>
        </tr>
    </table>

    <p style="text-align: left; margin-top: 5px;">
        Dengan ini mengajukan permohonan izin/rekomendasi Kepala Badan Kesatuan Bangsa dan Politik Kabupaten Subang, Untuk Mengadakan :
    </p>

    <table class="form-table">
        <tr>
            <td class="col-label">Kegiatan</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $detail->kegiatan }}</td>
        </tr>
        <tr>
            <td class="col-label">Dalam Rangka</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $detail->dalam_rangka }}</td>
        </tr>
        <tr>
            <td class="col-label">Dimulai dari tanggal</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ \Carbon\Carbon::parse($detail->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="col-label">Selesai Tanggal</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="col-label">Lokasi Kegiatan</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $detail->lokasi_kegiatan }}</td>
        </tr>
        <tr>
            <td class="col-label">Judul/ Pembicara</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $detail->judul_pembicara }}</td>
        </tr>
        <tr>
            <td class="col-label">Nama Penanggung Jawab</td>
            <td class="col-colon">:</td>
            <td class="col-value">
                1. {{ $detail->penanggung_jawab_1 }}<br>
                2. {{ $detail->penanggung_jawab_2 ?? '-' }}
            </td>
        </tr>
        <tr>
            <td class="col-label">Banyaknya Peserta</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $detail->banyak_peserta }} Orang</td>
        </tr>
    </table>

    <p style="text-align: left;">
        Dalam mengadakan kegiatan ini, saya bersedia untuk mengikuti segala peraturan dan persyaratan yang berlaku dan setelah melaksanakan kegiatan ini saya akan memberikan laporan maksimal 1 (<i>satu</i>) minggu setelah kegiatan selesai kepada Kepala Badan Kesatuan Bangsa dan Politik Kabupaten Subang.
    </p>

    <div class="signature-container">
        <div class="signature-right">
            Subang, {{ $tanggal_surat }}<br>
            Pemohon<br><br><br><br>
            {{ $detail->nama }}
        </div>
        <div class="clear"></div>
    </div>


    <!-- HALAMAN KEDUA -->
    <div class="page-break"></div>

    <table class="biodata-table">
        <tr>
            <td width="3%">1.</td><td width="22%">Nama</td><td width="2%">:</td><td width="23%">{{ $detail->nama }}</td>
            <td width="3%">12.</td><td width="22%">Tinggi Badan</td><td width="2%">:</td><td width="25%">{{ $detail->tinggi_badan ? $detail->tinggi_badan . ' cm' : '-' }}</td>
        </tr>
        <tr>
            <td>2.</td><td>Nama Alias</td><td>:</td><td>{{ $detail->nama_alias ?? '-' }}</td>
            <td>13.</td><td>Bentuk Badan</td><td>:</td><td>{{ $detail->bentuk_badan ?? '-' }}</td>
        </tr>
        <tr>
            <td>3.</td><td>Nama Panggilan</td><td>:</td><td>{{ $detail->nama_panggilan ?? '-' }}</td>
            <td>14.</td><td>Warna Kulit</td><td>:</td><td>{{ $detail->warna_kulit ?? '-' }}</td>
        </tr>
        <tr>
            <td>4.</td><td>Jenis Kelamin</td><td>:</td><td>{{ $detail->jenis_kelamin }}</td>
            <td>15.</td><td>Bentuk Rambut</td><td>:</td><td>{{ $detail->bentuk_rambut ?? '-' }}</td>
        </tr>
        <tr>
            <td>5.</td><td>Tempat & Tgl.Lahir</td><td>:</td><td>{{ $detail->tempat_lahir }}, {{ \Carbon\Carbon::parse($detail->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}</td>
            <td>16.</td><td>Bentuk Hidung</td><td>:</td><td>{{ $detail->bentuk_hidung ?? '-' }}</td>
        </tr>
        <tr>
            <td>6.</td><td>Kebangsaan</td><td>:</td><td>{{ $detail->kebangsaan ?? 'Indonesia' }}</td>
            <td>17.</td><td>Ciri-ciri Khusus</td><td>:</td><td>{{ $detail->ciri_khusus ?? '-' }}</td>
        </tr>
        <tr>
            <td>7.</td><td>No. Kartu Mahasiswa</td><td>:</td><td>{{ $detail->nomor_mahasiswa ?? '-' }}</td>
            <td>18.</td><td>Hobby</td><td>:</td><td>{{ $detail->hobi ?? '-' }}</td>
        </tr>
        <tr>
            <td>8.</td><td>Agama</td><td>:</td><td>{{ $detail->agama }}</td>
            <td>19.</td><td>No. HP</td><td>:</td><td>{{ $detail->no_hp }}</td>
        </tr>
        <tr>
            <td>9.</td><td>Pekerjaan</td><td>:</td><td>{{ $detail->pekerjaan ?? '-' }}</td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td>10.</td><td>Kawin / Belum Kawin</td><td>:</td><td>{{ $detail->status_perkawinan }}</td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td>11.</td><td>Alamat</td><td>:</td><td>{{ $detail->alamat_lengkap }}</td>
            <td colspan="4"></td>
        </tr>
    </table>

    <table class="photo-signature-table">
        <tr>
            <td width="50%" style="text-align: center; vertical-align: bottom;">
                @php
                    use Illuminate\Support\Facades\Storage;
                    $fotoBase64 = null;
                    
                    // Menyesuaikan jalur berkas sesuai dengan WordTemplateService[cite: 7]
                    $fullPath = 'private/pas_foto/' . $detail->path_pas_foto;

                    if (!empty($detail->path_pas_foto) && Storage::disk('local')->exists($fullPath)) {
                        $fileContent = Storage::disk('local')->get($fullPath);
                        $mimeType = Storage::disk('local')->mimeType($fullPath);
                        
                        // DomPDF memerlukan skema data URI untuk membaca berkas dari diska privat
                        $fotoBase64 = 'data:' . $mimeType . ';base64,' . base64_encode($fileContent);
                    }
                @endphp

                @if($fotoBase64)
                    <img src="{{ $fotoBase64 }}" style="width: 113px; height: 151px; object-fit: cover;">
                @else
                    <!-- Tampilan jika foto tidak ditemukan atau path kosong[cite: 9] -->
                    <div style="width: 113px; height: 151px; border: 1px solid #000; margin: 0 auto; display: table;">
                        <span style="display: table-cell; vertical-align: middle; font-size: 10pt;">Foto<br>3x4</span>
                    </div>
                @endif
            </td>
            <td width="50%" style="text-align: center; vertical-align: top;">
                Subang, {{ $tanggal_surat }}<br>
                Yang bertanda tangan,<br><br><br><br><br>
                ({{ $detail->nama }})
            </td>
        </tr>
    </table>

    <table class="wasnas-signature-table">
        <tr>
            <td width="50%"></td>
            <td width="50%" style="text-align: center;">
                <strong>BIDANG WASNAS DAN PK,</strong><br><br><br><br><br>
                <span style="text-decoration: underline; font-weight: bold;">{{ $nama_wasnas }}</span><br>
                NIP. {{ $nip_wasnas }}
            </td>
        </tr>
    </table>

</body>
</html>