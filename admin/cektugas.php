<?php
require_once '../connection.php'; // Pastikan koneksi menggunakan `sqlsrv_connect`


?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Tugas Mahasiswa</title>
    <!-- Bootstrap CSS -->
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

        main.content {
            margin-left: 50px;
        }

        .table th,
        .table td {
            text-align: justify;
            vertical-align: middle;
        }

        .btn-primary {
            background-color: #001f54;
            border: none;
        }

        .btn-primary:hover {
            background-color: #003080;
        }

        .custom-margin-top {
            margin-top: 100px;
        }

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

<body class="bg-light">
    <?php include "navbar.php"; ?>

    <div class="menu-icon" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="sidebar-trigger"></div>
            <?php include "sidebar.php"; ?>

            <!-- Konten Utama -->
            <main class="col-md-10 ms-sm-auto px-md-4 custom-margin-top">
                <div class="pt-4">
                    <div class="card shadow" style="margin-left: 10px; margin-right: 70px; ">
                        <div class="card-header text-center">
                            <h1 class="display-5 fw-bold mt-3">Cek Tugas Mahasiswa</h1>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Nim</th>
                                        <th>Kelas</th>
                                        <th>Pelanggaran</th>
                                        <th>File Tugas</th>
                                        <th>Waktu Upload</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "
                                    SELECT u.id_upload, m.nama, m.nim, k.nama_kelas, u.lokasi_file, submit_time FROM upload u
                                    JOIN mahasiswa m ON u.id_mahasiswa = m.id_mahasiswa
                                    JOIN kelas k ON m.kelas = k.id_kelas
                                    JOIN pelanggaran p ON
                                    ";
                                    $stmt = sqlsrv_query($conn, $sql);

                                    if ($stmt === false) {
                                        die(print_r(sqlsrv_errors(), true));
                                    }

                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['nama_kelas']) . "</td>";

                                        // Kolom File Tugas
                                        echo "<td>";
                                        if (!empty($row['lokasi_file'])) {
                                            echo "<button class='btn btn-primary btn-sm' onclick=\"window.open('" . htmlspecialchars($row['lokasi_file']) . "', '_blank')\">Tinjau</button>";
                                        } else {
                                            echo "<button class='btn btn-secondary btn-sm' disabled>Tidak Ada Bukti</button>";
                                        }
                                        echo "</td>";

                                        // Kolom Waktu Submit
                                        echo "<td>" . ($row['submit_time'] ? $row['submit_time']->format('Y-m-d H:i:s') : '-') . "</td>";

                                        // Kolom Aksi
                                        echo "<td>
                                                <a href='" . htmlspecialchars($row['lokasi_file']) . "' class='btn btn-sm btn-success' download>
                                                    <i class='bi bi-download'></i> Download
                                                </a>
                                                <button class='btn btn-sm btn-primary' onclick='verifikasiTugas(" . (int)$row['id_upload'] . ")'>
                                                    <i class='bi bi-check-circle'></i> Verifikasi
                                                </button>
                                                <button class='btn btn-sm btn-danger' onclick='tolakTugas(" . (int)$row['id_upload'] . ")'>
                                                    <i class='bi bi-x-circle'></i> Tolak
                                                </button>
                                            </td>";
                                        echo "</tr>";
                                    }

                                    sqlsrv_free_stmt($stmt);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Tombol Kembali ke Halaman Sebelumnya -->
    <a href="admin.php" class="btn-back-to-previous">
        <i class="bi bi-arrow-left"></i>
    </a>

    <!-- Link Bootstrap JS dan Icon -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script>
        function verifikasiTugas(id) {
            if (confirm("Apakah Anda yakin ingin memverifikasi tugas ini?")) {
                alert("Tugas dengan ID " + id + " berhasil diverifikasi.");
            }
        }

        function tolakTugas(id) {
            if (confirm("Apakah Anda yakin ingin menolak tugas ini?")) {
                alert("Tugas dengan ID " + id + " ditolak.");
            }
        }
    </script>
</body>

</html>