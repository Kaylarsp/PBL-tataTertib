<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Admin</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .bg-dongker {
            background-color: #001f54 !important;
        }

        .sidebar {
            width: 200px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: -150px;
            background-color: #001f54;
            color: white;
            transition: all 0.3s ease;
            overflow-y: auto;
            z-index: 10;
            padding-top: 90px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }

        .sidebar:hover {
            left: 0;
        }

        .menu-icon {
            position: fixed;
            top: 50px;
            left: 5px;
            background-color: #001f54;
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 20;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .menu-icon:hover {
            background-color: #003080;
        }

        .navbar {
            z-index: 11;
            position: relative;
        }

        .content-box {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #001f54;
            border: none;
        }

        .btn-primary:hover {
            background-color: #003080;
        }

        .card {
            margin-right: 40px;
            margin-top: 30px;
        }

        .card-header {
            background-color: transparent !important;
            color: #001f54 !important;
            text-align: center;
            border: none;
        }
    </style>
</head>

<body class="bg-light">
    <!-- Navbar di bagian atas -->
    <nav class="navbar navbar-expand-lg bg-dongker navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin.php">
                <i class="bi bi-mortarboard-fill me-2"></i>Polinema
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="admin.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Bantuan</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Ikon Menu -->
    <div class="menu-icon" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="sidebar-trigger"></div>
            <div class="sidebar">
                <ul class="nav flex-column">
                    <li><a href="admin.php"><i class="bi bi-house-door me-2"></i>Dashboard</a></li>
                    <li><a href="manajemenPelanggaran.php"><i class="bi bi-person-lines-fill me-2"></i>Manajemen Pengguna</a></li>
                    <li><a href="laporan.php"><i class="bi bi-file-earmark-text me-2"></i>Laporan</a></li>
                    <li><a href="pengaturan.php"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                    <li><a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                </ul>
            </div>

            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="pt-4">
                    <div class="card shadow-sm">
                        <div class="card-header text-center">
                            <h1 class="display-5 fw-bold mt-3">Selamat Datang, Admin!</h1>
                            <p class="lead">Di Portal Akademik Polinema</p>
                            <a href="#" class="btn bg-dongker text-white">Explore Now</a>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card text-center shadow-sm content-box">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold">Kelola Pengguna</h5>
                                            <p class="card-text">Lihat dan kelola data pengguna yang terlibat dalam pelanggaran.</p>
                                            <a href="kelolaPengguna.html" class="btn btn-primary">Kelola Pengguna</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-center shadow-sm content-box">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold">Transaksi Pelanggaran</h5>
                                            <p class="card-text">Lihat daftar seluruh pelanggaran yang terjadi.</p>
                                            <a href="transaksiPelanggaran.html" class="btn btn-primary">Lihat Pelanggaran</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-center shadow-sm content-box">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold">Edit Pelanggaran</h5>
                                            <p class="card-text">Ubah data pelanggaran atau sanksi yang diberikan.</p>
                                            <a href="editPelanggaran.html" class="btn btn-primary">Edit Pelanggaran</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 justify-content-center">
                                    <div class="col-md-4">
                                        <div class="card text-center shadow-sm content-box">
                                            <div class="card-body">
                                                <h5 class="card-title fw-bold">Cek Tugas</h5>
                                                <p class="card-text">Periksa tugas yang dikumpulkan oleh mahasiswa yang melanggar.</p>
                                                <a href="cek_tugas.html" class="btn btn-primary">Cek Tugas</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card text-center shadow-sm content-box">
                                            <div class="card-body">
                                                <h5 class="card-title fw-bold">Buat Laporan</h5>
                                                <p class="card-text">Buat laporan dari pelanggaran yang sudah terjadi.</p>
                                                <a href="buat_laporan.html" class="btn btn-primary">Buat Laporan</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.style.left = sidebar.style.left === '0px' ? '-150px' : '0px';
        }
    </script>
</body>

</html>