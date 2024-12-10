<?php
require_once '../connection.php';

// SQL query untuk mengambil data
$sql = "
    SELECT
        l.id_laporan,
        u.username AS nama,
        m.nim,
        k.nama_kelas,
        d.nama AS dosen,
        p.nama_pelanggaran AS pelanggaran,
        t.tingkat,
        l.sanksi,
        up.statusSanksi as status
    FROM laporan l
    JOIN [user] u ON l.id_pelaku = u.id_user
    JOIN mahasiswa m ON u.id_user = m.id_user
    JOIN kelas k ON m.kelas = k.id_kelas
    JOIN dosen d ON k.id_kelas = d.id_kelas
    JOIN tingkat t ON l.id_tingkat = t.id_tingkat
    JOIN pelanggaran p ON t.id_tingkat = p.id_tingkat
    JOIN upload up ON m.id_mahasiswa = up.id_mahasiswa
    WHERE up.statusSanksi = 1
";
$stmt = sqlsrv_query($conn, $sql);

// Cek jika query berhasil dijalankan
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin - Buat Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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

        .content-box {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #001f54;
            border: none;
        }

        .btn-primary:hover {
            background-color: #003080;
        }

        .card {
            margin-right: 40px;
        }

        .card-header {
            background-color: transparent !important;
            color: #001f54 !important;
            text-align: center;
            border: none;
        }

        .custom-margin-top {
            margin-top: 90px;
        }
    </style>
</head>

<body class="bg-light">
    <!-- Navbar -->
    <?php include "navbar.php"; ?>

    <!-- Ikon Menu -->
    <div class="menu-icon" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>

    <div class="sidebar-trigger"></div>
    <?php include "sidebar.php"; ?>

    <!-- Main Content Area -->
    <div class="col-md-10 ms-sm-auto px-md-4 custom-margin-top">
        <div class="card shadow-lg">
            <div class="card-body">
                <h1 class="card-title text-center mb-4">Buat Laporan</h1>
                <h2 class="h5 mb-3 text-center">Daftar Pelanggaran yang Sudah Selesai</h2>
                <div class="table-responsive mt-4">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Kelas</th>
                                <th>Dosen</th>
                                <th>Deskripsi Pelanggaran</th>
                                <th>Sanksi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1; // Counter untuk nomor urut
                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                echo "<tr>
                                        <td>{$no}</td>
                                        <td>{$row['nama']}</td>
                                        <td>{$row['nim']}</td>
                                        <td>{$row['nama_kelas']}</td>
                                        <td>{$row['dosen']}</td>
                                        <td>{$row['pelanggaran']}</td>
                                        <td>{$row['sanksi']}</td>
                                        <td>" . ($row['status'] == 1 ? 'Selesai' : 'Belum Selesai') . "</td>
                                        <td>
                                            <a href='hasillaporan.php?report_id={$row['id_laporan']}' class='btn btn-primary btn-sm'>Unduh Laporan</a>
                                        </td>
                                    </tr>";
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
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
