<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <!-- Brand logo or name -->
        <p>Dashboard Aplikasi Presensi Magang LEN</p>

        <!-- Navbar toggler button for small screens -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <!-- Home link -->
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('home.admin')}}">Home</a>
                </li>

                {{-- Matikan Permission Location --}}
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('location.index')}}">Lokasi</a>
                </li>

                {{-- Tambah peserta --}}
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('peserta.index')}}">Peserta</a>
                </li>

                <!-- Data Siswa link -->
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('admin.users')}}">Data Siswa</a>
                </li>

                <!-- Data kehadiran link -->
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.attendance')}}">Data kehadiran</a>
                </li>

                <!-- Logout link -->
                <li class="nav-item">
                    <form action="/sessions/logout" method="POST">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link" style="text-decoration: none;">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
