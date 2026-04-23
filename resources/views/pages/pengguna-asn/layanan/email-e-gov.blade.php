@extends('layouts.main')

@section('title', 'Layanan Email E-Gov')

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
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Pilih Jenis Layanan Email</h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Silakan pilih jenis pengajuan email yang Anda butuhkan.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            <div onclick="goToStep(2, 'perangkat_daerah')" class="cursor-pointer group flex flex-col bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-blue-500 transition-all p-6 shadow-sm hover:shadow-md">
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg w-16 h-16 flex items-center justify-center mb-4 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l18 0" /><path d="M9 8l1 0" /><path d="M9 12l1 0" /><path d="M9 16l1 0" /><path d="M14 8l1 0" /><path d="M14 12l1 0" /><path d="M14 16l1 0" /><path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16" /></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Email Perangkat Daerah</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400 text-sm">Untuk Dinas, Badan, atau Bagian.</p>
            </div>
            <div onclick="goToStep(2, 'asn')" class="cursor-pointer group flex flex-col bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-green-500 transition-all p-6 shadow-sm hover:shadow-md">
                <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg w-16 h-16 flex items-center justify-center mb-4 text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Email Pegawai (ASN)</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400 text-sm">Untuk individu ASN aktif.</p>
            </div>
        </div>
    </div>

    <div id="step-2" class="step-content hidden transition-opacity duration-300">
        <button onclick="goToStep(1)" class="mb-6 flex items-center text-sm text-gray-500 hover:text-blue-600 dark:text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
            Kembali ke Pilihan
        </button>

        <form id="form-pengajuan" action="{{ route('services-email-e-gov.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="kategori_aktif" id="kategori_aktif" value="">
            
            <div id="form-perangkat-daerah" class="hidden form-section max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2">1. Data Instansi Pemohon</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Perangkat Daerah</label>
                            <input type="text" name="nama_perangkat_daerah" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Kepala Instansi</label>
                            <input type="text" name="nama_kepala_instansi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: Dr. H. Dadang, M.Si">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Nama lengkap pejabat penanda tangan surat permohonan.</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bidang / Bagian / UPTD</label>
                            <input type="text" name="bidang_bagian" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                            <textarea name="alamat_instansi" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. Telepon Instansi</label>
                            <input type="number" name="no_telp_instansi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Instansi</label>
                            <input type="email" name="email_instansi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2">2. Data Penanggung Jawab Email</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Penanggung Jawab</label>
                            <input type="text" name="nama_pj" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                            <input type="number" name="nip_pj" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                            <input type="text" name="jabatan_pj" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Pribadi</label>
                            <input type="email" name="email_pj" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No HP / WA</label>
                            <input type="number" name="no_hp_pj" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2">3. Data Akun</h3>
                    <div class="mb-4 space-y-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Permohonan:</label>
                        <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                            <input checked id="opsi-baru" type="radio" value="baru" name="jenis_permohonan" class="w-4 h-4 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" onchange="toggleOpsiAkun()">
                            <label for="opsi-baru" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Permohonan Baru</label>
                        </div>
                        <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                            <input id="opsi-reset" type="radio" value="reset" name="jenis_permohonan" class="w-4 h-4 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" onchange="toggleOpsiAkun()">
                            <label for="opsi-reset" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Reset Password</label>
                        </div>
                        <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                            <input id="opsi-hapus" type="radio" value="hapus" name="jenis_permohonan" class="w-4 h-4 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" onchange="toggleOpsiAkun()">
                            <label for="opsi-hapus" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Hapus Akun</label>
                        </div>
                        <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                            <input id="opsi-ganti" type="radio" value="ganti" name="jenis_permohonan" class="w-4 h-4 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" onchange="toggleOpsiAkun()">
                            <label for="opsi-ganti" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Ganti Nama Akun</label>
                        </div>
                    </div>
                    <div id="field-alasan" class="hidden mt-4 bg-yellow-50 p-4 rounded-lg border border-yellow-200 dark:bg-yellow-900/20 dark:border-yellow-700">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alasan Permohonan (Wajib)</label>
                        <textarea name="alasan_permohonan" rows="2" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Jelaskan alasan..."></textarea>
                    </div>
                    <div id="field-usulan-nama" class="hidden mt-4 bg-blue-50 p-4 rounded-lg border border-blue-200 dark:bg-blue-900/20 dark:border-yellow-700">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usulan Nama Email Baru</label>
                        <div class="flex">
                            <input type="email" name="usulan_nama_email" class="rounded-lg bg-white border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="nama.baru">
                        </div>
                    </div>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" id="btn-submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Kirim Pengajuan <i class="fa-solid fa-paper-plane ml-1"></i>
                    </button>
                </div>
            </div>

            <div id="form-asn" class="hidden form-section max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Formulir Email Pegawai (ASN)</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Silakan lengkapi data diri Anda di bawah ini.</p>
                </div>
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Beserta gelar">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                        <input type="number" name="nip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Nomor Induk Pegawai">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                        <input type="text" name="jabatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Instansi</label>
                        <input type="text" name="unit_kerja" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Nama Perangkat Daerah / Unit Kerja">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. HP / WhatsApp</label>
                        <input type="number" name="no_hp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="08...">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Layanan</label>
                        <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input id="asn-baru" type="radio" value="baru" name="asn_jenis_layanan" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" checked>
                                    <label for="asn-baru" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Permohonan Baru</label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input id="asn-reset" type="radio" value="reset" name="asn_jenis_layanan" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="asn-reset" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Reset Password</label>
                                </div>
                            </li>
                            <li class="w-full dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input id="asn-hapus" type="radio" value="hapus" name="asn_jenis_layanan" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="asn-hapus" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Hapus Akun</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" id="btn-submit-asn" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                        Kirim Pengajuan ASN <i class="fa-solid fa-paper-plane ml-1"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div id="step-3" class="step-content hidden transition-opacity duration-300">
        <div class="text-center py-10 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 max-w-2xl mx-auto mt-8 shadow-sm">
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 inline-block mb-6 border border-gray-200 dark:border-gray-600">
                <span class="text-sm text-gray-500 dark:text-gray-400 block mb-1">Nomor Tiket Anda</span>
                <span class="text-xl font-mono font-bold text-blue-600 dark:text-blue-400" id="nomor-tiket">#TEG-XXXXXXXX</span>
            </div>
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h2 class="text-2xl font-bold mb-2 text-gray-900 dark:text-white">Permohonan Berhasil Dikirim!</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Silakan cek status pengajuan Anda secara berkala di dashboard.</p>
            <div class="flex justify-center space-x-4">
                <button onclick="window.location.reload()" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Kembali ke Dashboard
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @vite('resources/js/email-e-gov.js')
@endpush
@endsection