<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Izin Penelitian - KESBANGPOL</title>

    <!-- Fonts & Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- AlpineJS untuk interaksi mobile menu -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body
    class="antialiased bg-gray-50 dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100 transition-colors duration-300">

    <!-- Header / Navbar -->
    <nav x-data="{ open: false }"
        class="fixed w-full z-50 top-0 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 md:h-20 items-center">
                <!-- Logo Section -->
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/landingPages/logo-kabSubang.webp') }}" class="h-10 sm:h-12 w-auto"
                        alt="Logo Instansi">
                    <div class="flex flex-col border-l-2 border-red-600 pl-3 font-sans">
                        <span
                            class="font-bold text-gray-900 dark:text-white leading-none text-sm sm:text-lg">KESBANGPOL</span>
                        <span
                            class="text-[9px] sm:text-xs text-gray-500 dark:text-gray-400 tracking-widest uppercase font-semibold">Kabupaten
                            Subang</span>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-6 lg:gap-8 font-medium text-gray-600 dark:text-gray-300">
                    <a href="#beranda" class="hover:text-red-600 dark:hover:text-red-500 transition">Beranda</a>
                    <a href="#alur" class="hover:text-red-600 dark:hover:text-red-500 transition">Alur Pengajuan</a>
                    <a href="#berita" class="hover:text-red-600 dark:hover:text-red-500 transition">Berita</a>

                    <div class="h-6 w-px bg-gray-200 dark:bg-gray-700"></div>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-red-600 text-white px-5 py-2 rounded-full hover:bg-red-700 transition shadow-lg shadow-red-200 dark:shadow-none">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="hover:text-red-600 dark:hover:text-red-400 transition font-bold border border-red-600 px-5 py-2 rounded-full text-red-600">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="bg-red-600 text-white px-5 py-2 rounded-full hover:bg-red-700 transition shadow-lg shadow-red-200 dark:shadow-none">Daftar</a>
                            @endif
                        @endauth
                    @endif
                </div>

                <!-- Hamburger Button (Mobile) -->
                <div class="flex md:hidden items-center">
                    <button @click="open = !open"
                        class="text-gray-600 dark:text-gray-300 hover:text-red-600 focus:outline-none transition">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Dropdown) -->
        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            class="md:hidden bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-xl">
            <div class="px-4 pt-2 pb-6 space-y-1">
                <a href="#beranda" @click="open = false"
                    class="block px-3 py-3 text-base font-medium hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl">Beranda</a>
                <a href="#alur" @click="open = false"
                    class="block px-3 py-3 text-base font-medium hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl">Alur
                    Pengajuan</a>
                <a href="#layanan" @click="open = false"
                    class="block px-3 py-3 text-base font-medium hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl">Layanan</a>

                <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex flex-col gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="w-full text-center bg-red-600 text-white py-3 rounded-xl font-bold">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="w-full text-center text-red-600 font-bold border border-red-600 py-3 rounded-xl font-bold">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="w-full text-center bg-red-600 text-white py-3 rounded-xl font-bold">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header id="beranda"
        class="relative pt-24 pb-16 md:pt-48 md:pb-32 overflow-hidden bg-gradient-to-br from-white to-blue-50 dark:from-gray-900 dark:to-gray-800 transition-colors duration-300">
        <div
            class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 flex flex-col lg:flex-row items-center gap-10 md:gap-12">
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

        <!-- Decorative Circles -->
        <div
            class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 md:w-96 md:h-96 bg-red-100 dark:bg-red-900/20 rounded-full blur-3xl opacity-50 transition-colors">
        </div>
        <div
            class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 md:w-96 md:h-96 bg-blue-100 dark:bg-blue-900/20 rounded-full blur-3xl opacity-50 transition-colors">
        </div>
    </header>

    <!-- Alur Kerja Section -->
    <section id="alur"
        class="py-16 md:py-24 bg-white dark:bg-gray-900 transition-colors duration-300 border-t dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4 uppercase tracking-tight">
                    Langkah Mudah Pengajuan</h2>
                <div class="h-1.5 w-20 bg-red-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 lg:gap-8">
                <!-- Step Cards -->
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

    <!-- Berita & Informasi Section -->
    <section id="berita" class="py-16 md:py-24 bg-gray-50 dark:bg-gray-800/50 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div class="text-left">
                    <h2
                        class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-2 uppercase tracking-tight">
                        Berita & Informasi</h2>
                    <p class="text-gray-600 dark:text-gray-400">Update terbaru seputar kegiatan dan kebijakan
                        KESBANGPOL.</p>
                </div>
                <a href="#"
                    class="text-red-600 dark:text-red-400 font-bold hover:underline flex items-center gap-2 transition">
                    Lihat Semua Berita
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Loop Berita (Simulasi dengan Blade) -->
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
                        class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition duration-300 flex flex-col uppercase-none">
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

    <!-- Footer -->
    <footer class="bg-gray-900 dark:bg-black py-10 md:py-16 text-center border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col items-center gap-6">
                <div class="flex items-center gap-3 grayscale opacity-80">
                    <img src="{{ asset('assets/images/landingPages/logo-kabSubang.webp') }}" class="h-10 w-auto"
                        alt="">
                    <span class="text-white font-bold tracking-widest uppercase">Kesbangpol Subang</span>
                </div>
                <p
                    class="text-gray-500 dark:text-gray-400 text-[10px] md:text-xs tracking-[0.2em] uppercase leading-relaxed">
                    &copy; {{ date('Y') }} BADAN KESATUAN BANGSA DAN POLITIK.<br class="sm:hidden">
                    POWERED BY DISKOMINFO KAB. SUBANG.
                </p>
            </div>
        </div>
    </footer>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</body>

</html>
