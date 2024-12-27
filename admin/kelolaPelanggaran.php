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

    // Pastikan 'id_tingkat' sudah diset dan tidak kosong
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

    // Setelah berhasil, arahkan kembali ke halaman yang sama
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle Delete Pelanggaran
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id_pelanggaran = $_POST['id_pelanggaran'];

    // Query to delete violation
    $sql_delete = "DELETE FROM pelanggaran WHERE id_pelanggaran = ?";
    $stmt_delete = sqlsrv_query($conn, $sql_delete, array($id_pelanggaran));

    if ($stmt_delete === false) {
        die("Error deleting pelanggaran: " . print_r(sqlsrv_errors(), true));
    }

    header("Location: " . $_SERVER['PHP_SELF']); // Redirect after successful delete
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

            <main class="col-md-10 ms-sm-auto px-md-4 custom-margin-top">
                <div class="pt-4">
                    <div class="card shadow-sm">
                        <div class="card-header text-center">
                            <h1 class="display-5 fw-bold mt-3">Kelola Pelanggaran Mahasiswa</h1>
                            <p class="lead">Data pelanggaran mahasiswa yang terdaftar di sistem.</p>
                            <button class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Pelanggaran</button>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-striped table-bordered text-center">
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
                                        echo "<td style='text-align: center;'>{$row['tingkat']}</td>";
                                        echo "<td>{$row['sanksi']}</td>";
                                        echo "<td>
                                        <form action='' method='POST' style='display:inline;'>
                                            <!-- Tidak perlu form untuk edit karena data akan diambil dengan JavaScript -->
                                            <button class='btn btn-warning btn-sm'
                                                    data-bs-toggle='modal'
                                                    data-bs-target='#editModal'
                                                    data-id='{$row['id_pelanggaran']}'
                                                    data-nama='{$row['nama_pelanggaran']}'
                                                    data-tingkat='{$row['tingkat']}'>Edit</button>
                                        </form>
                                        <form action='' method='POST' style='display:inline;'>
                                            <input type='hidden' name='id_pelanggaran' value='{$row['id_pelanggaran']}'>
                                            <button type='submit' name='action' value='delete' class='btn btn-danger btn-sm' onclick='confirmDelete(event)'>Hapus</button>
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
                <form action="" method="POST">
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
                                    echo "<option value='{$tingkat['id_tingkat']}'>{$tingkat['tingkat']}</option>";
                                }
                                ?>
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
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
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
                                <?php
                                // Query tingkat untuk mendapatkan data
                                $tingkatStmt = sqlsrv_query($conn, "SELECT * FROM tingkat");
                                if ($tingkatStmt === false) {
                                    die("Query failed: " . print_r(sqlsrv_errors(), true));
                                }

                                // Populate dropdown with tingkat options
                                while ($tingkat = sqlsrv_fetch_array($tingkatStmt, SQLSRV_FETCH_ASSOC)) {
                                    echo "<option value='{$tingkat['id_tingkat']}'>{$tingkat['tingkat']}</option>";
                                }
                                ?>
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


    <!-- JavaScript untuk mengisi data modal -->
    <script>
        // Fungsi untuk mengisi modal edit dengan data pelanggaran yang dipilih
        document.querySelectorAll('.btn-warning').forEach(button => {
            button.addEventListener('click', function() {
                // Ambil data dari tombol yang diklik
                var idPelanggaran = this.getAttribute('data-id');
                var namaPelanggaran = this.getAttribute('data-nama');
                var tingkat = this.getAttribute('data-tingkat');

                // Isi data pada modal
                document.getElementById('editIdPelanggaran').value = idPelanggaran;
                document.getElementById('editNamaPelanggaran').value = namaPelanggaran;
                document.getElementById('editIdTingkat').value = tingkat;
            });
        });
    </script>

    <script>
        function confirmDelete(event) {
            // Menampilkan konfirmasi
            if (!confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                event.preventDefault(); // Mencegah form dikirim jika memilih "Batal"
            }
        }
    </script>

    <!-- Link Bootstrap JS dan Icon -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</body>

</html>