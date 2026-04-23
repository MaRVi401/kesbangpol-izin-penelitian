@extends('layouts.main')
@section('title', 'Security Logs')

@section('content')
    <div class="p-4 mt-14">
        <a href="{{ route('siem.index') }}"
            class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 mb-6 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Dashboard SIEM
        </a>


        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Riwayat Akses Keamanan</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pencatatan aktivitas login, logout, dan indikasi ancaman
                siber.</p>
        </div>

        <div
            class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-4">Waktu</th>
                            <th scope="col" class="px-6 py-4">Username / Email Attempt</th>
                            <th scope="col" class="px-6 py-4">IP Address</th>
                            <th scope="col" class="px-6 py-4">Event</th>
                            <th scope="col" class="px-6 py-4 text-center">Status Keamanan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $log->username_attempt }}
                                    @if ($log->user)
                                        <span class="block text-xs text-blue-500">Terdaftar sebagai:
                                            {{ $log->user->nama }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4"><span
                                        class="font-mono bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ $log->ip_address }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($log->tipe_event === 'login_sukses')
                                        <span class="text-green-600 font-semibold">Login Berhasil</span>
                                    @elseif($log->tipe_event === 'login_gagal')
                                        <span class="text-red-600 font-semibold">Login Gagal</span>
                                    @else
                                        <span
                                            class="text-gray-600 dark:text-gray-300">{{ ucfirst($log->tipe_event) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($log->is_suspicious)
                                        <span
                                            class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-400 animate-pulse">SUSPICIOUS
                                            (Alerted)</span>
                                    @else
                                        <span
                                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">Aman</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center">Tidak ada log keamanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $logs->links() }}</div>
    </div>
@endsection
