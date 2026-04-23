@extends('layouts.main')

@section('title', 'Layanan Pengaduan Sistem Elektronik')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <div class="mb-8 mt-4">
        <ol class="items-center w-full max-w-2xl mx-auto flex space-x-8 justify-center">
            <li id="indicator-step-1" class="flex items-center space-x-2.5 text-blue-600 dark:text-blue-500">
                <span class="flex items-center justify-center w-8 h-8 border border-blue-600 rounded-full shrink-0 dark:border-blue-500">1</span>
                <span><h3 class="font-medium leading-tight">Formulir Pengaduan</h3></span>
            </li>
            <li class="flex-1 h-px bg-gray-300 dark:bg-gray-600"></li>
            <li id="indicator-step-2" class="flex items-center space-x-2.5 text-gray-500 dark:text-gray-400">
                <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">2</span>
                <span><h3 class="font-medium leading-tight">Selesai</h3></span>
            </li>
        </ol>
    </div>

    <div id="step-1" class="step-content transition-opacity duration-300">
        <form id="form-pengaduan" action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Pengaduan Sistem Elektronik</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Sampaikan kendala, error, atau permasalahan sistem aplikasi yang Anda alami.</p>
                </div>

                <div class="p-4 mb-6 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 flex items-start" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div>
                        <span class="font-medium">Identitas Otomatis:</span> Data pelapor (Nama & NIP) akan otomatis terekam ke dalam tiket sesuai dengan akun yang Anda gunakan untuk login saat ini.
                    </div>
                </div>

                <div class="mb-8">
                    <div class="grid gap-6 md:grid-cols-1">
                        <div>
                            <label for="detail_pengaduan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Detail Pengaduan / Kronologi</label>
                            <textarea id="detail_pengaduan" name="detail_pengaduan" rows="6" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Jelaskan secara detail:&#10;1. Aplikasi apa yang digunakan?&#10;2. Bagaimana langkah-langkah sebelum terjadi error?&#10;3. Pesan error apa yang muncul di layar?" required></textarea>
                        </div>
                        <div>
                            <label for="lampiran_screenshot" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lampiran Screenshot (Opsional)</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="lampiran_screenshot" name="lampiran_screenshot" type="file" accept="image/jpeg,image/png,image/jpg,.pdf">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="javascript:history.back()" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-6 py-2.5 text-center inline-flex items-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 transition-colors">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali
                    </a>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Ajukan Tiket Pengaduan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div id="step-2" class="step-content hidden transition-opacity duration-300">
        <div class="text-center py-10 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 max-w-2xl mx-auto mt-8 shadow-sm">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h2 class="text-2xl font-bold mb-2 text-gray-900 dark:text-white">Tiket Pengaduan Berhasil Dibuat!</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-2">Terima kasih, laporan Anda telah masuk ke dalam antrean sistem untuk ditangani oleh tim teknis kami.</p>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 inline-block mt-2 mb-6 border border-gray-200 dark:border-gray-600">
                <span class="text-sm text-gray-500 dark:text-gray-400 block mb-1">Nomor Tiket Anda</span>
                <span class="text-xl font-mono font-bold text-blue-600 dark:text-blue-400" id="nomor-tiket">#TKT-XXXXXXXX</span>
            </div>
            <div class="flex justify-center space-x-4">
                <a href="/submission" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">Cek Status Tiket</a>
                <a href="/dashboard" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @vite('resources/js/complaint-forms.js')
@endpush
@endsection