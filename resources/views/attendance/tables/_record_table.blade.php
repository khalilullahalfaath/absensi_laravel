<div class="table-responsive">
    <table class="table table-striped table-bordered" id="user_records">
        <thead>
            <tr>
                <th></th>
                <th>Tanggal Presensi</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Jam Kerja</th>
                <th>Status Check-in</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
            <tr>
                <th></th>
                <td>{{ $record->absensiCheckin->tanggal_presensi }}</td>
                <td>{{ $record->absensiCheckIn->jam_masuk }}</td>
                <td>{{ $record->absensiCheckOut->jam_keluar }}</td>
                <td>{{ $record->jam_kerja }}</td>
                <td>{{$record->absensiCheckIn->status}}</td>
                <td class="text-center">
                    <a href="{{ route('print.record.csv', ['id' => $record->id]) }}" class="btn btn-sm btn-primary">Print to CSV</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3 mb-3 d-flex justify-content-center">
    <a href="{{ route('print.allrecords.csv') }}" class="btn btn-primary">Print All Records to CSV</a>
</div>
<script>
    $(document).ready(function() {
      $('#user_records').DataTable();
  } );
   </script>
