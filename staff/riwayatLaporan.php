<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Laporan</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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

        main.content {
            margin-left: 50px;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .btn-primary {
            background-color: #001f54;
            border: none;
        }

        .btn-primary:hover {
            background-color: #003080;
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
            <!-- Sidebar -->
            <div class="sidebar-trigger"></div> <!-- Hover trigger -->
            <div class="sidebar">
                <ul class="nav flex-column">
                    <li><a href="staff.php"><i class="bi bi-house-door me-2"></i>Dashboard</a></li>
                    <li><a href="dataMhs.php"><i class="bi bi-people me-2"></i>Data Mahasiswa</a></li>
                    <li><a href="laporanPelanggaran.php"><i class="bi bi-exclamation-circle me-2"></i>Laporkan Pelanggaran</a></li>
                    <li><a href="riwayatLaporan.php"><i class="bi bi-bar-chart-line me-2"></i>Memantau Pelanggaran</a></li>
                </ul>
            </div>


            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="pt-4">
                    <div class="card shadow-sm">
                        <div class="card-header text-center">
                            <h1 class="display-5 fw-bold mt-3">Riwayat Laporan</h1>
                            <p class="lead">Lihat detail laporan yang telah diinputkan ke sistem.</p>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelapor</th>
                                        <th>Nama Terlapor</th>
                                        <th>Jenis Pelanggaran</th>
                                        <th>Waktu Laporan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data tabel akan dimasukkan di sini -->
                                    <tr>
                                        <td>1</td>
                                        <td>Dosen A</td>
                                        <td>John Doe</td>
                                        <td>Terlambat Masuk Kelas</td>
                                        <td>2024-11-27 10:00</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm">Edit</button>
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Staff B</td>
                                        <td>Jane Smith</td>
                                        <td>Parkir Sembarangan</td>
                                        <td>2024-11-27 09:30</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm">Edit</button>
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
