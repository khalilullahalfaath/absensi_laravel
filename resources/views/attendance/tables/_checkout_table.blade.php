<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Tanggal Presensi</th>
                <th>Jam Keluar</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($checkOutRecords as $checkOutRecord)
            <tr>
                <td>{{ $checkOutRecord->tanggal_presensi }}</td>
                <td>{{ $checkOutRecord->jam_keluar }}</td>
                <td class="text-center">
                    <a href="{{ route('print.checkout.csv', ['id' => $checkOutRecord->id]) }}" class="btn btn-sm btn-primary">Print to CSV</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3 d-flex justify-content-center">
    <a href="{{ route('print.allcheckout.csv') }}" class="btn btn-primary">Print All Check-in to CSV</a>
</div>

