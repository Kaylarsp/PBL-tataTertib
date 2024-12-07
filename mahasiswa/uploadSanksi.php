<?php
// Koneksi ke database
$serverName = "LAPTOP-2R5AJL0O"; // Ganti dengan nama server Anda
$connectionOptions = [
    "Database" => "tatib", // Nama database Anda
];
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Periksa koneksi
if ($conn === false) {
    die("Koneksi ke database gagal: " . print_r(sqlsrv_errors(), true));
}

// Query untuk mengambil data pelanggaran dari tabel dbo.pelanggaran
$sql = "SELECT id_pelanggaran, nama_pelanggaran FROM dbo.pelanggaran";
$stmt = sqlsrv_query($conn, $sql);

// Periksa apakah query berhasil
if ($stmt === false) {
    die("Query gagal: " . print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Bukti Pembayaran</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="uploadSanksi.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- CSS tambahan -->
    <style>
        /* Warna utama */
        .bg-dongker {
            background-color: #001f54 !important;
        }

        /* Toast styling */
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1055;
        }

        .toast {
            border-radius: 10px;
        }

        /* Form dan Card Styling */
        .card {
            margin-top: 30px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
        }

        .card-header {
            background-color: #001f54;
            color: white;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-light">
    <!-- Navbar -->
    <?php include "navbar.php"; ?>

    <!-- Sidebar -->
    <div class="menu-icon" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>
    <div class="sidebar">
        <ul class="nav flex-column">
            <li><a href="listTatib.php"><i class="bi bi-list-check me-2"></i>List Tata Tertib</a></li>
            <li><a href="notifikasi.php"><i class="bi bi-bell me-2"></i>Notifikasi</a></li>
            <li><a href="uploadSanksi.php"><i class="bi bi-cloud-upload me-2"></i>Upload Sanksi</a></li>
            <li><a href="../login/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <main class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-dongker text-white">
                        <h4 class="text-center">Upload Bukti Pembayaran Sanksi</h4>
                    </div>
                    <div class="card-body">
                        <form id="uploadForm" action="prosesUpload.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Mahasiswa</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="nim" name="nim" required>
                            </div>
                            <div class="mb-3">
                                <label for="pelanggaran" class="form-label">Jenis Pelanggaran</label>
                                <select class="form-select" id="pelanggaran" name="pelanggaran" required>
                                    <option value="">-- Pilih Pelanggaran --</option>
                                    <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) : ?>
                                        <option value="<?= htmlspecialchars($row['id_pelanggaran']); ?>">
                                            <?= htmlspecialchars($row['nama_pelanggaran']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="bukti" class="form-label">Upload Bukti Sanksi</label>
                                <input type="file" class="form-control" id="bukti" name="bukti" accept=".jpg,.jpeg,.png,.pdf" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success">Upload</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Toast Notification -->
    <div class="toast-container" id="toast-container">
        <div id="toast" class="toast align-items-center text-bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">Pesan Notifikasi</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#uploadForm').on('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: 'prosesUpload.php', // Ganti dengan nama file handler Anda
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        const data = JSON.parse(response);
                        // Sesuaikan judul dan pesan berdasarkan status respons
                        $('#toastMessage').text(data.message);
                        $('#toast').removeClass('text-bg-primary')
                                   .addClass(data.status === 'success' ? 'text-bg-success' : 'text-bg-danger');
                        var toast = new bootstrap.Toast($('#toast'));
                        toast.show();
                    },
                    error: function () {
                        $('#toastMessage').text('Terjadi kesalahan pada server.');
                        $('#toast').removeClass('text-bg-primary')
                                   .addClass('text-bg-danger');
                        var toast = new bootstrap.Toast($('#toast'));
                        toast.show();
                    }
                });
            });
        });
    </script>
</body>

</html>

<?php
// Tutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
