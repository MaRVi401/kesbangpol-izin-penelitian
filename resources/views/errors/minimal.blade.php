<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - E-Gov Kominfo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900">
    <div class="flex items-center justify-center min-h-screen px-4 py-12">
        <div class="max-w-lg w-full text-center">
            <div class="mb-8">
                <img class="mx-auto h-16 w-auto" src="{{ asset('assets/images/dashboard/logo-diskominfo.png') }}" alt="Logo Subang">
            </div>
            
            <h1 class="text-9xl font-bold text-blue-600 dark:text-blue-500 mb-4">@yield('code')</h1>
            
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">
                @yield('title')
            </h2>
            
            <p class="text-lg text-slate-600 dark:text-slate-400 mb-10">
                @yield('message')
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ url('/') }}" class="w-full sm:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200">
                    Kembali ke Beranda
                </a>
                <button onclick="history.back()" class="w-full sm:w-auto px-6 py-3 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-semibold rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition duration-200">
                    Kembali Sebelumnya
                </button>
            </div>

            <div class="mt-16 text-slate-400 text-sm">
                &copy; {{ date('Y') }} Diskominfo Kabupaten Subang. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>