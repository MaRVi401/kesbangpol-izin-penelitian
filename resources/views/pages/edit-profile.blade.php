@extends('layouts.app')

@section('title', 'Edit Profil - E-Gov Kominfo')

@section('content')
    <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4">

            {{-- Breadcrumb / Back Button --}}
            <div class="mb-6">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors group">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>

            {{-- Page Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-left">Pengaturan Profil</h2>
                    <p class="text-sm text-gray-500 mt-1 text-left">Kelola informasi pribadi dan keamanan akun Anda.</p>
                </div>
                <span
                    class="px-4 py-1.5 text-xs font-bold text-blue-700 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-400 capitalize">
                    {{ str_replace('_', ' ', $user->role) }}
                </span>
            </div>

            {{-- Alert Section (Global) --}}
            <div class="space-y-4 mb-6">
                @if (session('success'))
                    <div class="p-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200 dark:bg-gray-800 dark:text-green-400 dark:border-green-900 shadow-sm flex items-center font-bold">
                        <svg class="w-5 h-5 me-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('info'))
                    <div class="p-4 text-sm text-blue-800 rounded-xl bg-blue-50 border border-blue-200 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-900 shadow-sm flex items-center font-bold">
                        <svg class="w-5 h-5 me-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('info') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="p-4 text-sm text-red-800 rounded-xl bg-red-50 border border-red-200 dark:bg-gray-800 dark:text-red-400 dark:border-red-900 shadow-sm flex items-center font-bold">
                        <svg class="w-5 h-5 me-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- Left Column: Avatar & Summary --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 text-center sticky top-24 flex flex-col items-center">

                            {{-- Bagian Gambar & Tombol Kamera --}}
                            <div class="relative inline-block mb-4">
                                @php
                                    $avatarUrl = $user->avatar
                                        ? \Illuminate\Support\Facades\Storage::disk('s3')->url($user->avatar)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->nama) . '&color=7F9CF5&background=EBF4FF';
                                @endphp
                                <img id="preview" src="{{ $avatarUrl }}"
                                    class="w-40 h-40 rounded-full object-cover border-4 border-blue-600 shadow-md transition-all duration-300">

                                <label for="avatar"
                                    class="absolute bottom-1 right-1 bg-blue-600 p-2.5 rounded-full text-white cursor-pointer hover:bg-blue-700 shadow-lg transition-transform hover:scale-110 active:scale-95 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <input type="file" id="avatar" name="avatar" class="hidden" accept="image/png, image/jpeg, image/jpg, image/webp">
                                </label>
                            </div>

                            {{-- PESAN ERROR AVATAR (Hanya Tulisan Merah) --}}
                            <div id="avatar-error-container" class="w-full mb-4">
                                @error('avatar')
                                    <p class="text-[11px] font-bold text-red-600 dark:text-red-500 text-center leading-tight">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Name & Member Info --}}
                            <div class="text-center border-t border-gray-100 dark:border-gray-700 pt-4 w-full">
                                <h3 class="font-bold text-gray-900 dark:text-white text-lg leading-tight">{{ $user->nama }}</h3>
                                <p class="text-xs text-gray-500 italic">Member sejak {{ $user->created_at->format('M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Forms --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Form Informasi Dasar --}}
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold mb-6 flex items-center text-gray-900 dark:text-white text-left">
                                <svg class="w-5 h-5 me-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Informasi Dasar
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                                <div class="md:col-span-2">
                                    <label class="block mb-2 text-xs font-bold text-gray-900 dark:text-white">Nama Lengkap</label>
                                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                                    @error('nama') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block mb-2 text-xs font-bold text-gray-400 dark:text-gray-500">NIP (Nomor Induk Pegawai)</label>
                                    <input type="text" value="{{ $nip }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed dark:bg-gray-900/50 dark:border-gray-700 font-medium outline-none" readonly>
                                </div>

                                <div>
                                    <label class="block mb-2 text-xs font-bold text-gray-900 dark:text-white">Username</label>
                                    <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                                    @error('username') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block mb-2 text-xs font-bold text-gray-900 dark:text-white">Alamat Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                                    @error('email') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block mb-2 text-xs font-bold text-gray-900 dark:text-white">Nomor WhatsApp</label>
                                    <input type="text" name="no_wa" value="{{ old('no_wa', $user->no_wa) }}" maxlength="15" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    @class([
                                        'w-full px-4 py-3 rounded-xl border focus:ring-2 outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                                        'border-red-500 focus:ring-red-500' => $errors->has('no_wa'),
                                        'border-gray-300 focus:ring-blue-500' => !$errors->has('no_wa'),
                                    ]) placeholder="08xxxxxxxxxx">
                                    @error('no_wa') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block mb-2 text-xs font-bold text-gray-900 dark:text-white">Alamat Lengkap</label>
                                    <textarea name="alamat" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">{{ old('alamat', $user->alamat) }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Form Keamanan --}}
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold mb-6 flex items-center text-gray-900 dark:text-white text-left">
                                <svg class="w-5 h-5 me-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Keamanan Akun
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                                <div>
                                    <label class="block mb-2 text-xs font-bold text-gray-900 dark:text-white">Password Baru</label>
                                    <input type="password" name="password" placeholder="••••••••" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                                    @error('password') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block mb-2 text-xs font-bold text-gray-900 dark:text-white">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                                </div>
                            </div>
                            <p class="mt-4 text-[10px] text-gray-500 italic font-medium">*Kosongkan jika tidak ingin mengubah password.</p>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-end gap-4 pt-4">
                            <a href="{{ route('dashboard') }}" class="px-8 py-3 text-xs font-bold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
                            <button type="submit" class="bg-blue-700 text-white px-12 py-3 rounded-xl font-bold hover:bg-blue-800 shadow-lg shadow-blue-500/30 transition-all transform active:scale-95 text-xs">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    @push('scripts')
        @vite('resources/js/profile.js')
    @endpush
@endsection
