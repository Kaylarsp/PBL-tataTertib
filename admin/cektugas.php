<?php
require_once '../connection.php'; // Pastikan koneksi menggunakan `sqlsrv_connect`


?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Tugas Mahasiswa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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

            <!-- Konten Utama -->
            <main class="col-md-10 ms-sm-auto px-md-4 custom-margin-top custom-margin-top d-flex justify-content-center align-items-center">
                <div class="pt-4">
                    <div class="card shadow" style="margin-right: 150px;">
                        <div class="card-header text-center">
                            <h1 class="display-5 fw-bold mt-3">Cek Tugas Mahasiswa</h1>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Nim</th>
                                        <th>Kelas</th>
                                        <th>Pelanggaran</th>
                                        <th>File Tugas</th>
                                        <th>Waktu Upload</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "
                                    SELECT
                                        u.id_upload,
                                        m.nama,
                                        m.nim,
                                        k.nama_kelas,
                                        u.lokasi_file,
                                        u.submit_time,
                                        p.nama_pelanggaran,
                                        l.id_laporan,
                                        t.tingkat,
                                        u.statusSanksi,
                                        u.alasanTolak,
                                        l.sanksi
                                    FROM upload u
                                    JOIN mahasiswa m ON u.id_mahasiswa = m.id_mahasiswa
                                    JOIN kelas k ON m.kelas = k.id_kelas
                                    JOIN laporan l ON u.id_laporan = l.id_laporan
                                    JOIN pelanggaran p ON l.id_pelanggaran = p.id_pelanggaran
                                    JOIN tingkat t ON p.id_tingkat = t.id_tingkat
                                    WHERE u.statusSanksi IS NULL;
                                    ";
                                    $stmt = sqlsrv_query($conn, $sql);

                                    if ($stmt === false) {
                                        die(print_r(sqlsrv_errors(), true));
                                    }

                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['nama_kelas']) . "</td>";

                                        // Kolom Pelanggaran
                                        echo "<td class='text-center'>";
                                        echo "<button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modal{$row['id_laporan']}'>Detail</button>";

                                        // Modal untuk Detail Pelanggaran
                                        echo "<div class='modal fade mt-5' id='modal{$row['id_laporan']}' tabindex='-1' aria-labelledby='modalLabel{$row['id_laporan']}' aria-hidden='true'>
                                                <div class='modal-dialog custom-modal'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <h5 class='modal-title' id='modalLabel{$row['id_laporan']}'>Detail Pelanggaran</h5>
                                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <p><strong>Nama Pelanggaran:</strong> " . htmlspecialchars($row['nama_pelanggaran']) . "</p>
                                                            <p><strong>Tingkat:</strong> " . htmlspecialchars($row['tingkat']) . "</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";
                                        echo "</td>";

                                        // Kolom File Tugas
                                        echo "<td class='text-center'>";
                                        if (!empty($row['lokasi_file'])) {
                                            echo "<button class='btn btn-primary btn-sm' onclick=\"window.open('" . htmlspecialchars($row['lokasi_file']) . "', '_blank')\">Tinjau</button>";
                                        } else {
                                            echo "<button class='btn btn-secondary btn-sm' disabled>Tidak Ada Bukti</button>";
                                        }
                                        echo "</td>";

                                        // Kolom Waktu Submit
                                        echo "<td>" . ($row['submit_time'] ? $row['submit_time']->format('Y-m-d H:i:s') : '-') . "</td>";

                                        // Kolom Aksi
                                        echo "<td>
                                                <a href='" . htmlspecialchars($row['lokasi_file']) . "' class='btn btn-sm btn-primary' download>
                                                    <i class='bi bi-download'></i> Download
                                                </a>
                                                <button class='btn btn-sm btn-success' onclick='verifikasiTugas(" . (int)$row['id_upload'] . ")'>
                                                    <i class='bi bi-check-circle'></i> Verifikasi
                                                </button>
                                                <button class='btn btn-sm btn-danger' onclick='tolakTugas(" . (int)$row['id_upload'] . ")'>
                                                    <i class='bi bi-x-circle'></i> Tolak
                                                </button>
                                            </td>";
                                        echo "</tr>";
                                    }

                                    sqlsrv_free_stmt($stmt);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Tombol Kembali ke Halaman Sebelumnya -->
    <a href="admin.php" class="btn-back-to-previous">
        <i class="bi bi-arrow-left"></i>
    </a>

    <!-- Link Bootstrap JS dan Icon -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script>
        function verifikasiTugas(id) {
            if (confirm("Apakah Anda yakin ingin memverifikasi tugas ini?")) {
                alert("Tugas dengan ID " + id + " berhasil diverifikasi.");
            }
        }

        function tolakTugas(id) {
            if (confirm("Apakah Anda yakin ingin menolak tugas ini?")) {
                alert("Tugas dengan ID " + id + " ditolak.");
            }
        }

        function verifikasiTugas(id) {
            if (confirm("Apakah Anda yakin ingin memverifikasi tugas ini?")) {
                updateStatusSanksi(id, 1); // 1 untuk verifikasi
            }
        }

        function tolakTugas(id) {
            if (confirm("Apakah Anda yakin ingin menolak tugas ini?")) {
                updateStatusSanksi(id, 2); // 2 untuk tolak
            }
        }

        function updateStatusSanksi(id, status) {
            fetch('update_status_sanksi.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id_upload=${id}&status_sanksi=${status}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload(); // Reload halaman setelah berhasil
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Terjadi kesalahan. Silakan coba lagi.");
                });
        }

        let idUploadTolak = 0;

        function tolakTugas(id) {
            idUploadTolak = id;
            document.getElementById("idTugasTolak").value = id; // Set ID di modal
            document.getElementById("alasanTolak").value = ""; // Kosongkan alasan sebelumnya
            const modalTolakTugas = new bootstrap.Modal(document.getElementById("modalTolakTugas"));
            modalTolakTugas.show(); // Tampilkan modal
        }

        function submitTolakTugas() {
            const alasan = document.getElementById("alasanTolak").value.trim();
            if (alasan === "") {
                alert("Alasan penolakan harus diisi.");
                return;
            }

            fetch('update_status_sanksi.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id_upload=${idUploadTolak}&status_sanksi=2&alasan_tolak=${encodeURIComponent(alasan)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload(); // Reload halaman setelah berhasil
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Terjadi kesalahan. Silakan coba lagi.");
                });
        }
    </script>

    <!-- Modal untuk Alasan Penolakan -->
    <div class="modal fade mt-5" id="modalTolakTugas" tabindex="-1" aria-labelledby="modalTolakTugasLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTolakTugasLabel">Tolak Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTolakTugas">
                        <div class="mb-3">
                            <label for="alasanTolak" class="form-label">Alasan Penolakan</label>
                            <textarea id="alasanTolak" class="form-control" rows="4" required></textarea>
                        </div>
                        <input type="hidden" id="idTugasTolak">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" onclick="submitTolakTugas()">Tolak</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>