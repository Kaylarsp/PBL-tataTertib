<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Mahasiswa</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link ke CSS eksternal -->
    <link rel="stylesheet" href="mahasiswa.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body class="bg-light">
    <!-- Navbar di bagian atas -->
    <?php include "navbar.php"; ?>

    <!-- Sidebar -->
    <div class="menu-icon" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>

    <?php include "sidebar.php"; ?>

            <main class="col-md-10 ms-sm-auto px-md-4" style="margin-top: 70px;">
                <div class="pt-4">
                    <div class="card shadow-sm">
                        <div class="card-header text-center">
                            <h1 class="display-5 fw-bold mt-3">Selamat Datang, Mahasiswa!</h1>
                            <p class="lead">Di Portal Akademik Polinema</p>
                            <a href="#" class="btn bg-dongker text-white">Explore Now</a>
                        </div>
                        <div class="card-body">
                            <section class="row justify-content-center mt-4">
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card shadow">
                                        <div class="card-body text-center">
                                            <h5 class="card-title fw-bold">List Tata Tertib</h5>
                                            <p class="card-text">Lihat aturan yang berlaku di lingkungan kampus.</p>
                                            <a href="listTatib.php" class="btn bg-dongker text-white">Lihat Tata Tertib</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card shadow">
                                        <div class="card-body text-center">
                                            <h5 class="card-title fw-bold">Notifikasi</h5>
                                            <p class="card-text">Lihat pemberitahuan terbaru untuk Anda.</p>
                                            <a href="notifikasi.php" class="btn bg-dongker text-white">Lihat Notifikasi</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card shadow">
                                        <div class="card-body text-center">
                                            <h5 class="card-title fw-bold">Upload Sanksi</h5>
                                            <p class="card-text">Upload bukti pelanggaran atau sanksi.</p>
                                            <a href="uploadSanksi.php" class="btn bg-dongker text-white">Upload Sanksi</a>
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
