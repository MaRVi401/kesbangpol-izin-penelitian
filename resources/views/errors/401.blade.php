@extends('errors.minimal')

@section('title', 'Sesi Tidak Sah')
@section('code', '401')
@section('message')
    Maaf, Anda harus masuk (login) terlebih dahulu untuk dapat mengakses halaman ini. 
    Silakan klik tombol di bawah untuk menuju halaman masuk.
@endsection

@section('button')
    <a href="{{ route('login') }}" class="w-full sm:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200">
        Masuk Sekarang
    </a>
@endsection