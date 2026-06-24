<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Izin Penelitian</title>
    <style>
        @page {
            margin: 1cm 1.5cm 1cm 1.5cm; 
        }
        body { 
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt; 
            line-height: 1.15;
            margin: 0; 
            padding: 0; 
            text-rendering: optimizeLegibility;
        }
        .kop-surat { 
            width: 100%; 
            border-bottom: 3px solid black; 
            padding-bottom: 3px;
            margin-bottom: 10px;
            border-collapse: collapse;
        }
        .kop-surat td { vertical-align: middle; }
        .logo-container { width: 15%; text-align: center; }
        .logo { width: 70px; height: auto; }
        
        .text-kop { 
            width: 85%; 
            text-align: center; 
            line-height: 1.1;
        }
        .text-kop h3 { margin: 0; font-size: 13pt; font-weight: normal; }
        .text-kop h2 { margin: 0; font-size: 15pt; font-weight: bold; letter-spacing: 0.5px; }
        .text-kop p { margin: 0; font-size: 10pt; }
        
        table.layout-table { width: 100%; border-collapse: collapse; }
        table.layout-table td { vertical-align: top; padding: 1px 0; }
        
        .text-justify { text-align: justify; }
        .indent-list { margin-top: 0; margin-bottom: 0; padding-left: 20px; }
        .table-biodata { width: 100%; padding-left: 17%; }
        .table-biodata td { vertical-align: top; padding: 1px 0; }
        .signature-table { width: 100%; margin-top: 15px; page-break-inside: avoid; }
    </style>
</head>
<body>

    @php
        $logoPathFisik = public_path('images/logo-subang.png'); 
        $logoBase64 = null;
        
        if (file_exists($logoPathFisik)) {
            $fileContent = file_get_contents($logoPathFisik);
            $mimeType = mime_content_type($logoPathFisik);
            $logoBase64 = 'data:' . $mimeType . ';base64,' . base64_encode($fileContent);
        }
    @endphp

    <table class="kop-surat">
        <tr>
            <td class="logo-container">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" class="logo" alt="Logo Subang">
                @else
                    <span style="font-size: 10px;">[Logo Tidak Ditemukan]</span>
                @endif
            </td>
            <td class="text-kop">
                <h3>PEMERINTAH DAERAH KABUPATEN SUBANG</h3>
                <h2>BADAN KESATUAN BANGSA DAN POLITIK</h2>
                <p>Jalan Ade Irma Suryani Nomor 4 Subang, Jawa Barat 41214</p>
                <p>Telepon (0260) 411109</p>
            </td>
        </tr>
    </table>

    <div class="konten">
        <table class="layout-table">
            <tr>
                <td width="12%">Nomor</td>
                <td width="2%">:</td>
                <td width="46%">400.14.5.4/{{ $detail->nomor_surat ?? '...' }}/WASNAS/2025</td>
                <td width="40%" align="right">{{ $tanggal_cetak_surat }}</td>
            </tr>
            <tr>
                <td>Sifat</td>
                <td>:</td>
                <td>Biasa</td>
                <td></td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>-</td>
                <td></td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>:</td>
                <td class="text-justify" style="padding-right: 20px;">{{ $detail->kegiatan }}</td>
                <td></td>
            </tr>
        </table>
        
        <div style="margin-top: 10px;">
            Yth. {{ $detail->yth_kepada }}<br>
            C.q {{ $detail->yth_cq }}<br>
            di <br>
            &nbsp;&nbsp;&nbsp;&nbsp;{{ $detail->yth_di }}
        </div>

        <table class="layout-table" style="margin-top: 10px;">
            <tr>
                <td width="15%">Dasar</td>
                <td width="2%">:</td>
                <td class="text-justify">
                    <ol class="indent-list">
                        <li>Peraturan Menteri Dalam Negeri Nomor 3 Tahun 2018 tentang Penerbitan Surat Keterangan Penelitian.</li>
                        <li>Peraturan Menteri Dalam Negeri RI Nomor 11 Tahun 2019 tentang Perangkat Daerah yang Melaksanakan Urusan Pemerintahan di Bidang Kesatuan Bangsa dan Politik.</li>
                    </ol>
                </td>
            </tr>
            <tr>
                <td>Menimbang</td>
                <td>:</td>
                <td class="text-justify">
                    Surat dari {{ $detail->institusi_pendidikan }} Nomor : {{ $detail->nomor_surat_institusi }} Tanggal {{ \Carbon\Carbon::parse($detail->tanggal_surat_institusi)->locale('id')->translatedFormat('d F Y') }} hal Ijin Penelitian yang kami terima pada tanggal {{ \Carbon\Carbon::parse($detail->tanggal_diterima_surat)->locale('id')->translatedFormat('d F Y') }}.
                </td>
            </tr>
        </table>

        <p class="text-justify" style="margin-top: 10px; margin-bottom: 5px;">Menerangkan bahwa :</p>

        <table class="table-biodata">
            <tr>
                <td width="30%">Nama</td>
                <td width="3%">:</td>
                <td width="67%">{{ $detail->nama }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td class="text-justify">{{ $detail->alamat_lengkap }}</td>
            </tr>
            <tr>
                <td>Penanggung Jawab</td>
                <td>:</td>
                <td>
                    1. {{ $detail->penanggung_jawab_1 }} <br>
                    @if($detail->penanggung_jawab_2)
                    2. {{ $detail->penanggung_jawab_2 }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Peserta</td>
                <td>:</td>
                <td>{{ $detail->banyak_peserta }} orang</td>
            </tr>
            <tr>
                <td>Lokasi</td>
                <td>:</td>
                <td class="text-justify">{{ $detail->lokasi_kegiatan }}</td>
            </tr>
        </table>

        <p class="text-justify" style="margin-top: 10px; margin-bottom: 5px;">
            Yang akan melakukan Kegiatan Praktek Kerja Lapangan / Magang/Penelitian di daerah/Kantor yang Bapak/Ibu Pimpin dari Tanggal {{ \Carbon\Carbon::parse($detail->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') }} dengan judul :
        </p>

        <p style="text-align: center; font-weight: bold; margin: 10px 0;">
            {{ $detail->dalam_rangka }}
        </p>

        <p class="text-justify" style="margin-bottom: 5px;">
            Kami lanjutkan kepada Bapak/Ibu, apabila situasi dan kondisi memungkinkan kami tidak berkeberatan dilaksanakan.
        </p>

        <p class="text-justify" style="margin-top: 0;">
            Setelah selesai melaksanakan kegiatan agar mengirimkan laporan kepada Kepala Badan Kesatuan Bangsa dan Politik Kabupaten Subang secara tertulis, paling lambat 1 (satu) minggu setelah kegiatan.
        </p>

        <table class="signature-table">
            <tr>
                <td width="50%"></td>
                <td width="50%" style="text-align: center;">
                    @if(!empty($penandatangan))
                        @if(!empty($penandatangan->jabatan_atasan))
                            {{ $penandatangan->jabatan_atasan }}<br>
                        @endif
                        {{ $penandatangan->jabatan_penandatangan }}<br>
                        @if(!empty($qrCodeBase64))
                            <div style="margin-top: 10px; margin-bottom: 10px;">
                                <img src="{{ $qrCodeBase64 }}" alt="QR Code Verifikasi" style="width: 80px; height: 80px;">
                            </div>
                        @else
                            <br><br><br><br><br><br>
                        @endif
                        <strong><u>{{ $penandatangan->user->nama ?? 'NAMA PEJABAT' }}</u></strong><br>
                        
                    @else
                        an. Kepala Badan Kesatuan Bangsa dan Politik Kabupaten Subang<br>
                        Kepala Bidang Ideologi Wawasan Kebangsaan dan Karakter Bangsa<br>
                        @if(!empty($qrCodeBase64))
                            <div style="margin-top: 10px; margin-bottom: 10px;">
                                <img src="{{ $qrCodeBase64 }}" alt="QR Code Verifikasi" style="width: 80px; height: 80px;">
                            </div>
                        @else
                            <br><br><br><br><br><br>
                        @endif
                        <strong><u>NAMA PEJABAT</u></strong>
                    @endif
                </td>
            </tr>
        </table>
    </div>

</body>
</html>