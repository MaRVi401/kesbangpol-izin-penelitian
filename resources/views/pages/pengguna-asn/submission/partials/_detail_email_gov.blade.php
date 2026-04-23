@php
    $detail = $ticket->detailEmailGov;
@endphp

@if($detail && isset($kategoriEmail))
    
    @if($kategoriEmail === 'perangkat_daerah')
        <div class="space-y-8">
            
            <div>
                <h4 class="text-md font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    1. Data Instansi Pemohon
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 bg-gray-50/50 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-100 dark:border-gray-700">
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Nama Perangkat Daerah</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->pd_instansi_nama ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Nama Kepala Instansi</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->pd_nama_kepala_instansi ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Bidang / Bagian / UPTD</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->pd_bidang ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Alamat Instansi</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->pd_alamat ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">No. Telepon Instansi</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->pd_telp ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Email Instansi</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->pd_email ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-md font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    2. Data Penanggung Jawab Email
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 bg-gray-50/50 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-100 dark:border-gray-700">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Nama Penanggung Jawab</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->pd_pj_nama ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">NIP</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->pd_pj_nip ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Jabatan</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->pd_pj_jabatan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">No HP / WhatsApp</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->pd_pj_kontak ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Email Pribadi</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->pd_pj_email ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-md font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    3. Data Akun & Permohonan
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Jenis Layanan</p>
                        <span class="inline-flex items-center mt-1 px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800 uppercase shadow-sm">
                            {{ $detail->pd_jenis_layanan ?? '-' }}
                        </span>
                    </div>

                    @if(!empty($detail->pd_alasan_hapus_akun))
                    <div class="md:col-span-2 bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg border border-yellow-200 dark:border-yellow-800/50">
                        <p class="text-xs text-yellow-800 dark:text-yellow-400 uppercase tracking-wider font-semibold mb-1">Alasan Hapus Akun</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->pd_alasan_hapus_akun }}</p>
                    </div>
                    @endif

                    @if(!empty($detail->pd_alasan_ganti_nama))
                    <div class="md:col-span-2 bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg border border-yellow-200 dark:border-yellow-800/50">
                        <p class="text-xs text-yellow-800 dark:text-yellow-400 uppercase tracking-wider font-semibold mb-1">Alasan Ganti Nama Akun</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->pd_alasan_ganti_nama }}</p>
                    </div>
                    @endif

                    @if(!empty($detail->pd_usulan_email))
                    <div class="md:col-span-2 bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-100 dark:border-blue-800/50">
                        <p class="text-xs text-blue-600 dark:text-blue-400 uppercase tracking-wider font-semibold mb-1">Usulan Nama Email Baru</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white mt-1">{{ $detail->pd_usulan_email }}<span class="text-gray-500 font-normal">@subang.go.id</span></p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    @elseif($kategoriEmail === 'asn')
        <div class="space-y-8">
            
            <div>
                <h4 class="text-md font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                    Data Pegawai (ASN) Pemohon
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 bg-gray-50/50 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-100 dark:border-gray-700">
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Nama Lengkap (Beserta Gelar)</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->asn_nama_lengkap ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">NIP</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->asn_nip ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Jabatan</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->asn_jabatan ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Instansi / Unit Kerja</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->asn_instansi ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">No. HP / WhatsApp</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->asn_kontak ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-md font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Data Layanan Email
                </h4>
                <div class="grid grid-cols-1 bg-gray-50/50 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-100 dark:border-gray-700">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Jenis Layanan yang Diajukan</p>
                        <span class="inline-flex items-center mt-1 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800 uppercase shadow-sm">
                            {{ $detail->asn_jenis_layanan ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif

@else
    <div class="flex flex-col items-center justify-center py-10 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-100 dark:border-gray-700">
        <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <p class="text-gray-500 dark:text-gray-400 font-medium">Data detail pengajuan email belum lengkap atau tidak ditemukan.</p>
    </div>
@endif