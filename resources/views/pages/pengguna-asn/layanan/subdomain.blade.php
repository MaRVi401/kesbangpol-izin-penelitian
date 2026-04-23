@extends('layouts.main')

@section('title', 'Layanan Subdomain')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <div class="mb-8 mt-4">
        <ol class="items-center w-full max-w-2xl mx-auto flex space-x-8 justify-center">
            <li id="indicator-step-1" class="flex items-center space-x-2.5 text-blue-600 dark:text-blue-500">
                <span class="flex items-center justify-center w-8 h-8 border border-blue-600 rounded-full shrink-0 dark:border-blue-500">1</span>
                <span><h3 class="font-medium leading-tight">Formulir Pengajuan</h3></span>
            </li>
            <li class="flex-1 h-px bg-gray-300 dark:bg-gray-600"></li>
            <li id="indicator-step-2" class="flex items-center space-x-2.5 text-gray-500 dark:text-gray-400">
                <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">2</span>
                <span><h3 class="font-medium leading-tight">Selesai</h3></span>
            </li>
        </ol>
    </div>

    <div id="step-1" class="step-content transition-opacity duration-300">
        <form id="form-subdomain" action="{{ route('service-sub-domain.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Formulir Layanan Subdomain</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Mohon lengkapi data administratif dan teknis di bawah ini.</p>
                </div>

                <div class="mb-10">
                    <h3 class="flex items-center text-lg font-bold text-gray-900 dark:text-white mb-4">
                        <span class="flex items-center justify-center w-6 h-6 mr-2 text-sm rounded-full bg-blue-100 text-blue-600">1</span>
                        Identitas Instansi (OPD)
                    </h3>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Perangkat Daerah</label>
                            <input type="text" name="nama_perangkat_daerah" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: Dinas Komunikasi dan Informatika" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bidang / Bagian / UPTD</label>
                            <input type="text" name="bidang_bagian" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Kepala Instansi</label>
                            <input type="text" name="nama_kepala_instansi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Instansi</label>
                            <textarea name="alamat_instansi" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. Telepon Kantor</label>
                            <input type="number" name="no_telp_instansi" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Instansi</label>
                            <input type="email" name="email_instansi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>
                </div>

                <hr class="h-px mt-14 mb-8 bg-gray-200 border-0 dark:bg-gray-700">

                <div class="mb-10">
                    <h3 class="flex items-center text-lg font-bold text-gray-900 dark:text-white mb-4">
                        <span class="flex items-center justify-center w-6 h-6 mr-2 text-sm rounded-full bg-blue-100 text-blue-600">2</span>
                        Penanggung Jawab Administratif
                    </h3>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                            <input type="text" name="nama_pj_admin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                            <input type="number" name="nip_pj_admin" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                            <input type="text" name="jabatan_pj_admin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email_pj_admin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. HP / WhatsApp</label>
                            <input type="number" name="no_telp_pj_admin" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                    </div>
                </div>

                <hr class="h-px mt-14 mb-8 bg-gray-200 border-0 dark:bg-gray-700">

                <div class="mb-10">
                    <h3 class="flex items-center text-lg font-bold text-gray-900 dark:text-white mb-4">
                        <span class="flex items-center justify-center w-6 h-6 mr-2 text-sm rounded-full bg-blue-100 text-blue-600">3</span>
                        Penanggung Jawab Teknis
                    </h3>
                    <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                        <span class="font-medium">Info:</span> PJ Teknis adalah orang yang akan mengelola server atau konfigurasi subdomain.
                    </div>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                            <input type="text" name="nama_pj_teknis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asal Instansi / Perusahaan (Vendor)</label>
                            <input type="text" name="instansi_pj_teknis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: PT. Solusi Digital atau Staff IT Internal">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Domisili</label>
                            <textarea name="alamat_pj_teknis" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Teknis</label>
                            <input type="email" name="email_pj_teknis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. HP / WhatsApp</label>
                            <input type="number" name="no_telp_pj_teknis" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                    </div>
                </div>

                <hr class="h-px mt-14 mb-8 bg-gray-200 border-0 dark:bg-gray-700">

                <div class="mb-8">
                    <h3 class="flex items-center text-lg font-bold text-gray-900 dark:text-white mb-4">
                        <span class="flex items-center justify-center w-6 h-6 mr-2 text-sm rounded-full bg-blue-100 text-blue-600">4</span>
                        Data Teknis Subdomain
                    </h3>
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Permohonan Subdomain</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                                <input checked id="layanan-baru" type="radio" value="permohonan baru" name="jenis_aplikasi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600">
                                <label for="layanan-baru" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Permohonan Baru</label>
                            </div>
                            <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                                <input id="layanan-ganti" type="radio" value="ganti nama sub domain" name="jenis_aplikasi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600">
                                <label for="layanan-ganti" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Ganti Nama Subdomain</label>
                            </div>
                            <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                                <input id="layanan-hapus" type="radio" value="penghapusan sub domain" name="jenis_aplikasi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600">
                                <label for="layanan-hapus" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Penghapusan Subdomain</label>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usulan Subdomain</label>
                            <input type="text" name="usulan_subdomain" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="simpeg.namakab.go.id" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Subdomain (Prefix)</label>
                            <input type="text" name="nama_subdomain" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: simpeg" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Subdomain Lengkap (URL)</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">https://</span>
                                <input type="text" name="alamat_subdomain" class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="simpeg.namakab.go.id" required>
                            </div>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat IP (Server Target)</label>
                            <input type="text" name="alamat_ip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="103.xxx.xxx.xxx" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Redirect IP / URL (Opsional)</label>
                            <input type="text" name="redirect_ip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi Singkat Aplikasi / Website</label>
                            <textarea name="deskripsi_singkat" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Kirim Permohonan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div id="step-2" class="step-content hidden transition-opacity duration-300">
        <div class="text-center py-10 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 max-w-2xl mx-auto mt-8 shadow-sm">
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 inline-block mb-6 border border-gray-200 dark:border-gray-600">
                <span class="text-sm text-gray-500 dark:text-gray-400 block mb-1">Nomor Tiket Anda</span>
                <span class="text-xl font-mono font-bold text-blue-600 dark:text-blue-400" id="nomor-tiket">#Memproses...</span>
            </div>
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Permohonan Berhasil!</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Dokumen permohonan sedang diunduh secara otomatis.</p>
            <div class="flex justify-center space-x-4">
                <a href="/submission" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">Cek Status Tiket</a>
                <a href="/dashboard" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @vite('resources/js/subdomain-forms.js')
@endpush
@endsection