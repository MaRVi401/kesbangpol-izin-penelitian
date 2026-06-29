@extends('layouts.master')

@section('title', 'Dashboard Monitoring Kaban')

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
                        Meja Kerja Kepala Badan
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="p-5 bg-blue-50/50 border border-blue-100 rounded-xl shadow-sm dark:bg-blue-900/10 dark:border-blue-900/20">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-blue-600 dark:text-blue-400 tracking-wider">Perlu Diproses</p>
                    <i class="ti ti-clock text-blue-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-blue-700 dark:text-blue-100">{{ $totalMenunggu ?? 0 }}</h5>
            </div>

            <div class="p-5 bg-green-50/50 border border-green-100 rounded-xl shadow-sm dark:bg-green-900/10 dark:border-green-900/20">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-green-600 dark:text-green-400 tracking-wider">Tiket Diterima</p>
                    <i class="ti ti-check text-green-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-green-700 dark:text-green-100">{{ $totalDiterima ?? 0 }}</h5>
            </div>

            <div class="p-5 bg-red-50/50 border border-red-100 rounded-xl shadow-sm dark:bg-red-900/10 dark:border-red-900/20">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-red-600 dark:text-red-400 tracking-wider">Tiket Ditolak</p>
                    <i class="ti ti-x text-red-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-red-700 dark:text-red-100">{{ $totalDitolak ?? 0 }}</h5>
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
                                        <a href="{{ route('kaban.tiket.preview', $tiket->uuid) }}" 
                                            target="_blank"
                                            class="inline-flex items-center justify-center px-3 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 transition-all shadow-sm font-bold text-xs"
                                            title="Preview PDF Tiket">
                                                <i class="ti ti-file-description mr-1"></i> Preview PDF
                                        </a>

                                        <form action="{{ route('kaban.tiket.proses', $tiket->uuid) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="ditolak">
                                            <input type="hidden" name="komentar" class="input-komentar" value="">
                                            <button type="button" 
                                                    data-notiket="{{ $tiket->no_tiket }}"
                                                    class="btn-tolak inline-flex items-center justify-center px-3 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800 transition-all shadow-sm font-bold text-xs"
                                                    title="Tolak Tiket">
                                                <i class="ti ti-x mr-1"></i> Tolak
                                            </button>
                                        </form>

                                        <form action="{{ route('kaban.tiket.proses', $tiket->uuid) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="ditandatangani">
                                            <input type="hidden" name="passphrase" class="input-passphrase" value="">
                                            <button type="button" 
                                                    data-notiket="{{ $tiket->no_tiket }}"
                                                    class="btn-tte inline-flex items-center justify-center px-3 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800 transition-all shadow-sm font-bold text-xs"
                                                    title="Proses TTE">
                                                <i class="ti ti-signature mr-1"></i> Proses TTE
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
                                    @if($history->status == 'ditandatangani')
                                        <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wider text-green-700 bg-green-100 rounded-lg dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                                            DITANDATANGANI
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wider text-red-700 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">
                                            DITOLAK
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('kaban.tiket.preview', $history->uuid) }}" 
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
@endsection

@push('scripts')
    @vite(['resources/js/dashboard-kaban.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{!! session('success') !!}',
                    confirmButtonColor: '#10b981',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{!! session('error') !!}',
                    confirmButtonColor: '#ef4444'
                });
            @endif

            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Terdapat Kesalahan',
                    html: `
                        <ul class="text-left list-disc list-inside text-sm mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    `,
                    confirmButtonColor: '#ef4444'
                });
            @endif
        });
    </script>
@endpush