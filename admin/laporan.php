<?php
require_once '../connection.php';

// SQL query untuk mengambil data
$sql = "
        SELECT DISTINCT
        up.id_laporan,
        u.username AS nama,
        m.nim,
        k.nama_kelas,
        d.nama AS dosen,
        p.nama_pelanggaran AS pelanggaran,
        l.sanksi,
        t.tingkat,
        up.statusSanksi as status
    FROM upload up
    JOIN laporan l ON l.id_laporan = up.id_laporan
    JOIN [user] u ON l.id_pelaku = u.id_user
    JOIN mahasiswa m ON u.id_user = m.id_user
    JOIN kelas k ON m.kelas = k.id_kelas
    JOIN pelanggaran p ON l.id_pelanggaran = p.id_pelanggaran
    JOIN dosen d ON k.id_kelas = d.id_kelas
    JOIN tingkat t ON l.id_tingkat = t.id_tingkat
    WHERE up.statusSanksi = 1;
";

// Eksekusi query
$stmt = sqlsrv_query($conn, $sql);

// Cek jika query berhasil dijalankan
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin - Buat Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .bg-dongker {
            background-color: #001f54 !important;
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

        .content-box {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #001f54;
            border: none;
        }

        .btn-primary:hover {
            background-color: #003080;
        }

        .card {
            margin-right: 150px;
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

        .table {
            background-color: #A5BFCC;
            border: 5px solid #fff;
            border-collapse: collapse; /* Gabungkan garis untuk tampilan rapi */
        }

        .table th,
        .table td {
            text-align: justify;
            vertical-align: middle;
            border: 1px solid #fff; /* Warna garis */
        }
    </style>
</head>

<body class="bg-light">
    <?php include "navbar.php"; ?>
    <div class="menu-icon" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>
    <?php include "sidebar.php"; ?>

    <main class="col-md-10 ms-sm-auto px-md-4 custom-margin-top d-flex justify-content-center align-items-center">
        <div class="pt-4">
            <div class="card shadow" style="margin-right: 150px;">
                <div class="card-header bg-dongker text-white p-4">
                    <h1 class="text-center mb-3 fw-bold">Buat Laporan</h1>
                    <h2 class="h5 mb-3 text-center">Daftar Pelanggaran yang Sudah Selesai</h2>
                </div>
                <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-hover table-striped">
                        <thead class="bg-dongker text-white">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Kelas</th>
                                <th>Dosen</th>
                                <th>Pelanggaran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                echo "<tr>
                                        <td>{$no}</td>
                                        <td>{$row['nama']}</td>
                                        <td>{$row['nim']}</td>
                                        <td>{$row['nama_kelas']}</td>
                                        <td>{$row['dosen']}</td>
                                        <td class='text-center'>
                                            <button class='btn btn-sm bg-dongker text-white' data-bs-toggle='modal' data-bs-target='#detailModal' data-pelanggaran='{$row['pelanggaran']}' data-sanksi='{$row['sanksi']}' data-tingkat='{$row['tingkat']}'>Detail</button>
                                        </td>
                                        <td>" . ($row['status'] == 1 ? 'Selesai' : 'Belum Selesai') . "</td>
                                        <td class='text-center'>
                                            <a href='hasillaporan.php?report_id={$row['id_laporan']}' class='btn btn-primary btn-sm'>Unduh Laporan</a>
                                        </td>
                                    </tr>";
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <a href="admin.php" class="btn-back-to-previous">
        <i class="bi bi-arrow-left"></i>
    </a>

    <!-- Modal -->
    <div class="modal fade mt-5" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pelanggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Pelanggaran:</strong> <span id="pelanggaranDetail"></span></p>
                    <p><strong>Tingkat:</strong> <span id="tingkatDetail"></span></p>
                    <p><strong>Sanksi:</strong> <span id="sanksiDetail"></span></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
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

        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.style.left = sidebar.style.left === '0px' ? '-150px' : '0px';
        }

        // Event listener untuk tombol detail
        $('#detailModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button yang memicu modal
            var pelanggaran = button.data('pelanggaran'); // Ambil data pelanggaran
            var sanksi = button.data('sanksi'); // Ambil data sanksi
            var tingkat = button.data('tingkat'); // Ambil data sanksi

            var modal = $(this);
            modal.find('#pelanggaranDetail').text(pelanggaran);
            modal.find('#sanksiDetail').text(sanksi);
            modal.find('#tingkatDetail').text(tingkat);
        });
    </script>
</body>

</html>