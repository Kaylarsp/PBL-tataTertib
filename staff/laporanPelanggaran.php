<?php
// Memanggil koneksi database
require_once '../connection.php';

// Query untuk mengambil nama pelanggaran
$sql = "SELECT * FROM pelanggaran";
$stmt = sqlsrv_query($conn, $sql);

// Query untuk mengambil data kelas
$sql_kelas = "SELECT * FROM kelas";
$stmt_kelas = sqlsrv_query($conn, $sql_kelas);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pelanggaran</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <!-- Link jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Link Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        /* Warna dongker untuk tema */
        .bg-dongker {
            background-color: #001f54 !important;
        }

        .text-dongker {
            color: #001f54 !important;
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

        .custom-margin-top {
            margin-top: 90px;
        }

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
    <!-- Navbar -->
    <?php include "navbar.php"; ?>

    <!-- Ikon Menu -->
    <div class="menu-icon" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>

    <!-- Layout dengan Bootstrap Grid -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include "sidebar.php"; ?>

            <!-- Konten Utama -->
            <main class="col-md-10 ms-sm-auto px-md-4 custom-margin-top">
                <div class="pt-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h1 class="h2 mb-0 fw-bold">Laporan Pelanggaran</h1>
                        </div>
                        <div class="card-body">
                            <!-- Form Laporan -->
                            <form action="prosesLaporan.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="nim_pelaku" class="form-label">NIM Pelaku</label>
                                    <input type="text" class="form-control" id="nim_pelaku" name="nim_pelaku" required>
                                </div>
                                <div class="mb-3">
                                    <label for="pelanggaran" class="form-label">Jenis Pelanggaran</label>
                                    <select class="form-select select2" id="pelanggaran" name="pelanggaran" required>
                                        <option value="">Pilih Jenis Pelanggaran</option>
                                        <?php
                                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                            echo "<option value='" . $row['id_pelanggaran'] . "'>" . htmlspecialchars($row['nama_pelanggaran']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Upload Gambar</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Pelanggaran</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn bg-dongker text-white">Kirim Laporan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <!-- Tombol Kembali ke Halaman Sebelumnya -->
    <a href="staff.php" class="btn-back-to-previous">
        <i class="bi bi-arrow-left"></i>
    </a>

    <!-- Link Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- Link Bootstrap JS dan Icon -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.style.left = sidebar.style.left === '0px' ? '-150px' : '0px';
        }
        // Mengirimkan form dengan AJAX
        $('#laporanForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman form normal

            $.ajax({
                url: 'prosesLaporan.php', // URL untuk mengirimkan data
                type: 'POST',
                data: $(this).serialize(), // Mengirim data form
                success: function(response) {
                    $('#responseMessage').html('<div class="alert alert-success">Laporan berhasil dikirim!</div>');
                    $('#laporanForm')[0].reset(); // Mereset form setelah sukses
                },
                error: function() {
                    $('#responseMessage').html('<div class="alert alert-danger">Gagal mengirim laporan. Coba lagi.</div>');
                }
            });
        });
    </script>

    <script>
        // Validasi file sebelum upload
        document.getElementById('image').addEventListener('change', function() {
            const file = this.files[0];
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            if (file && !allowedTypes.includes(file.type)) {
                alert('Hanya file JPG, PNG, atau GIF yang diizinkan!');
                this.value = ''; // Reset input file
            }

            if (file && file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                this.value = ''; // Reset input file
            }
        });
    </script>

    <!-- Script Select2 -->
    <script>
    $(document).ready(function() {
        $('#pelanggaran').select2({
            placeholder: "Pilih Jenis Pelanggaran",
            allowClear: true,
            width: '100%' // Agar tampilan sesuai dengan lebar dropdown asli
        });
    });
    </script>
</body>

</html>