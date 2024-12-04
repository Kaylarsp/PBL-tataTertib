<?php
// Memanggil koneksi database
require_once '../connection.php';

// Proses untuk menambah dosen
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $nama = $_POST['nama'];
    $nidn = $_POST['nidn'];
    $tgl_lahir = $_POST['tgl_lahir'];

    $sql = "INSERT INTO dosen (nama, nidn, tgl_lahir) VALUES (?, ?, ?)";
    $stmt = sqlsrv_query($conn, $sql, array($nama, $nidn, $tgl_lahir));

    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "Dosen berhasil ditambahkan.";
    exit;
}

// Proses untuk mengedit dosen
if (isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id_dosen = $_POST['id'];
    $nama = $_POST['nama'];
    $nidn = $_POST['nidn'];
    $tgl_lahir = $_POST['tgl_lahir'];

    $sql = "UPDATE dosen SET nama = ?, nidn = ?, tgl_lahir = ? WHERE id_dosen = ?";
    $stmt = sqlsrv_prepare($conn, $sql, array($nama, $nidn, $tgl_lahir, $id_dosen));

    if (sqlsrv_execute($stmt)) {
        echo "Dosen berhasil diubah.";
    } else {
        echo "Gagal mengubah dosen.";
    }
    exit;
}

// Proses untuk menghapus dosen
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id_dosen = $_POST['id'];

    $sql = "DELETE FROM dosen WHERE id_dosen = ?";
    $stmt = sqlsrv_prepare($conn, $sql, array($id_dosen));

    if (sqlsrv_execute($stmt)) {
        echo "Dosen berhasil dihapus.";
    } else {
        echo "Gagal menghapus dosen.";
    }
    exit;
}

// Query untuk mengambil data dosen
$sql = "SELECT id_dosen, nama, nidn, tgl_lahir FROM dosen";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
            height: 100vh;
        }

        .text-dongker {
            color: #001f54;
        }
    </style>
</head>

<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-dongker navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin.php">
                <i class="bi bi-mortarboard-fill me-2"></i>Polinema
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="admin.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Laporan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Bantuan</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Ikon Menu -->
    <div class="menu-icon" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>

    <div class="sidebar-trigger"></div>
    <?php include "sidebar.php"; ?>

    <!-- Konten Utama -->
    <div class="d-flex align-items-center justify-content-center full-height">
        <div class="card cardContent shadow p-4" style="width: 100%; max-width: 850px;">
            <div class="text-center mb-4">
                <h1 class="display-5 fw-bold text-dongker">Kelola Dosen</h1>
                <button class="btn btn-primary mt-2" onclick="tambahDosen()">Tambah Dosen</button>
            </div>
            <div class="card-body">
                <div id="formTambahDosen" style="display:none;">
                    <input type="text" id="tambahNama" class="form-control" placeholder="Nama Dosen">
                    <input type="text" id="tambahNidn" class="form-control mt-2" placeholder="NIDN Dosen">
                    <input type="date" id="tambahTglLahir" class="form-control mt-2" placeholder="Tanggal Lahir">
                    <button class="btn btn-success mt-2" onclick="simpanTambahDosen()">Simpan</button>
                    <button class="btn btn-danger mt-2" onclick="batalTambahDosen()">Batal</button>
                </div>
                <table class="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIDN</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { ?>
                            <tr id="row-<?= $row['id_dosen'] ?>">
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nidn']) ?></td>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= htmlspecialchars($row['tgl_lahir']->format('Y-m-d')) ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editDosen(<?= $row['id_dosen'] ?>)">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="hapusDosen(<?= $row['id_dosen'] ?>)">Hapus</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function tambahDosen() {
            document.getElementById('formTambahDosen').style.display = 'block';
        }

        function simpanTambahDosen() {
            const nama = document.getElementById('tambahNama').value;
            const nidn = document.getElementById('tambahNidn').value;
            const tglLahir = document.getElementById('tambahTglLahir').value;

            if (nama && nidn && tglLahir) {
                const formData = new FormData();
                formData.append('action', 'add');
                formData.append('nama', nama);
                formData.append('nidn', nidn);
                formData.append('tgl_lahir', tglLahir);

                fetch('', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        location.reload();
                    });
            } else {
                alert("Semua data harus diisi!");
            }
        }

        function editDosen(id) {
            const row = document.getElementById(`row-${id}`);
            const nama = row.cells[2].innerText;
            const nidn = row.cells[1].innerText;
            const tglLahir = row.cells[3].innerText;

            const form = `
                <input type="text" id="editNama" class="form-control" value="${nama}">
                <input type="text" id="editNidn" class="form-control mt-2" value="${nidn}">
                <input type="date" id="editTglLahir" class="form-control mt-2" value="${tglLahir}">
                <button class="btn btn-warning mt-2" onclick="simpanEditDosen(${id})">Simpan</button>
                <button class="btn btn-danger mt-2" onclick="batalEditDosen(${id})">Batal</button>
            `;
            row.cells[2].innerHTML = form;
        }

        function simpanEditDosen(id) {
            const nama = document.getElementById('editNama').value;
            const nidn = document.getElementById('editNidn').value;
            const tglLahir = document.getElementById('editTglLahir').value;

            const formData = new FormData();
            formData.append('action', 'edit');
            formData.append('id', id);
            formData.append('nama', nama);
            formData.append('nidn', nidn);
            formData.append('tgl_lahir', tglLahir);

            fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    location.reload();
                });
        }

        function hapusDosen(id) {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);

            fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    location.reload();
                });
        }

        function batalTambahDosen() {
            document.getElementById('formTambahDosen').style.display = 'none';
        }

        function batalEditDosen(id) {
            const row = document.getElementById(`row-${id}`);
            row.cells[2].innerHTML = row.cells[2].innerText;
            row.cells[3].innerHTML = row.cells[3].innerText;
        }
    </script>
    
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
