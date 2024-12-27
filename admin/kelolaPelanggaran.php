<?php
require_once '../connection.php'; // Ensure connection is established using `sqlsrv_connect`

// Handle Add Pelanggaran
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $nama_pelanggaran = $_POST['nama_pelanggaran'];

    // Ensure 'id_tingkat' is set
    if (isset($_POST['id_tingkat']) && !empty($_POST['id_tingkat'])) {
        $id_tingkat = $_POST['id_tingkat'];
    } else {
        die("Tingkat tidak dipilih.");
    }

    // Query to insert new violation
    $sql_add = "INSERT INTO pelanggaran (nama_pelanggaran, id_tingkat) VALUES (?, ?)";
    $stmt_add = sqlsrv_query($conn, $sql_add, array($nama_pelanggaran, $id_tingkat));

    if ($stmt_add === false) {
        die("Error adding pelanggaran: " . print_r(sqlsrv_errors(), true));
    }

    header("Location: " . $_SERVER['PHP_SELF']); // Redirect after successful add to refresh the page
    exit;
}

// Handle Update Pelanggaran
if (isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id_pelanggaran = $_POST['id_pelanggaran'];
    $nama_pelanggaran = $_POST['nama_pelanggaran'];

    if (isset($_POST['id_tingkat']) && !empty($_POST['id_tingkat'])) {
        $id_tingkat = $_POST['id_tingkat'];
    } else {
        die("Tingkat tidak dipilih.");
    }

    // Query untuk update pelanggaran
    $sql_edit = "UPDATE pelanggaran SET nama_pelanggaran = ?, id_tingkat = ? WHERE id_pelanggaran = ?";
    $stmt_edit = sqlsrv_query($conn, $sql_edit, array($nama_pelanggaran, $id_tingkat, $id_pelanggaran));

    if ($stmt_edit === false) {
        die("Error updating pelanggaran: " . print_r(sqlsrv_errors(), true));
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle Delete Pelanggaran
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id_pelanggaran = $_POST['id_pelanggaran'];

    $sql_delete = "DELETE FROM pelanggaran WHERE id_pelanggaran = ?";
    $stmt_delete = sqlsrv_query($conn, $sql_delete, array($id_pelanggaran));

    if ($stmt_delete === false) {
        die("Error deleting pelanggaran: " . print_r(sqlsrv_errors(), true));
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Query to get existing violations
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

if ($stmt === false) {
    die("Query failed: " . print_r(sqlsrv_errors(), true));
}

// Query to get the list of tingkat (levels)
$tingkatQuery = "SELECT * FROM tingkat";
$tingkatStmt = sqlsrv_query($conn, $tingkatQuery);
if ($tingkatStmt === false) {
    die("Query failed: " . print_r(sqlsrv_errors(), true));
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pelanggaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

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

        /* Geser search bar ke kanan */
        .dataTables_filter {
            float: right;
        }

        /* Menjadikan show entries dalam satu baris */
        .dataTables_length {
            display: flex !important;
            align-items: center;
            justify-content: flex-start;
            margin: 0;
            white-space: nowrap;
        }

        /* Pastikan label "Show entries" dan dropdown berada dalam satu baris */
        .dataTables_length label {
            margin-right: 10px;
        }

        /* Styling untuk select */
        .dataTables_length select {
            margin-left: 5px;
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
            <main class="col-md-10 ms-sm-auto px-md-4 custom-margin-top">
                <div class="card shadow" style="margin-left:-90px; margin-right:70px">
                    <div class="card-header text-center mt-3">
                        <h1 class="fw-bold" style="color: #001f54;">Kelola Pelanggaran Mahasiswa</h1>
                        <button class="btn btn-primary text-white mt-2 mb-2" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Pelanggaran</button>
                    </div>
                    <div class="card-body">
                        <table id="dataTable" class="table table-hover table-striped table-bordered text-center">
                            <thead class="bg-dongker text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Pelanggaran</th>
                                    <th>Tingkat</th>
                                    <th>Sanksi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['nama_pelanggaran']; ?></td>
                                        <td class="text-center"><?= $row['tingkat']; ?></td>
                                        <td><?= $row['sanksi']; ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm w-100"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal"
                                                data-id="<?= $row['id_pelanggaran']; ?>"
                                                data-nama="<?= $row['nama_pelanggaran']; ?>"
                                                data-tingkat="<?= $row['tingkat']; ?>">Edit</button>
                                            <form action="" method="POST" style="display:inline;">
                                                <input type="hidden" name="id_pelanggaran" value="<?= $row['id_pelanggaran']; ?>">
                                                <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm w-100 mt-1" onclick='confirmDelete(event)'>Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahModal">
        <div class="modal-dialog">
            <div class="modal-content bg-dongker text-white">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5>Tambah Pelanggaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="namaPelanggaran">Nama Pelanggaran</label>
                            <input type="text" id="namaPelanggaran" name="nama_pelanggaran" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="idTingkat">Tingkat</label>
                            <select id="idTingkat" name="id_tingkat" class="form-select" required>
                                <?php while ($tingkat = sqlsrv_fetch_array($tingkatStmt, SQLSRV_FETCH_ASSOC)): ?>
                                    <option value="<?= $tingkat['id_tingkat']; ?>"><?= $tingkat['tingkat']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="action" value="add" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5>Edit Pelanggaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editIdPelanggaran" name="id_pelanggaran">
                        <div class="mb-3">
                            <label for="editNamaPelanggaran">Nama Pelanggaran</label>
                            <input type="text" id="editNamaPelanggaran" name="nama_pelanggaran" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editIdTingkat">Tingkat</label>
                            <select id="editIdTingkat" name="id_tingkat" class="form-select" required>
                                <?php
                                $tingkatStmt = sqlsrv_query($conn, "SELECT * FROM tingkat");
                                while ($tingkat = sqlsrv_fetch_array($tingkatStmt, SQLSRV_FETCH_ASSOC)): ?>
                                    <option value="<?= $tingkat['id_tingkat']; ?>"><?= $tingkat['tingkat']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="action" value="edit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tombol Kembali ke Halaman Sebelumnya -->
    <a href="admin.php" class="btn-back-to-previous">
        <i class="bi bi-arrow-left"></i>
    </a>

    <script>
        document.querySelectorAll('.btn-warning').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                var idPelanggaran = this.getAttribute('data-id');
                var namaPelanggaran = this.getAttribute('data-nama');
                var tingkat = this.getAttribute('data-tingkat');

                document.getElementById('editIdPelanggaran').value = idPelanggaran;
                document.getElementById('editNamaPelanggaran').value = namaPelanggaran;

                let tingkatDropdown = document.getElementById('editIdTingkat');
                Array.from(tingkatDropdown.options).forEach(option => {
                    option.selected = option.text === tingkat;
                });

                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
        });

        function confirmDelete(event) {
            // Menampilkan konfirmasi
            if (!confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                event.preventDefault(); // Mencegah form dikirim jika memilih "Batal"
            }
        }

        $(document).ready(function() {
            // Inisialisasi DataTables
            $('#dataTable').DataTable({
                paging: true, // Aktifkan pagination
                searching: true, // Aktifkan pencarian
                ordering: true, // Aktifkan pengurutan
                responsive: true, // Responsif untuk perangkat kecil
                lengthMenu: [3, 5, 10, 25, 50],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                }
            });
        });
    </script>

    <!-- Link Bootstrap JS dan Icon -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</body>

</html>