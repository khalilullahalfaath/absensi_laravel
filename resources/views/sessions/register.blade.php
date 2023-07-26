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
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="work_unit">Work Unit</label>
                            <input type="text" name="work_unit" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="agency_origin">Agency Origin</label>
                            <input type="text" name="agency_origin" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select name="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
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
    
</body>
@endsection