<?php
require_once '../connection.php'; // Pastikan koneksi menggunakan `sqlsrv_connect`
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Tugas Mahasiswa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .navbar {
            background-color: #001f54 !important;
        }

        .navbar-brand,
        .nav-link,
        .dropdown-item {
            color: white !important;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #001f54;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 70px;
            color: white;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            display: block;
            padding: 10px 20px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #003080;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .card-header {
            background-color: #001f54;
            color: white;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?php include "navbar.php"; ?>

    <!-- Sidebar -->
    <?php include "sidebar.php"; ?>
    
    <!-- Konten Utama -->
    <main class="content">
        <div class="container">
            <div class="card shadow">
                <div class="card-header">
                    <h1 class="h4 fw-bold">Cek Tugas Mahasiswa</h1>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>#</th>
                                <th>Nama File</th>
                                <th>Lokasi File</th>
                                <th>Waktu Upload</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT id_upload, nama_file, lokasi_file, waktu FROM upload";
                            $stmt = sqlsrv_query($conn, $sql);

                            if ($stmt === false) {
                                die(print_r(sqlsrv_errors(), true));
                            }

                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . $row['id_upload'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_file']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['lokasi_file']) . "</td>";
                                echo "<td>" . ($row['waktu'] ? $row['waktu']->format('Y-m-d H:i:s') : '-') . "</td>";
                                echo '<td>
                                        <a href="' . htmlspecialchars($row['lokasi_file']) . '" class="btn btn-sm btn-success" download>
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                        <button class="btn btn-sm btn-primary" onclick="verifikasiTugas(' . $row['id_upload'] . ')">
                                            <i class="bi bi-check-circle"></i> Verifikasi
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="tolakTugas(' . $row['id_upload'] . ')">
                                            <i class="bi bi-x-circle"></i> Tolak
                                        </button>
                                      </td>';
                                echo "</tr>";
                            }

                            sqlsrv_free_stmt($stmt);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function verifikasiTugas(id) {
            if (confirm("Apakah Anda yakin ingin memverifikasi tugas ini?")) {
                alert("Tugas dengan ID " + id + " berhasil diverifikasi.");
            }
        }

        function tolakTugas(id) {
            if (confirm("Apakah Anda yakin ingin menolak tugas ini?")) {
                alert("Tugas dengan ID " + id + " ditolak.");
            }
        }
    </script>
</body>

</html>
