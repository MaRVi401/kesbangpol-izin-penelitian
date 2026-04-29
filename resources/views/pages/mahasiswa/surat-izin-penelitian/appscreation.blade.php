@extends('layouts.main')

@section('title', 'Layanan Pembuatan Apps')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <div class="mb-8 mt-4">
        <ol class="items-center w-full max-w-2xl mx-auto flex space-x-8 justify-center">
            <li id="indicator-step-1" class="flex items-center space-x-2.5 text-blue-600 dark:text-blue-500">
                <span class="flex items-center justify-center w-8 h-8 border border-blue-600 rounded-full shrink-0 dark:border-blue-500">1</span>
                <span><h3 class="font-medium leading-tight">Pilih Jenis</h3></span>
            </li>
            <li class="flex-1 h-px bg-gray-300 dark:bg-gray-600"></li>
            <li id="indicator-step-2" class="flex items-center space-x-2.5 text-gray-500 dark:text-gray-400">
                <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">2</span>
                <span><h3 class="font-medium leading-tight">Formulir</h3></span>
            </li>
            <li class="flex-1 h-px bg-gray-300 dark:bg-gray-600"></li>
            <li id="indicator-step-3" class="flex items-center space-x-2.5 text-gray-500 dark:text-gray-400">
                <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">3</span>
                <span><h3 class="font-medium leading-tight">Selesai</h3></span>
            </li>
        </ol>
    </div>

    <div id="step-1" class="step-content transition-opacity duration-300">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Pilih Jenis Layanan Aplikasi</h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Silakan pilih jenis pengembangan sistem yang Anda butuhkan.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            <div onclick="goToStep(2, 'pembangunan_awal')" class="cursor-pointer group flex flex-col bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-blue-500 transition-all p-6 shadow-sm hover:shadow-md">
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg w-16 h-16 flex items-center justify-center mb-4 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 13a8 8 0 0 1 7 7a6 6 0 0 0 3 -5a9 9 0 0 0 6 -8a3 3 0 0 0 -3 -3a9 9 0 0 0 -8 6a6 6 0 0 0 -5 3" /><path d="M7 14a6 6 0 0 0 -3 6a6 6 0 0 0 6 -3" /><path d="M15 9m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Pembangunan Sistem Awal</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400 text-sm">Pembuatan aplikasi/sistem informasi baru dari nol sesuai kebutuhan instansi.</p>
            </div>

            <div onclick="goToStep(2, 'pengembangan_fitur')" class="cursor-pointer group flex flex-col bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-green-500 transition-all p-6 shadow-sm hover:shadow-md">
                <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg w-16 h-16 flex items-center justify-center mb-4 text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7h3a1 1 0 0 0 1 -1v-1a2 2 0 0 1 4 0v1a1 1 0 0 0 1 1h3a1 1 0 0 1 1 1v3a1 1 0 0 0 1 1h1a2 2 0 0 1 0 4h-1a1 1 0 0 0 -1 1v3a1 1 0 0 1 -1 1h-3a1 1 0 0 1 -1 -1v-1a2 2 0 0 0 -4 0v1a1 1 0 0 1 -1 1h-3a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1h1a2 2 0 0 0 0 -4h-1a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1" /></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Pengembangan Fitur</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400 text-sm">Penambahan modul, fitur baru, atau optimalisasi aplikasi yang sudah ada.</p>
            </div>
        </div>
    </div>

    <div id="step-2" class="step-content hidden transition-opacity duration-300">
        <button onclick="goToStep(1)" class="mb-6 flex items-center text-sm text-gray-500 hover:text-blue-600 dark:text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
            Kembali ke Pilihan
        </button>

        <form id="form-pengajuan" action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="kategori_aktif" id="kategori_aktif" value="">
            
            <div id="form-pembangunan-awal" class="hidden form-section max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Formulir Pembangunan Sistem Awal</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Lengkapi data administratif dan detail teknis sistem baru.</p>
                </div>

                <h3 class="text-md font-semibold text-blue-600 dark:text-blue-400 mb-4 border-b pb-2">Informasi Surat & Instansi</h3>
                <div class="grid gap-6 mb-8 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama SKPD (Perangkat Daerah)</label>
                        <input type="text" name="ajuan_nama_skpd" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                </div>

                <h3 class="text-md font-semibold text-blue-600 dark:text-blue-400 mb-4 border-b pb-2">Personalia</h3>
                <div class="grid gap-6 mb-8 md:grid-cols-2 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg">
                    <div class="md:col-span-2"><p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Pejabat Penandatangan Surat</p></div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Pejabat</label>
                        <input type="text" name="ajuan_ttd_nama" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                        <input type="text" name="ajuan_ttd_nip" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="18 digit NIP">
                    </div>

                    <div class="md:col-span-2 mt-2"><p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Penanggung Jawab 1</p></div>
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" name="ajuan_perintah_pj1_nama" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                            <input type="text" name="ajuan_perintah_pj1_nip" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="18 digit NIP">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                            <input type="text" name="ajuan_perintah_pj1_jabatan" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>

                    <div class="md:col-span-2 mt-2"><p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Penanggung Jawab 2</p></div>
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" name="ajuan_perintah_pj2_nama" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                            <input type="text" name="ajuan_perintah_pj2_nip" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="18 digit NIP (Opsional)">    
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                            <input type="text" name="ajuan_perintah_pj2_jabatan" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>
                </div>

                <h3 class="text-md font-semibold text-blue-600 dark:text-blue-400 mb-4 border-b pb-2">Detail Sistem yang Diajukan</h3>
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Sistem Aplikasi</label>
                        <input type="text" name="ajuan_nama_sistem" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan / Latar Belakang Sistem</label>
                        <textarea name="ajuan_ket_sistem" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Daftar Fitur Utama <span class="text-xs text-gray-500 font-normal">(Maksimal 20 fitur)</span>
                        </label>
                        <div class="fitur-container space-y-3" data-name="ajuan_fitur[]">
                            <div class="flex items-center space-x-2 transition-all duration-300 fitur-row">
                                <input type="text" name="ajuan_fitur[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Fitur ke-1...">
                                <button type="button" class="btn-tambah-fitur px-3 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </button>
                                <button type="button" class="btn-hapus-fitur hidden px-3 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                                </button>
                            </div>
                        </div>
                        <p class="fitur-warning mt-2 text-sm text-red-600 hidden dark:text-red-400">Anda telah mencapai batas maksimal 20 fitur.</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan Detail Fitur</label>
                        <textarea name="ajuan_ket_fitur" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-4 mt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" id="btn-submit-baru" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Kirim Pengajuan Awal <i class="fa-solid fa-paper-plane ml-1"></i>
                    </button>
                </div>
            </div>

            <div id="form-pengembangan-fitur" class="hidden form-section max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Formulir Pengembangan Fitur</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Lengkapi data untuk penambahan fitur/modul pada sistem yang sudah ada.</p>
                </div>

                <h3 class="text-md font-semibold text-green-600 dark:text-green-400 mb-4 border-b pb-2">Informasi Surat & Instansi</h3>
                <div class="grid gap-6 mb-8 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama SKPD (Perangkat Daerah)</label>
                        <input type="text" name="kembang_nama_skpd" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                </div>

                <h3 class="text-md font-semibold text-green-600 dark:text-green-400 mb-4 border-b pb-2">Personalia</h3>
                <div class="grid gap-6 mb-8 md:grid-cols-2 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg">
                    <div class="md:col-span-2"><p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Pejabat Penandatangan Surat</p></div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Pejabat</label>
                        <input type="text" name="kembang_ttd_nama" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                        <input type="text" name="kembang_ttd_nip" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Masukkan 18 digit NIP">   
                    </div>

                    <div class="md:col-span-2 mt-2"><p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Penanggung Jawab 1</p></div>
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" name="kembang_perintah_pj1_nama" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                            <input type="text" name="kembang_perintah_pj1_nip" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                            <input type="text" name="kembang_perintah_pj1_jabatan" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>
                    <div class="md:col-span-2 mt-2"><p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Penanggung Jawab 2</p></div>
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" name="kembang_perintah_pj2_nama" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                            <input type="text" name="kembang_perintah_pj2_nip" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                            <input type="text" name="kembang_perintah_pj2_jabatan" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>
                </div>

                <h3 class="text-md font-semibold text-green-600 dark:text-green-400 mb-4 border-b pb-2">Detail Pengembangan Fitur</h3>
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Aplikasi Saat Ini</label>
                        <input type="text" name="kembang_nama_sistem" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan Umum Pengembangan</label>
                        <textarea name="kembang_ket" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    </div>    
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Daftar Fitur yang Dikembangkan <span class="text-xs text-gray-500 font-normal">(Maksimal 20 fitur)</span>
                        </label>   
                        <div class="fitur-container space-y-3" data-name="kembang_nama_fitur[]">
                            <div class="flex items-center space-x-2 transition-all duration-300 fitur-row">
                                <input type="text" name="kembang_nama_fitur[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Fitur ke-1...">
                                <button type="button" class="btn-tambah-fitur px-3 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </button>
                                <button type="button" class="btn-hapus-fitur hidden px-3 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                                </button>
                            </div>
                        </div>    
                        <p class="fitur-warning mt-2 text-sm text-red-600 hidden dark:text-red-400">Anda telah mencapai batas maksimal 20 fitur.</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan Detail Fitur</label>
                        <textarea name="kembang_ket_fitur" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-4 mt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" id="btn-submit-kembang" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                        Kirim Pengajuan Pengembangan <i class="fa-solid fa-paper-plane ml-1"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div id="step-3" class="step-content hidden transition-opacity duration-300">
        <div class="text-center py-10 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 max-w-2xl mx-auto mt-8 shadow-sm">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h2 class="text-2xl font-bold mb-2 text-gray-900 dark:text-white">Permohonan Berhasil Dikirim!</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-2">Silakan cek status pengajuan Anda secara berkala di dashboard.</p>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 inline-block mt-2 mb-6 border border-gray-200 dark:border-gray-600">
                <span class="text-sm text-gray-500 dark:text-gray-400 block mb-1">Nomor Tiket Anda</span>
                <span class="text-xl font-mono font-bold text-blue-600 dark:text-blue-400" id="nomor-tiket">#TKT-XXXXXXXX</span>
            </div>
            <div class="flex justify-center space-x-4">
                <button onclick="window.location.reload()" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Kembali ke Dashboard
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @vite('resources/js/app-creation.js') 
@endpush
@endsection