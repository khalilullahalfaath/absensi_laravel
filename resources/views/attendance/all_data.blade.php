@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h3>All Data</h3>

    <!-- Display Check-in Records -->
    <h4>Check-in Records</h4>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Tanggal Presensi</th>
                    <th>Jam Masuk</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($checkInRecords as $checkInRecord)
                <tr>
                    <td>{{ $checkInRecord->tanggal_presensi }}</td>
                    <td>{{ $checkInRecord->jam_masuk }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Display Check-out Records -->
    <h4>Check-out Records</h4>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Tanggal Presensi</th>
                    <th>Jam Keluar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($checkOutRecords as $checkOutRecord)
                <tr>
                    <td>{{ $checkOutRecord->tanggal_presensi }}</td>
                    <td>{{ $checkOutRecord->jam_keluar }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Display Records -->
    <h4>Records</h4>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Tanggal Presensi</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Jam Kerja</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr>
                    <td>{{ $record->absensiCheckIn->tanggal_presensi }}</td>
                    <td>{{ $record->absensiCheckIn->jam_masuk }}</td>
                    <td>{{ $record->absensiCheckOut->jam_keluar }}</td>
                    <td>{{ $record->jam_kerja }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
