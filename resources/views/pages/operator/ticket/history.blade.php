@extends('layouts.main')

@section('title', 'Riwayat Penanganan Tiket')

@section('content')
    <div class="p-4 mt-14">
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-colors">
                        <svg class="w-3 h-3 me-2.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-500">
                            Riwayat Penanganan
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Riwayat Penanganan Tiket</h2>
        </div>
        <hr class="mb-6 border-gray-200 dark:border-gray-700">

        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 mb-6">
            <div class="w-full md:w-3/4">
                <form action="{{ route('ticket.history') }}" method="GET" class="flex flex-col md:flex-row gap-3 w-full">
                    
                    <div class="w-full md:w-48 shrink-0">
                        <select name="filter_time" onchange="this.form.submit()" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-colors cursor-pointer">
                            <option value="">Semua Waktu</option>
                            <option value="hari" {{ request('filter_time') == 'hari' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="minggu" {{ request('filter_time') == 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="bulan" {{ request('filter_time') == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                        </select>
                    </div>

                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>

                        <input type="text" name="search" id="simple-search" value="{{ request('search') }}"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Cari no tiket, pemohon, atau layanan...">

                        @if (request('search') || request('filter_time'))
                            <a href="{{ route('ticket.history') }}"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-red-500 transition-colors"
                                title="Bersihkan Pencarian dan Filter">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold text-gray-900 dark:text-white w-16">No</th>
                            <th scope="col" class="px-6 py-4 font-bold">No Tiket</th>
                            <th scope="col" class="px-6 py-4 font-bold">Layanan</th>
                            <th scope="col" class="px-6 py-4 font-bold">Pemohon</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Tgl Selesai</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                            <th scope="col" class="px-6 py-4 text-right font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($tickets as $index => $ticket)
                            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $tickets->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <span class="font-mono text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded border border-gray-200 dark:border-gray-600">
                                        {{ $ticket->no_tiket ?? '-' }}
                                    </span>
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-blue-600 dark:text-blue-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $ticket->layanan->nama ?? 'Layanan Tidak Ditemukan' }}
                                        </span>
                                    </div>
                                </th>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                    {{ $ticket->user->nama ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $ticket->updated_at->format('d M Y, H:i') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($ticket->status === 'selesai')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border bg-green-100 text-green-800 border-green-300 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800 shadow-sm">
                                            Selesai
                                        </span>
                                    @elseif($ticket->status === 'ditolak')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border bg-red-100 text-red-800 border-red-300 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800 shadow-sm">
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border bg-gray-100 text-gray-800 border-gray-300 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 shadow-sm">
                                            {{ ucfirst($ticket->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button"
                                            data-modal-target="detail-modal-{{ $ticket->uuid }}" 
                                            data-modal-toggle="detail-modal-{{ $ticket->uuid }}"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 transition-all shadow-sm"
                                            title="Lihat Detail Tiket">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Detail
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <p class="text-gray-500 dark:text-gray-400 font-medium">
                                            @if(request('search'))
                                                Riwayat tiket dengan kata kunci tersebut tidak ditemukan.
                                            @else
                                                Belum ada riwayat tiket yang Anda selesaikan atau tolak.
                                            @endif
                                        </p>

                                        @if(request('search'))
                                            <a href="{{ route('ticket.history') }}"
                                                class="mt-4 text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                Tampilkan semua riwayat
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($tickets->hasPages())
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $tickets->appends([
                        'search' => request('search'), 
                        'filter_time' => request('filter_time')
                    ])->links() }}
                </div>
            @endif
        </div>

        @foreach($tickets as $ticket)
            <div id="detail-modal-{{ $ticket->uuid }}" tabindex="-1" aria-hidden="true" 
                class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Detail Tiket: {{ $ticket->no_tiket }}
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detail-modal-{{ $ticket->uuid }}">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-1 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Layanan</label>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $ticket->layanan->nama ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block mb-1 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Pemohon</label>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $ticket->user->nama ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block mb-1 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Tanggal Selesai</label>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $ticket->updated_at->format('d F Y, H:i') }} WIB</p>
                                </div>
                                <div>
                                    <label class="block mb-1 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Status Akhir</label>
                                    <div>
                                        @if($ticket->status === 'selesai')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 border border-green-300">Selesai</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 border border-red-300">Ditolak</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr class="border-gray-200 dark:border-gray-700">

                            <div>
                                <label class="block mb-1 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Isi Pengaduan / Deskripsi</label>
                                <div class="p-3 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <p class="text-sm text-gray-700 dark:text-gray-300 italic">
                                        "{{ $ticket->detailPengaduan->deskripsi ?? 'Tidak ada deskripsi tambahan.' }}"
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button data-modal-hide="detail-modal-{{ $ticket->uuid }}" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection