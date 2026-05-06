@extends('layouts.main')

@section('title', 'Detail Pengajuan Tiket')

@section('content')
<div class="p-4 mt-14">
    <hr class="mb-6 border-gray-200 dark:border-gray-700">

    <div class="max-w-4xl mx-auto">
        
        <div class="mb-6 flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Tiket #{{ $ticket->no_tiket }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Layanan: <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $ticket->layanan->nama ?? 'Surat Permohonan Izin Penelitian' }}</span></p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold border 
                    {{ $ticket->status == 'diajukan' ? 'bg-gray-100 text-gray-800 border-gray-200' : 
                      ($ticket->status == 'ditangani' ? 'bg-blue-100 text-blue-800 border-blue-200' : 
                      ($ticket->status == 'selesai' ? 'bg-green-100 text-green-800 border-green-200' : 'bg-red-100 text-red-800 border-red-200')) }}">
                    Status: {{ Str::ucfirst($ticket->status) }}
                </span>

                @if($jumlahRevisi > 0)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold border bg-purple-100 text-red-800 border-purple-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Revisi ke-{{ $jumlahRevisi }}
                    </span>
                @endif
            </div>
        </div>

        @if(in_array($ticket->status, ['verifikasi lengkap', 'verifikasi gagal', 'diterima', 'ditolak']))
            @if($ticket->komentar->isNotEmpty())
                @php
                    $isError = in_array($ticket->status, ['verifikasi gagal', 'ditolak']);
                @endphp
                
                <div class="mb-6 p-5 rounded-xl border shadow-sm {{ $isError ? 'bg-red-50 border-red-200 dark:bg-red-900/10 dark:border-red-800' : 'bg-green-50 border-green-200 dark:bg-green-900/10 dark:border-green-800' }}">
                    <div class="flex items-center mb-3">
                        <div class="p-2 rounded-lg {{ $isError ? 'bg-red-100 dark:bg-red-800' : 'bg-green-100 dark:bg-green-800' }} mr-3">
                            <svg class="w-5 h-5 {{ $isError ? 'text-red-600 dark:text-red-300' : 'text-green-600 dark:text-green-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold {{ $isError ? 'text-red-800 dark:text-red-400' : 'text-green-800 dark:text-green-400' }}">
                            Balasan Admin (Tiket {{ Str::title($ticket->status) }})
                        </h3>
                    </div>

                    <div class="space-y-4">
                        @foreach($ticket->komentar as $item)
                            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-100 dark:border-gray-700 shadow-sm">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">
                                        {{ $item->user->nama ?? 'Administrator' }}
                                    </span>
                                    <span class="text-xs text-gray-500 italic">
                                        {{ $item->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300 italic leading-relaxed">
                                    "{{ $item->komentar }}"
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
            <div class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 p-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Detail Formulir Surat Izin Penelitian</h3>
            </div>
            
            <div class="p-6">
                {{-- Karena sistem ini HANYA untuk Surat Izin Penelitian, kita panggil langsung partial-nya --}}
                @include('pages.mahasiswa.DetailSuratIzin.partials._detail_surat_izin')
            </div>
        </div>

        @if(($ticket->status == 'belum diajukan' && empty($ticket->lampiran)) || $ticket->status == 'ditolak')
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-8 text-center">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Unduh Dokumen Sistem</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Anda dapat mengunduh ulang dokumen persuratan yang telah di-generate oleh sistem melalui tombol di bawah ini.</p>
            <div class="flex justify-center items-center">
                <div class="w-full sm:w-auto">
                    {{-- Sesuaikan route download ini dengan route khusus surat izin penelitian Anda nanti --}}
                    <a href="{{ url('detail/download/' . $ticket->uuid) }}" class="inline-flex items-center justify-center w-full px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition-all shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download Ulang Surat
                    </a>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

@push('scripts')
    @vite('resources/js/detail-surat.js')
@endpush
@endsection