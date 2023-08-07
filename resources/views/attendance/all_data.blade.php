@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h3>All Data</h3>

    <!-- Legend -->
    <div class="mt-4 mb-5">
        <h4>Keterangan</h4>
        <div class="d-flex align-items-center mt-2">
            <div class="legend-circle legend-green"></div>
            <span class="ml-2">OK</span>
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

    <!-- Display Check-in Records -->
    <h4>Check-in Records</h4>
    @include('attendance.tables._checkin_table')
    
    <!-- Display Check-out Records -->
    <h4>Check-out Records</h4>
    @include('attendance.tables._checkout_table')
    
    <!-- Display Records -->
    <h4>Records</h4>
    <p>Perhatikan bahwa catatan record untuk jam kerja <br> hanya akan ditampilkan jika Anda melakukan checkout</p>
    <p>Jika Anda tidak melakukan check-in maka check-in Anda akan dihitung pada pukul 13:00</p>
    @include('attendance.tables._record_table')
</div>
@endsection
