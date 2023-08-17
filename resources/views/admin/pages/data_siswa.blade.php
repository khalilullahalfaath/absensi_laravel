@extends('layout.app')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
<div class="container mt-5">
    <!-- Display Check-in Records -->
    <h4>Students Records</h4>
    @include('admin.pages._siswa_table')
</div>
@endsection

<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

<script>



// JavaScript to handle the edit modal
$(document).ready(function () {
    // Click event for the edit button
    $(".edit-btn").on("click", function () {
        var userId = $(this).data("userid");
        var editUrl = "{{ route('admin.users.update', ':id') }}".replace(':id', userId);
        console.log(editUrl);
        
        // Retrieve user record data from the row and populate the edit modal form fields
        var fields = ['nama', 'email', 'no_presensi', 'asal_instansi', 'nama_unit_kerja', 'jenis_kelamin', 'tanggal_lahir'];

        fields.forEach(function (field) {
            var value = $("#user_" + userId + " td[data-field='" + field + "']").text().trim();
            if (field === 'tanggal_lahir') {
                // Assuming the date format in the database is 'YYYY-MM-DD 00:00:00'
                var tanggal_lahir_db = $("#user_" + userId + " td[data-field='tanggal_lahir']").text().trim();
                var tanggal_lahir_only = tanggal_lahir_db.substring(0, 10); // Extract only the date part 'YYYY-MM-DD'
                value = tanggal_lahir_only;
            }
            $("#edit_" + field).val(value);
        });

        // Set the form action to the edit URL
        $("#editUserForm").attr("action", editUrl);

        // Show the edit modal
        $("#editUserModal").modal("show");
    });

    // Click event for the "Save Changes" button in the edit modal
    $("#saveChangesBtn").on("click", function () {
        // Submit the edit form when "Save Changes" is clicked
        $("#editUserForm").submit();
    });

    // Click event for the "Close" button in the edit modal
    $("#editUserModal").on("hidden.bs.modal", function () {
        // Clear form data when modal is closed
        $("#editUserForm")[0].reset();
    });


});

function confirmDelete(deleteUrl) {
    if (confirm('Apakah Anda Yakin Menghapus Data?')) {
        window.location.href = deleteUrl;
    }
}

</script>
