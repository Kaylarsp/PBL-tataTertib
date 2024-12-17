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
        }

        .card-header {
            background-color: transparent !important;
            color: #001f54 !important;
            text-align: center;
            border: none;
        }

        .custom-margin-top {
            margin-top: 90px;
        }
    </style>
</head>

<body class="bg-light">

<?php include "navbar.php"; ?>

    <!-- Ikon Menu -->
    <div class="menu-icon" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="sidebar-trigger"></div>
            <?php include "sidebar.php"; ?>

            <main class="col-md-10 ms-sm-auto px-md-4 custom-margin-top">
                <div class="pt-4">
                    <div class="card shadow-sm">
                        <div class="card-header text-center">
                            <h1 class="display-5 fw-bold mt-3">Selamat Datang, Admin!</h1>
                            <p class="lead">Di Portal Akademik Polinema</p>
                        </div>
                        <div class="card-body mt-5">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card text-center shadow-sm content-box">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold">Kelola Pengguna</h5>
                                            <p class="card-text">Lihat dan kelola data pengguna yang terlibat dalam pelanggaran.</p>
                                            <a href="kelolaPengguna.php" class="btn btn-primary">Kelola Pengguna</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-center shadow-sm content-box">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold">Lihat Pelanggaran</h5>
                                            <p class="card-text">Lihat daftar seluruh pelanggaran yang terjadi.</p>
                                            <a href="lihatPelanggaran.php" class="btn btn-primary">Lihat Pelanggaran</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-center shadow-sm content-box">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold">Edit Pelanggaran</h5>
                                            <p class="card-text">Ubah data pelanggaran atau sanksi yang diberikan.</p>
                                            <a href="kelolaPelanggaran.php" class="btn btn-primary">Edit Pelanggaran</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 justify-content-center">
                                    <div class="col-md-4">
                                        <div class="card text-center shadow-sm content-box">
                                            <div class="card-body">
                                                <h5 class="card-title fw-bold">Cek Tugas</h5>
                                                <p class="card-text">Periksa tugas yang dikumpulkan oleh mahasiswa yang melanggar.</p>
                                                <a href="cektugas.php" class="btn btn-primary">Cek Tugas</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card text-center shadow-sm content-box">
                                            <div class="card-body">
                                                <h5 class="card-title fw-bold">Buat Laporan</h5>
                                                <p class="card-text">Buat laporan dari pelanggaran yang sudah terjadi.</p>
                                                <a href="laporan.php" class="btn btn-primary">Buat Laporan</a>
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