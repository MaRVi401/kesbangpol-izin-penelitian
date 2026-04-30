@extends('layouts.main')

@section('title', 'Aktivasi Mahasiswa')

@section('content')
    <div class="p-4 mt-14">
        {{-- Breadcrumb Section --}}
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-colors">
                        <svg class="w-3 h-3 me-2.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <a href="{{ route('user-management.index') }}"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white transition-colors">User Management</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-500">Aktivasi Mahasiswa</span>
                    </div>
                </li>
            </ol>
        </nav>
        <hr class="mb-6 border-gray-200 dark:border-gray-700">

        {{-- Title Section --}}
        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Daftar Tunggu Aktivasi Mahasiswa</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Tinjau data diri dan dokumen pendukung mahasiswa sebelum memberikan akses sistem.</p>
        </div>

        {{-- Table Card --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-4 font-bold">Nama Mahasiswa</th>
                            <th class="px-6 py-4 font-bold">NIM</th>
                            <th class="px-6 py-4 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($pendingUsers as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $user->nama }}</td>
                                <td class="px-6 py-4">{{ $user->mahasiswa->nim }}</td>
                                <td class="px-6 py-4 text-center">
                                    <button data-modal-target="modal-{{ $user->uuid }}" data-modal-toggle="modal-{{ $user->uuid }}"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-4 py-2 transition-all">
                                        Preview & Aktivasi
                                    </button>

                                    {{-- Modal Preview --}}
                                    <div id="modal-{{ $user->uuid }}" tabindex="-1" aria-hidden="true" 
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-2xl max-h-full text-left">
                                            <div class="relative bg-white rounded-xl shadow-lg dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                                <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
                                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Detail Pengajuan: {{ $user->nama }}</h3>
                                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modal-{{ $user->uuid }}">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                                                    </button>
                                                </div>
                                                <div class="p-6 space-y-6">
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg">
                                                            <p class="text-xs text-gray-500 uppercase font-bold mb-1">NIM</p>
                                                            <p class="text-sm text-gray-900 dark:text-white">{{ $user->mahasiswa->nim }}</p>
                                                        </div>
                                                        <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg">
                                                            <p class="text-xs text-gray-500 uppercase font-bold mb-1">WhatsApp</p>
                                                            <p class="text-sm text-gray-900 dark:text-white">{{ $user->no_wa ?? '-' }}</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="space-y-3">
                                                        <p class="text-sm font-bold text-gray-900 dark:text-white">Preview KTM:</p>
                                                        <img src="{{ url('storage/private/' . $user->mahasiswa->ktm_path) }}" 
                                                             class="w-full h-48 object-cover rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm"
                                                             alt="KTM Preview">
                                                        
                                                        <div class="pt-2">
                                                            <p class="text-sm font-bold text-gray-900 dark:text-white mb-2">Dokumen Pendukung:</p>
                                                            <a href="{{ url('storage/private/' . $user->mahasiswa->surat_rekomendasi_path) }}" target="_blank"
                                                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 dark:bg-blue-900/20 dark:border-blue-800 dark:text-blue-400 transition-all">
                                                                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                                Lihat Surat Rekomendasi
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center justify-end p-6 space-x-3 border-t dark:border-gray-700">
                                                    <form action="{{ route('user-management.activate', $user->uuid) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="ditolak">
                                                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-red-600 bg-white border border-red-200 rounded-lg hover:bg-red-50 focus:ring-4 focus:ring-red-100 transition-all">Tolak Pengajuan</button>
                                                    </form>
                                                    <form action="{{ route('user-management.activate', $user->uuid) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="aktif">
                                                        <button type="submit" class="px-8 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 shadow-md transition-all">Aktifkan Akun</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p class="text-gray-500 dark:text-gray-400">Tidak ada mahasiswa yang menunggu aktivasi.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($pendingUsers->hasPages())
                <div class="p-4 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    {{ $pendingUsers->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection