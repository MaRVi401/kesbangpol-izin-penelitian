@extends('layouts.main')

@section('title', 'Create User')

@section('content')
    <div class="p-4 mt-14">
        {{-- Breadcrumb Section --}}
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-colors">
                        <svg class="w-3 h-3 me-2.5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <a href="{{ route('user-management.index') }}"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white transition-colors">User
                            Management</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-500">Create User</span>
                    </div>
                </li>
            </ol>
        </nav>

        <hr class="mb-6 border-gray-200 dark:border-gray-700">

        {{-- Sub-Title --}}
        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">Tambah Pengguna Baru</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Silahkan lengkapi formulir di bawah untuk mendaftarkan
                pengguna baru ke sistem.</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-6">
            <form action="{{ route('user-management.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid gap-6 mb-8 md:grid-cols-2">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Ahmad Yassin"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:text-white transition-colors
                        {{ $errors->has('nama') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }}">
                        @error('nama')
                            <p class="mt-1.5 text-xs font-medium text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@subang.go.id"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:text-white transition-colors
                        {{ $errors->has('email') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }}">
                        @error('email')
                            <p class="mt-1.5 text-xs font-medium text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Username --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:text-white transition-colors
                        {{ $errors->has('username') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }}">
                        @error('username')
                            <p class="mt-1.5 text-xs font-medium text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NIP --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip') }}" maxlength="18"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="199001012015011001"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:text-white transition-colors
                            {{ $errors->has('nip') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }}">
                        @error('nip')
                            <p class="mt-1.5 text-xs font-medium text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Role</label>
                        <select name="role"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="pengguna_asn" {{ old('role') == 'pengguna_asn' ? 'selected' : '' }}>Pengguna ASN
                            </option>
                            <option value="kabid" {{ old('role') == 'kabid' ? 'selected' : '' }}>Kabid</option>
                            <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                            <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin
                            </option>
                        </select>
                    </div>

                    {{-- WhatsApp --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Nomor WhatsApp</label>
                        <input type="text" name="no_wa" value="{{ old('no_wa') }}" maxlength="13"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="081234567890"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:text-white transition-colors
                            {{ $errors->has('no_wa') ? 'border-red-500' : 'border-gray-300' }}">
                        @error('no_wa')
                            <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:text-white transition-colors
                            {{ $errors->has('alamat') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }}"
                            placeholder="Masukkan alamat lengkap sesuai KTP...">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="mt-1.5 text-xs font-medium text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:text-white transition-colors
                        {{ $errors->has('password') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }}">
                        @error('password')
                            <p class="mt-1.5 text-xs font-medium text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Konfirmasi
                            Password</label>
                        <input type="password" name="password_confirmation"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:text-white transition-colors
                        {{ $errors->has('password') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }}">
                    </div>
                </div>

                {{-- Avatar Section --}}
                <div class="mb-8">
                    <label class="block mb-3 text-sm font-semibold text-gray-900 dark:text-white">Avatar Profile</label>
                    <div
                        class="flex items-center gap-6 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-dashed transition-colors
                    {{ $errors->has('avatar') ? 'border-red-500 bg-red-50/50 dark:bg-red-900/10' : 'border-gray-300 dark:border-gray-600' }}">
                        <div class="w-full">
                            <input type="file" name="avatar"
                                class="block w-full text-xs text-gray-900 border rounded-lg cursor-pointer bg-white focus:outline-none dark:bg-gray-800 dark:placeholder-gray-400 transition-colors
                            {{ $errors->has('avatar') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600 dark:text-gray-400' }}">
                            @error('avatar')
                                <div class="flex items-center gap-1 mt-1.5 text-red-600 dark:text-red-500">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-xs font-medium">{{ $message }}</p>
                                </div>
                            @else
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 font-normal">PNG, JPG or WebP (Max.
                                    2MB).</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Button Section --}}
                <div class="flex items-center justify-end gap-3 border-t border-gray-200 dark:border-gray-700 pt-6">
                    <a href="{{ route('user-management.index') }}"
                        class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 transition-all">
                        Batal
                    </a>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-2.5 text-center transition-all shadow-md">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
