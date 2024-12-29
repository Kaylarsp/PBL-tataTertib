<?php
session_start();
require_once '../connection.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

$id_user = $_SESSION['id_user'];

$sql = "
    SELECT
        l.id_laporan,
        u.username AS pelaku,
        t.tingkat AS tingkat,
        p.nama_pelanggaran AS pelanggaran,
        l.deskripsi,
        l.sanksi,
        COALESCE(up.statusSanksi, 0) AS status,
        COALESCE(l.verifikasiMhs, 0) AS verifikasi,
        l.statusTolak,
        l.bukti_filepath,
        up.lokasi_file
    FROM laporan AS l
    LEFT JOIN [user] AS u ON l.id_pelaku = u.id_user
    LEFT JOIN tingkat AS t ON l.id_tingkat = t.id_tingkat
    LEFT JOIN pelanggaran AS p ON l.id_pelanggaran = p.id_pelanggaran
    LEFT JOIN upload up ON l.id_laporan = up.id_laporan
    WHERE l.id_pelaku = ?
        AND l.statusTolak = 1";

$params = [$id_user];
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(json_encode(['status' => 'error', 'message' => sqlsrv_errors()]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_laporan = $_POST['id_laporan'] ?? null;
    $verifikasi = $_POST['verifikasi'] ?? null;

    if ($id_laporan && in_array($verifikasi, [1, 2])) {
        $sqlUpdate = "UPDATE laporan SET verifikasiMhs = ? WHERE id_laporan = ?";
        $paramsUpdate = [$verifikasi, $id_laporan];

        $stmtUpdate = sqlsrv_prepare($conn, $sqlUpdate, $paramsUpdate);
        if ($stmtUpdate === false) {
            echo json_encode(['status' => 'error', 'message' => 'Kesalahan saat mempersiapkan query: ' . print_r(sqlsrv_errors(), true)]);
            exit();
        }

        if (sqlsrv_execute($stmtUpdate)) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data: ' . print_r(sqlsrv_errors(), true)]);
        }
    }
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

        /* Gaya untuk setiap kartu agar bisa di-scroll */
        .custom {
            /* max-height: 500px; */
            overflow-y: auto;
        }

        /* Warna utama untuk elemen */
        .bg-dongker {
            background-color: #001f54 !important;
            /* color: white; */
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

        .text-dongker {
            color: #001f54;
        }

        main.content {
            margin-left: 50px;
        }

        /* Kartu Notifikasi */
        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }

        .card-body {
            padding: 20px;
            background-color: #f8f9fa;
        }

        .card-title {
            color: #001f54;
            /* font-weight: bold; */
        }

        .card-text {
            margin-bottom: 15px;
            color: #001f54;
            text-align: justify;
        }

        /* Tombol */
        .btn {
            font-size: 14px;
            border-radius: 5px;
            padding: 8px 12px;
        }

        .btn-success {
            background-color: #198754;
            border-color: #198754;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-success:hover,
        .btn-danger:hover {
            opacity: 0.9;
        }

        /* Modal */
        .modal-header {
            background-color: #001f54;
            color: white;
        }

        .modal-content {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .modal-body {
            padding: 20px;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn-primary {
            background-color: #001f54;
            border-color: #001f54;
        }

        .btn-primary:hover {
            background-color: #003080;
            border-color: #003080;
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
            <div class="card shadow custom" style="margin-top: 50px; width: 90%; margin-left: 50px; height: 550px">
                <div class="text-center mb-3 bg-dongker">
                    <h1 class="display-5 fw-bold mt-4 text-white mb-4">Notifikasi Pelanggaran</h1>
                </div>
                <div class="card-body overflow-auto" style="max-height: 500px; text-align:justify;">
                    <?php if (sqlsrv_has_rows($stmt)): ?>
                        <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>
                            <div class="card shadow mb-3">
                                <div class="card-body">
                                    <h5 class="card-text fs-6">Pelanggaran: <?= htmlspecialchars($row['pelanggaran'] ?? '') ?></h5>
                                    <h5 class="card-text fs-6">Deskripsi: <?= htmlspecialchars($row['deskripsi'] ?? '') ?></h5>
                                    <h5 class="card-text fs-6">Sanksi: <?= htmlspecialchars($row['sanksi'] ?? '') ?></h5>

                                    <?php
                                    $status = $row['status'] ?? 0; // Nilai default jika null
                                    $verifikasi = $row['verifikasi'] ?? 0; // Nilai default jika null
                                    $lokasi_file = $row['lokasi_file'] ?? 0; // Nilai default jika null
                                    ?>

                                    <?php if ($verifikasi === 0): ?>
                                        <button class="btn btn-success btn-sm me-2" onclick="terimaPelanggaran(<?= htmlspecialchars($row['id_laporan']) ?>)">Terima</button>
                                        <button class="btn btn-danger btn-sm" onclick="ajukanPenolakan(<?= htmlspecialchars($row['id_laporan']) ?>)">Ajukan Penolakan</button>
                                    <?php elseif ($verifikasi === 2): ?>
                                        <span class="badge bg-warning">Penolakan Diajukan, Mohon Ditunggu</span>
                                    <?php elseif ($status === 0 && $lokasi_file != 0): ?>
                                        <span class="badge bg-warning">Menunggu Konfirmasi</span>
                                    <?php elseif ($verifikasi === 1 && $status === 0): ?>
                                        <button class="btn btn-primary btn-sm me-2" onclick="uploadSanksi(<?= htmlspecialchars($row['id_laporan']) ?>)">Upload Sanksi</button>
                                    <?php elseif ($status == 1): ?>
                                        <span class="badge bg-success">Telah Dikonfirmasi oleh Admin</span>
                                    <?php elseif ($status == 2): ?>
                                        <span class="badge bg-danger">Sanksi Ditolak</span>
                                        <button class="btn btn-primary btn-sm me-2" onclick="uploadSanksi(<?= htmlspecialchars($row['id_laporan']) ?>)">Upload Sanksi</button>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Status Tidak Dikenal</span>
                                    <?php endif; ?>

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
        function ajukanPenolakan(id) {
            document.getElementById('notifikasiId').value = id; // Set ID laporan
            const modal = new bootstrap.Modal(document.getElementById('penolakanModal'));
            if (confirm("Apakah Anda yakin ingin mengajukan penolakan laporan ini?")) {
                modal.show();
            }
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

        // Fungsi untuk menerima pelanggaran
        function terimaPelanggaran(id) {
            if (confirm("Apakah Anda yakin ingin menerima laporan ini?")) {
                // Lakukan aksi submit (bisa pakai AJAX atau form)
                fetch('', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `id_laporan=${id}&verifikasi=1`
                    })
                    .then(response => response.text()) // Ambil sebagai teks mentah dulu
                    .then(rawData => {
                        console.log('Raw Response:', rawData);
                        const data = JSON.parse(rawData); // Parse setelah cek
                        if (data.status === 'success') {
                            alert('Pelanggaran diterima');
                            location.reload();
                        } else {
                            alert('Terjadi kesalahan: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Parsing Error:', error);
                        alert('Pelanggaran diterima');
                        location.reload();
                    });
            }
        }
    </script>
</body>

</html>