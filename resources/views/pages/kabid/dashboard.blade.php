@extends('layouts.master')

@section('title', 'Dashboard Monitoring Kabid')

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
                        <span class="block md:inline text-transparent bg-clip-text bg-linear-to-r from-blue-600 to-cyan-500 uppercase font-black">
                            {{ auth()->user()->nama }}
                        </span>
                    </h2>
                    <p class="mt-1 text-xs md:text-sm text-gray-500 dark:text-gray-400 tracking-wider">
                        Meja Kerja Kepala Bidang
                    </p>
                </div>
                
                <div class="flex flex-col md:flex-row items-center gap-4">
                    <div class="flex items-center justify-center md:justify-end space-x-3 md:space-x-4 bg-white dark:bg-gray-800 px-4 py-2 md:px-5 md:py-2.5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all hover:shadow-md">
                        <div class="flex flex-col items-center md:items-end border-r border-gray-200 dark:border-gray-600 pr-3 md:pr-4">
                            <span id="realtime-clock" class="text-lg md:text-xl font-black font-mono text-blue-600 dark:text-blue-400 leading-none">00:00:00</span>
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
        </div>

        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 flex items-center gap-2" role="alert">
                <i class="ti ti-check text-lg"></i>
                <span class="font-medium">Berhasil!</span> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 flex items-center gap-2" role="alert">
                <i class="ti ti-alert-circle text-lg"></i>
                <span class="font-medium">Gagal!</span> {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="p-5 bg-blue-50/50 border border-blue-100 rounded-xl shadow-sm dark:bg-blue-900/10 dark:border-blue-900/20">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-blue-600 dark:text-blue-400 tracking-wider">Perlu Diproses</p>
                    <i class="ti ti-clock text-blue-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-blue-700 dark:text-blue-100">{{ $totalMenunggu }}</h5>
            </div>

            <div class="p-5 bg-green-50/50 border border-green-100 rounded-xl shadow-sm dark:bg-green-900/10 dark:border-green-900/20">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-green-600 dark:text-green-400 tracking-wider">Tiket Diterima</p>
                    <i class="ti ti-check text-green-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-green-700 dark:text-green-100">{{ $totalDiterima }}</h5>
            </div>

            <div class="p-5 bg-red-50/50 border border-red-100 rounded-xl shadow-sm dark:bg-red-900/10 dark:border-red-900/20">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-red-600 dark:text-red-400 tracking-wider">Tiket Ditolak</p>
                    <i class="ti ti-x text-red-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-red-700 dark:text-red-100">{{ $totalDitolak }}</h5>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden flex flex-col mb-8">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30 flex justify-between items-center text-heading font-bold italic">
                <h3 class="flex items-center text-gray-900 dark:text-white">
                    <i class="ti ti-inbox text-blue-600 me-2 text-xl"></i> Antrean Tiket Verifikasi Lengkap
                </h3>
            </div>

            <div class="relative overflow-x-auto bg-white dark:bg-[#1e293b]">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs uppercase bg-white dark:bg-[#1e293b] border-b border-gray-100 dark:border-gray-700/50">
                        <tr>
                            <th class="px-6 py-5 font-black tracking-widest text-blue-900 dark:text-blue-400">No. Tiket</th>
                            <th class="px-6 py-5 font-black tracking-widest text-blue-900 dark:text-blue-400">Pengaju</th>
                            <th class="px-6 py-5 font-black tracking-widest text-blue-900 dark:text-blue-400">Layanan</th>
                            <th class="px-6 py-5 font-black tracking-widest text-blue-900 dark:text-blue-400">Status</th>
                            <th class="px-6 py-5 font-black tracking-widest text-blue-900 dark:text-blue-400 text-center">Aksi (Terima/Tolak)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                        @forelse($tiketMenunggu as $tiket)
                            <tr class="hover:bg-blue-50/30 dark:hover:bg-slate-700/40 transition-all duration-200">
                                <td class="px-6 py-4">
                                    <span class="inline-block px-2.5 py-1 text-xs font-black rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 tracking-wider">
                                        {{ $tiket->no_tiket }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $tiket->user->nama ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    {{ $tiket->layanan->nama ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wider text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                        {{ $tiket->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('kabid.tiket.preview', $tiket->uuid) }}" 
                                            target="_blank"
                                            class="inline-flex items-center justify-center px-3 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 transition-all shadow-sm font-bold text-xs"
                                            title="Preview PDF Tiket">
                                                <i class="ti ti-file-description mr-1"></i> Preview PDF
                                        </a>
                                        <form action="{{ route('kabid.tiket.proses', $tiket->uuid) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="diterima">
                                            <button type="button" 
                                                    class="btn-terima inline-flex items-center justify-center px-3 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800 transition-all shadow-sm font-bold text-xs"
                                                    title="Terima Tiket">
                                                <i class="ti ti-check mr-1"></i> Terima
                                            </button>
                                        </form>
                                        <form action="{{ route('kabid.tiket.proses', $tiket->uuid) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="ditolak">
                                            <input type="hidden" name="komentar" class="input-komentar" value="">
                                            <button type="button" 
                                                    data-notiket="{{ $tiket->no_tiket }}"
                                                    class="btn-tolak inline-flex items-center justify-center px-3 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900 transition-all shadow-sm font-bold text-xs"
                                                    title="Tolak Tiket">
                                                <i class="ti ti-x mr-1"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center italic text-gray-400 dark:text-gray-500 bg-white dark:bg-[#1e293b]">
                                    Belum ada tiket yang berstatus 'Verifikasi Lengkap' untuk diproses.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-5 py-4 bg-gray-50 dark:bg-[#1e293b] border-t border-gray-100 dark:border-gray-700 rounded-b-xl">
                {{ $tiketMenunggu->links() }}
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden flex flex-col">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30 flex justify-between items-center text-heading font-bold italic">
                <h3 class="flex items-center text-gray-900 dark:text-white">
                    <i class="ti ti-history text-blue-600 me-2 text-xl"></i> Riwayat Tiket Diproses
                </h3>
            </div>

            <div class="relative overflow-x-auto bg-white dark:bg-[#1e293b]">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs uppercase bg-white dark:bg-[#1e293b] border-b border-gray-100 dark:border-gray-700/50">
                        <tr>
                            <th class="px-6 py-5 font-black tracking-widest text-blue-900 dark:text-blue-400">No. Tiket</th>
                            <th class="px-6 py-5 font-black tracking-widest text-blue-900 dark:text-blue-400">Pengaju</th>
                            <th class="px-6 py-5 font-black tracking-widest text-blue-900 dark:text-blue-400">Layanan</th>
                            <th class="px-6 py-5 font-black tracking-widest text-blue-900 dark:text-blue-400">Status</th>
                            <th class="px-6 py-5 font-black tracking-widest text-blue-900 dark:text-blue-400 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                        @forelse($tiketHistory as $history)
                            <tr class="hover:bg-blue-50/30 dark:hover:bg-slate-700/40 transition-all duration-200">
                                <td class="px-6 py-4">
                                    <span class="inline-block px-2.5 py-1 text-xs font-black rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 tracking-wider">
                                        {{ $history->no_tiket }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $history->user->nama ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    {{ $history->layanan->nama ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($history->status == 'diterima')
                                        <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wider text-green-700 bg-green-100 rounded-lg dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                                            DITERIMA
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wider text-red-700 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">
                                            DITOLAK
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('kabid.tiket.preview', $history->uuid) }}" 
                                        target="_blank"
                                        class="inline-flex items-center justify-center px-3 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 dark:focus:ring-gray-800 transition-all shadow-sm font-bold text-xs"
                                        title="Preview PDF Tiket">
                                            <i class="ti ti-file-description mr-1"></i> Preview PDF
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center italic text-gray-400 dark:text-gray-500 bg-white dark:bg-[#1e293b]">
                                    Belum ada riwayat tiket yang diproses.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-5 py-4 bg-gray-50 dark:bg-[#1e293b] border-t border-gray-100 dark:border-gray-700 rounded-b-xl">
                {{ $tiketHistory->links() }}
            </div>
        </div>
    </div>

    <div id="modalTolakTiket" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm overflow-y-auto h-full w-full items-center justify-center p-4">
        <div class="relative w-full max-w-lg bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-6 md:p-8 border border-gray-100 dark:border-gray-700 flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-black text-gray-900 dark:text-white flex items-center gap-3">
                    <i class="ti ti-alert-triangle text-red-600 text-2xl"></i> Tolak Tiket
                </h3>
                <button onclick="tutupModalTolak()" type="button" class="text-gray-400 hover:text-red-500 transition-colors">
                    <i class="ti ti-x text-2xl"></i>
                </button>
            </div>

            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                Anda akan menolak tiket dengan nomor: <span id="nomor_tiket_tolak" class="font-bold text-gray-900 dark:text-white"></span>
            </p>

            <form id="formTolakTiket" method="POST" action="">
                @csrf
                <input type="hidden" name="status" value="ditolak">
                <div class="mb-5">
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2 tracking-widest">Alasan Penolakan <span class="text-red-500">*</span></label>
                    <textarea name="komentar" required class="w-full min-h-30 bg-gray-50 dark:bg-gray-700/50 border-2 border-gray-100 dark:border-gray-700 text-gray-900 dark:text-white text-sm rounded-2xl p-4 focus:ring-0 focus:border-red-500 outline-none resize-none transition-colors" placeholder="Masukkan alasan mengapa tiket ini ditolak..."></textarea>
                </div>

                <div class="flex justify-end gap-3 mt-5">
                    <button type="button" onclick="tutupModalTolak()" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 shadow-lg shadow-red-500/30 transition flex items-center gap-2">
                        <i class="ti ti-send"></i> Konfirmasi Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/dashboard-kabid.js'])
@endpush