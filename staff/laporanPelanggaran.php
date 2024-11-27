<?php
// Memanggil koneksi database
require_once '../connection.php';

// Query untuk mengambil nama pelanggaran
$sql = "SELECT * FROM pelanggaran";
$stmt = sqlsrv_query($conn, $sql);

// Query untuk mengambil data kelas
$sql_kelas = "SELECT * FROM kelas";
$stmt_kelas = sqlsrv_query($conn, $sql_kelas);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pelanggaran</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-dongker navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dosen.php">
                <i class="bi bi-mortarboard-fill me-2"></i>Polinema
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dosen.php">Home</a></li>
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

    <!-- Layout dengan Bootstrap Grid -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="sidebar-trigger"></div> <!-- Hover trigger -->
            <div class="sidebar">
                <ul class="nav flex-column">
                    <li><a href="dosen.php"><i class="bi bi-house-door me-2"></i>Dashboard</a></li>
                    <li><a href="dataMhs.php"><i class="bi bi-people me-2"></i>Data Mahasiswa</a></li>
                    <li><a href="laporanPelanggaran.php"><i class="bi bi-exclamation-circle me-2"></i>Laporkan Pelanggaran</a></li>
                    <li><a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                </ul>
            </div>

            <!-- Konten Utama -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="pt-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h1 class="h2 mb-0 fw-bold">Laporan Pelanggaran</h1>
                        </div>
                        <div class="card-body">
                            <!-- Form untuk membuat laporan pelanggaran baru -->
                            <form action="prosesLaporan.php" method="POST">
                                <div class="mb-3">
                                    <label for="nama_pelaku" class="form-label">Nama Pelaku</label>
                                    <input type="text" class="form-control" id="nama_pelaku" name="nama_pelaku" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kelas" class="form-label">Kelas</label>
                                    <select class="form-select" id="kelas" name="kelas" required>
                                        <option value="">Pilih Kelas</option>
                                        <?php
                                        while ($row = sqlsrv_fetch_array($stmt_kelas, SQLSRV_FETCH_ASSOC)) {
                                            echo "<option value='" . $row['id_kelas'] . "'>" . htmlspecialchars($row['nama_kelas']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="pelanggaran" class="form-label">Jenis Pelanggaran</label>
                                    <select class="form-select" id="pelanggaran" name="pelanggaran" required>
                                        <option value="">Pilih Jenis Pelanggaran</option>
                                        <?php
                                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                            echo "<option value='" . $row['id_pelanggaran'] . "'>" . htmlspecialchars($row['nama_pelanggaran']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Pelanggaran</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn bg-dongker text-white">Kirim Laporan</button>
                            </form>
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
        // Mengirimkan form dengan AJAX
        $('#laporanForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman form normal

            $.ajax({
                url: 'prosesLaporan.php', // URL untuk mengirimkan data
                type: 'POST',
                data: $(this).serialize(), // Mengirim data form
                success: function(response) {
                    $('#responseMessage').html('<div class="alert alert-success">Laporan berhasil dikirim!</div>');
                    $('#laporanForm')[0].reset(); // Mereset form setelah sukses
                },
                error: function() {
                    $('#responseMessage').html('<div class="alert alert-danger">Gagal mengirim laporan. Coba lagi.</div>');
                }
            });
        });
    </script>
</body>

</html>