<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Dosen</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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

        /* Konten utama */
        main.content {
            margin-left: 50px;
            /* Leave space for sidebar trigger */
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
    <!-- Navbar di bagian atas -->
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
                            <h1 class="display-5 fw-bold mt-3">Selamat Datang, Dosen!</h1>
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