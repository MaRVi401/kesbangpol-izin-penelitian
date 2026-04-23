@extends('layouts.main')

@section('title', 'Revisi Dari Kadis')

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
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-500">
                            Revisi Dari Kadis
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col md:flex-row items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Tiket Revisi (Dikembalikan oleh Kadis)</h2>
        </div>

        <hr class="mb-6 border-gray-200 dark:border-gray-700">

        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 mb-6">
            <div class="w-full flex flex-col md:flex-row gap-3">
                <form action="{{ url()->current() }}" method="GET" class="flex flex-col md:flex-row gap-3 w-full">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>

                        <input type="text" name="search" value="{{ request('search') }}"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Cari No. Tiket, Layanan, atau Pengaju...">
                        @if (request('search'))
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <a href="{{ url()->current() }}"
                                    class="text-gray-400 hover:text-red-500 transition-colors cursor-pointer"
                                    title="Bersihkan Pencarian">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            </div>
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
                            <th scope="col" class="px-6 py-4 font-bold">Tiket</th>
                            <th scope="col" class="px-6 py-4 font-bold">Pengaju</th>
                            <th scope="col" class="px-6 py-4 font-bold">Layanan</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Prioritas</th>
                            <th scope="col" class="px-6 py-4 text-right font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($tickets as $index => $ticket)
                            @php
                                $usulanKadis = \App\Models\PrioritasTiketKadis::where('tiket_id', $ticket->uuid)
                                                ->where('status_persetujuan', 'disetujui')
                                                ->latest()
                                                ->first();
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $tickets->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <span class="font-mono text-xs bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-300 px-2 py-1 rounded border border-red-100 dark:border-red-800 flex items-center gap-1 w-fit">
                                        <i class="ti ti-alert-circle"></i> {{ $ticket->no_tiket ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-900 dark:text-white">{{ $ticket->user->nama ?? 'N/A' }}</span>
                                        <span class="text-xs text-gray-500">{{ $ticket->user->email ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    {{ $ticket->layanan->nama }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($usulanKadis && $usulanKadis->level_prioritas)
                                        @php
                                            $badgeClass = match($usulanKadis->level_prioritas) {
                                                'tinggi' => 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/50 dark:text-red-300 dark:border-red-800',
                                                'sedang' => 'bg-yellow-100 text-yellow-800 border-yellow-200 dark:bg-yellow-900/50 dark:text-yellow-300 dark:border-yellow-800',
                                                'rendah' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/50 dark:text-green-300 dark:border-green-800',
                                                default => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600'
                                            };
                                        @endphp
                                        <span class="px-2.5 py-1 rounded text-xs font-semibold uppercase border {{ $badgeClass }}">
                                            {{ $usulanKadis->level_prioritas }}
                                        </span>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button data-modal-target="update-modal-{{ $ticket->uuid }}"
                                        data-modal-toggle="update-modal-{{ $ticket->uuid }}"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm cursor-pointer transition-all shadow-sm">
                                        Lihat Revisi
                                    </button>

                                    <div id="update-modal-{{ $ticket->uuid }}" tabindex="-1" aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 border dark:border-gray-700">
                                                <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-left">
                                                        Perbaiki Tiket: {{ $ticket->no_tiket }}
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer"
                                                        data-modal-hide="update-modal-{{ $ticket->uuid }}">
                                                        <svg class="w-3 h-3" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>

                                                <form action="{{ route('ticket.update', $ticket->uuid) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="p-6 space-y-4 text-left">
                                                        
                                                        @if($usulanKadis)
                                                            <div class="space-y-3">
                                                                @if($usulanKadis->catatan_kabid)
                                                                    <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg dark:bg-blue-900/20">
                                                                        <div class="flex items-center mb-2">
                                                                            <i class="ti ti-message-circle-2 text-blue-600 dark:text-blue-400 text-lg mr-2"></i>
                                                                            <h4 class="text-sm font-bold text-blue-800 dark:text-blue-300 uppercase tracking-wide">Catatan dari Kabid</h4>
                                                                        </div>
                                                                        <p class="text-sm text-blue-700 dark:text-blue-400 italic">
                                                                            "{{ $usulanKadis->catatan_kabid }}"
                                                                        </p>
                                                                    </div>
                                                                @endif

                                                                @if($usulanKadis->catatan_kadis)
                                                                    <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg dark:bg-red-900/20">
                                                                        <div class="flex items-center mb-2">
                                                                            <i class="ti ti-message-exclamation text-red-600 dark:text-red-400 text-lg mr-2"></i>
                                                                            <h4 class="text-sm font-bold text-red-800 dark:text-red-300 uppercase tracking-wide">Instruksi Revisi dari Kadis</h4>
                                                                        </div>
                                                                        <p class="text-sm text-red-700 dark:text-red-400 italic">
                                                                            "{{ $usulanKadis->catatan_kadis }}"
                                                                        </p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                                            <div>
                                                                <label class="block text-xs text-gray-500 uppercase font-semibold">Pengaju</label>
                                                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $ticket->user->nama }}</p>
                                                            </div>
                                                            <div>
                                                                <label class="block text-xs text-gray-500 uppercase font-semibold">Layanan</label>
                                                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $ticket->layanan->nama }}</p>
                                                            </div>
                                                            <div>
                                                                <label class="block text-xs text-gray-500 uppercase font-semibold">Prioritas</label>
                                                                <p class="text-sm font-bold text-gray-900 dark:text-white uppercase">
                                                                    {{ $usulanKadis->level_prioritas ?? '-' }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label class="block text-xs text-gray-500 uppercase font-semibold">Deskripsi Masalah</label>
                                                            <p class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg border dark:border-gray-600 italic">
                                                                "{{ $ticket->deskripsi }}"
                                                            </p>
                                                        </div>

                                                        @if ($ticket->lampiran)
                                                            <div class="mt-4">
                                                                <label class="block text-xs text-gray-500 uppercase mb-1">Lampiran</label>
                                                                <img src="{{ Storage::disk('s3')->url($ticket->lampiran) }}"
                                                                    class="w-full max-h-48 object-contain rounded-lg border dark:border-gray-600 bg-gray-50 dark:bg-gray-900"
                                                                    alt="Lampiran Tidak ada">
                                                            </div>
                                                        @endif

                                                        <hr class="dark:border-gray-600 mt-4">

                                                        <div class="mt-4">
                                                            <label class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Pilih Status Akhir</label>
                                                            <select name="status" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white cursor-pointer">
                                                                <option value="selesai">Selesai (Revisi Berhasil Ditangani)</option>
                                                                <option value="ditolak">Tolak (Permohonan Tidak Sesuai)</option>
                                                            </select>
                                                        </div>

                                                        <div>
                                                            <label class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Balasan ke Pengguna</label>
                                                            <textarea name="komentar" rows="4" required class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Tuliskan alasan penolakan atau keterangan revisi selesai..."></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                        <button type="submit" class="text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all cursor-pointer">
                                                            Simpan Revisi
                                                        </button>
                                                        <button data-modal-hide="update-modal-{{ $ticket->uuid }}" type="button" class="ms-3 text-gray-500 bg-white hover:bg-gray-100 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 cursor-pointer hover:text-gray-900 transition-all dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">
                                                            Batal
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 font-medium text-lg">Tidak ada tiket revisi.</p>
                                        <p class="text-sm text-gray-400">Kerja bagus! Semua revisi sudah diselesaikan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($tickets->hasPages())
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $tickets->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection