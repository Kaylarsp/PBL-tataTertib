<?php
// Koneksi ke database
$serverName = "LAPTOP-2R5AJL0O"; // Ganti dengan nama server Anda
$connectionOptions = [
    "Database" => "tatib", // Nama database Anda
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

// Periksa koneksi
if ($conn === false) {
    die("Koneksi ke database gagal: " . print_r(sqlsrv_errors(), true));
}

// Query untuk mengambil data dari tabel dbo.pelanggaran
$sql = "SELECT id_pelanggaran, nama_pelanggaran, tingkat FROM dbo.pelanggaran";
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
<div class="sidebar">
    <ul class="nav flex-column">
        <li><a href="listTatib.php"><i class="bi bi-list-check me-2"></i>List Tata Tertib</a></li>
        <li><a href="notifikasi.php"><i class="bi bi-bell me-2"></i>Notifikasi</a></li>
        <li><a href="uploadSanksi.php"><i class="bi bi-cloud-upload me-2"></i>Upload Sanksi</a></li>
        <li><a href="../login/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
    </ul>
</div>

    <!-- Konten -->
    <div class="container mt-5">
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
                            <span class="badge bg-primary rounded-pill">Tingkat: <?= htmlspecialchars($row['tingkat']); ?></span>
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

<?php
// Tutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
