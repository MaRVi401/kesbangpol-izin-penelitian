@extends('errors.minimal')

@section('title', 'Terlalu Banyak Permintaan')
@section('code', '429')
@section('message')
    Sistem mendeteksi terlalu banyak permintaan dari perangkat Anda. 
    Mohon tunggu sebentar sebelum mencoba mengakses kembali.
@endsection