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
                                <th></th>
                                <th>No. Presensi</th>
                                <th>Nama</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Berakhir</th>
                                <th>Status Peserta</th>
                                <th>Status Akun</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="table-peserta">
                            @foreach($data as $peserta)
                            <tr id="index_{{ $peserta->id }}">
                                <td></td>
                                <td>{{$peserta->no_presensi }}</td>
                                <td>{{$peserta->nama_peserta}}</td>
                                <td>{{$peserta->tanggal_mulai}}</td>
                                <td>{{$peserta->tanggal_berakhir}}</td>
                                <td>
                                    @if($peserta->status_peserta_aktif == 1)
                                        <button class="btn btn-success">Aktif</button>
                                    @else
                                        <button class="btn btn-danger">Tidak Aktif</button>
                                    @endif
                                </td>
                                <td>
                                    @if($peserta->status_akun_aplikasi == 1)
                                        <button class="btn btn-success">Aktif</button>
                                    @else
                                        <button class="btn btn-danger">Tidak Aktif</button>
                                    @endif
                                </td>

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
@include('components.modal-edit-peserta')
@include('components.delete-peserta')

<script>
    // data table
    // $(document).ready(function() {
    //     $('#table-peserta-d').DataTable();
    // });

    const table = new DataTable('#table-peserta-d', {
    columnDefs: [
        {
            searchable: false,
            orderable: false,
            targets: 0
        }
    ],
    order: [[1, 'asc']]
});
 
table
    .on('order.dt search.dt', function () {
        let i = 1;
 
        table
            .cells(null, 0, { search: 'applied', order: 'applied' })
            .every(function (cell) {
                this.data(i++);
            });
    })
    .draw();
</script>
@endsection