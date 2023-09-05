@extends('layout.app')
@section('content')

{{-- Head --}}
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1 class="text-center">Location Check Settings</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('location.store') }}" method="POST">
                @csrf
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="toggleLocationCheck" name="toggleLocationCheck" value="1" {{ $locationCheck && $locationCheck->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="toggleLocationCheck">Toggle Location Check</label>
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection