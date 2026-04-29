<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrasi Mahasiswa - E-Gov Kominfo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <section class="py-8">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
            <a href="/" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-10 h-auto mr-2" src="{{ asset('assets/images/landingPages/logo-kabSubang.webp') }}"
                    alt="logo-KabSubang">
                E-Gov KOMINFO
            </a>

            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-xl xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white text-center">
                        Daftar Akun Mahasiswa
                    </h1>

                    {{-- Notifikasi Error --}}
                    @if ($errors->any())
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-700 dark:text-red-400" role="alert">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="space-y-4 md:space-y-6" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Bagian 1: Informasi Dasar --}}
                        <div class="space-y-4">
                            <h2 class="text-md font-semibold text-gray-700 dark:text-gray-300 border-b pb-1">Informasi Akun</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="Nama sesuai KTM" required>
                                </div>

                                <div>
                                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                                    <input type="text" name="username" id="username" value="{{ old('username') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="Username" required>
                                </div>

                                <div>
                                    <label for="nim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIM</label>
                                    <input type="text" name="nim" id="nim" value="{{ old('nim') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="Contoh: 210xxxx" required>
                                </div>
                            </div>
                        </div>

                        {{-- Bagian 2: Kontak & Alamat --}}
                        <div class="space-y-4">
                            <h2 class="text-md font-semibold text-gray-700 dark:text-gray-300 border-b pb-1">Kontak & Alamat</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="nama@email.com" required>
                                </div>

                                <div>
                                    <label for="no_wa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor WhatsApp</label>
                                    <input type="text" name="no_wa" id="no_wa" value="{{ old('no_wa') }}" minlength="10" maxlength="15"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="0812xxxx" required>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Lengkap</label>
                                    <textarea name="alamat" id="alamat" rows="2"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="Masukkan alamat domisili sekarang" required>{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Bagian 3: Keamanan --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                <input type="password" name="password" id="password" placeholder="••••••••"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                            </div>
                        </div>

                        {{-- Bagian 4: Dokumen --}}
                        <div class="space-y-4">
                            <h2 class="text-md font-semibold text-blue-600 dark:text-blue-400 border-b pb-1">Dokumen Verifikasi</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="ktm" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload KTM (Gambar)</label>
                                    <input type="file" name="ktm" id="ktm" accept="image/*"
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600"
                                        required>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-300">JPG, PNG atau JPEG (Max. 2MB).</p>
                                </div>

                                <div>
                                    <label for="surat_rekomendasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Surat Rekomendasi (PDF)</label>
                                    <input type="file" name="surat_rekomendasi" id="surat_rekomendasi" accept="application/pdf"
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600"
                                        required>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-300">Format PDF (Max. 2MB).</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" type="checkbox"
                                    class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600"
                                    required>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-light text-gray-500 dark:text-gray-300">Saya setuju dengan <a class="font-medium text-blue-600 hover:underline dark:text-blue-500" href="#">Syarat dan Ketentuan</a></label>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Daftar Sekarang
                        </button>

                        <p class="text-sm font-light text-gray-500 dark:text-gray-400 text-center">
                            Sudah memiliki akun? <a href="{{ route('login') }}"
                                class="font-medium text-blue-600 hover:underline dark:text-blue-500">Masuk di sini</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>