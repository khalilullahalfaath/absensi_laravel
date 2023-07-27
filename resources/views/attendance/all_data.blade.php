@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h3>All Data</h3>

    <!-- Display Check-in Records -->
    <h4>Check-in Records</h4>
    @include('attendance.tables._checkin_table')
    
    <!-- Display Check-out Records -->
    <h4>Check-out Records</h4>
    @include('attendance.tables._checkout_table')
    
    <!-- Display Records -->
    <h4>Records</h4>
    @include('attendance.tables._record_table')
</div>
@endsection
