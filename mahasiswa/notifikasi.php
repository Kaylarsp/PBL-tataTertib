<?php
session_start();
require_once '../connection.php';

// Pastikan sesi `id_user` aktif
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

$id_user = $_SESSION['id_user']; // Ambil ID user dari sesi

// Cek koneksi
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Query untuk mengambil data laporan
$sql = "
    SELECT
        l.id_laporan,
        u.username AS pelaku,
        t.tingkat AS tingkat,
        p.nama_pelanggaran AS pelanggaran,
        l.deskripsi,
        l.bukti_filepath
    FROM laporan AS l
    INNER JOIN tingkat AS t ON l.id_tingkat = t.id_tingkat
    INNER JOIN [user] AS u ON l.id_pelaku = u.id_user
    INNER JOIN pelanggaran AS p ON l.id_pelanggaran = p.id_pelanggaran
    WHERE l.id_pelaku = ?
";

$params = [$id_user];
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Mahasiswa</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="notifikasi.css">
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

    <div class="container my-4">
        <h1 class="text-center mb-4">Notifikasi Pelanggaran</h1>

        <!-- Daftar Notifikasi -->
        <?php if (sqlsrv_has_rows($stmt)): ?>
            <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pelanggaran: <?= htmlspecialchars($row['pelanggaran']) ?></h5>
                        <p class="card-text">Deskripsi: <?= htmlspecialchars($row['deskripsi']) ?></p>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-success btn-sm" onclick="terimaPelanggaran()">Terima</button>
                            <button class="btn btn-danger btn-sm" onclick="ajukanPenolakan(<?= $row['id_laporan'] ?>)">Ajukan Penolakan</button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">Tidak ada notifikasi.</p>
        <?php endif; ?>
    </div>

    <!-- Modal Ajukan Penolakan -->
    <div class="modal fade" id="penolakanModal" tabindex="-1" aria-labelledby="penolakanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="penolakanModalLabel">Ajukan Penolakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="penolakanForm">
                        <input type="hidden" id="notifikasiId">
                        <div class="mb-3">
                            <label for="alasanPenolakan" class="form-label">Alasan Penolakan</label>
                            <textarea class="form-control" id="alasanPenolakan" rows="3" placeholder="Jelaskan alasan penolakan Anda"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="buktiPendukung" class="form-label">Bukti Pendukung (Opsional)</label>
                            <input type="file" class="form-control" id="buktiPendukung">
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Penolakan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function terimaPelanggaran() {
            alert("Pelanggaran telah diterima.");
        }

        function ajukanPenolakan(id) {
            document.getElementById('notifikasiId').value = id;
            const modal = new bootstrap.Modal(document.getElementById('penolakanModal'));
            modal.show();
        }

        // Form pengajuan penolakan
        document.getElementById("penolakanForm").addEventListener("submit", function (e) {
            e.preventDefault();
            const id = document.getElementById('notifikasiId').value;
            const alasan = document.getElementById('alasanPenolakan').value;

            fetch('handle_penolakan.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id_notifikasi=${id}&alasan=${encodeURIComponent(alasan)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Penolakan berhasil diajukan.');
                    location.reload();
                } else {
                    alert('Terjadi kesalahan: ' + data.message);
                }
            });

            const modal = bootstrap.Modal.getInstance(document.getElementById('penolakanModal'));
            modal.hide();
        });
    </script>
</body>

</html>
