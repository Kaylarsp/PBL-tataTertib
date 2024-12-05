<?php
// Memanggil koneksi database
require_once '../connection.php'; // Pastikan koneksi menggunakan `sqlsrv_connect`

// Proses verifikasi jika ada request verifikasi
if (isset($_GET['action']) && $_GET['action'] == 'verify' && isset($_GET['id_laporan'])) {
    $id_laporan = $_GET['id_laporan'];
    $admin_id = 1; // Ganti dengan ID admin yang sedang login
    $verify_at = date("Y-m-d H:i:s");

    // Menggunakan prepared statement untuk update
    $sql = "UPDATE laporan SET verify_by = ?, verify_at = ? WHERE id_laporan = ?";
    $params = [$admin_id, $verify_at, $id_laporan];

    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        $message = "Error: " . print_r(sqlsrv_errors(), true);
    } else {
        $message = "Laporan berhasil diverifikasi.";
    }
}

// Query untuk mengambil data laporan
$sql = "SELECT
            l.id_laporan,
            t.tingkat,
            up.username AS nama_pelapor,
            ut.username AS nama_terlapor,
            m.nim AS nim_terlapor,
            p.nama_pelanggaran,
            l.verify_by,
            l.verify_at
        FROM laporan l
        JOIN tingkat t ON l.id_tingkat = t.id_tingkat
        JOIN [user] up ON l.id_pelapor = up.id_user
        JOIN [user] ut ON l.id_pelaku = ut.id_user
        JOIN mahasiswa m ON ut.id_user = m.id_user
        JOIN pelanggaran p ON l.id_pelanggaran = p.id_pelanggaran";

$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die("Error: " . print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        .bg-dongker {
            background-color: #001f54 !important;
        }

        .card-option {
            cursor: pointer;
            transition: transform 0.3s;
        }

        .card-option:hover {
            transform: scale(1.05);
        }

        .btn-primary {
            background-color: #001f54;
            border: none;
        }

        .btn-primary:hover {
            background-color: #003080;
        }

        .cardContent {
            margin-left: 70px;
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
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 11;
        }

        .full-height {
            height: 80vh;
        }

        .text-dongker {
            color: #001f54;
        }

        .content-margin {
            margin-top: 10px; /* Sesuaikan jarak ini */
        }
    </style>
</head>

<body class="bg-light">
    <?php include "navbar.php"; ?>

    <!-- Ikon Menu -->
    <div class="menu-icon" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>

    <div class="sidebar-trigger"></div>
    <?php include "sidebar.php"; ?>

    <div class="container content-margin">
        <!-- Konten Utama -->
        <div class="d-flex align-items-center justify-content-center full-height">
            <div class="card cardContent shadow p-4" style="width: 90%;">
                <div class="text-center mb-4">
                    <h1 class="display-5 fw-bold text-dongker">Lihat Pelanggaran</h1>
                </div>
                <div class="card-body">
                    <!-- Menampilkan pesan jika ada -->
                    <?php if (isset($message)) : ?>
                        <div class="alert alert-info text-center">
                            <?= $message; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Tabel Pelanggaran -->
                    <table class="table table-hover table-striped mt-4">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tingkat</th>
                                <th>Pelapor</th>
                                <th>Terlapor</th>
                                <th>NIM Terlapor</th>
                                <th>Pelanggaran</th>
                                <th>Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['tingkat']}</td>
                            <td>{$row['pelapor']}</td>
                            <td>{$row['pelaku']}</td>
                            <td>{$row['nim']}</td>
                            <td>{$row['nama_pelanggaran']}</td>
                            <td>";
                                if ($row['verify_by'] && $row['verify_at']) {
                                    echo "Verified by {$row['verify_by']} at {$row['verify_at']}";
                                } else {
                                    echo "<a href='?action=verify&id_laporan={$row['id_laporan']}' class='btn btn-success btn-sm'>Verifikasi</a>";
                                }
                                echo "</td>
                        </tr>";
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Card -->
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