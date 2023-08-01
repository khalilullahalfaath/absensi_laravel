<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <!-- Brand logo or name -->
        <a class="navbar-brand" href="/home/admin">Dashboard Aplikasi Presensi Magang LEN</a>

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
                    <a class="nav-link" aria-current="page" href="/home/admin">Home</a>
                </li>

                <!-- Data Siswa link -->
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/admin/users">Data Siswa</a>
                </li>

                <!-- Data kehadiran link -->
                <li class="nav-item">
                    <a class="nav-link" href="/admin/attendance">Data kehadiran</a>
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
