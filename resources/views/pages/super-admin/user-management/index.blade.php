@extends('layouts.main')

@section('title', 'Users Management')

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
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-500">User
                            Management</span>
                    </div>
                </li>
            </ol>
        </nav>

        <hr class="mb-6 border-gray-200 dark:border-gray-700">

        {{-- Title Section --}}
        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">User Management</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola pengguna dan hak akses sistem secara efektif.</p>
        </div>

        {{-- Header Section (Search, Filter & Add) --}}
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 mb-6">
            <div class="w-full md:w-3/4 flex flex-col md:flex-row gap-3">
                {{-- Form Search & Filter --}}
                <form action="{{ route('user-management.index') }}" method="GET"
                    class="flex flex-col md:flex-row gap-3 w-full">
                    {{-- Input Search --}}
                    <div class="relative w-full md:w-2/3">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>

                        <input type="text" name="search" id="simple-search" value="{{ request('search') }}"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Cari pengguna...">

                        {{-- Tombol X (Clear) --}}
                        @if (request('search') || request('role'))
                            <a href="{{ route('user-management.index') }}"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-red-500 transition-colors"
                                title="Bersihkan Pencarian">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>

                    <div class="w-full md:w-1/3">
                        <div class="relative w-full">
                            {{-- Ikon Filter --}}
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m2.133 2.6 5.856 6.9L8 14l4 2V9.5l5.856-6.9a1 1 0 0 0-.77-1.6H2.902a1 1 0 0 0-.769 1.6Z" />
                                </svg>
                            </div>

                            {{-- Select Role --}}
                            <select name="role" onchange="this.form.submit()"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all cursor-pointer">
                                <option value="">Semua Role</option>
                                <option value="pengguna_asn" {{ request('role') == 'pengguna_asn' ? 'selected' : '' }}>
                                    Pengguna ASN</option>
                                <option value="kabid" {{ request('role') == 'kabid' ? 'selected' : '' }}>Kabid</option>
                                <option value="operator" {{ request('role') == 'operator' ? 'selected' : '' }}>Operator
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="w-full md:w-auto flex shrink-0">
                <a href="{{ route('user-management.create') }}"
                    class="w-full flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-all shadow-sm">
                    <svg class="h-4 w-4 mr-2" fill="currentColor" viewbox="0 0 20 20">
                        <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    Tambah User
                </a>
            </div>
        </div>

        {{-- Table Section --}}
        <div
            class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold text-gray-900 dark:text-white">Detail Pengguna
                            </th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Username</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Role</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">NIP</th>
                            <th scope="col" class="px-6 py-4 text-right font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($users as $user)
                            <tr
                                class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="flex items-center gap-3">
                                        <img class="w-10 h-10 rounded-full object-cover border border-gray-200 dark:border-gray-600"
                                            src="{{ $user->avatar ? \Illuminate\Support\Facades\Storage::disk('s3')->url($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->nama) }}"
                                            alt="{{ $user->nama }}"
                                            onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}';">

                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-bold text-gray-900 dark:text-white">{{ $user->nama }}</span>
                                            <span
                                                class="text-xs text-gray-500 dark:text-gray-400 font-normal">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </th>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="font-mono text-xs font-medium px-2 py-1 rounded bg-gray-100 text-gray-600 border border-gray-200 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-600">
                                        {{ $user->username }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border
                                        {{ $user->role == 'super_admin'
                                            ? 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800'
                                            : 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800' }}">
                                        {{ Str::headline($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php $roleRel = Str::camel($user->role); @endphp
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $user->$roleRel ? $user->$roleRel->nip : '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- Tombol Edit (Ikon Pensil) --}}
                                        <a href="{{ route('user-management.edit', $user->uuid) }}"
                                            class="p-2 text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/40 transition-all shadow-sm"
                                            title="Edit User">
                                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>

                                        {{-- Tombol Delete (Ikon Trash) --}}
                                        <form id="delete-form-{{ $user->uuid }}"
                                            action="{{ route('user-management.destroy', $user->uuid) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="confirmDelete('{{ $user->uuid }}', '{{ $user->nama }}')"
                                                class="p-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/40 transition-all shadow-sm"
                                                title="Hapus User">
                                                <svg class="w-4 h-4" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <p class="text-gray-500 dark:text-gray-400 font-medium">
                                            Data dengan pencarian <span
                                                class="font-bold text-blue-600 dark:text-blue-400">"{{ request('search') }}"</span>
                                            tidak ditemukan.
                                        </p>

                                        <a href="{{ route('user-management.index') }}"
                                            class="mt-4 text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Tampilkan semua data
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $users->appends(['search' => request('search')])->links() }}
        </div>
    </div>

    <div id="session-flash" aria-hidden="true" data-success="{{ session('success') }}"
        data-error="{{ session('error') }}">
    </div>

    @push('scripts')
        @vite('resources/js/user-management.js')
    @endpush
@endsection
