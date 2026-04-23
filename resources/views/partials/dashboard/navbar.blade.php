{{-- NAVBAR --}}
<nav class="fixed top-0 z-50 w-full bg-neutral-primary-soft border-b border-default dark:border-default-medium">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <button data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-body rounded-base sm:hidden hover:bg-neutral-secondary-medium focus:outline-none focus:ring-2 focus:ring-neutral-tertiary">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z">
                        </path>
                    </svg>
                </button>
                <a href="#" class="flex ms-2 md:me-24">
                    <img src="{{ asset('assets/images/dashboard/logo-diskominfo.png') }}" class="h-8 me-3"
                        alt="Logo-Dashboard" />
                    <span class="self-center text-xl font-bold whitespace-nowrap text-heading">E-Gov Service</span>
                </a>
            </div>

            <div class="flex items-center gap-2">
                <button id="theme-toggle" type="button"
                    class="text-body hover:bg-neutral-secondary-medium focus:outline-none focus:ring-4 focus:ring-neutral-tertiary rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z">
                        </path>
                    </svg>
                </button>

                <div class="flex items-center ms-3">
                    <button type="button"
                        class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-neutral-tertiary"
                        data-dropdown-toggle="dropdown-user">
                        <img class="w-8 h-8 rounded-full object-cover"
                            src="{{ auth()->check() && auth()->user()->avatar
                                ? \Illuminate\Support\Facades\Storage::disk('s3')->url(auth()->user()->avatar)
                                : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nama ?? 'Guest') }}"
                            alt="user photo"
                            onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama ?? 'Guest') }}';">
                    </button>
                    <div class="z-50 hidden my-4 text-base list-none bg-white dark:bg-neutral-primary-medium divide-y divide-default border border-default dark:border-default-medium rounded-base shadow-lg"
                        id="dropdown-user">
                        <div class="px-4 py-3">
                            <p class="text-sm font-medium text-heading">{{ auth()->user()->nama ?? 'Tamu' }}</p>
                            <p class="text-sm text-body truncate">
                                {{ auth()->user()->email ?? 'guest@kominfoservice.com' }}</p>
                        </div>
                        <ul class="py-1">
                            <li>
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-body hover:bg-neutral-secondary-soft">
                                    Edit Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sign out
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
