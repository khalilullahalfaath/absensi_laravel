@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h3>Admin Dashboard</h3>

    <!-- Add Admin-specific content here -->

    <div class="mt-3">
        <!-- Logout Button -->
        <form action="/sessions/logout" method="POST">
            @csrf
            <button type="submit" class="nav-link btn btn-link" style="text-decoration: none;">Logout</button>
        </form>
    </div>
</div>
@endsection