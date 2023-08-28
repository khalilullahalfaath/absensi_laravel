@extends('layout.app')
@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container" style="margin-top: 50px">
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-center">Data Peserta</h4>
            <div class="card border-0 shadow-sm rounded-md mt-4">
                <div class="card-body">

                    <a href="javascript:void(0)" class="btn btn-success mb-2" id="btn-create-post">Tambah</a>

                    <table class="table table-bordered table-striped text-center" id="table-peserta-d">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Presensi</th>
                                <th>Nama</th>
                                <th>Status Peserta</th>
                                <th>Status Akun</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="table-peserta">
                            @foreach($data as $peserta)
                            <tr id="index_{{ $peserta->id }}">
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $peserta->no_presensi }}</td>
                                <td>{{ $peserta->nama_peserta}}</td>
                                <td>{{$peserta->status_peserta_aktif}}</td>
                                <td>{{$peserta->status_akun_aplikasi}}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" id="btn-edit-peserta" data-id="{{ $peserta->id }}" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="javascript:void(0)" id="btn-delete-peserta" data-id="{{ $peserta->id }}" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                </div>
            </div>
        </div>
    </div>
</div>
@include('components.modal-create-peserta')

<script>
    // data table
    $(document).ready(function() {
        $('#table-peserta-d').DataTable();
    });
</script>
@endsection