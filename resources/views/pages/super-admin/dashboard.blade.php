@extends('layouts.main')

@section('title', 'Super Admin Dashboard')

@section('content')
    <div class="space-y-6">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Gambaran Umum Analisis Pengguna</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Ringkasan distribusi dan statistik data pengguna
                    sistem.</p>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Total Users --}}
            <div
                class="p-6 rounded-base bg-neutral-primary-medium border border-default shadow-sm hover:border-primary/50 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 tracking-wider">Total Users
                    </p>
                    <div class="p-2 rounded-lg bg-blue-500/10 text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold text-slate-900 dark:text-white">{{ $stats['total_users'] }}</p>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-2">Seluruh pengguna terdaftar</p>
            </div>

            {{-- Joined Today --}}
            <div
                class="p-6 rounded-base bg-neutral-primary-medium border border-default shadow-sm hover:border-emerald-500/50 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 tracking-wider">User Baru
                        Hari Ini</p>
                    <div class="p-2 rounded-lg bg-emerald-500/10 text-emerald-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <line x1="20" y1="8" x2="20" y2="14"></line>
                            <line x1="23" y1="11" x2="17" y2="11"></line>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold text-slate-900 dark:text-white">{{ $stats['new_users_today'] }}</p>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-2">User baru hari ini</p>
            </div>

            {{-- Active Roles --}}
            <div
                class="p-6 rounded-base bg-neutral-primary-medium border border-default shadow-sm hover:border-amber-500/50 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 tracking-wider">Total Role
                    </p>
                    <div class="p-2 rounded-lg bg-amber-500/10 text-amber-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold text-slate-900 dark:text-white">{{ $stats['total_roles'] }}</p>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-2">Variasi peran dalam sistem</p>
            </div>
        </div>

        {{-- Chart and Insights --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div
                class="lg:col-span-1 bg-neutral-primary-medium rounded-base border border-default p-6 flex flex-col h-full">
                <h3 class="text-center text-lg font-bold text-slate-900 dark:text-white mb-6    ">Distribusi Pengguna</h3>
                <div class="relative grow flex items-center justify-center min-h-60">
                    <canvas id="userRoleChart" data-labels="{{ json_encode($chartData['labels']) }}"
                        data-values="{{ json_encode($chartData['data']) }}">
                    </canvas>
                </div>
            </div>

            <div class="lg:col-span-2 bg-neutral-primary-medium rounded-base border border-default p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Rincian Distribusi Pengguna</h3>
                    <a href="{{ route('user-management.index') }}"
                        class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                        Kelola User →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($chartData['labels'] as $index => $label)
                        <div
                            class="flex items-center justify-between p-4 rounded-lg bg-neutral-secondary-soft border border-default">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full"
                                    style="background-color: {{ ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'][$index] ?? '#6366f1' }}">
                                </div>
                                <span
                                    class="font-medium text-slate-700 dark:text-slate-200 text-sm">{{ $label }}</span>
                            </div>
                            <span class="text-slate-900 dark:text-white font-bold">{{ $chartData['data'][$index] }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 p-4 rounded-base bg-blue-500/5 border border-blue-500/10">
                    <div class="flex gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Data distribusi peran membantu Anda memantau beban akses sistem. Pastikan jumlah akun dengan
                            peran <span class="text-slate-900 dark:text-white font-bold">Super Admin</span> tetap
                            terjaga untuk keamanan
                            infrastruktur.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        @vite('resources/js/user-management.js')
    @endpush
@endsection
