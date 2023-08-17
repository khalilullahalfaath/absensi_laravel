<!-- Check-in table -->
<h5>Check-in Records</h5>
<div class="table-responsive">
    <table class="table table-striped" id="checkins">
        <thead>
            <tr>
                <th>No</th>
                <th>Id User</th>
                <th>Nama Peserta</th>
                <th>Tanggal Presensi</th>
                <th>Jam Masuk</th>
                <th>Status</th>
                <th>Actions</th> 
                <th width="50px"><button type="button" name="bulk_delete_checkins" id="bulk_delete_checkins" class="btn btn-danger btn-xs">Delete</button></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($checkInRecords as $checkInRecord)
            <tr class="{{ $checkInRecord->status === 'late' ? 'table-danger' : ($checkInRecord->status === 'not check-in' ? 'table-warning' : ($checkInRecord->status === 'ontime' ? 'table-success' : '')) }}">
                    <td>{{ $loop->iteration }}</td>
                    {{-- show some data relevant to checkin such as id_user which is a foreign key to users table --}}
                    <td>{{ optional($checkInRecord->user)->id ?? 'N/A' }}</td>
                    <td>{{ optional($checkInRecord->user)->nama ?? 'N/A' }}</td>
                    <td>{{ $checkInRecord->tanggal_presensi }}</td>
                    <td>{{ $checkInRecord->jam_masuk }}</td>
                    <td>{{$checkInRecord->status}}</td>
                    <td>
                        <!-- Delete button -->
                        <button class="btn btn-danger delete-btn" onclick="confirmDelete('{{ route('admin.attendance.checkin.destroy', $checkInRecord->id) }}')">Delete</button>
                    </td>
                    <td class="text-center">
                        <input name='id_Checkins[]' type="checkbox" id="checkItemCheckins_{{ $checkInRecord->id }}" 
                            value="{{ $checkInRecord->id }}">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3 d-flex justify-content-center">
    <a href="{{ route('admin.print.allcheckin.csv')}}" class="btn btn-primary">Download Check-in Records</a>
</div>

<!-- Check-out table -->
<h5>Check-out Records</h5>
<div class="table-responsive">
    <table class="table table-striped" id="checkouts">
        <thead>
            <tr>
                <th>No</th>
                <th>Id User</th>
                <th>Nama Peserta</th>
                <th>Tanggal Presensi</th>
                <th>Jam Keluar</th>
                <th>Actions</th> 
                <th width="50px"><button type="button" name="bulk_delete_checkouts" id="bulk_delete_checkouts" class="btn btn-danger btn-xs">Delete</button></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($checkOutRecords as $checkOutRecord)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    {{-- show some data relevant to checkout such as id_user which is a foreign key to users table --}}
                    <td>{{ optional($checkOutRecord->user)->id ?? 'N/A' }}</td>
                    <td>{{ optional($checkOutRecord->user)->nama ?? 'N/A' }}</td>
                    <td>{{ $checkOutRecord->tanggal_presensi }}</td>
                    <td>{{ $checkOutRecord->jam_keluar }}</td>
                    <td>
                        <!-- Delete button -->
                        <button class="btn btn-danger delete-btn" onclick="confirmDelete('{{ route('admin.attendance.checkout.destroy', $checkOutRecord->id) }}')">Delete</button>
                    </td>
                    <td class="text-center">
                        <input name='id_Checkouts[]' type="checkbox" id="checkItemCheckouts_{{ $checkOutRecord->id }}" 
                            value="{{ $checkOutRecord->id }}">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3 d-flex justify-content-center">
    <a href="{{ route('admin.print.allcheckout.csv')}}" class="btn btn-primary">Download Check-out Records</a>
</div>

<!-- Records table -->
<h5>Records</h5>
<div class="table-responsive">
    <table class="table table-striped" id="records">
        <thead>
            <tr>
                <th>No</th>
                <th>Id User</th>
                <th>Nama Peserta</th>
                <th>Tanggal Presensi</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Jam Kerja</th>
                <th>Status Check-in</th>
                <th>Actions</th> 
                <th width="50px"><button type="button" name="bulk_delete_records" id="bulk_delete_records" class="btn btn-danger btn-xs">Delete</button></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
            <tr class="{{ $record->absensiCheckIn->status === 'late' ? 'table-danger' : ($record->absensiCheckIn->status === 'not check-in' ? 'table-warning' : ($record->absensiCheckIn->status === 'ontime' ? 'table-success' : '')) }}">
                    <td>{{ $loop->iteration }}</td>
                    {{-- show some data relevant to record such as id_user which is a foreign key to users table --}}
                    <td>{{ optional($record->user)->id ?? 'N/A' }}</td>
                    <td>{{ optional($record->user)->nama ?? 'N/A' }}</td>
                    <td>{{ $record->absensiCheckIn->tanggal_presensi }}</td>
                    <td>{{ $record->absensiCheckIn->jam_masuk }}</td>
                    <td>{{ $record->absensiCheckOut->jam_keluar }}</td>
                    <td>{{ $record->jam_kerja }}</td>
                    <td>{{$record->absensiCheckIn->status}}</td>
                    <td>
                        <!-- Delete button -->
                        <button class="btn btn-danger delete-btn" onclick="confirmDelete('{{ route('admin.attendance.records.destroy', $record->id) }}')">Delete</button>
                    </td>
                    <td class="text-center">
                        <input name='id_Records[]' type="checkbox" id="checkItemRecords_{{ $record->id }}" 
                            value="{{ $record->id }}">
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3 mb-3 d-flex justify-content-center">
    <a href="{{ route('admin.print.allrecords.csv')}}" class="btn btn-primary">Download Record time Records</a>
</div>

<script>
    $(document).ready(function() {
      $('#checkins').DataTable();
      $('#checkouts').DataTable();
      $('#records').DataTable();
  } );

  $(document).on('click', '#bulk_delete_checkins', function() {
        var id = [];
        if (confirm("Are you sure you want to delete this data?")) {
            $('input[name="id_Checkins[]"]:checked').each(function() {
                id.push($(this).val());
            });
            if (id.length > 0) {
                $.ajax({
                    url: "{{ route('checkins.removeall') }}",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    method: "get",
                    data: { id: id },
                    success: function(data) {
                        console.log(data);
                        alert(data);
                        window.location.assign("users");
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                });
            } else {
                alert("Please select at least one checkbox");
            }
        }
    });

    $(document).on('click', '#bulk_delete_checkouts', function() {
        var id = [];
        if (confirm("Are you sure you want to delete this data?")) {
            $('input[name="id_Checkouts[]"]:checked').each(function() {
                id.push($(this).val());
            });
            if (id.length > 0) {
                $.ajax({
                    url: "{{ route('checkouts.removeall') }}",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    method: "get",
                    data: { id: id },
                    success: function(data) {
                        console.log(data);
                        alert(data);
                        window.location.assign("users");
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                });
            } else {
                alert("Please select at least one checkbox");
            }
        }
    });

    $(document).on('click', '#bulk_delete_records', function() {
        var id = [];
        if (confirm("Are you sure you want to delete this data?")) {
            $('input[name="id_Records[]"]:checked').each(function() {
                id.push($(this).val());
            });
            if (id.length > 0) {
                $.ajax({
                    url: "{{ route('records.removeall') }}",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    method: "get",
                    data: { id: id },
                    success: function(data) {
                        console.log(data);
                        alert(data);
                        window.location.assign("users");
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                });
            } else {
                alert("Please select at least one checkbox");
            }
        }
    });
   </script>
