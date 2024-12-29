<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        .bg-dongker {
            background: rgb(14, 11, 38);
            background: linear-gradient(125deg, rgba(14, 11, 38, 1) 0%, rgba(0, 31, 84, 1) 50%, rgba(79, 103, 143, 1) 99%);
            border: rgb(14, 11, 38);
        }

        .menu-icon {
            position: fixed;
            top: 50px;
            left: 5px;
            /* background-color: #001f54; */
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

        main.content {
            margin-left: 50px;
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
            margin-top: 120px;
        }
    </style>
</head>

<body class="bg-light">
    <!-- Navbar di bagian atas -->
    <?php include "navbar.php"; ?>

    <!-- Sidebar -->
    <div class="menu-icon" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>

    <?php include "sidebar.php"; ?>

    <main class="col-md-10 ms-sm-auto px-md-4 custom-margin-top">
        <div class="pt-4">
            <div class="card shadow" style="margin-right: 120px; margin-left:-30px">
                <div class="card-header text-center">
                    <h1 class="display-5 fw-bold mt-3">Selamat Datang, Mahasiswa!</h1>
                    <p class="lead">Di Portal Akademik Polinema</p>
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