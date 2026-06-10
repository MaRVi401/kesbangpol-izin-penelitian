@extends('layouts.main')

@section('title', 'Daftar Mahasiswa Ditolak')

@section('content')
    <div class="p-4 mt-14">
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li><a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Home</a></li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        <a href="{{ route('user-management.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">User Management</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        <span class="text-sm font-medium text-gray-500">Daftar Mahasiswa Ditolak</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Daftar Mahasiswa yang Ditolak</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pengelolaan akun mahasiswa yang telah ditolak sistem.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4">Nama Mahasiswa</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">NIM</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($rejectedUsers as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $user->nama }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ $user->mahasiswa->nim ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex gap-2 justify-center">
                                    <form action="{{ route('user-management.activate', $user->uuid) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="aktif">
                                        <button type="submit" class="text-green-600 bg-green-50 hover:bg-green-100 font-medium rounded-lg text-xs px-3 py-2 transition-all">
                                            Aktifkan
                                        </button>
                                    </form>

                                    <form action="{{ route('user-management.forceDelete', $user->uuid) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus permanen akun ini? Semua dokumen (KTM/Rekomendasi) akan terhapus dari server.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 bg-red-50 hover:bg-red-100 font-medium rounded-lg text-xs px-3 py-2 transition-all">
                                            Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">Tidak ada mahasiswa yang ditolak.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($rejectedUsers->hasPages())
                <div class="p-4 border-t dark:border-gray-700">
                    {{ $rejectedUsers->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection