@extends('layout.app')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
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

<div class="container mt-5">
    <!-- Legend -->
<div class="mt-4 mb-5">
    <h4>Keterangan</h4>
    <div class="d-flex align-items-center mt-2">
        <div class="legend-circle legend-green"></div>
        <span class="ml-2">Ontime</span>
    </div>
    <div class="d-flex align-items-center">
        <div class="legend-circle legend-red"></div>
        <span class="ml-2">Late</span>
    </div>
    <div class="d-flex align-items-center mt-2">
        <div class="legend-circle legend-yellow"></div>
        <span class="ml-2">Not Check-in. Created by System</span>
    </div>
</div>
<div class="d-flex justify-content-end">
    <a href="{{ route('export.advanced.index') }}" class="btn btn-primary">Advanced Export</a>
</div>
    <!-- Display Check-in Records -->
    <h4>Attendance Record</h4>
    @include('admin.pages.attendances._attendance_table')
</div>
@endsection

<script>
    // JavaScript to handle the delete confirmation
    function confirmDelete(deleteUrl) {
        if (confirm('Apakah Anda Yakin Menghapus Data?')) {
            window.location.href = deleteUrl;
        }
    }
    </script>