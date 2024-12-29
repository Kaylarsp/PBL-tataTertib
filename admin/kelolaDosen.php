<?php
// Memanggil koneksi database
require_once '../connection.php';

if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $nama = $_POST['nama'];
    $nidn = $_POST['nidn'];
    $tgl_lahir = $_POST['tgl_lahir'];

    // Tambahkan data ke tabel dosen
    $sql = "INSERT INTO dosen (nama, nidn, tgl_lahir) VALUES (?, ?, ?)";
    $stmt = sqlsrv_query($conn, $sql, array($nama, $nidn, $tgl_lahir));

    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Setelah data dosen berhasil ditambahkan, tambahkan ke tabel user
    $username = $nama; // Gunakan NIDN sebagai username
    $password = '123'; // Hash NIDN untuk password awal
    $role = 2; // Tentukan role untuk user dosen

    $sqlUser = "INSERT INTO [user] (username, password, role) VALUES (?, ?, ?)";
    $stmtUser = sqlsrv_query($conn, $sqlUser, array($username, $password, $role));

    if (!$stmtUser) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "Dosen berhasil ditambahkan";
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

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id_dosen = $_POST['id'];

    // Ambil id_user dari tabel dosen
    $sqlSelect = "SELECT id_user FROM dosen WHERE id_dosen = ?";
    $stmtSelect = sqlsrv_query($conn, $sqlSelect, array($id_dosen));

    if ($stmtSelect === false || !($row = sqlsrv_fetch_array($stmtSelect, SQLSRV_FETCH_ASSOC))) {
        echo "Data dosen tidak ditemukan.";
        exit;
    }

    $id_user = $row['id_user'];

    // Hapus data dari tabel dosen
    $sqlDeleteDosen = "DELETE FROM dosen WHERE id_dosen = ?";
    $stmtDeleteDosen = sqlsrv_query($conn, $sqlDeleteDosen, array($id_dosen));

    if (!$stmtDeleteDosen) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Hapus data dari tabel user
    $sqlDeleteUser = "DELETE FROM [user] WHERE id_user = ?";
    $stmtDeleteUser = sqlsrv_query($conn, $sqlDeleteUser, array($id_user));

    if (!$stmtDeleteUser) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "Data dosen berhasil dihapus.";
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

        table {
            width: 100%;
            /* Tabel menyesuaikan dengan container */
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #003080;
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

        .full-height {
            height: 100vh;
            min-height: 100vh;
            /* Membuat halaman penuh tinggi */
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            /* Atur ke tengah atas */
            align-items: center;
        }

        .table-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .text-dongker {
            color: #001f54;
        }

        .cardContent {
            margin-left: 70px;
            margin-top: 130px;
            margin-bottom: 50px;
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

        .table {
            background-color: #A5BFCC;
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
    <div class="d-flex align-items-center full-height">
        <div class="card cardContent shadow p-4" style="width: 90%; max-width: 850px; height:550px; overflow-y:auto">
            <div class="text-center mb-3 mt-4">
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
                <div class="table-responsive">
                    <table class="table table-striped mt-4">
                        <thead class="bg-dongker text-white">
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

        <!-- Tombol Kembali ke Halaman Sebelumnya -->
        <a href="kelolaPengguna.php" class="btn-back-to-previous">
            <i class="bi bi-arrow-left"></i>
        </a>

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
                            location.reload();
                        });
                }
            }

            function batalTambahDosen() {
                location.reload();
            }

            function batalEditDosen(id) {
                location.reload();
            }
        </script>

        <!-- Link Bootstrap JS dan Icon -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</body>

</html>