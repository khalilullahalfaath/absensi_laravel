<!-- Check-in table -->
<h5>Check-in Records</h5>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id User</th>
                <th>Tanggal Presensi</th>
                <th>Jam Masuk</th>
                <th>Actions</th> 
            </tr>
        </thead>
        <tbody>
            @foreach ($checkInRecords as $checkInRecord)
                <tr>
                    {{-- show some data relevant to checkin such as id_user which is a foreign key to users table --}}
                    <td>{{ optional($checkInRecord->user)->id ?? 'N/A' }}</td>
                    <td>{{ $checkInRecord->tanggal_presensi }}</td>
                    <td>{{ $checkInRecord->jam_masuk }}</td>
                    <td>
                        <!-- Delete button -->
                        <button class="btn btn-danger delete-btn" onclick="confirmDelete('{{ route('admin.checkin.destroy', $checkInRecord->id) }}')">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Check-out table -->
<h5>Check-out Records</h5>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tanggal Presensi</th>
                <th>Jam Keluar</th>
                <th>Actions</th> 
            </tr>
        </thead>
        <tbody>
            @foreach ($checkOutRecords as $checkOutRecord)
                <tr>
                    <td>{{ $checkOutRecord->tanggal_presensi }}</td>
                    <td>{{ $checkOutRecord->jam_keluar }}</td>
                    <td>
                        <!-- Delete button -->
                        <button class="btn btn-danger delete-btn" onclick="confirmDelete('{{ route('admin.checkout.destroy', $checkOutRecord->id) }}')">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Records table -->
<h5>Records</h5>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tanggal Presensi</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Jam Kerja</th>
                <th>Actions</th> 
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
                <tr>
                    <td>{{ $record->absensiCheckIn->tanggal_presensi }}</td>
                    <td>{{ $record->absensiCheckIn->jam_masuk }}</td>
                    <td>{{ $record->absensiCheckOut->jam_keluar }}</td>
                    <td>{{ $record->jam_kerja }}</td>
                    <td>
                        <!-- Delete button -->
                        <button class="btn btn-danger delete-btn" onclick="confirmDelete('{{ route('admin.record.destroy', $record->id) }}')">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
