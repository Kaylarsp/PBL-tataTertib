<?php
session_start();
require_once '../connection.php';

// Pastikan sesi `id_user` aktif
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

$id_user = $_SESSION['id_user']; // Ambil ID user dari sesi

$sql = "
    SELECT
        u.username AS pelaku,
        t.tingkat AS tingkat,
        p.nama_pelanggaran AS pelanggaran,
        l.deskripsi,
        l.bukti_filepath
    FROM laporan AS l
    INNER JOIN tingkat AS t ON l.id_tingkat = t.id_tingkat
    INNER JOIN [user] AS u ON l.id_pelaku = u.id_user
    INNER JOIN pelanggaran AS p ON l.id_pelanggaran = p.id_pelanggaran
    WHERE l.id_pelapor = ?
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
    <title>Riwayat Laporan</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-dongker {
            background-color: #001f54 !important;
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

        main.content {
            margin-left: 50px;
        }

        .btn-primary {
            background-color: #001f54;
            border: none;
        }

        .btn-primary:hover {
            background-color: #003080;
        }

        .custom-margin-top {
            margin-top: 90px;
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
            <?php include "sidebar.php"; ?>

            <main class="col-md-10 ms-sm-auto px-md-4 custom-margin-top">
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
                                        <th>Tingkat</th>
                                        <th>Nama Terlapor</th>
                                        <th>Deskripsi</th>
                                        <th>Jenis Pelanggaran</th>
                                        <th>Bukti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) : ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= htmlspecialchars($row['tingkat']) ?></td>
                                            <td><?= htmlspecialchars($row['pelaku']) ?></td>
                                            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $no ?>">Detail</button>
                                            </td>
                                            <td>
                                                <button
                                                    class="btn btn-primary btn-sm"
                                                    <?= empty($row['bukti_filepath']) ? 'disabled' : "onclick=\"window.open('" . htmlspecialchars($row['bukti_filepath']) . "', '_blank')\"" ?>>
                                                    Lihat Bukti
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal untuk detail laporan -->
                                        <div class="modal fade" id="modalDetail<?= $no ?>" tabindex="-1" aria-labelledby="modalLabel<?= $no ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalLabel<?= $no ?>">Detail Laporan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Jenis Pelanggaran:</strong> <?= htmlspecialchars($row['pelanggaran']) ?></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                        $no++;
                                    endwhile;

                                    if ($no === 1) : ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada laporan</td>
                                        </tr>
                                    <?php endif; ?>
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