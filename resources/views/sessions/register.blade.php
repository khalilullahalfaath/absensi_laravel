@extends('layout/app')

@section('content')
<body style="background-image: url('https://swamediainc.storage.googleapis.com/swa.co.id/wp-content/uploads/2018/10/23174621/Len-Industri_OCC-LRT-Sumatera-Selatan.jpg'); background-size: cover;">
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" style="background-color: rgba(255, 255, 255, 0.85)";>
                <div class="card-header">
                    <h4 class="text-center">Registrasi Akun Presensi</h4>
                </div>
                <div class="card-body">
                    <form action="/sessions/create" method="POST">
                        @csrf
                        {{-- TODO: add confirmed password --}}
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{Session::get('email')}}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" value="{{Session::get('password')}}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{Session::get('nama')}}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="no_presensi">No presensi</label>
                            <input type="text" name="no_presensi" class="form-control" value="{{Session::get('no_presensi')}}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="nama_unit_kerja">Nama Unit Kerja</label>
                            <input type="text" name="nama_unit_kerja" class="form-control" value="{{Session::get('nama_unit_kerja')}}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="asal_instansi">Asal Instansi</label>
                            <input type="text" name="asal_instansi" class="form-control" value="{{Session::get('asal_instansi')}}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="">Pilih jenis kelamin</option>
                                <option value="Male" {{ Session::get('jenis_kelamin') === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Female" {{ Session::get('jenis_kelamin') === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ Session::get('tanggal_lahir') }}" required>
                        </div>
                        <div class="text-center mt-3">
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