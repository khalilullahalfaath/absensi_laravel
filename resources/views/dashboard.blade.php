@extends('layout/app')
@section('content')
<body>
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="text-center">
            <img src="{{ asset('pictures/undraw_Happy_announcement_re_tsm0.png') }}" alt="gambar selamat datang" style="max-width: 300px;">
            <h4>Selamat datang di Aplikasi Presensi Kehadiran <br>Peserta Kerja Praktik</h4>
            <h6>PT LEN Industry</h6>
            <h6>Login sebagai Admin</h6>
        </div>
    </div>
@endsection