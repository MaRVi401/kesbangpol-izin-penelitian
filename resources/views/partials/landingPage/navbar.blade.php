<nav
    class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl flex flex-wrap items-center justify-between mx-auto p-4">
        {{-- Logo Section --}}
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            {{-- <img src="{{ asset('assets/images/landingPages/logo-diskominfo.png') }}" class="h-8 hidden md:block" alt="Logo" /> --}}
            <span class="self-center text-2xl font-bold whitespace-nowrap">E-Gov SUBANG</span>
        </a>

        {{-- Action Buttons (Login/Dashboard & Mobile Toggle) --}}
        <div class="flex md:order-2 space-x-3 md:space-x-2 rtl:space-x-reverse items-center">
            @auth
                {{-- Tombol Dashboard untuk semua user yang login --}}
                <a href="{{ route('dashboard') }}"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition shadow-md">
                    Dashboard
                </a>
            @else
                {{-- Tombol Login dengan icon masuk --}}
                <a href="{{ route('login') }}"
                    class="inline-flex items-center text-gray-900 dark:text-white bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 transition duration-300 dark:bg-gray-800 dark:border-gray-600 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 18 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3" />
                    </svg>
                    Login
                </a>
            @endauth

            {{-- Hamburger Menu for Mobile --}}
            <button data-collapse-toggle="navbar-cta" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>

        {{-- Navigation Links --}}
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-cta">
            <ul
                class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900">
                <li><a href="#beranda" class="nav-link block py-2 px-3 md:p-0" id="link-beranda">Beranda</a></li>
                <li><a href="#layanan" class="nav-link block py-2 px-3 md:p-0" id="link-layanan">Layanan</a></li>
                <li><a href="#informasi" class="nav-link block py-2 px-3 md:p-0" id="link-informasi">Informasi</a></li>
            </ul>
        </div>
    </div>
</nav>
