{{-- NAVBAR --}}
<nav
    class="fixed top-0 z-50 w-full bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">

            <div class="flex items-center justify-start">
                <button data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-red-500 dark:text-gray-400 dark:hover:bg-gray-700">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z">
                        </path>
                    </svg>
                </button>

                <a href="{{ route('dashboard') }}" class="flex ms-2 md:me-24 items-center gap-3">
                    <img src="{{ asset('assets/images/dashboard/logo-kabSubang.webp') }}" class="h-10 w-auto"
                        alt="Logo" />
                    <div class="flex flex-col border-l-2 border-red-600 pl-3 font-sans">
                        <span
                            class="font-bold text-gray-900 dark:text-white leading-none text-sm sm:text-lg uppercase">SIREKIPEMA</span>
                        <span
                            class="text-[9px] sm:text-xs text-gray-500 dark:text-gray-400 tracking-widest uppercase font-semibold">KESBANGPOL
                            Subang</span>
                    </div>
                </a>
            </div>

            {{-- Bagian Kanan: Theme Toggle & User Menu --}}
            <div class="flex items-center gap-3">
                {{-- Theme Toggle --}}
                <button id="theme-toggle" type="button"
                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-red-100 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 transition">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z">
                        </path>
                    </svg>
                </button>

                {{-- User Dropdown --}}
                <div class="flex items-center ms-1">
                    <button type="button"
                        class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-red-100 dark:focus:ring-gray-700 transition"
                        data-dropdown-toggle="dropdown-user">
                        <img class="w-9 h-9 rounded-full object-cover border-2 border-white dark:border-gray-800 shadow-sm"
                            src="{{ auth()->check() && auth()->user()->avatar
                                ? route('avatar.display', ['filename' => basename(auth()->user()->avatar)])
                                : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nama ?? 'Guest') . '&background=DC2626&color=fff' }}"
                            alt="user photo"
                            onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama ?? 'Guest') }}&background=DC2626&color=fff';">
                    </button>

                    {{-- Dropdown Menu --}}
                    <div class="z-50 hidden my-4 text-base list-none bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700 border border-gray-100 dark:border-gray-700 rounded-xl shadow-xl"
                        id="dropdown-user">
                        <div class="px-4 py-3">
                            <p class="text-sm font-bold text-gray-900 dark:text-white">
                                {{ auth()->user()->nama ?? 'Tamu' }}</p>
                            <p class="text-xs font-medium text-gray-500 truncate dark:text-gray-400">
                                {{ auth()->user()->email ?? 'guest@kominfoservice.com' }}
                            </p>
                        </div>
                        <ul class="py-1">
                            <li>
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-400 transition">
                                    Edit Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition font-bold"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Keluar
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
