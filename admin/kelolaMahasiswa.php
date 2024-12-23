<?php
// Memanggil koneksi database
require_once '../connection.php';
include "navbar.php";

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
    } else {
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
        echo json_encode(['status' => 'success', 'message' => 'Pengguna berhasil diubah.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengubah pengguna.']);
    }
    exit;
}

// Proses untuk menghapus pengguna
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id_mahasiswa = $_POST['id'];

    // Ambil id_user dari tabel mahasiswa
    $sqlSelect = "SELECT id_user FROM mahasiswa WHERE id_mahasiswa = ?";
    $stmtSelect = sqlsrv_query($conn, $sqlSelect, array($id_mahasiswa));

    if ($stmtSelect === false || !($row = sqlsrv_fetch_array($stmtSelect, SQLSRV_FETCH_ASSOC))) {
        echo "Data mahasiswa tidak ditemukan.";
        exit;
    }

    $id_user = $row['id_user'];

    // Hapus dari tabel mahasiswa berdasarkan id_user
    $sql_mahasiswa = "DELETE FROM mahasiswa WHERE id_user = ?";
    $stmt_mahasiswa = sqlsrv_query($conn, $sql_mahasiswa, array($id_user));

    if (!$stmt_mahasiswa) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Hapus data dari tabel user
    $sqlDeleteUser = "DELETE FROM [user] WHERE id_user = ?";
    $stmtDeleteUser = sqlsrv_query($conn, $sqlDeleteUser, array($id_user));

    if (!$stmtDeleteUser) {
        die(print_r(sqlsrv_errors(), true));
    }

    // echo "Data mahasiswa berhasil dihapus.";
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

<script>
    // Mengonversi array kelas_options PHP ke format JSON yang bisa dipakai di JavaScript
    const kelasOptions = <?php echo json_encode($kelas_options); ?>;
</script>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            /* Mencegah scroll horizontal */
            font-family: Arial, sans-serif;
            overflow-y: hidden;
        }

        .full-height {
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

        /* Tambahkan margin-top agar judul tidak terpotong oleh navbar */
        .text-center {
            margin-top: 20px;
        }

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
            margin-top: 70px;
            margin-bottom: 50px;
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        const kelasOptions = <?= json_encode($kelas_options); ?>;
    </script>
</head>

<body class="bg-light">

    <!-- Ikon Menu -->
    <div class="menu-icon" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>

    <div class="sidebar-trigger"></div>
    <?php include "sidebar.php"; ?>

    <!-- Konten Utama -->
    <div class="d-flex align-items-center full-height">
        <div class="card cardContent shadow p-4" style="width: 90%; max-width: 850px; height:470px; overflow-y:auto">
            <div class="text-center mb-4">
                <h1 class="display-5 fw-bold text-dongker">Kelola Mahasiswa</h1>
                <button class="btn btn-primary mt-2" onclick="tambahPenggunaInline()">Tambah Pengguna</button>
            </div>
            <div class="card-body">
                <div id="formTambahPengguna" style="display:none;">
                    <div class="card-body">
                        <input type="text" id="tambahNama" class="form-control" placeholder="Nama Mahasiswa">
                        <input type="text" id="tambahNim" class="form-control mt-2" placeholder="NIM Mahasiswa">
                        <select id="tambahKelas" class="form-select mt-2">
                            <option value="" disabled selected>Kelas</option>
                            <!-- Opsi kelas akan diisi menggunakan JavaScript -->
                        </select>
                        <select id="tambahStatus" class="form-select mt-2">
                            <option value="" disabled selected>Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Cuti">Cuti</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                        <button class="btn btn-success mt-3" onclick="simpanTambahPenggunaInline()">Simpan</button>
                        <button class="btn btn-danger mt-3" onclick="batalTambahPenggunaInline()">Batal</button>
                    </div>
                </div>
                <div class="table-container d-flex justify-content-center">
                    <div class="table-responsive" style="width: 90%;">
                        <table class="table table-striped mt-4 text-center">
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
        </div>
    </div>



    <!-- Tombol Kembali ke Halaman Sebelumnya -->
    <a href="kelolaPengguna.php" class="btn-back-to-previous">
        <i class="bi bi-arrow-left"></i>
    </a>

    <script>
        function editPenggunaInline(id) {
            const row = document.getElementById(`row-${id}`);
            const nama = row.cells[2].innerText;
            const nim = row.cells[1].innerText;
            const kelas = row.cells[3].innerText;
            const status = row.cells[4].innerText;

            const form = `
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <input type="text" id="editNama" value="${nama}" placeholder="Nama"
                style="width: 100%; padding: 10px; font-size: 14px; border-radius: 5px; border: 1px solid #ccc;">
            <input type="text" id="editNim" value="${nim}" placeholder="NIM"
                style="width: 100%; padding: 10px; font-size: 14px; border-radius: 5px; border: 1px solid #ccc;">
            <select id="editKelas"
                style="width: 100%; padding: 10px; font-size: 14px; border-radius: 5px; border: 1px solid #ccc;">
                ${kelasOptions.map(option => `
                    <option value="${option.id_kelas}" ${option.nama_kelas === kelas ? 'selected' : ''}>
                        ${option.nama_kelas}
                    </option>`).join('')}
            </select>
            <select id="editStatus"
                style="width: 100%; padding: 10px; font-size: 14px; border-radius: 5px; border: 1px solid #ccc;">
                <option value="Aktif" ${status === 'Aktif' ? 'selected' : ''}>Aktif</option>
                <option value="Tidak Aktif" ${status === 'Tidak Aktif' ? 'selected' : ''}>Tidak Aktif</option>
                <option value="Cuti" ${status === 'Cuti' ? 'selected' : ''}>Cuti</option>
            </select>
            <div style="display: flex; gap: 10px; justify-content: flex-start;">
                <button onclick="simpanEditPenggunaInline(${id})"
                    style="font-size: 14px; padding: 8px 15px; border-radius: 5px; background-color: #ffc107; color: #fff; border: none;">
                    Simpan
                </button>
                <button onclick="batalEditPenggunaInline(${id})"
                    style="font-size: 14px; padding: 8px 15px; border-radius: 5px; background-color: #dc3545; color: #fff; border: none;">
                    Batal
                </button>
            </div>
        </div>
    `;

            row.cells[2].innerHTML = form;
        }

        function simpanEditPenggunaInline(id) {
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
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert(data.message);
                            location.reload(); // Reload halaman
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Data berhasil diubah.');
                        location.reload();
                    });
            } else {
                alert("Semua data harus diisi!");
            }
        }

        function tambahPenggunaInline() {
            document.getElementById('formTambahPengguna').style.display = 'block';
            const kelasSelect = document.getElementById('tambahKelas');
            kelasOptions.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option.id_kelas;
                optionElement.textContent = option.nama_kelas;
                kelasSelect.appendChild(optionElement);
            });
        }

        function simpanTambahPenggunaInline() {
            const nama = document.getElementById('tambahNama').value;
            const nim = document.getElementById('tambahNim').value;
            const kelas = document.getElementById('tambahKelas').value;
            const status = document.getElementById('tambahStatus').value;

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
                        alert("Berhasil menambah data");
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
                        alert("Berhasil menghapus data");
                        location.reload();
                    });
            }
        }
    </script>

    <!-- Link Bootstrap JS dan Icon -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

</body>

</html>