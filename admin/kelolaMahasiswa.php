<?php
// Memanggil koneksi database
require_once '../connection.php';

// Proses untuk menambah pengguna
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $kelas = $_POST['kelas'];
    $status_akademik = $_POST['status_akademik'];

    $sql = "INSERT INTO mahasiswa (nama, nim, kelas, status_akademik) VALUES (?, ?, ?, ?)";
    $stmt = sqlsrv_query($conn, $sql, array($nama, $nim, $kelas, $status_akademik));

    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "Pengguna berhasil ditambahkan.";
    exit;
}

// Proses untuk mengedit pengguna
if (isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id_mahasiswa = $_POST['id'];
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $kelas = $_POST['kelas'];
    $status_akademik = $_POST['status_akademik'];

    $sql = "UPDATE mahasiswa SET nama = ?, nim = ?, kelas = ?, status_akademik = ? WHERE id_mahasiswa = ?";
    $stmt = sqlsrv_prepare($conn, $sql, array($nama, $nim, $kelas, $status_akademik, $id_mahasiswa));

    if (sqlsrv_execute($stmt)) {
        echo "Pengguna berhasil diubah.";
    } else {
        echo "Gagal mengubah pengguna.";
    }
    exit;
}

// Proses untuk menghapus pengguna
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id_mahasiswa = $_POST['id'];

    $sql = "DELETE FROM mahasiswa WHERE id_mahasiswa = ?";
    $stmt = sqlsrv_prepare($conn, $sql, array($id_mahasiswa));

    if (sqlsrv_execute($stmt)) {
        echo "Pengguna berhasil dihapus.";
    } else {
        echo "Gagal menghapus pengguna.";
    }
    exit;
}

// Proses untuk mengambil data kelas
$sql_kelas = "SELECT id_kelas, nama_kelas FROM kelas";
$stmt_kelas = sqlsrv_query($conn, $sql_kelas);
if ($stmt_kelas === false) {
    die(print_r(sqlsrv_errors(), true));
}

$kelas_options = [];
while ($row_kelas = sqlsrv_fetch_array($stmt_kelas, SQLSRV_FETCH_ASSOC)) {
    $kelas_options[] = $row_kelas;
}

// Query untuk mengambil data mahasiswa
$sql = "
    SELECT m.id_mahasiswa, m.nama, m.nim, k.nama_kelas, m.status_akademik
    FROM mahasiswa AS m
    INNER JOIN kelas AS k ON m.kelas = k.id_kelas
";
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
    <title>Kelola Mahasiswa</title>
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
    <script>
        const kelasOptions = <?= json_encode($kelas_options); ?>;
    </script>
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
                <h1 class="display-5 fw-bold text-dongker">Kelola Mahasiswa</h1>
                <button class="btn btn-primary mt-2" onclick="tambahPengguna()">Tambah Pengguna</button>
            </div>
            <div class="card-body">
                <div id="formTambahPengguna" style="display:none;">
                    <input type="text" id="tambahNama" class="form-control" placeholder="Nama Mahasiswa">
                    <input type="text" id="tambahNim" class="form-control mt-2" placeholder="NIM Mahasiswa">
                    <select id="tambahKelas" class="form-select mt-2">
                        <option value="" disabled selected>Pilih Kelas</option>
                        <?php foreach ($kelas_options as $kelas) { ?>
                            <option value="<?= $kelas['id_kelas'] ?>"><?= $kelas['nama_kelas'] ?></option>
                        <?php } ?>
                    </select>
                    <input type="text" id="tambahStatus" class="form-control mt-2" placeholder="Status Akademik">
                    <button class="btn btn-success mt-2" onclick="simpanTambahPengguna()">Simpan</button>
                    <button class="btn btn-danger mt-2" onclick="batalTambahPengguna()">Batal</button>
                </div>
                <table class="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { ?>
                            <tr id="row-<?= $row['id_mahasiswa'] ?>">
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nim']) ?></td>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= htmlspecialchars($row['nama_kelas']) ?></td>
                                <td><?= htmlspecialchars($row['status_akademik']) ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editPengguna(<?= $row['id_mahasiswa'] ?>)">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="hapusPengguna(<?= $row['id_mahasiswa'] ?>)">Hapus</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function tambahPengguna() {
            document.getElementById('formTambahPengguna').style.display = 'block';
        }

        function simpanTambahPengguna() {
            const nama = document.getElementById('tambahNama').value;
            const nim = document.getElementById('tambahNim').value;
            const kelas = document.getElementById('tambahKelas').value;
            const status = document.getElementById('tambahStatus').value;

            if (nama && nim && kelas && status) {
                const formData = new FormData();
                formData.append('action', 'add');
                formData.append('nama', nama);
                formData.append('nim', nim);
                formData.append('kelas', kelas);
                formData.append('status_akademik', status);

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

        function editPengguna(id) {
            const row = document.getElementById(`row-${id}`);
            const nama = row.cells[2].textContent.trim();
            const nim = row.cells[1].textContent.trim();
            const kelas = row.cells[3].textContent.trim();
            const status = row.cells[4].textContent.trim();

            const formHtml = `
                <td colspan="6">
                    <input type="text" id="editNama" class="form-control" value="${nama}">
                    <input type="text" id="editNim" class="form-control mt-2" value="${nim}">
                    <select id="editKelas" class="form-select mt-2">
                        ${kelasOptions.map(option => `
                            <option value="${option.id_kelas}" ${option.nama_kelas === kelas ? 'selected' : ''}>
                                ${option.nama_kelas}
                            </option>`).join('')}
                    </select>
                    <input type="text" id="editStatus" class="form-control mt-2" value="${status}">
                    <button class="btn btn-success mt-2" onclick="simpanEditPengguna(${id})">Simpan</button>
                    <button class="btn btn-danger mt-2" onclick="batalEditPengguna(${id})">Batal</button>
                </td>
            `;
            row.innerHTML = formHtml;
        }

        function simpanEditPengguna(id) {
            const nama = document.getElementById('editNama').value;
            const nim = document.getElementById('editNim').value;
            const kelas = document.getElementById('editKelas').value;
            const status = document.getElementById('editStatus').value;

            if (nama && nim && kelas && status) {
                const formData = new FormData();
                formData.append('action', 'edit');
                formData.append('id', id);
                formData.append('nama', nama);
                formData.append('nim', nim);
                formData.append('kelas', kelas);
                formData.append('status_akademik', status);

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

        function batalEditPengguna(id) {
            location.reload();
        }

        function hapusPengguna(id) {
            if (confirm("Apakah Anda yakin ingin menghapus pengguna ini?")) {
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
                        document.getElementById(`row-${id}`).remove();
                    });
            }
        }

        function batalTambahPengguna() {
            document.getElementById('formTambahPengguna').style.display = 'none';
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