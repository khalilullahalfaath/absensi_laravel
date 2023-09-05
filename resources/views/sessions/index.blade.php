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
    <div class="container d-flex align-items-center" style="height: 100vh">
        <div class="w-560 center border rounded px-3 py-3 mx-auto" style="background-color: rgba(255, 255, 255, 0.85);">
            <h1>Login</h1>
            <p>Khusus untuk Peserta PKL, Kerja Praktek, dan TA di Lingkungan PT. Len Industri (Persero)</p>
            <form action="/sessions/login" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" id="email" class="form-label">Email</label>
                    <input type="email" value="{{ Session::get('email')}}" name="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control">
                        <div class="input-group-append">
                            <button type="button" id="togglePassword" class="btn btn-outline-secondary"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                </div>
                <div class="mb-3 d-grid">
                    <button name="submit" type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
            <div class="mt-3 text-center">
                <p>Don't have an account? <a href="/sessions/register">Register here</a></p>
            </div>

            <div class="mt-3 text-center">
                <p>Not verified yet? <a href="{{route('user.reverifyEmail')}}">Click here</a></p>
            </div>

            <div class="mt-3 text-center">
                <p>Forgot your password? <a href="{{route('forget.password.get')}}">Reset here</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            // Function to toggle password visibility
            $('#togglePassword').click(function () {
                var passwordInput = $('#password');
                var type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                passwordInput.attr('type', type);
                $(this).find('i').toggleClass('bi-eye bi-eye-slash');
            });
        });
    </script>
</body>
@endsection
