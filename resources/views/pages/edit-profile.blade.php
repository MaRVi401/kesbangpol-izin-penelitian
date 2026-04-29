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
                {{ session('success') }}
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
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 text-center">
                        <div class="relative inline-block mb-4">
                            @php
                                $avatarUrl = $user->avatar
                                    ? Storage::disk('s3')->url($user->avatar)
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
                    </div>
                </div>

                {{-- Kanan: Form Data --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block mb-2 text-xs font-bold text-gray-900 dark:text-white">Nama Lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                                @error('nama') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- DINAMIS NIM/NIP --}}
                            <div>
                                <label class="block mb-2 text-xs font-bold text-gray-400">{{ $labelIdentitas }}</label>
                                <input type="text" value="{{ $identitas }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed" readonly>
                            </div>

                            <div>
                                <label class="block mb-2 text-xs font-bold text-gray-900 dark:text-white">Username</label>
                                <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                                @error('username') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Tambahkan field email/no_wa jika diperlukan --}}
                        </div>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="flex justify-end gap-4">
                        <button type="submit" class="bg-blue-700 text-white px-12 py-3 rounded-xl font-bold hover:bg-blue-800 shadow-lg transition-all active:scale-95 text-xs">Simpan Perubahan</button>
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
