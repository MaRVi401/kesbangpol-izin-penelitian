@php
    // Mengambil data detail dari relasi yang ada di model Tiket
    $detail = $ticket->suratIzinPenelitian;
@endphp

@if($detail)
<div class="space-y-8">
    {{-- 1. IDENTITAS PRIBADI --}}
    <div>
        <h4 class="text-md font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            1. Identitas Pribadi Pemohon
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50/50 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-100 dark:border-gray-700">
            <div class="md:col-span-2">
                <p class="text-xs text-gray-500 uppercase font-semibold">Nama Lengkap</p>
                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->nama }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Tempat, Tanggal Lahir</p>
                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->tempat_lahir }}, {{ \Carbon\Carbon::parse($detail->tanggal_lahir)->translatedFormat('d F Y') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Jenis Kelamin</p>
                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->jenis_kelamin }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Agama</p>
                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->agama }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">No. HP / WhatsApp</p>
                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->no_hp }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-xs text-gray-500 uppercase font-semibold">Alamat Lengkap</p>
                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->alamat_lengkap }}</p>
            </div>
        </div>
    </div>

    {{-- 2. DATA AKADEMIK --}}
    <div>
        <h4 class="text-md font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
            2. Data Institusi / Akademik
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50/50 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-100 dark:border-gray-700">
            <div class="md:col-span-2">
                <p class="text-xs text-gray-500 uppercase font-semibold">Institusi Pendidikan</p>
                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->institusi_pendidikan }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Program Studi / Pekerjaan</p>
                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->pekerjaan_pendidikan }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">NIM / Nomor Mahasiswa</p>
                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->nomor_mahasiswa ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Semester</p>
                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->semester ?? '-' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-xs text-gray-500 uppercase font-semibold">Alamat Institusi</p>
                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->alamat_institusi ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- 3. RENCANA PENELITIAN --}}
    <div>
        <h4 class="text-md font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            3. Rincian Rencana Penelitian
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50/50 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-100 dark:border-gray-700">
            <div class="md:col-span-2">
                <p class="text-xs text-gray-500 uppercase font-semibold">Bentuk Kegiatan</p>
                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->kegiatan }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-xs text-gray-500 uppercase font-semibold">Judul Penelitian / Dalam Rangka</p>
                <p class="text-base font-medium text-gray-900 dark:text-white leading-relaxed">{{ $detail->dalam_rangka }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Waktu Pelaksanaan</p>
                <p class="text-base font-medium text-gray-900 dark:text-white">
                    {{ \Carbon\Carbon::parse($detail->tanggal_mulai)->translatedFormat('d M Y') }} s/d {{ \Carbon\Carbon::parse($detail->tanggal_selesai)->translatedFormat('d M Y') }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Banyak Peserta</p>
                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->banyak_peserta }} Orang</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-xs text-gray-500 uppercase font-semibold">Lokasi Penelitian (Tujuan)</p>
                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->lokasi_kegiatan }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-xs text-gray-500 uppercase font-semibold">Dosen Pembimbing / Penanggung Jawab</p>
                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $detail->penanggung_jawab_1 }}</p>
            </div>
        </div>
    </div>

    {{-- 4. LAMPIRAN FOTO --}}
    @if($detail->path_pas_foto)
    <div>
        <h4 class="text-md font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">4. Pas Foto Pemohon</h4>
        <div class="flex justify-start">
            <img src="{{ url('/storage/private/private/pas_foto/' . $detail->path_pas_foto) }}" alt="Pas Foto" class="w-32 h-40 object-cover rounded-lg border border-gray-300 shadow-sm">
        </div>
    </div>
    @endif
</div>
@else
<div class="text-center py-10 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-dashed border-gray-300">
    <p class="text-gray-500 dark:text-gray-400">Data detail permohonan tidak ditemukan.</p>
</div>
@endif