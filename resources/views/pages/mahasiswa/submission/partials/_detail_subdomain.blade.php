@php
    $detail = $ticket->detailSubdomain;
@endphp

@if($detail)
<div class="space-y-10">
    <div>
        <h3 class="flex items-center text-lg font-bold text-gray-900 dark:text-white mb-4">
            <span class="flex items-center justify-center w-6 h-6 mr-2 text-sm rounded-full bg-blue-100 text-blue-600">1</span>
            Identitas Instansi (OPD)
        </h3>
        <div class="grid gap-6 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Perangkat Daerah</label>
                <input type="text" value="{{ $detail->instansi_opd }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>

            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bidang / Bagian / UPTD</label>
                <input type="text" value="{{ $detail->instansi_bidang ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>

            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Kepala Instansi</label>
                <input type="text" value="{{ $detail->instansi_nama_kepala }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>

            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Instansi</label>
                <textarea rows="2" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">{{ $detail->instansi_alamat ?? '-' }}</textarea>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. Telepon Kantor</label>
                <input type="text" value="{{ $detail->instansi_telp ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Instansi</label>
                <input type="email" value="{{ $detail->instansi_email ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>
        </div>
    </div>

    <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">

    <div>
        <h3 class="flex items-center text-lg font-bold text-gray-900 dark:text-white mb-4">
            <span class="flex items-center justify-center w-6 h-6 mr-2 text-sm rounded-full bg-blue-100 text-blue-600">2</span>
            Penanggung Jawab Administratif
        </h3>
        <div class="grid gap-6 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                <input type="text" value="{{ $detail->pj_admin_nama }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                <input type="text" value="{{ $detail->pj_admin_nip ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                <input type="text" value="{{ $detail->pj_admin_jabatan ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input type="email" value="{{ $detail->pj_admin_email ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. HP / WhatsApp</label>
                <input type="text" value="{{ $detail->pj_admin_telp }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>
        </div>
    </div>

    <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">

    <div>
        <h3 class="flex items-center text-lg font-bold text-gray-900 dark:text-white mb-4">
            <span class="flex items-center justify-center w-6 h-6 mr-2 text-sm rounded-full bg-blue-100 text-blue-600">3</span>
            Penanggung Jawab Teknis
        </h3>
        <div class="grid gap-6 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                <input type="text" value="{{ $detail->pj_teknis_nama }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>

            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asal Instansi / Perusahaan (Vendor)</label>
                <input type="text" value="{{ $detail->pj_teknis_instansi ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>

            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Domisili</label>
                <textarea rows="2" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">{{ $detail->pj_teknis_alamat ?? '-' }}</textarea>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Teknis</label>
                <input type="email" value="{{ $detail->pj_teknis_email }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. HP / WhatsApp</label>
                <input type="text" value="{{ $detail->pj_teknis_telp }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>
        </div>
    </div>

    <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">

    <div>
        <h3 class="flex items-center text-lg font-bold text-gray-900 dark:text-white mb-4">
            <span class="flex items-center justify-center w-6 h-6 mr-2 text-sm rounded-full bg-blue-100 text-blue-600">4</span>
            Data Teknis Subdomain
        </h3>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Permohonan Subdomain</label>
                <input type="text" value="{{ ucwords($detail->subdomain_jenis) }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 font-semibold text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Subdomain</label>
                <input type="text" value="{{ $detail->subdomain_nama }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Subdomain Lengkap (URL)</label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 text-sm text-gray-500 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                        https://
                    </span>
                    <input type="text" value="{{ str_replace(['http://', 'https://'], '', $detail->subdomain_alamat) }}" readonly disabled class="rounded-none rounded-r-lg bg-gray-100 border border-gray-300 text-gray-600 block flex-1 min-w-0 w-full text-sm p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                </div>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat IP (Server Target)</label>
                <input type="text" value="{{ $detail->subdomain_ip }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Redirect IP / URL</label>
                <input type="text" value="{{ $detail->subdomain_redirect ?? 'Tidak ada' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
            </div>
            
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi Singkat Aplikasi / Website</label>
                <textarea rows="3" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">{{ $detail->subdomain_deskripsi }}</textarea>
            </div>
        </div>
    </div>
</div>
@else
<div class="text-center py-8 text-gray-500 dark:text-gray-400">
    <p>Data detail subdomain tidak ditemukan untuk tiket ini.</p>
</div>
@endif