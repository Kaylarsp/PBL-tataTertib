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
    $stmt = sqlsrv_prepare($conn, $sql, array($nama, $nim, $kelas, $status_akademik));

    if (sqlsrv_execute($stmt)) {
        echo "Pengguna berhasil ditambahkan.";
    } else {
        echo "Gagal menambah pengguna.";
    }
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
}

// Proses untuk mengambil semua pengguna
if (isset($_POST['action']) && $_POST['action'] == 'get_all') {
    $sql = "SELECT m.id_mahasiswa, m.nama, m.nim, k.nama_kelas, m.status_akademik
            FROM mahasiswa AS m
            INNER JOIN kelas AS k ON m.kelas = k.id_kelas";
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $data = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $data[] = $row;
    }

    echo json_encode($data);
}

// Query untuk mengambil data mahasiswa
$sql = "
    SELECT  m.id_mahasiswa, m.nama, m.nim, k.nama_kelas, m.status_akademik
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

        .navbar {
            z-index: 11;
            position: relative;
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

    <div class="container-fluid">
        <div class="row">
            <div class="sidebar-trigger"></div>
            <?php include "sidebar.php"; ?>

            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="pt-4">
                    <div class="card shadow-sm">
                        <div class="card-header text-center">
                            <h1 class="display-5 fw-bold mt-3">Kelola Mahasiswa</h1>
                            <p class="lead">Data pengguna yang terdaftar di sistem.</p>
                            <button class="btn btn-primary text-white" onclick="tambahPengguna()">Tambah Pengguna</button>

                            <!-- Form Input Tambah Pengguna -->
                            <div id="formTambahPengguna" style="display:none; margin-top: 20px;">
                                <input type="text" id="tambahNama" class="form-control" placeholder="Nama Mahasiswa">
                                <input type="text" id="tambahNim" class="form-control" placeholder="NIM Mahasiswa">
                                <input type="text" id="tambahKelas" class="form-control" placeholder="Kelas Mahasiswa">
                                <input type="text" id="tambahStatus" class="form-control" placeholder="Status Akademik">
                                <button class="btn btn-success mt-2" onclick="simpanTambahPengguna()">Simpan</button>
                                <button class="btn btn-danger mt-2" onclick="batalTambahPengguna()">Batal</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nim</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Status Akademik</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                        // Menghindari masalah dengan tanda kutip pada data string
                                        $nama = htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8');
                                        $nim = htmlspecialchars($row['nim'], ENT_QUOTES, 'UTF-8');
                                        $kelas = htmlspecialchars($row['nama_kelas'], ENT_QUOTES, 'UTF-8');
                                        $status_akademik = htmlspecialchars($row['status_akademik'], ENT_QUOTES, 'UTF-8');

                                    ?>
                                        <tr id="row-<?php echo $row['id_mahasiswa']; ?>">
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $row['nim']; ?></td>
                                            <td><?php echo $row['nama']; ?></td>
                                            <td><?php echo $row['nama_kelas']; ?></td>
                                            <td><?php echo $row['status_akademik']; ?></td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" onclick="editPengguna('<?php echo $row['id_mahasiswa']; ?>', '<?php echo addslashes($row['nama']); ?>', '<?php echo addslashes($row['nim']); ?>', '<?php echo addslashes($row['nama_kelas']); ?>', '<?php echo addslashes($row['status_akademik']); ?>')">Edit</button>
                                                <button class="btn btn-danger btn-sm" onclick="hapusPengguna(<?php echo $row['id_mahasiswa']; ?>)">Hapus</button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
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

        function tambahPengguna() {
            alert("Fitur Tambah Pengguna belum tersedia.");
        }
    </script>

    <script>
        function tambahPengguna() {
            document.getElementById('formTambahPengguna').style.display = 'block'; // Menampilkan form
        }

        function simpanTambahPengguna() {
            let nama = document.getElementById('tambahNama').value;
            let nim = document.getElementById('tambahNim').value;
            let kelas = document.getElementById('tambahKelas').value;
            let status_akademik = document.getElementById('tambahStatus').value;

            if (nama && nim && kelas && status_akademik) {
                const formData = new FormData();
                formData.append('action', 'add');
                formData.append('nama', nama);
                formData.append('nim', nim);
                formData.append('kelas', kelas);
                formData.append('status_akademik', status_akademik);

                fetch('', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        location.reload();
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                alert("Semua data harus diisi!");
            }
        }

        function batalTambahPengguna() {
            document.getElementById('formTambahPengguna').style.display = 'none'; // Menyembunyikan form
        }

        function editPengguna(id, nama, nim, kelas, status_akademik) {
            // Menyisipkan form input di baris yang sesuai
            let row = document.getElementById('row-' + id);
            row.innerHTML = `
        <td>${row.cells[0].innerText}</td>
        <td><input type="text" class="form-control" value="${nama}" id="editNama-${id}"></td>
        <td><input type="text" class="form-control" value="${nim}" id="editNim-${id}"></td>
        <td><input type="text" class="form-control" value="${kelas}" id="editKelas-${id}"></td>
        <td><input type="text" class="form-control" value="${status_akademik}" id="editStatus-${id}"></td>
        <td>
            <button class="btn btn-success btn-sm" onclick="simpanEditPengguna(${id})">Simpan</button>
            <button class="btn btn-secondary btn-sm" onclick="batalEditPengguna(${id}, '${nama}', '${nim}', '${kelas}', '${status_akademik}')">Batal</button>
        </td>
    `;
        }

        function simpanEditPengguna(id) {
            let newNama = document.getElementById('editNama-' + id).value;
            let newNim = document.getElementById('editNim-' + id).value;
            let newKelas = document.getElementById('editKelas-' + id).value;
            let newStatus = document.getElementById('editStatus-' + id).value;

            if (newNama && newNim && newKelas && newStatus) {
                const formData = new FormData();
                formData.append('action', 'edit');
                formData.append('id', id);
                formData.append('nama', newNama);
                formData.append('nim', newNim);
                formData.append('kelas', newKelas);
                formData.append('status_akademik', newStatus);

                fetch('', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        location.reload();
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                alert("Semua data harus diisi!");
            }
        }

        function batalEditPengguna(id, nama, nim, kelas, status_akademik) {
            let row = document.getElementById('row-' + id);
            row.innerHTML = `
        <td>${row.cells[0].innerText}</td>
        <td>${nama}</td>
        <td>${nim}</td>
        <td>${kelas}</td>
        <td>${status_akademik}</td>
        <td>
            <button class="btn btn-warning btn-sm" onclick="editPengguna(${id}, '${nama}', '${nim}', '${kelas}', '${status_akademik}')">Edit</button>
            <button class="btn btn-danger btn-sm" onclick="hapusPengguna(${id})">Hapus</button>
        </td>
    `;
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
                        alert(data); // Menampilkan pesan sukses/gagal
                        location.reload(); // Reload halaman untuk menampilkan data terbaru
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
    </script>

</body>

</html>