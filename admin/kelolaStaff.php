<?php
// Memanggil koneksi database
require_once '../connection.php';

if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $tgl_lahir = $_POST['tgl_lahir'];

    // Tambahkan data ke tabel staff
    $sql = "INSERT INTO staff (nama, nip, tgl_lahir) VALUES (?, ?, ?)";
    $stmt = sqlsrv_query($conn, $sql, array($nama, $nip, $tgl_lahir));

    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Setelah data staff berhasil ditambahkan, tambahkan ke tabel user
    $username = $nama;
    $password = '123';
    $role = 2; // Tentukan role untuk user staff

    $sqlUser = "INSERT INTO [user] (username, password, role) VALUES (?, ?, ?)";
    $stmtUser = sqlsrv_query($conn, $sqlUser, array($username, $password, $role));

    if (!$stmtUser) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "Staff berhasil ditambahkan";
    exit;
}

// Proses untuk mengedit staff
if (isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id_staff = $_POST['id'];
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $tgl_lahir = $_POST['tgl_lahir'];

    $sql = "UPDATE staff SET nama = ?, nip = ?, tgl_lahir = ? WHERE id_staff = ?";
    $stmt = sqlsrv_prepare($conn, $sql, array($nama, $nip, $tgl_lahir, $id_staff));

    if (sqlsrv_execute($stmt)) {
        echo "Staff berhasil diubah.";
    } else {
        echo "Gagal mengubah staff.";
    }
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id_staff = $_POST['id'];

    // Ambil id_user dari tabel staff
    $sqlSelect = "SELECT id_user FROM staff WHERE id_staff = ?";
    $stmtSelect = sqlsrv_query($conn, $sqlSelect, array($id_staff));

    if ($stmtSelect === false || !($row = sqlsrv_fetch_array($stmtSelect, SQLSRV_FETCH_ASSOC))) {
        echo "Data staff tidak ditemukan.";
        exit;
    }

    $id_user = $row['id_user'];

    // Hapus data dari tabel staff
    $sqlDeleteStaff = "DELETE FROM staff WHERE id_staff = ?";
    $stmtDeleteStaff = sqlsrv_query($conn, $sqlDeleteStaff, array($id_staff));

    if (!$stmtDeleteStaff) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Hapus data dari tabel user
    $sqlDeleteUser = "DELETE FROM [user] WHERE id_user = ?";
    $stmtDeleteUser = sqlsrv_query($conn, $sqlDeleteUser, array($id_user));

    if (!$stmtDeleteUser) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "Data staff berhasil dihapus.";
    exit;
}

// Query untuk mengambil data staff
$sql = "SELECT id_staff, nama, nip, tgl_lahir FROM staff";
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
    <title>Kelola Staff</title>
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
                <h1 class="display-5 fw-bold text-dongker">Kelola Staff</h1>
                <button class="btn btn-primary mt-2" onclick="tambahStaff()">Tambah Staff</button>
            </div>
            <div class="card-body">
                <div id="formTambahStaff" style="display:none;">
                    <input type="text" id="tambahNama" class="form-control" placeholder="Nama Staff">
                    <input type="text" id="tambahNidn" class="form-control mt-2" placeholder="NIDN Staff">
                    <input type="date" id="tambahTglLahir" class="form-control mt-2" placeholder="Tanggal Lahir">
                    <button class="btn btn-success mt-2" onclick="simpanTambahStaff()">Simpan</button>
                    <button class="btn btn-danger mt-2" onclick="batalTambahStaff()">Batal</button>
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
                            <tr id="row-<?= $row['id_staff'] ?>">
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nip']) ?></td>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= htmlspecialchars($row['tgl_lahir']->format('Y-m-d')) ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editStaff(<?= $row['id_staff'] ?>)">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="hapusStaff(<?= $row['id_staff'] ?>)">Hapus</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tombol Kembali ke Halaman Sebelumnya -->
    <a href="kelolaPengguna.php" class="btn-back-to-previous">
        <i class="bi bi-arrow-left"></i>
    </a>

    <script>
        function tambahStaff() {
            document.getElementById('formTambahStaff').style.display = 'block';
        }

        function simpanTambahStaff() {
            const nama = document.getElementById('tambahNama').value;
            const nip = document.getElementById('tambahNidn').value;
            const tglLahir = document.getElementById('tambahTglLahir').value;

            if (nama && nip && tglLahir) {
                const formData = new FormData();
                formData.append('action', 'add');
                formData.append('nama', nama);
                formData.append('nip', nip);
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

        function editStaff(id) {
            const row = document.getElementById(`row-${id}`);
            const nama = row.cells[2].innerText;
            const nip = row.cells[1].innerText;
            const tglLahir = row.cells[3].innerText;

            const form = `
                <input type="text" id="editNama" class="form-control" value="${nama}">
                <input type="text" id="editNidn" class="form-control mt-2" value="${nip}">
                <input type="date" id="editTglLahir" class="form-control mt-2" value="${tglLahir}">
                <button class="btn btn-warning mt-2" onclick="simpanEditStaff(${id})">Simpan</button>
                <button class="btn btn-danger mt-2" onclick="batalEditStaff(${id})">Batal</button>
            `;
            row.cells[2].innerHTML = form;
        }

        function simpanEditStaff(id) {
            const nama = document.getElementById('editNama').value;
            const nip = document.getElementById('editNidn').value;
            const tglLahir = document.getElementById('editTglLahir').value;

            const formData = new FormData();
            formData.append('action', 'edit');
            formData.append('id', id);
            formData.append('nama', nama);
            formData.append('nip', nip);
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

        function hapusStaff(id) {
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

        function batalTambahStaff() {
            document.getElementById('formTambahStaff').style.display = 'none';
        }

        function batalEditStaff(id) {
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