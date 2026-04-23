@extends('layouts.main')

@section('title', 'Halaman Kerja Operator')

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
                            Halaman Kerja
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col md:flex-row items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Tiket Sedang Ditangani</h2>
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

        <div
            class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold text-gray-900 dark:text-white w-16">No</th>
                            <th scope="col" class="px-6 py-4 font-bold">Tiket</th>
                            <th scope="col" class="px-6 py-4 font-bold">Pengaju</th>
                            <th scope="col" class="px-6 py-4 font-bold">Layanan</th>
                            <th scope="col" class="px-6 py-4 text-right font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($tickets as $index => $ticket)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $tickets->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <span
                                        class="font-mono text-xs bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 px-2 py-1 rounded border border-blue-100 dark:border-blue-800">
                                        {{ $ticket->no_tiket ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-bold text-gray-900 dark:text-white">{{ $ticket->user->nama ?? 'N/A' }}</span>
                                        <span class="text-xs text-gray-500">{{ $ticket->user->email ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    {{ $ticket->layanan->nama }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button data-modal-target="update-modal-{{ $ticket->uuid }}"
                                        data-modal-toggle="update-modal-{{ $ticket->uuid }}"
                                        class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-2 rounded-lg text-sm cursor-pointer transition-all shadow-sm">
                                        Prosses Tiket
                                    </button>

                                    <div id="update-modal-{{ $ticket->uuid }}" tabindex="-1" aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                                            <div
                                                class="relative bg-white rounded-lg shadow dark:bg-gray-800 border dark:border-gray-700">
                                                <div
                                                    class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                    <h3
                                                        class="text-xl font-semibold text-gray-900 dark:text-white text-left">
                                                        Update Status: {{ $ticket->no_tiket }}
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

                                                <form action="{{ route('ticket.update', $ticket->uuid) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="p-6 space-y-4 text-left">
                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div>
                                                                <label
                                                                    class="block text-xs text-gray-500 uppercase font-semibold">Pengaju</label>
                                                                <p class="text-sm font-bold text-gray-900 dark:text-white">
                                                                    {{ $ticket->user->nama }}</p>
                                                            </div>
                                                            <div>
                                                                <label
                                                                    class="block text-xs text-gray-500 uppercase font-semibold">Layanan</label>
                                                                <p class="text-sm font-bold text-gray-900 dark:text-white">
                                                                    {{ $ticket->layanan->nama }}</p>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label
                                                                class="block text-xs text-gray-500 uppercase font-semibold">Deskripsi
                                                                Masalah</label>
                                                            <p
                                                                class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg border dark:border-gray-600 italic">
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

                                                        {{-- Menampilkan Screenshot Pengaduan (Folder: pengaduan) --}}
                                                        @if ($ticket->detailPengaduan && $ticket->detailPengaduan->lampiran_screenshot)
                                                            <div class="mt-4">
                                                                <label class="block text-xs text-gray-500 uppercase mb-1">Screenshot Pengaduan</label>
                                                                <img src="{{ Storage::disk('s3')->url($ticket->detailPengaduan->lampiran_screenshot) }}"
                                                                    class="w-full max-h-48 object-contain rounded-lg border dark:border-gray-600 bg-gray-50 dark:bg-gray-900"
                                                                    alt="Lampiran tidak ada">
                                                            </div>
                                                        @endif

                                                        <hr class="dark:border-gray-600">

                                                        <div>
                                                            <label
                                                                class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Pilih
                                                                Status Akhir</label>
                                                            <select name="status" required
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white cursor-pointer">
                                                                <option value="selesai">Selesai (Tiket Berhasil Ditangani)
                                                                </option>
                                                                <option value="ditolak">Tolak (Permohonan Tidak Sesuai)
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div>
                                                            <label
                                                                class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Balasan
                                                                ke Pengguna</label>
                                                            <textarea name="komentar" rows="4" required
                                                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                                                placeholder="Tuliskan instruksi langkah selanjutnya atau alasan penolakan..."></textarea>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="flex items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                        <button type="submit"
                                                            class="text-white bg-orange-600 hover:bg-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all cursor-pointer">
                                                            Simpan Perubahan
                                                        </button>
                                                        <button data-modal-hide="update-modal-{{ $ticket->uuid }}"
                                                            type="button"
                                                            class="ms-3 text-gray-500 bg-white hover:bg-gray-100 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 cursor-pointer hover:text-gray-900 transition-all dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">
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
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 font-medium text-lg">Halaman kerja
                                            kosong.
                                        </p>
                                        <p class="text-sm text-gray-400">Silakan ambil tiket baru di halaman Tiket Masuk.
                                        </p>
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
