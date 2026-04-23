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

    @include('partials.dashboard.navbar')

    @include('partials.dashboard.sidebar')
    <main class="p-4 sm:ml-64 mt-14">
        @yield('content')
    </main>
    @vite('resources/js/main.js')
    
    <script nonce="{{ $csp_nonce }}" src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script nonce="{{ $csp_nonce }}" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script nonce="{{ $csp_nonce }}" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>

</html>
