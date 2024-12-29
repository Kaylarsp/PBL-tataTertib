<?php
session_start();
// Memanggil koneksi database
require_once '../connection.php';

$id_user = $_SESSION['id_user']; // ID dosen yang sedang login

// Query untuk mendapatkan nama kelas berdasarkan ID dosen
$sql_kelas = "
    SELECT k.nama_kelas
    FROM kelas k
    INNER JOIN dosen d ON k.id_kelas = d.id_kelas
    WHERE d.id_user = ?
";
$params_kelas = [$id_user];
$stmt_kelas = sqlsrv_query($conn, $sql_kelas, $params_kelas);

$nama_kelas = "Tidak ada"; // Default jika query gagal
if ($stmt_kelas && $row_kelas = sqlsrv_fetch_array($stmt_kelas, SQLSRV_FETCH_ASSOC)) {
    $nama_kelas = isset($row_kelas['nama_kelas']) ? htmlspecialchars($row_kelas['nama_kelas']) : 'Tidak ada';
}

// Query dengan join tabel dosen, kelas, mahasiswa, dan data pelanggarannya
$sql = "
    SELECT
        m.nama,
        m.nim,
        m.status_akademik,
        STRING_AGG(p.nama_pelanggaran, '. ') AS daftar_pelanggaran,
        STRING_AGG(t.tingkat, '. ') AS daftar_tingkat
    FROM mahasiswa m
    INNER JOIN kelas k ON m.kelas = k.id_kelas
    INNER JOIN dosen d ON k.id_kelas = d.id_kelas
    LEFT JOIN laporan l ON m.id_user = l.id_pelaku
    LEFT JOIN tingkat t ON l.id_tingkat = t.id_tingkat
    LEFT JOIN pelanggaran p ON l.id_pelanggaran = p.id_pelanggaran
    WHERE d.id_user = ?
    GROUP BY m.nama, m.nim, m.status_akademik
";
$params = [$id_user];
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Warna dongker untuk tema */
        .bg-dongker {
            background-color: #001f54 !important;
        }

        .bg-light{
            background-color: #A5BFCC !important;
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

        .sidebar:hover {
            left: 0;
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

        .navbar {
            z-index: 11;
            position: relative;
        }

        main.content {
            margin-left: 50px;
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

        .table {
            background-color: #A5BFCC;
        }
    </style>
</head>

<body>
    <?php include "navbar.php"; ?>

    <div class="menu-icon" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>

    <div class="container-fluid">
        <div class="row">
            <?php include "sidebar.php"; ?>

            <main class="col-md-10 ms-sm-auto px-md-4 custom-margin-top" >
                <div class="pt-4">
                    <div class="card shadow" style="margin-right:160px">
                        <div class="card-header">
                            <h1 class="h2 mb-0 fw-bold mt-4 mb-4">Data Mahasiswa <?php echo $nama_kelas ?></h1>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="max-width: 800px; margin: auto;">
                                <table class="table table-bordered table-striped table-hover table-dongker">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIM</th>
                                            <th>Status Akademik</th>
                                            <th>Jenis Pelanggaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                            $pelanggaran = isset($row['daftar_pelanggaran']) ? htmlspecialchars($row['daftar_pelanggaran']) : 'Tidak Ada';
                                            $tingkat_list = isset($row['daftar_tingkat']) ? explode(". ", htmlspecialchars($row['daftar_tingkat'])) : [];
                                        ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo isset($row['nama']) ? htmlspecialchars($row['nama']) : 'Tidak Ada'; ?></td>
                                                <td><?php echo isset($row['nim']) ? htmlspecialchars($row['nim']) : 'Tidak Ada'; ?></td>
                                                <td><?php echo isset($row['status_akademik']) ? htmlspecialchars($row['status_akademik']) : 'Tidak Ada'; ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm bg-dongker text-white" data-bs-toggle="modal" data-bs-target="#modalPelanggaran<?php echo $row['nim']; ?>">Detail</button>
                                                </td>
                                            </tr>

                                            <div class="modal fade mt-5" id="modalPelanggaran<?php echo $row['nim']; ?>" tabindex="-1" aria-labelledby="modalPelanggaranLabel<?php echo $row['nim']; ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalPelanggaranLabel<?php echo $row['nim']; ?>">Daftar Pelanggaran Mahasiswa</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul>
                                                                <?php
                                                                $pelanggaran_list = explode(". ", $pelanggaran);
                                                                foreach ($pelanggaran_list as $index => $p) {
                                                                    $tingkat = isset($tingkat_list[$index]) ? " (Tingkat " . $tingkat_list[$index] . ")" : "";
                                                                    echo "<li>" . $p . $tingkat . "</li>";
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }

                                        if ($no === 1) {
                                            echo "<tr><td colspan='5' class='text-center'>Tidak ada data mahasiswa</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <a href="dosen.php" class="btn-back-to-previous">
        <i class="bi bi-arrow-left"></i>
    </a>

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
