@extends('layouts.main')
@section('title', 'Audit Trails')

@section('content')
    <div class="p-4 mt-14">


        <a href="{{ route('siem.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 mb-6 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Dashboard SIEM
        </a>

        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Jejak Audit (Audit Trails)</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Rekaman perubahan data di dalam sistem untuk transparansi operasional.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-4">Waktu & User</th>
                            <th scope="col" class="px-6 py-4">Aksi</th>
                            <th scope="col" class="px-6 py-4">Tabel / Target</th>
                            <th scope="col" class="px-6 py-4">Detail Perubahan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($audits as $audit)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $audit->user ? $audit->user->nama : 'Sistem/Unknown' }}</div>
                                    <div class="text-xs">{{ $audit->created_at->format('d/m/Y H:i') }}</div>
                                    <div class="text-xs text-blue-500 mt-1">IP: {{ $audit->ip_address }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded text-xs font-bold uppercase
                                        {{ $audit->aksi == 'create' ? 'bg-green-100 text-green-800' : ($audit->aksi == 'update' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $audit->aksi }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-mono text-xs">{{ $audit->nama_tabel }}</div>
                                    <div class="text-xs text-gray-400">ID: {{ Str::limit($audit->record_id, 8) }}...</div>
                                </td>
                                <td class="px-6 py-4 w-1/3">
                                    @if($audit->aksi == 'update')
                                        <div class="grid grid-cols-2 gap-2 text-xs">
                                            <div class="p-2 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 rounded border border-red-100 dark:border-red-800">
                                                <strong>Sebelum:</strong><br>
                                                <pre class="whitespace-pre-wrap">{{ json_encode($audit->data_lama, JSON_PRETTY_PRINT) }}</pre>
                                            </div>
                                            <div class="p-2 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded border border-green-100 dark:border-green-800">
                                                <strong>Sesudah:</strong><br>
                                                <pre class="whitespace-pre-wrap">{{ json_encode($audit->data_baru, JSON_PRETTY_PRINT) }}</pre>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-2 bg-gray-50 dark:bg-gray-900 rounded border border-gray-200 dark:border-gray-700 text-xs">
                                            <pre class="whitespace-pre-wrap">{{ json_encode($audit->data_baru ?? $audit->data_lama, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-4 text-center">Belum ada jejak audit.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $audits->links() }}</div>
    </div>
@endsection