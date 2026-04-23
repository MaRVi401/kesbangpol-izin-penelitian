<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="icon" type="image" href="{{ asset('assets/images/landingPages/logo-kabSubang.webp') }}">

    <script nonce="{{ $csp_nonce }}">
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white dark:bg-neutral-primary-soft antialiased transition-colors duration-200">
    <nav class="fixed top-0 z-50 w-full bg-neutral-primary-soft border-b border-default dark:border-default-medium">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
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
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor"
                            viewBox="0 0 20 20">
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

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="hidden">
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


    @yield('content')


    @vite('resources/js/main.js')

    <script nonce="{{ $csp_nonce }}" src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script nonce="{{ $csp_nonce }}" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script nonce="{{ $csp_nonce }}" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>

</html>
