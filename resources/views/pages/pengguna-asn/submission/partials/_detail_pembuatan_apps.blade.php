@php
    $detail = $ticket->detailApps;
    
    $isPembangunanAwal = !empty($detail->ajuan_nama_skpd) || !empty($detail->ajuan_nama_sistem);
    $isPengembanganFitur = !empty($detail->kembang_nama_skpd) || !empty($detail->kembang_nama_sistem);
@endphp

@if($detail)
    @if($isPembangunanAwal)
        <div class="space-y-8">
            <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">Detail Pembangunan Sistem Awal</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Data administratif dan teknis pengajuan sistem baru.</p>
            </div>

            <div>
                <h3 class="text-md font-semibold text-blue-600 dark:text-blue-400 mb-4 border-b pb-2">Informasi Surat & Instansi</h3>
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama SKPD (Perangkat Daerah)</label>
                        <input type="text" value="{{ $detail->ajuan_nama_skpd ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-md font-semibold text-blue-600 dark:text-blue-400 mb-4 border-b pb-2">Personalia</h3>
                <div class="grid gap-6 md:grid-cols-2 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="md:col-span-2"><p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Pejabat Penandatangan Surat</p></div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Pejabat</label>
                        <input type="text" value="{{ $detail->ajuan_ttd_nama ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                        <input type="text" value="{{ $detail->ajuan_ttd_nip ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                    </div>
                    
                    <div class="md:col-span-2 mt-2"><p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Penanggung Jawab 1</p></div>
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" value="{{ $detail->ajuan_perintah_pj1_nama ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                            <input type="text" value="{{ $detail->ajuan_perintah_pj1_nip ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                            <input type="text" value="{{ $detail->ajuan_perintah_pj1_jabatan ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                        </div>
                    </div>

                    <div class="md:col-span-2 mt-2"><p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Penanggung Jawab 2</p></div>
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" value="{{ $detail->ajuan_perintah_pj2_nama ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                            <input type="text" value="{{ $detail->ajuan_perintah_pj2_nip ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">    
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                            <input type="text" value="{{ $detail->ajuan_perintah_pj2_jabatan ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-md font-semibold text-blue-600 dark:text-blue-400 mb-4 border-b pb-2">Detail Sistem yang Diajukan</h3>
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Sistem Aplikasi</label>
                        <input type="text" value="{{ $detail->ajuan_nama_sistem ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan / Latar Belakang Sistem</label>
                        <textarea rows="3" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">{{ $detail->ajuan_ket_sistem ?? '-' }}</textarea>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Daftar Fitur Utama</label>
                        <div class="space-y-3 p-4 bg-gray-50 border border-gray-200 rounded-lg dark:bg-gray-700/50 dark:border-gray-600">
                            @php
                                $rawAjuanFitur = $detail->ajuan_fitur;
                                
                                if (is_array($rawAjuanFitur)) {
                                    $ajuanFitur = empty($rawAjuanFitur) ? ['Tidak ada fitur terdaftar'] : $rawAjuanFitur;
                                } else {
                                    $decoded = json_decode($rawAjuanFitur, true);
                                    $ajuanFitur = is_array($decoded) ? $decoded : ($rawAjuanFitur ? [$rawAjuanFitur] : ['Tidak ada fitur terdaftar']);
                                }
                            @endphp

                            <ul class="list-disc pl-5 text-sm text-gray-600 dark:text-gray-300 space-y-1">
                                @foreach($ajuanFitur as $fitur)
                                    <li>{{ $fitur }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan Detail Fitur</label>
                        <textarea rows="3" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">{{ $detail->ajuan_ket_fitur ?? '-' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

    @elseif($isPengembanganFitur)
        <div class="space-y-8">
            <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">Detail Pengembangan Fitur</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Data untuk penambahan fitur/modul pada sistem yang sudah ada.</p>
            </div>

            <div>
                <h3 class="text-md font-semibold text-green-600 dark:text-green-400 mb-4 border-b pb-2">Informasi Surat & Instansi</h3>
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama SKPD (Perangkat Daerah)</label>
                        <input type="text" value="{{ $detail->kembang_nama_skpd ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-md font-semibold text-green-600 dark:text-green-400 mb-4 border-b pb-2">Personalia</h3>
                <div class="grid gap-6 md:grid-cols-2 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="md:col-span-2"><p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Pejabat Penandatangan Surat</p></div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Pejabat</label>
                        <input type="text" value="{{ $detail->kembang_ttd_nama ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                        <input type="text" value="{{ $detail->kembang_ttd_nip ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">   
                    </div>

                    <div class="md:col-span-2 mt-2"><p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Penanggung Jawab 1</p></div>
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" value="{{ $detail->kembang_perintah_pj1_nama ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                            <input type="text" value="{{ $detail->kembang_perintah_pj1_nip ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                            <input type="text" value="{{ $detail->kembang_perintah_pj1_jabatan ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                        </div>
                    </div>
                    
                    <div class="md:col-span-2 mt-2"><p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Penanggung Jawab 2</p></div>
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" value="{{ $detail->kembang_perintah_pj2_nama ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                            <input type="text" value="{{ $detail->kembang_perintah_pj2_nip ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                            <input type="text" value="{{ $detail->kembang_perintah_pj2_jabatan ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-md font-semibold text-green-600 dark:text-green-400 mb-4 border-b pb-2">Detail Pengembangan Fitur</h3>
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Aplikasi Saat Ini</label>
                        <input type="text" value="{{ $detail->kembang_nama_sistem ?? '-' }}" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan Umum Pengembangan</label>
                        <textarea rows="3" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">{{ $detail->kembang_ket ?? '-' }}</textarea>
                    </div>    
                    
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Daftar Fitur yang Dikembangkan</label>   
                        <div class="space-y-3 p-4 bg-gray-50 border border-gray-200 rounded-lg dark:bg-gray-700/50 dark:border-gray-600">
                            @php
                                $rawKembangFitur = $detail->kembang_nama_fitur;
                                
                                if (is_array($rawKembangFitur)) {
                                    $kembangFitur = empty($rawKembangFitur) ? ['Tidak ada fitur terdaftar'] : $rawKembangFitur;
                                } else {
                                    $decoded = json_decode($rawKembangFitur, true);
                                    $kembangFitur = is_array($decoded) ? $decoded : ($rawKembangFitur ? [$rawKembangFitur] : ['Tidak ada fitur terdaftar']);
                                }
                            @endphp

                            <ul class="list-disc pl-5 text-sm text-gray-600 dark:text-gray-300 space-y-1">
                                @foreach($kembangFitur as $fitur)
                                    <li>{{ $fitur }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan Detail Fitur</label>
                        <textarea rows="3" readonly disabled class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">{{ $detail->kembang_ket_fitur ?? '-' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    @endif
@else
    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
        <p>Data detail pembuatan aplikasi tidak ditemukan untuk tiket ini.</p>
    </div>
@endif