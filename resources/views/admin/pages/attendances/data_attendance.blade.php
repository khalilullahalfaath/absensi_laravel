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