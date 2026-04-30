@extends('layouts.main')

@section('title', 'Formulir Izin Penelitian')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <div id="step-1" class="step-content transition-opacity duration-300">
        <form id="form-penelitian" action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Formulir Permohonan Izin Penelitian</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Lengkapi identitas diri, data pendidikan, dan detail kegiatan penelitian.</p>
                </div>

                <div class="mb-10">
                    <h3 class="flex items-center text-lg font-bold text-gray-900 dark:text-white mb-4">
                        <span class="flex items-center justify-center w-6 h-6 mr-2 text-sm rounded-full bg-blue-100 text-blue-600">1</span>
                        Identitas Pemohon
                    </h3>
                    <div class="grid gap-6 md:grid-cols-3">
                        <div class="md:col-span-3">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                            <input type="text" name="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Alias (Opsional)</label>
                            <input type="text" name="nama_alias" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Panggilan (Opsional)</label>
                            <input type="text" name="nama_panggilan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. HP / WhatsApp</label>
                            <input type="text" inputmode="numeric" pattern="[0-9]*" minlength="10" maxlength="15" name="no_hp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        </div>
                        
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Agama</label>
                            <input type="text" name="agama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status Perkawinan</label>
                            <select name="status_perkawinan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                <option value="Belum Kawin">Belum Kawin</option>
                                <option value="Kawin">Kawin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kebangsaan</label>
                            <input type="text" name="kebangsaan" value="Indonesia" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <div class="md:col-span-3">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></textarea>
                        </div>

                        <div class="md:col-span-3">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pas Foto</label>
                            <input type="file" name="pas_foto" accept="image/*" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">File akan otomatis dikonversi ke format .webp (Maks. 2MB).</p>
                        </div>
                    </div>
                </div>

                <hr class="h-px mt-10 mb-8 bg-gray-200 border-0 dark:bg-gray-700">

                <div class="mb-10">
                    <h3 class="flex items-center text-lg font-bold text-gray-900 dark:text-white mb-4">
                        <span class="flex items-center justify-center w-6 h-6 mr-2 text-sm rounded-full bg-blue-100 text-blue-600">2</span>
                        Pendidikan & Instansi
                    </h3>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pekerjaan/Pendidikan Saat Ini</label>
                            <input type="text" name="pekerjaan_pendidikan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: Mahasiswa" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Institusi Pendidikan/Kampus</label>
                            <input type="text" name="institusi_pendidikan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester (Opsional)</label>
                            <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="2" name="semester" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Mahasiswa (NIM)</label>
                            <input type="text" inputmode="numeric" pattern="[0-9]*" name="nomor_mahasiswa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Pegawai (Opsional)</label>
                            <input type="text" inputmode="numeric" pattern="[0-9]*" minlength="18" maxlength="18" name="nomor_pegawai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Institusi Kampus</label>
                            <textarea name="alamat_institusi" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                        </div>
                    </div>
                </div>

                <hr class="h-px mt-10 mb-8 bg-gray-200 border-0 dark:bg-gray-700">

                <div class="mb-10">
                    <h3 class="flex items-center text-lg font-bold text-gray-900 dark:text-white mb-4">
                        <span class="flex items-center justify-center w-6 h-6 mr-2 text-sm rounded-full bg-blue-100 text-blue-600">3</span>
                        Detail Kegiatan Penelitian
                    </h3>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul Penelitian / Pembicara</label>
                            <input type="text" name="judul_pembicara" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kegiatan</label>
                            <input type="text" name="kegiatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: Skripsi / Tugas Akhir" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dalam Rangka</label>
                            <input type="text" name="dalam_rangka" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lokasi Kegiatan</label>
                            <input type="text" name="lokasi_kegiatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penanggung Jawab 1 (Dosen Pembimbing)</label>
                            <input type="text" name="penanggung_jawab_1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penanggung Jawab 2 (Opsional)</label>
                            <input type="text" name="penanggung_jawab_2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Banyak Peserta/Anggota Tim</label>
                            <input type="text" inputmode="numeric" pattern="[0-9]*" name="banyak_peserta" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        </div>
                    </div>
                </div>

                <hr class="h-px mt-10 mb-8 bg-gray-200 border-0 dark:bg-gray-700">

                <div class="mb-8">
                    <h3 class="flex items-center text-lg font-bold text-gray-900 dark:text-white mb-4">
                        <span class="flex items-center justify-center w-6 h-6 mr-2 text-sm rounded-full bg-blue-100 text-blue-600">4</span>
                        Ciri Fisik & Lainnya (Opsional)
                    </h3>
                    <div class="grid gap-6 md:grid-cols-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tinggi Badan (cm)</label>
                            <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="3" name="tinggi_badan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bentuk Badan</label>
                            <input type="text" name="bentuk_badan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Warna Kulit</label>
                            <input type="text" name="warna_kulit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bentuk Rambut</label>
                            <input type="text" name="bentuk_rambut" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ciri Khusus</label>
                            <input type="text" name="ciri_khusus" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hobi</label>
                            <input type="text" name="hobi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Kirim Permohonan
                    </button>
                </div>
            </div>
        </form>       
    </div>
</div>

@push('scripts')
    @vite('resources/js/service-controller.js')
@endpush
@endsection