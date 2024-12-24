<?php
session_start();
require_once '../connection.php'; // Pastikan koneksi menggunakan `sqlsrv_connect`

// Pastikan sesi `id_user` aktif
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

$id_user = $_SESSION['id_user']; // Ambil ID user dari sesi

// Query untuk mengambil data laporan
$sql = "
    SELECT
        l.id_laporan,
        u.username AS pelaku,
        t.tingkat AS tingkat,
        p.nama_pelanggaran AS pelanggaran,
        l.deskripsi,
        l.sanksi,
        l.bukti_filepath
    FROM laporan AS l
    INNER JOIN tingkat AS t ON l.id_tingkat = t.id_tingkat
    INNER JOIN [user] AS u ON l.id_pelaku = u.id_user
    INNER JOIN pelanggaran AS p ON l.id_pelanggaran = p.id_pelanggaran
    WHERE l.id_pelaku = ?
    AND l.sanksi IS NOT NULL
";

$params = [$id_user];
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(json_encode(['status' => 'error', 'message' => sqlsrv_errors()]));
}

// Proses pengiriman data (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_laporan = $_POST['id_laporan'] ?? null;
    $verifikasi = $_POST['verifikasi'] ?? null;
    $alasan = $_POST['alasan'] ?? null;
    $file = $_FILES['buktiPendukung'] ?? null;

    // Validasi input
    if ($id_laporan && in_array($verifikasi, [1, 2])) {
        $sqlUpdate = "UPDATE laporan SET verifikasiMhs = ?, alasanMhsNolak = ? WHERE id_laporan = ?";
        $paramsUpdate = [$verifikasi, $verifikasi == 2 ? $alasan : null, $id_laporan];

        $stmtUpdate = sqlsrv_query($conn, $sqlUpdate, $paramsUpdate);
        if ($stmtUpdate) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Parameter tidak valid']);
    }
    exit();
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

    <style>
        /* Gaya untuk tombol kembali ke halaman sebelumnya */
        .btn-back-to-previous {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #001f54;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 100;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-back-to-previous:hover {
            background-color: #003080;
        }
    </style>
</head>

<body class="bg-light overflow-hidden">
    <!-- Navbar di bagian atas -->
    <?php include "navbar.php"; ?>

    <!-- Sidebar -->
    <div class="menu-icon" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>

    <?php include "sidebar.php"; ?>

    <div class="container my-4">
        <!-- Daftar Notifikasi -->
        <div class="d-flex align-items-center justify-content-center">
            <div class="card shadow" style="margin-top: 50px; width: 90%; margin-left: 50px;">
                <div class="text-center mb-4">
                    <h1 class="display-5 fw-bold mt-4" style="color: #001f54;">Notifikasi Pelanggaran</h1>
                </div>
                <div class="card-body overflow-auto" style="max-height: 350px; text-align:justify;">
                    <?php if (sqlsrv_has_rows($stmt)): ?>
                        <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>
                            <div class="card shadow mb-3">
                                <div class="card-body">
                                    <h5 class="card-text fs-6">Pelanggaran: <?= htmlspecialchars($row['pelanggaran']) ?></h5>
                                    <h5 class="card-text fs-6">Deskripsi: <?= htmlspecialchars($row['deskripsi']) ?></h5>
                                    <h5 class="card-text fs-6">Sanksi: <?= htmlspecialchars($row['sanksi']) ?></h5>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <button class="btn btn-success btn-sm me-2" onclick="terimaPelanggaran(<?= $row['id_laporan'] ?>)">Terima</button>
                                            <button class="btn btn-danger btn-sm me-2" onclick="ajukanPenolakan(<?= $row['id_laporan'] ?>)">Ajukan Penolakan</button>
                                        </div>
                                        <button class="btn btn-upload btn-sm bg-dongker text-white" onclick="uploadSanksi(<?= $row['id_laporan'] ?>)">Upload Sanksi</button>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-center">Tidak ada notifikasi.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
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
                            <textarea class="form-control" id="alasanPenolakan" rows="3" placeholder="Jelaskan alasan penolakan Anda" required></textarea>
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

    <!-- Modal utk upload sanksi -->
    <div class="modal fade mt-5" id="uploadSanksiModal" tabindex="-1" aria-labelledby="uploadSanksiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadSanksiModalLabel">Upload Sanksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadForm" enctype="multipart/form-data">
                        <input type="hidden" id="uploadIdLaporan" name="id_laporan">
                        <div class="mb-3">
                            <label for="sanksiFile" class="form-label">File Sanksi</label>
                            <input type="file" class="form-control" id="sanksiFile" name="sanksiFile" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Kembali ke Halaman Sebelumnya -->
    <a href="mahasiswa.php" class="btn-back-to-previous">
        <i class="bi bi-arrow-left"></i>
    </a>

    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function terimaPelanggaran(id) {
            fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id_laporan=${id}&verifikasi=1`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Pelanggaran diterima');
                        location.reload();
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);
                    }
                });
        }

        function ajukanPenolakan(id) {
            document.getElementById('notifikasiId').value = id; // Set ID laporan
            const modal = new bootstrap.Modal(document.getElementById('penolakanModal'));
            modal.show();
        }

        document.getElementById('penolakanForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('notifikasiId').value;
            const alasan = document.getElementById('alasanPenolakan').value;

            fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id_laporan=${id}&verifikasi=2&alasan=${encodeURIComponent(alasan)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Penolakan berhasil diajukan');
                        location.reload();
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);
                    }
                });

            const modal = bootstrap.Modal.getInstance(document.getElementById('penolakanModal'));
            modal.hide();
        });

        function uploadSanksi(id) {
            document.getElementById('uploadIdLaporan').value = id;
            const modal = new bootstrap.Modal(document.getElementById('uploadSanksiModal'));
            modal.show();
        }

        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('uploadSanksi.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Sanksi berhasil diupload');
                        location.reload();
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);
                    }
                });

            const modal = bootstrap.Modal.getInstance(document.getElementById('uploadSanksiModal'));
            modal.hide();
        });
    </script>
</body>

</html>