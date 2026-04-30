@extends('layouts.app')

@section('title', 'Edit Profil - E-Gov Kominfo')

@section('content')
<section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto px-4">

        {{-- Header & Alerts --}}
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Pengaturan Profil</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi pribadi Anda sebagai <span class="font-bold text-blue-600">{{ str_replace('_', ' ', $user->role) }}</span>.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 text-green-800 border border-green-200 rounded-xl font-bold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 p-4 bg-blue-50 text-blue-800 border border-blue-200 rounded-xl font-bold flex items-center">
                {{ session('info') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 text-red-800 border border-red-200 rounded-xl font-bold flex items-center">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Kiri: Foto Profil --}}
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 text-center sticky top-24">
                        <div class="relative inline-block mb-4">
                            @php
                                $avatarUrl = $user->avatar
                                    ? \Illuminate\Support\Facades\Storage::disk('s3')->url($user->avatar)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->nama) . '&color=7F9CF5&background=EBF4FF';
                            @endphp
                            <img id="preview" src="{{ $avatarUrl }}" class="w-40 h-40 rounded-full object-cover border-4 border-blue-600 shadow-md">
                            <label for="avatar" class="absolute bottom-1 right-1 bg-blue-600 p-2.5 rounded-full text-white cursor-pointer hover:bg-blue-700 shadow-lg transition-transform hover:scale-110 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*" onchange="previewImage(this)">
                            </label>
                        </div>
                        @error('avatar') <p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p> @enderror
                        <h3 class="font-bold text-gray-900 dark:text-white mt-4">{{ $user->nama }}</h3>
                        <p class="text-xs text-gray-500 italic mt-1 text-center">Member sejak {{ $user->created_at->format('M Y') }}</p>
                    </div>
                </div>

                {{-- Kanan: Form Data --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Card 1: Informasi Dasar --}}
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Nama Lengkap --}}
                            <div class="md:col-span-2 text-left">
                                <label class="block mb-2 text-xs font-bold text-gray-900 dark:text-white">Nama lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                @error('nama') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            {{-- DINAMIS NIM/NIP --}}
                            <div class="text-left">
                                <label class="block mb-2 text-xs font-bold text-gray-400">{{ $labelIdentitas }}</label>
                                <input type="text" value="{{ $identitas }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed dark:bg-gray-900/50 dark:border-gray-700" readonly>
                            </div>

                            {{-- Username --}}
                            <div class="text-left">
                                <label class="block mb-2 text-xs font-bold text-gray-900 dark:text-white">Username</label>
                                <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                @error('username') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            {{-- Email --}}
                            <div class="text-left">
                                <label class="block mb-2 text-xs font-bold text-gray-900 dark:text-white">Alamat email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                @error('email') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            {{-- No WhatsApp --}}
                            <div class="text-left">
                                <label class="block mb-2 text-xs font-bold text-gray-900 dark:text-white">Nomor whatsapp</label>
                                <input type="text" name="no_wa" value="{{ old('no_wa', $user->no_wa) }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                @error('no_wa') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="md:col-span-2 text-left">
                                <label class="block mb-2 text-xs font-bold text-gray-900 dark:text-white">Alamat lengkap</label>
                                <textarea name="alamat" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition-all">{{ old('alamat', $user->alamat) }}</textarea>
                                @error('alamat') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Password (Terpisah) --}}
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-6 text-left">Ubah password (opsional)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Password Baru --}}
                            <div class="text-left">
                                <label class="block mb-2 text-xs font-bold text-gray-900 dark:text-white">Password baru</label>
                                <input type="password" name="password" placeholder="••••••••" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                @error('password') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div class="text-left">
                                <label class="block mb-2 text-xs font-bold text-gray-900 dark:text-white">Konfirmasi password</label>
                                <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('dashboard') }}" class="px-10 py-3 text-xs font-bold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-12 py-3 rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition-all active:scale-95 text-xs">Simpan perubahan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
