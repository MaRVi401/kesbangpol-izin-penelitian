@extends('layouts.app')

@section('title', 'Sistem Izin Penelitian - KESBANGPOL Kabupaten Subang')

@extends('partials.landingPage.navbar')

@section('content')
    <header id="beranda"
        class="relative pt-32 pb-16 md:pt-48 md:pb-32 overflow-hidden bg-linear-to-br from-white to-blue-50 dark:from-gray-900 dark:to-gray-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 flex flex-col lg:flex-row items-center gap-10 md:gap-12">
            <div class="w-full lg:w-1/2 text-center lg:text-left order-2 lg:order-1">
                <h1
                    class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 dark:text-white leading-tight mb-4 md:mb-6">
                    Ajukan Izin Penelitian <br class="hidden sm:block">
                    <span class="text-red-600 dark:text-red-500 italic font-serif">Lebih Mudah & Cepat</span>
                </h1>
                <p
                    class="text-base md:text-lg text-gray-600 dark:text-gray-300 mb-8 md:mb-10 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                    Sistem informasi pelayanan permohonan Surat Rekomendasi Penelitian Online pada Badan Kesatuan Bangsa
                    dan Politik untuk Mahasiswa, Peneliti, dan Instansi.
                </p>
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                    <a href="{{ route('login') }}"
                        class="px-8 py-3 md:py-4 bg-red-600 text-white rounded-2xl font-bold text-lg hover:bg-red-700 transition-all transform hover:scale-105 shadow-xl shadow-red-200 dark:shadow-none">
                        Mulai Pengajuan
                    </a>
                    <a href="#alur"
                        class="px-8 py-3 md:py-4 bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 rounded-2xl font-bold text-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-all shadow-sm">
                        Lihat Alur Kerja
                    </a>
                </div>
            </div>
            <div class="w-full lg:w-1/2 order-1 lg:order-2">
                <img src="{{ asset('assets/images/landingPages/logo-jumbotron.svg') }}"
                    class="w-4/5 sm:w-full max-w-sm md:max-w-lg mx-auto drop-shadow-2xl animate-pulse"
                    style="animation-duration: 5s;" alt="Hero Illustration">
            </div>
        </div>

        <div
            class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 md:w-96 md:h-96 bg-red-100 dark:bg-red-900/20 rounded-full blur-3xl opacity-50 transition-colors">
        </div>
        <div
            class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 md:w-96 md:h-96 bg-blue-100 dark:bg-blue-900/20 rounded-full blur-3xl opacity-50 transition-colors">
        </div>
    </header>

    <section id="alur"
        class="py-16 md:py-24 bg-white dark:bg-gray-900 transition-colors duration-300 border-t dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4 uppercase tracking-tight">
                    Langkah Mudah Pengajuan</h2>
                <div class="h-1.5 w-20 bg-red-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 lg:gap-8">
                @php
                    $steps = [
                        [
                            'no' => 1,
                            'title' => 'Registrasi Akun',
                            'desc' => 'Buat akun menggunakan email aktif untuk memantau status pengajuan.',
                        ],
                        [
                            'no' => 2,
                            'title' => 'Isi Data',
                            'desc' =>
                                'Lengkapi formulir permohonan dan unggah berkas persyaratan (KTP, Proposal, Pengantar).',
                        ],
                        [
                            'no' => 3,
                            'title' => 'Verifikasi Data',
                            'desc' => 'Petugas KESBANGPOL akan memverifikasi dokumen Anda secara sistem.',
                        ],
                        [
                            'no' => 4,
                            'title' => 'Cetak Rekomendasi',
                            'desc' => 'Jika disetujui, unduh dan cetak Surat Rekomendasi secara mandiri.',
                        ],
                    ];
                @endphp

                @foreach ($steps as $step)
                    <div
                        class="group p-6 md:p-8 rounded-3xl bg-gray-50 dark:bg-gray-800 hover:bg-red-600 dark:hover:bg-red-600 transition-all duration-300 border border-gray-100 dark:border-gray-700 shadow-sm">
                        <div
                            class="w-12 h-12 bg-white dark:bg-gray-700 rounded-xl flex items-center justify-center text-xl font-extrabold text-red-600 dark:text-red-400 mb-6 shadow-sm group-hover:rotate-12 transition-transform">
                            {{ $step['no'] }}
                        </div>
                        <h3
                            class="text-lg md:text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-white transition">
                            {{ $step['title'] }}
                        </h3>
                        <p
                            class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-red-50 transition leading-relaxed">
                            {{ $step['desc'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="berita" class="py-16 md:py-24 bg-gray-50 dark:bg-gray-800/50 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div class="text-left">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-2 uppercase tracking-tight">
                        Berita & Informasi</h2>
                    <p class="text-gray-600 dark:text-gray-400">Update terbaru seputar kegiatan dan kebijakan KESBANGPOL.
                    </p>
                </div>
                <a href="#"
                    class="text-red-600 dark:text-red-400 font-bold hover:underline flex items-center gap-2 transition">
                    Lihat Semua Berita
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $news = [
                        [
                            'title' => 'Sosialisasi Kebijakan Izin Penelitian Terbaru 2026',
                            'date' => '02 Mei 2026',
                            'category' => 'Pengumuman',
                            'img' => asset('assets/images/landingPages/logo-kabSubang.webp'),
                        ],
                        [
                            'title' => 'Kunjungan Kerja Lapangan Tim Verifikasi Kesbangpol',
                            'date' => '28 April 2026',
                            'category' => 'Kegiatan',
                            'img' => asset('assets/images/landingPages/logo-kabSubang.webp'),
                        ],
                        [
                            'title' => 'Peningkatan Layanan Digital Melalui Sistem Online',
                            'date' => '15 April 2026',
                            'category' => 'Inovasi',
                            'img' => asset('assets/images/landingPages/logo-kabSubang.webp'),
                        ],
                    ];
                @endphp

                @foreach ($news as $item)
                    <div
                        class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition duration-300 flex flex-col">
                        <img src="{{ $item['img'] }}" alt="Berita" class="w-full h-48 object-cover">
                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex items-center gap-3 mb-3 text-xs font-semibold uppercase tracking-wider">
                                <span class="text-red-600 dark:text-red-400">{{ $item['category'] }}</span>
                                <span class="text-gray-400">|</span>
                                <span class="text-gray-500 dark:text-gray-500">{{ $item['date'] }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 line-clamp-2 leading-snug">
                                {{ $item['title'] }}
                            </h3>
                            <div class="mt-auto">
                                <a href="#"
                                    class="text-sm font-bold text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 transition inline-flex items-center gap-1">
                                    Baca Selengkapnya
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <button id="back-to-top" type="button"
        class="fixed bottom-8 right-8 z-50 inline-flex items-center p-3 text-white bg-gray-600 rounded-lg shadow-lg opacity-0 invisible transition-all duration-300 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 active:scale-90">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
            class="icon icon-tabler icons-tabler-filled icon-tabler-arrow-big-up-line">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path
                d="M10.586 3l-6.586 6.586a2 2 0 0 0 -.434 2.18l.068 .145a2 2 0 0 0 1.78 1.089h2.586v5a1 1 0 0 0 1 1h6l.117 -.007a1 1 0 0 0 .883 -.993l-.001 -5h2.587a2 2 0 0 0 1.414 -3.414l-6.586 -6.586a2 2 0 0 0 -2.828 0z" />
            <path d="M15 20a1 1 0 0 1 .117 1.993l-.117 .007h-6a1 1 0 0 1 -.117 -1.993l.117 -.007h6z" />
        </svg>
    </button>
    @include('partials.landingPage.footer')
@endsection
