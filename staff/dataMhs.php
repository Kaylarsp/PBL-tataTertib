<?php
// Memanggil koneksi database
require_once '../connection.php';

// Query untuk mengambil data mahasiswa
$sql = "
    SELECT m.nama, m.nim, k.nama_kelas, m.status_akademik
    FROM mahasiswa AS m
    INNER JOIN kelas AS k ON m.kelas = k.id_kelas
";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Warna dongker untuk tema */
        .bg-dongker {
            background-color: #001f54 !important;
        }

        .text-dongker {
            color: #001f54 !important;
        }

        .table-dongker thead {
            background-color: #001f54;
            color: white;
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
    <?php include "navbar.php"; ?>

    <!-- Ikon Menu -->
    <div class="menu-icon" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>

    <!-- Layout dengan Bootstrap Grid -->
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

            <!-- Konten Utama -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="pt-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h1 class="h2 mb-0 fw-bold">Data Mahasiswa</h1>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover table-dongker">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIM</th>
                                            <th>Kelas</th>
                                            <th>Status Akademik</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                            echo "<tr>";
                                            echo "<td>" . $no++ . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_kelas']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['status_akademik']) . "</td>";
                                            echo "</tr>";
                                        }

                                        if ($no === 1) {
                                            echo "<tr><td colspan='5' class='text-center'>Tidak ada data mahasiswa</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
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