<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Keaslian Dokumen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4 font-sans">

    <div class="max-w-md w-full bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-blue-600 p-6 text-center">
            <h1 class="text-white text-xl font-bold">Portal Verifikasi Dokumen</h1>
            <p class="text-blue-100 text-sm mt-1">Pemerintah Kabupaten Subang</p>
        </div>

        <div class="p-6">
            @if($isValid)
                <div class="flex flex-col items-center mb-6">
                    <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 text-center">Dokumen Valid & Sah</h2>
                    <p class="text-gray-500 text-sm text-center mt-1">Dokumen ini telah ditandatangani secara elektronik yang sah dan terdaftar di sistem kami.</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 space-y-3 text-sm">
                    <div>
                        <span class="block text-gray-500">Nomor Tiket:</span>
                        <span class="font-semibold text-gray-800">{{ $tiket->no_tiket }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500">Nama Pemohon:</span>
                        <span class="font-semibold text-gray-800">{{ $surat->nama }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500">Institusi Pendidikan:</span>
                        <span class="font-semibold text-gray-800">{{ $surat->institusi_pendidikan }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500">Jenis Layanan:</span>
                        <span class="font-semibold text-gray-800">Izin Penelitian / {{ $surat->kegiatan }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500">Tanggal Ditandatangani:</span>
                        <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($tiket->updated_at)->locale('id')->translatedFormat('d F Y H:i:s') }} WIB</span>
                    </div>
                </div>

            @else
                <div class="flex flex-col items-center py-6">
                    <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 text-center">Dokumen Tidak Valid</h2>
                    <p class="text-red-600 text-sm text-center mt-2 font-medium">{{ $message }}</p>
                    <p class="text-gray-500 text-xs text-center mt-4">Pastikan Anda melakukan pemindaian dari QR Code dokumen yang resmi dan belum dimanipulasi.</p>
                </div>
            @endif
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-400">© {{ date('Y') }} Bakesbangpol Kab. Subang. All rights reserved.</p>
        </div>
    </div>

</body>
</html>