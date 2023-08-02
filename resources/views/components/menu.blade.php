<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <!-- Brand logo or name -->
        <a class="navbar-brand" href="/home">Aplikasi Presensi Magang LEN</a>

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
                    <a class="nav-link" aria-current="page" href="{{ route('home.user')}}">Home</a>
                </li>

                <!-- Isi Kehadiran link -->
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('user.attendance')}}">Isi Kehadiran</a>
                </li>

                <!-- History link -->
                <li class="nav-item">
                    <a class="nav-link" href="{{route('user.attendance.allData')}}">History</a>
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
