<div class="table-responsive">
    <table class="table table-striped table-bordered" id="user_checkins">
        <thead>
            <tr>
                <th>Tanggal Presensi</th>
                <th>Jam Masuk</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($checkInRecords as $checkInRecord)
            <tr class="{{ $checkInRecord->status === 'late' ? 'table-danger' : ($checkInRecord->status === 'not check-in' ? 'table-warning' : ($checkInRecord->status === 'ontime' ? 'table-success' : '')) }}">

                <td>{{ $checkInRecord->tanggal_presensi }}</td>
                <td>{{ $checkInRecord->jam_masuk }}</td>
                <td>{{ $checkInRecord->status }}</td>
                <td class="text-center">
                    <a href="{{ route('print.checkin.csv', ['id' => $checkInRecord->id]) }}" class="btn btn-sm btn-primary">Print to CSV</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3 d-flex justify-content-center">
    <a href="{{ route('print.allcheckin.csv') }}" class="btn btn-primary">Print All Check-in to CSV</a>
</div>

<script>
    $(document).ready(function() {
      $('#user_checkins').DataTable();
  } );
   </script>
