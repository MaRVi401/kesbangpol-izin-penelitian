<nav x-data="{ open: false }"
    class="fixed w-full z-50 top-0 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 md:h-20 items-center">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/images/landingPages/logo-kabSubang.webp') }}" class="h-10 sm:h-12 w-auto"
                    alt="Logo Instansi">
                <div class="flex flex-col border-l-2 border-red-600 pl-3 font-sans">
                    <span class="font-bold text-gray-900 dark:text-white leading-none text-sm sm:text-lg">KESBANGPOL</span>
                    <span class="text-[9px] sm:text-xs text-gray-500 dark:text-gray-400 tracking-widest uppercase font-semibold">Kabupaten Subang</span>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-6 lg:gap-8 font-medium text-gray-600 dark:text-gray-300">
                <a href="#beranda" class="hover:text-red-600 dark:hover:text-red-500 transition">Beranda</a>
                <a href="#alur" class="hover:text-red-600 dark:hover:text-red-500 transition">Alur Pengajuan</a>
                <a href="#berita" class="hover:text-red-600 dark:hover:text-red-500 transition">Berita</a>

                <div class="h-6 w-px bg-gray-200 dark:bg-gray-700"></div>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-red-600 text-white px-5 py-2 rounded-full hover:bg-red-700 transition shadow-lg shadow-red-200 dark:shadow-none">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-red-600 dark:hover:text-red-400 transition font-bold border border-red-600 px-5 py-2 rounded-full text-red-600">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-red-600 text-white px-5 py-2 rounded-full hover:bg-red-700 transition shadow-lg shadow-red-200 dark:shadow-none">Daftar</a>
                        @endif
                    @endauth
                @endif
            </div>

            <div class="flex md:hidden items-center">
                <button @click="open = !open" class="text-gray-600 dark:text-gray-300 hover:text-red-600 focus:outline-none transition">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        class="md:hidden bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-xl">
        <div class="px-4 pt-2 pb-6 space-y-1">
            <a href="#beranda" @click="open = false" class="block px-3 py-3 text-base font-medium hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl">Beranda</a>
            <a href="#alur" @click="open = false" class="block px-3 py-3 text-base font-medium hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl">Alur Pengajuan</a>
            <a href="#berita" @click="open = false" class="block px-3 py-3 text-base font-medium hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl">Berita</a>

            <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex flex-col gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full text-center bg-red-600 text-white py-3 rounded-xl font-bold">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center text-red-600 font-bold border border-red-600 py-3 rounded-xl">Masuk</a>
                    <a href="{{ route('register') }}" class="w-full text-center bg-red-600 text-white py-3 rounded-xl font-bold">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
