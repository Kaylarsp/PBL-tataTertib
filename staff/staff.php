<?php
session_start();

// Cek apakah session sudah ada dan apakah role adalah staff
// if (!isset($_SESSION['username']) || $_SESSION['role'] !== 1002) {
//     header("Location: ../login/login.php");
// }
//
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Staff</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-dongker {
            background-color: #001f54 !important;
        }

        /* Sidebar styling */
        .sidebar {
            width: 200px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: -150px;
            /* Hide sidebar initially */
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

        /* Sidebar muncul saat hover */
        .sidebar:hover {
            left: 0;
        }

        /* Ikon menu tetap terlihat */
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

        /* Navbar z-index untuk menghindari ketumpukan */
        .navbar {
            z-index: 11;
            position: relative;
        }

        /* Konten utama */
        main.content {
            margin-left: 50px;
            /* Leave space for sidebar trigger */
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
            <a class="navbar-brand" href="staff.php">
                <i class="bi bi-mortarboard-fill me-2"></i>Polinema
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="staff.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Jadwal</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Bantuan</a></li>
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
            <!-- Sidebar di bagian kiri -->
            <div class="sidebar-trigger"></div> <!-- Hover trigger -->
            <div class="sidebar">
                <ul class="nav flex-column">
                    <li><a href="staff.php"><i class="bi bi-house-door me-2"></i>Dashboard</a></li>
                    <li><a href="dataMhs.php"><i class="bi bi-people me-2"></i>Data Mahasiswa</a></li>
                    <li><a href="laporanPelanggaran.php"><i class="bi bi-exclamation-circle me-2"></i>Laporkan Pelanggaran</a></li>
                    <li><a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                </ul>
            </div>

            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="pt-4">
                    <div class="card shadow-sm">
                        <div class="card-header text-center">
                            <h1 class="display-5 fw-bold mt-3">Selamat Datang, Staff!</h1>
                            <p class="lead">Di Portal Akademik Polinema</p>
                            <a href="#" class="btn bg-dongker text-white">Explore Now</a>
                        </div>
                        <div class="card-body">
                            <section class="row justify-content-center mt-4">
                                <!-- Card for Data Mahasiswa -->
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card shadow">
                                        <div class="card-body text-center">
                                            <h5 class="card-title fw-bold">Data Mahasiswa</h5>
                                            <p class="card-text">Kelola informasi dan perkembangan mahasiswa di sini.</p>
                                            <a href="dataMhs.php" class="btn bg-dongker text-white">Lihat Data</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card for Pelanggaran -->
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card shadow">
                                        <div class="card-body text-center">
                                            <h5 class="card-title fw-bold">Laporkan Pelanggaran</h5>
                                            <p class="card-text">Laporkan pelanggaran yang terjadi.</p>
                                            <a href="laporanPelanggaran.php" class="btn bg-dongker text-white">Laporkan Pelanggaran</a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Link Bootstrap JS dan Icon -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.style.left = sidebar.style.left === '0px' ? '-150px' : '0px';
        }
    </script>
</body>

</html>