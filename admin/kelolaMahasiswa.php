<?php
// Memanggil koneksi database
require_once '../connection.php';

if (isset($_POST['action']) && $_POST['action'] == 'add') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $kelas = $_POST['kelas'];
    $status_akademik = $_POST['status_akademik'];

    // Mulai transaksi
    $beginTransaction = sqlsrv_begin_transaction($conn);

    // Cek apakah transaksi berhasil dimulai
    if (!$beginTransaction) {
        die("Error starting transaction: " . print_r(sqlsrv_errors(), true));
    }

    // Tambahkan data ke tabel user terlebih dahulu
    $sql_user = "INSERT INTO [user] (username, password, role) VALUES (?, ?, ?)";
    $username = $nama;
    $password = '123'; // Password default, bisa diubah kemudian
    $role = 4; // Role default
    $stmt_user = sqlsrv_query($conn, $sql_user, array($username, $password, $role));

    if (!$stmt_user) {
        sqlsrv_rollback($conn);
        die("Error inserting user: " . print_r(sqlsrv_errors(), true));
    }

    // Ambil ID user yang baru ditambahkan menggunakan @@IDENTITY
    $sql_last_insert_user_id = "SELECT @@IDENTITY AS id_user";
    $stmt_last_user_id = sqlsrv_query($conn, $sql_last_insert_user_id);

    if (!$stmt_last_user_id) {
        sqlsrv_rollback($conn);
        die("Error fetching last insert id: " . print_r(sqlsrv_errors(), true));
    }

    $row_user = sqlsrv_fetch_array($stmt_last_user_id, SQLSRV_FETCH_ASSOC);

    // Debugging: Print the result of the fetch to check what is returned
    if ($row_user) {
    } else {
        sqlsrv_rollback($conn);
        die("No row returned after fetch. Please check your query and database setup.");
    }

    $id_user = $row_user['id_user'];

    // Periksa apakah ID user berhasil didapatkan
    if (!$id_user) {
        sqlsrv_rollback($conn);
        die('Gagal mendapatkan id_user. Returned value: ' . print_r($row_user, true));
    }

    // Menambahkan data ke tabel mahasiswa dengan id_user yang sudah didapatkan
    $sql = "INSERT INTO mahasiswa (nama, nim, kelas, status_akademik, id_user) VALUES (?, ?, ?, ?, ?)";
    $stmt = sqlsrv_query($conn, $sql, array($nama, $nim, $kelas, $status_akademik, $id_user));

    if (!$stmt) {
        sqlsrv_rollback($conn);
        die("Error inserting mahasiswa: " . print_r(sqlsrv_errors(), true));
    }

    // Commit transaksi
    $commitTransaction = sqlsrv_commit($conn);

    if (!$commitTransaction) {
        sqlsrv_rollback($conn);
        die("Error committing transaction: " . print_r(sqlsrv_errors(), true));
    }else{
        echo "Pengguna berhasil ditambahkan.";
    }

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

        .full-height {
            height: 100vh;
        }

        .text-dongker {
            color: #001f54;
        }

        .custom-margin-top {
            margin-top: 90px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        const kelasOptions = <?= json_encode($kelas_options); ?>;
    </script>
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
    <div class="d-flex align-items-center justify-content-center full-height custom-margin-top">
        <div class="card cardContent shadow p-4" style="width: 100%; max-width: 850px; margin-top: 90px;">
            <div class="text-center mb-4">
                <h1 class="display-5 fw-bold text-dongker">Kelola Mahasiswa</h1>
                <button class="btn btn-primary mt-2" onclick="tambahPenggunaInline()">Tambah Pengguna</button>
            </div>
            <div class="card-body">
                <div id="formTambahPengguna" style="display:none;">
                    <div class="card p-3 mt-3 shadow">
                        <div class="card-body">
                            <h5 class="card-title">Tambah Pengguna</h5>
                            <input type="text" id="tambahNama" class="form-control mt-2" placeholder="Nama Mahasiswa">
                            <input type="text" id="tambahNim" class="form-control mt-2" placeholder="NIM Mahasiswa">
                            <select id="tambahKelas" class="form-select form-select-sm">
                                <option value="" disabled selected>Kelas</option>
                                ${kelasOptions.map(option => `
                                <option value="${option.id_kelas}">${option.nama_kelas}</option>
                                `).join('')}
                            </select>

                            <select id="tambahStatus" class="form-select form-select-sm">
                                <option value="" disabled selected>Status</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Cuti">Cuti</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                            <button class="btn btn-success mt-3" onclick="simpanTambahPenggunaInline()">Simpan</button>
                            <button class="btn btn-danger mt-3" onclick="batalTambahPenggunaInline()">Batal</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-hover mt-4">
                    <thead class="table-dark">
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
                                    <button class="btn btn-warning btn-sm" onclick="editPenggunaInline(<?= $row['id_mahasiswa'] ?>)">Edit</button>
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
        function editPenggunaInline(id) {
            const row = document.getElementById(`row-${id}`);
            const nama = row.cells[2].textContent.trim();
            const nim = row.cells[1].textContent.trim();
            const kelas = row.cells[3].textContent.trim();
            const status = row.cells[4].textContent.trim();

            row.innerHTML = `
                <td>${row.cells[0].textContent}</td>
                <td><input type="text" class="form-control form-control-sm" id="editNim-${id}" value="${nim}"></td>
                <td><input type="text" class="form-control form-control-sm" id="editNama-${id}" value="${nama}"></td>
                <td>
                    <select class="form-select form-select-sm" id="editKelas-${id}">
                        ${kelasOptions.map(option => `
                            <option value="${option.id_kelas}" ${option.nama_kelas === kelas ? 'selected' : ''}>
                                ${option.nama_kelas}
                            </option>`).join('')}
                    </select>
                </td>
                    <select class="form-select form-select-sm" id="editStatus-${id}">
                        <option value="Aktif" ${status === 'Aktif' ? 'selected' : ''}>Aktif</option>
                        <option value="Tidak Aktif" ${status === 'Tidak Aktif' ? 'selected' : ''}>Tidak Aktif</option>
                        <option value="Cuti" ${status === 'Cuti' ? 'selected' : ''}>Cuti</option>
                    </select>
                <td>
                    <button class="btn btn-success btn-sm me-1" onclick="simpanEditPenggunaInline(${id})"><i class="bi bi-check-lg"></i></button>
                    <button class="btn btn-danger btn-sm" onclick="batalEditPenggunaInline()"><i class="bi bi-x-lg"></i></button>
                </td>
            `;
        }

        function simpanEditPenggunaInline(id) {
            let nim = document.getElementById(`editNim-${id}`).value;
            let nama = document.getElementById(`editNama-${id}`).value;
            let kelas = document.getElementById(`editKelas-${id}`).value;
            let status = document.getElementById(`editStatus-${id}`).value;

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

        function tambahPenggunaInline() {
            const tbody = document.querySelector('tbody');
            const currentRowCount = tbody.rows.length;
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${currentRowCount + 1}</td> <!-- Nomor urut -->
                <td><input type="text" class="form-control form-control-sm tambahNim" id="tambahNim" placeholder="Masukkan NIM"></td>
                <td><input type="text" class="form-control form-control-sm tambahNama" id="tambahNama" placeholder="Masukkan Nama"></td>
                <td>
                    <select class="form-select form-select-sm tambahKelas" id="tambahKelas">
                        <option value="" disabled selected>Kelas</option>
                        ${kelasOptions.map(option => `
                            <option value="${option.id_kelas}">${option.nama_kelas}</option>
                        `).join('')}
                    </select>
                </td>
                <td>
                    <select class="form-select form-select-sm tambahStatus" id="tambahStatus"> <!-- Dropdown untuk Status Akademik -->
                        <option value="" disabled selected>Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Cuti">Cuti</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </td>
                <td>
                    <button class="btn btn-success btn-sm me-1" onclick="simpanTambahPenggunaInline()"><i class="bi bi-check-lg"></i></button>
                    <button class="btn btn-danger btn-sm" onclick="batalTambahPenggunaInline()"><i class="bi bi-x-lg"></i></button>
                </td>
            `;
            tbody.appendChild(newRow);
        }

        function simpanTambahPenggunaInline() {
            const nim = $('.tambahNim').val();
            const nama = $('.tambahNama').val();
            const kelas = $('.tambahKelas').val();
            const status = $('.tambahStatus').val();

            console.log({
                nim,
                nama,
                kelas,
                status
            }); // Debugging anjay 

            if (nim && nama && kelas && status) {
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

        function batalEditPenggunaInline() {
            location.reload();
        }

        function batalTambahPenggunaInline() {
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
    </script>

    <!-- Link Bootstrap JS dan Icon -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

</body>

</html>