<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-dongker {
            background-color: #001f54 !important;
        }

        .card-option {
            cursor: pointer;
            transition: transform 0.3s;
        }

        .card-option:hover {
            transform: scale(1.05);
        }

        .btn-primary {
            background-color: #001f54;
            border: none;
        }

        .btn-primary:hover {
            background-color: #003080;
        }

        .cardContent {
            margin-left: 70px;
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

        .full-height {
            height: 100vh;
        }

        .text-dongker {
            color: #001f54;
        }
    </style>
</head>

<body class="bg-light">

<?php include "navbar.php"; ?>

    <!-- Ikon Menu -->
    <div class="menu-icon" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>

    <div class="sidebar-trigger"></div>
    <?php include "sidebar.php"; ?>

    <!-- Konten Utama -->
    <div class="d-flex align-items-center justify-content-center full-height">
        <div class="card cardContent shadow p-4" style="width: 100%; max-width: 850px;">
            <div class="text-center mb-4">
                <h1 class="display-5 fw-bold text-dongker">Kelola Pengguna</h1>
                <p class="lead">Pilih jenis pengguna yang ingin dikelola.</p>
            </div>

            <div class="row  d-flex justify-content-center">
                <div class="col-md-4 mb-4 ">
                    <div class="d-flex justify-content-center">

                        <div class="card card-option shadow" onclick="location.href='kelolaStaff.php'">
                            <div class="card-body text-center">
                                <i class="bi bi-briefcase-fill display-4 text-primary mb-3"></i>
                                <h5 class="card-title fw-bold">Staff</h5>
                                <p class="card-text">Kelola data pengguna yang berperan sebagai staff.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 ">
                    <div class="d-flex justify-content-center">

                        <div class="card card-option shadow" onclick="location.href='kelolaDosen.php'">
                            <div class="card-body text-center">
                                <i class="bi bi-person-workspace display-4 text-success mb-3"></i>
                                <h5 class="card-title fw-bold">Dosen</h5>
                                <p class="card-text">Kelola data pengguna yang berperan sebagai dosen.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 ">
                    <div class="d-flex justify-content-center">

                        <div class="card card-option shadow" onclick="location.href='kelolaMahasiswa.php'">
                            <div class="card-body text-center">
                                <i class="bi bi-people-fill display-4 text-warning mb-3"></i>
                                <h5 class="card-title fw-bold">Mahasiswa</h5>
                                <p class="card-text">Kelola data pengguna yang berperan sebagai mahasiswa.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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