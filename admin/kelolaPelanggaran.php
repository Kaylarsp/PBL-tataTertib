<?php
require_once '../connection.php'; // Pastikan koneksi menggunakan `sqlsrv_connect`

// Query untuk mengambil data dari tabel pelanggaran
$sql = "
    SELECT
        p.id_pelanggaran,
        p.nama_pelanggaran,
        t.tingkat,
        t.sanksi
    FROM pelanggaran p
    JOIN tingkat t ON p.id_tingkat = t.id_tingkat
";
$stmt = sqlsrv_query($conn, $sql);

// Periksa apakah query berhasil
if ($stmt === false) {
    die("Query gagal: " . print_r(sqlsrv_errors(), true));
}

// Query untuk mendapatkan daftar tingkat
$tingkatQuery = "SELECT * FROM tingkat";
$tingkatStmt = sqlsrv_query($conn, $tingkatQuery);
if ($tingkatStmt === false) {
    die("Query gagal: " . print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pelanggaran</title>
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

        .table th,
        .table td {
            text-align: center;
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
            <div class="sidebar-trigger"></div>
            <?php include "sidebar.php"; ?>

            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="pt-4">
                    <div class="card shadow-sm">
                        <div class="card-header text-center">
                            <h1 class="display-5 fw-bold mt-3">Kelola Pelanggaran Mahasiswa</h1>
                            <p class="lead">Data pelanggaran mahasiswa yang terdaftar di sistem.</p>
                            <button class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Pelanggaran</button>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis Pelanggaran</th>
                                        <th>Tingkat</th>
                                        <th>Sanksi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                        echo "<tr>";
                                        echo "<td>{$no}</td>";
                                        echo "<td>{$row['nama_pelanggaran']}</td>";
                                        echo "<td>{$row['tingkat']}</td>";
                                        echo "<td>{$row['sanksi']}</td>";
                                        echo "<td>
                                                <button class='btn btn-warning btn-sm' onclick='editPelanggaran({$row['id_pelanggaran']})' data-bs-toggle=\"modal\" data-bs-target=\"#editModal\">Edit</button>
                                                <form action='delete_pelanggaran.php' method='POST' style='display:inline;'>
                                                    <input type='hidden' name='id_pelanggaran' value='{$row['id_pelanggaran']}'>
                                                    <button type='submit' class='btn btn-danger btn-sm'>Hapus</button>
                                                </form>
                                                </td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="create_pelanggaran.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Pelanggaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="namaPelanggaran" class="form-label">Nama Pelanggaran</label>
                            <input type="text" class="form-control" id="namaPelanggaran" name="nama_pelanggaran" required>
                        </div>
                        <div class="mb-3">
                            <label for="idTingkat" class="form-label">Tingkat</label>
                            <select class="form-select" id="idTingkat" name="id_tingkat" required>
                                <?php
                                while ($tingkat = sqlsrv_fetch_array($tingkatStmt, SQLSRV_FETCH_ASSOC)) {
                                    echo "<option value='{$tingkat['tingkat']}'>{$tingkat['tingkat']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="update_pelanggaran.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Pelanggaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_pelanggaran" id="editIdPelanggaran">
                        <div class="mb-3">
                            <label for="editNamaPelanggaran" class="form-label">Nama Pelanggaran</label>
                            <input type="text" class="form-control" id="editNamaPelanggaran" name="nama_pelanggaran" required>
                        </div>
                        <div class="mb-3">
                            <label for="editIdTingkat" class="form-label">Tingkat</label>
                            <select class="form-select" id="editIdTingkat" name="id_tingkat" required>
                                <!-- Options akan di-load di runtime -->
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
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

        function editPelanggaran(id) {
            // Load data pelanggaran berdasarkan ID ke modal edit
            // Ini hanya placeholder, sesuaikan dengan fetch data yang dibutuhkan
            document.getElementById('editIdPelanggaran').value = id;
        }
    </script>
</body>

</html>