@extends('layouts.main')

@section('title', 'Dashboard Pengguna ASN')

@section('content')
    <div class="p-4 mt-14">
        <div class="mb-8 border-b border-gray-200 pb-6 dark:border-gray-700">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div class="text-center md:text-left">
                    <h2 class="text-xl md:text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                        @php
                            $hour = date('H');
                            $sapaan = $hour < 12 ? 'Pagi' : ($hour < 15 ? 'Siang' : ($hour < 18 ? 'Sore' : 'Malam'));
                        @endphp
                        Selamat <span id="sapaan-teks">{{ $sapaan }}</span>,
                        <span class="block md:inline text-transparent bg-clip-text bg-linear-to-r from-blue-600 to-cyan-500 uppercase">
                            {{ auth()->user()->nama }}
                        </span>
                    </h2>
                    <p class="mt-1 text-xs md:text-sm text-gray-500 dark:text-gray-400 font-medium">
                        Sistem Layanan Digital KOMINFO Subang
                    </p>
                </div>

                <div class="flex items-center justify-center md:justify-end space-x-3 md:space-x-4 bg-gray-50 dark:bg-gray-800/50 px-4 py-2 md:px-5 md:py-2.5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all">
                    <div class="flex flex-col items-center md:items-end border-r border-gray-300 dark:border-gray-600 pr-3 md:pr-4">
                        <span id="realtime-clock" class="text-lg md:text-xl font-black font-mono text-blue-600 dark:text-blue-400 leading-none">
                            00:00:00
                        </span>
                        <span class="text-[9px] md:text-[10px] uppercase tracking-widest font-bold text-gray-400 mt-1">Waktu Server</span>
                    </div>

                    <div class="flex flex-col text-left">
                        <span class="text-xs md:text-sm font-bold text-gray-700 dark:text-gray-200 leading-none">
                            {{ \Carbon\Carbon::now()->translatedFormat('l') }}
                        </span>
                        <span class="text-[10px] md:text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Menunggu Antrean</p>
                    <span class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <h5 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalDiajukan }}</h5>
                <div class="mt-4">
                    <a href="{{ route('submission.index') }}" class="text-xs font-bold text-blue-600 hover:underline dark:text-blue-400 inline-flex items-center">
                        Cek Status Pengajuan
                        <svg class="w-3 h-3 ms-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
            </div>

            <div class="p-5 bg-orange-50 border border-orange-200 rounded-lg shadow-sm dark:bg-orange-900/10 dark:border-orange-900/30">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-orange-600 dark:text-orange-400">Sedang Diproses</p>
                    <span class="p-2 bg-orange-100 dark:bg-orange-900/40 rounded-lg">
                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </span>
                </div>
                <h5 class="text-3xl font-bold text-orange-900 dark:text-orange-100">{{ $totalDiproses }}</h5>
            </div>

            <div class="p-5 bg-green-50 border border-green-200 rounded-lg shadow-sm dark:bg-green-900/10 dark:border-green-900/30">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-green-600 dark:text-green-400">Pengajuan Selesai</p>
                    <span class="p-2 bg-green-100 dark:bg-green-900/40 rounded-lg">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <h5 class="text-3xl font-bold text-green-900 dark:text-green-100">{{ $totalSelesai }}</h5>
            </div>

            <div class="p-5 bg-red-50 border border-red-200 rounded-lg shadow-sm dark:bg-red-900/10 dark:border-red-900/30">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-red-600 dark:text-red-400">Pengajuan Ditolak</p>
                    <span class="p-2 bg-red-100 dark:bg-red-900/40 rounded-lg">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <h5 class="text-3xl font-bold text-red-900 dark:text-red-100">{{ $totalDitolak }}</h5>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/30 dark:bg-gray-700/30 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-5 h-5 me-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Pengajuan Terbaru Anda
                    </h3>
                </div>

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50/50 dark:bg-gray-700/50 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3 font-semibold">No. Tiket</th>
                                <th class="px-6 py-3 font-semibold">Layanan</th>
                                <th class="px-6 py-3 font-semibold">Status</th>
                                <th class="px-6 py-3 font-semibold text-right">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($recentTickets as $rt)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-all duration-200">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('submission.show', $rt->uuid) }}" class="font-mono font-bold text-blue-600 hover:underline dark:text-blue-400">
                                            {{ $rt->no_tiket }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-gray-900 dark:text-gray-200 font-medium">{{ $rt->layanan->nama }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $badgeClass = match($rt->status) {
                                                'belum diajukan'=> 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300', 
                                                'diajukan' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-300',
                                                'ditangani' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                                'selesai' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                'ditolak' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $badgeClass }}">
                                            {{ ucwords($rt->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ $rt->created_at->format('d M Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-200 dark:text-gray-700 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                            </svg>
                                            <p class="text-gray-400 dark:text-gray-500 italic">Anda belum memiliki tiket pengajuan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700 bg-gray-50/20 dark:bg-gray-800/50 flex justify-between items-center">
                    <a href="/services" class="text-xs font-bold text-blue-600 hover:underline dark:text-blue-400">
                        + Buat Pengajuan Baru
                    </a>
                    <a href="{{ route('submission.index') }}" class="flex items-center justify-center text-xs font-bold text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors">
                        LIHAT SEMUA
                        <svg class="w-4 h-4 ms-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 p-4">
                <h3 class="font-bold text-gray-900 dark:text-white mb-4">Aktivitas Pengajuan (7 Hari)</h3>
                <div class="relative h-64">
                    <canvas id="performanceChart" data-tren="{{ json_encode($trenData) }}"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- Kita gunakan script yang sama karena id canvas chart dan fungsi jam realtime-nya sama --}}
        @vite('resources/js/dashboard-pengguna-asn.js')
    @endpush
@endsection