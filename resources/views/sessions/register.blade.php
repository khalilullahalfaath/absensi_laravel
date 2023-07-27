@extends('layout/app')

@section('content')
<body style="background-image: url('https://swamediainc.storage.googleapis.com/swa.co.id/wp-content/uploads/2018/10/23174621/Len-Industri_OCC-LRT-Sumatera-Selatan.jpg'); background-size: cover;">
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" style="background-color: rgba(255, 255, 255, 0.85)";>
                <div class="card-header">
                    <h4 class="text-center">Registrasi Akun Presensi</h4>
                </div>
                <div class="card-body">
                    <form action="/register" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="work_unit">Unit Kerja</label>
                            <input type="text" name="work_unit" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="agency_origin">Asal Institusi</label>
                            <input type="text" name="agency_origin" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="sex">Jenis Kelamin</label>
                            <select name="sex" class="form-control" required>
                                <option value="">Pilih jenis kelamin</option>
                                <option value="Male">Laki-laki</option>
                                <option value="Female">Perempuan</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                    <div class="mt-3 text-center">
                        <p>Already have an account? <a href="/sessions">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Jquery --}}
 <!-- Add jQuery -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

 <!-- Add custom JavaScript -->
    <!-- Add custom JavaScript -->
    <script>
        $(document).ready(function () {
            // Find all input elements with the "required" attribute
            $('input[required], select[required]').each(function () {
                // Get the associated label element
                var label = $("label[for='" + $(this).attr('name') + "']");
                // Add "(required)" text to the label
                label.append(' <span class="required-text">(required)</span>');
            });
        });
    </script>
</body>
@endsection