<?php
// Koneksi ke database
require_once '../connection.php';

// Periksa koneksi
if ($conn === false) {
    die("Koneksi ke database gagal: " . print_r(sqlsrv_errors(), true));
}

// Query untuk mengambil data dari tabel pelanggaran
$sql = "SELECT id_pelanggaran, nama_pelanggaran, id_tingkat FROM pelanggaran";
$stmt = sqlsrv_query($conn, $sql);

// Periksa apakah query berhasil
if ($stmt === false) {
    die("Query gagal: " . print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tata Tertib Universitas</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link ke CSS eksternal -->
    <link rel="stylesheet" href="listTatib.css">
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

    <!-- Konten -->
    <div class="container" style="margin-top: 90px; margin-left: 170px;">
        <div class="card shadow">
            <div class="card-header text-center bg-dongker text-white">
                <h2 class="fw-bold">Tata Tertib Polinema</h2>
                <p class="mb-0">daftar pelanggaran yang tidak boleh dilakukan mahasiswa</p>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <?= htmlspecialchars($row['nama_pelanggaran']); ?>
                            </span>
                            <span class="badge bg-primary rounded-pill">Tingkat: <?= htmlspecialchars($row['id_tingkat']); ?></span>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
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