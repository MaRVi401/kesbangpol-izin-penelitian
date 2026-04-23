@extends('layouts.main')

@section('title', 'SIEM Dashboard')

@section('content')
    <div class="p-4 mt-14">
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-colors">
                        <svg class="w-3 h-3 me-2.5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-500">Security & Audit
                            (SIEM)</span>
                    </div>
                </li>
            </ol>
        </nav>
        <hr class="mb-6 border-gray-200 dark:border-gray-700">

        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Security & Event Management</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Pantau aktivitas keamanan dan jejak audit sistem.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 mb-6">
            <a href="{{ route('siem.security-logs', ['is_suspicious' => 1]) }}"
                class="p-6 rounded-base bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:border-red-500/50 transition-colors block">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 tracking-wider">Peringatan Kritis
                        (Alerts)</p>
                    <div class="p-2 rounded-lg bg-red-500/10 text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold text-slate-900 dark:text-white">{{ $totalSuspicious ?? 0 }}</p>
                <p class="text-xs text-red-500 mt-2">Deteksi percobaan login paksa atau anomali</p>
            </a>

            <a href="{{ route('siem.audit-trails') }}"
                class="p-6 rounded-base bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:border-blue-500/50 transition-colors block">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 tracking-wider">Aktivitas Hari Ini
                    </p>
                    <div class="p-2 rounded-lg bg-blue-500/10 text-blue-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold text-slate-900 dark:text-white">Lihat Jejak Audit →</p>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-2">Pantau perubahan data (CRUD) oleh pengguna</p>
            </a>
        </div>
    </div>
@endsection
