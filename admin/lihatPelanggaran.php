<?php
session_start();
require_once '../connection.php'; // Pastikan koneksi menggunakan `sqlsrv_connect`
// taks
// Pastikan sesi `id_user` aktif
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

$id_user = $_SESSION['id_user']; // Ambil ID user dari sesi

// Proses verifikasi atau penolakan jika ada request
if (isset($_GET['action']) && isset($_GET['id_laporan'])) {
    $id_laporan = $_GET['id_laporan'];

    if ($_GET['action'] == 'verify') {
        $verify_at = date("Y-m-d H:i:s");

        // Update kolom verify dan statusTolak
        $sql = "UPDATE laporan SET verify_by = ?, verify_at = ?, statusTolak = 1 WHERE id_laporan = ?";
        $params = [$id_user, $verify_at, $id_laporan];
    } elseif ($_GET['action'] == 'reject') {
        // Update kolom statusTolak
        $sql = "UPDATE laporan SET statusTolak = 2 WHERE id_laporan = ?";
        $params = [$id_laporan];
    }

    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        $message = "Error: " . print_r(sqlsrv_errors(), true);
    } else {
        $message = ($_GET['action'] == 'verify')
            ? "Laporan berhasil diverifikasi."
            : "Laporan berhasil ditolak.";
    }
}

// Query untuk mengambil data laporan
$sql = "
        SELECT
            l.id_laporan,
            l.id_tingkat,
            up.username AS nama_pelapor,
            ut.username AS nama_terlapor,
            m.nim AS nim_terlapor,
            p.nama_pelanggaran,
            t.tingkat,
            t.sanksi AS opsi_sanksi,
            l.bukti_filepath,
            l.verify_by,
            l.verify_at,
            l.statusTolak,
            d.nama AS dpa,
            k.nama_kelas AS kelas
        FROM laporan l
        JOIN tingkat t ON l.id_tingkat = t.id_tingkat
        JOIN [user] up ON l.id_pelapor = up.id_user
        JOIN [user] ut ON l.id_pelaku = ut.id_user
        JOIN mahasiswa m ON ut.id_user = m.id_user
        JOIN kelas k ON m.kelas = k.id_kelas
        JOIN dosen d ON k.id_kelas = d.id_kelas
        JOIN pelanggaran p ON l.id_pelanggaran = p.id_pelanggaran
";

$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die("Error: " . print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Pelanggaran</title>
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
            margin-top: 30px;
            max-height: calc(100vh - 150px);
            overflow-y: auto;
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

        .content-margin {
            margin-top: 30px;
        }

        .text-dongker {
            color: #001f54;
        }

        .modal-dialog {
            margin-top: 100px;
        }

        .custom-modal {
            margin-top: 150px;
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

    <div class="container content-margin">
        <div class="d-flex align-items-center justify-content-center">
            <div class="card cardContent shadow p-4" style="width: 90%;">
                <div class="text-center mb-4">
                    <h1 class="display-5 fw-bold text-dongker">Lihat Pelanggaran</h1>
                </div>
                <div class="card-body">
                    <?php if (isset($message)) : ?>
                        <div class="alert alert-info text-center">
                            <?= $message; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Tabel dengan ID "laporanTable" -->
                    <table id="laporanTable" class="table table-hover table-striped table-bordered text-center">
                        <thead class="bg-dongker text-white">
                            <tr>
                                <th>No</th>
                                <th>Pelapor</th>
                                <th>Terlapor</th>
                                <th>NIM</th>
                                <th>Kelas</th>
                                <th>DPA</th>
                                <th>Pelanggaran</th>
                                <th>Bukti</th>
                                <th>Sanksi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                echo "<tr>
                                <td>{$no}</td>
                                <td>" . htmlspecialchars($row['nama_pelapor']) . "</td>
                                <td>" . htmlspecialchars($row['nama_terlapor']) . "</td>
                                <td>" . htmlspecialchars($row['nim_terlapor']) . "</td>
                                <td>" . htmlspecialchars($row['kelas']) . "</td>
                                <td>" . htmlspecialchars($row['dpa']) . "</td>
                                <td>
                                    <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modal{$row['id_laporan']}'>Detail</button>
                                    <div class='modal fade' id='modal{$row['id_laporan']}' tabindex='-1' aria-labelledby='modalLabel{$row['id_laporan']}' aria-hidden='true'>
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
                                    </div>
                                </td>
                                <td>";
                                if (!empty($row['bukti_filepath'])) {
                                    echo "<button class='btn btn-primary btn-sm' onclick=\"window.open('" . htmlspecialchars($row['bukti_filepath']) . "', '_blank')\">Tinjau</button>";
                                } else {
                                    echo "<button class='btn btn-secondary btn-sm' disabled>Tidak Ada Bukti</button>";
                                }
                                echo "</td>
                                <td>
                                <select id='sanksiDropdown_{$row['id_laporan']}'
                                    data-id_laporan='{$row['id_laporan']}'
                                    data-id_tingkat='{$row['id_tingkat']}'
                                    class='form-select form-select-sm sanksiDropdown_{$no}'
                                    onchange='saveSanksi({$row['id_laporan']})'
                                    >
                                    <option value='' disabled selected>Pilih Sanksi</option>
                                </select>
                                </td>
                                <td>";
                                if ($row['statusTolak'] == 1) {
                                    echo "Terverifikasi";
                                } elseif ($row['statusTolak'] == 2) {
                                    echo "Ditolak";
                                } else {
                                    echo "
                                    <a href='?action=verify&id_laporan={$row['id_laporan']}' class='btn btn-success btn-sm w-100'>Verifikasi</a>
                                    <a href='?action=reject&id_laporan={$row['id_laporan']}' class='btn btn-danger btn-sm w-100' onclick=\"return confirm('Apakah Anda yakin ingin menolak laporan ini?')\">Tolak</a>";
                                }
                                echo "</td>
                                </tr>";
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Kembali ke Halaman Sebelumnya -->
    <a href="admin.php" class="btn-back-to-previous">
        <i class="bi bi-arrow-left"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            $('#laporanTable').DataTable({
                paging: true, // Aktifkan pagination
                searching: true, // Aktifkan pencarian
                ordering: true, // Aktifkan pengurutan
                responsive: true, // Responsif untuk perangkat kecil
                lengthMenu: [5, 10, 25, 50], // Pilihan jumlah data per halaman
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" // Bahasa Indonesia
                }
            });
        });

        $(() => {
            var no = "<?= $no ?>";

            for (i = 0; i <= no; i++) {
                let dropdown = $(`.sanksiDropdown_${i}`);

                if (dropdown.length > 0) { // Pastikan elemen dengan ID ini ada
                    let idTingkat = dropdown.data('id_tingkat');
                    let idLaporan = dropdown.data('id_laporan');

                    loadSanctions(idLaporan, idTingkat)
                }
            }
        })

        function loadSanctions(id_laporan, id_tingkat) {
            // Mendapatkan id_tingkat dari selectElement yang sedang dipilih
            // const id_tingkat = $(selectElement).data('id-tingkat'); // Mengambil id_tingkat dari selectElement yang dipilih

            // console.log("ID Tingkat:", id_tingkat); // Debug: Cek nilai ID Tingkat
            // console.log("ID Laporan:", id_laporan); // Debug: Cek ID Laporan

            // Pastikan id_tingkat valid sebelum mengirimkan request
            if (!id_tingkat) {
                alert("ID Tingkat tidak ditemukan.");
                return;
            }

            // Kirim AJAX request untuk mengambil sanksi berdasarkan id_tingkat
            $.ajax({
                url: "get_sanksi.php", // Ganti dengan URL file PHP yang menghandle permintaan sanksi
                method: "POST",
                data: {
                    id_tingkat: id_tingkat
                },
                success: function(data) {
                    // console.log("Data Sanksi:", data); // Debug: Cek data yang diterima
                    const sanksiDropdown = $(`#sanksiDropdown_${id_laporan}`);
                    sanksiDropdown.empty().append(`<option value='' disabled selected>Pilih Sanksi</option>`);
                    sanksiDropdown.append(data); // Menambahkan opsi sanksi ke dropdown
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error); // Debug: Lihat error
                    alert("Gagal memuat sanksi.");
                }
            });
        }

        function saveSanksi(idLaporan) {
            const selectedSanksi = $(`#sanksiDropdown_${idLaporan}`).val();

            if (!selectedSanksi) {
                alert("Pilih sanksi terlebih dahulu.");
                return;
            }

            // Kirim data ke server untuk disimpan
            $.ajax({
                url: "save_sanksi.php",
                method: "POST",
                data: {
                    id_laporan: idLaporan,
                    sanksi: selectedSanksi
                },
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.status === "success") {
                        alert(result.message);
                    } else {
                        alert(result.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    alert("Gagal menyimpan sanksi.");
                }
            });
        }
    </script>

    <?php
    if (isset($_POST['action']) && $_POST['action'] == 'get_sanksi') {
        $id_tingkat = $_POST['id_tingkat'];
        $sanctions = [];

        switch ($id_tingkat) {
            case 1:
                $sanctions = [
                    'Dinonaktifkan (Cuti Akademik/ Terminal) selama dua semester',
                    'Diberhentikan sebagai mahasiswa',
                ];
                break;
            case 2:
                $sanctions = [
                    'Dikenakan penggantian kerugian atau penggantian benda/barang semacamnya',
                    'Melakukan tugas layanan sosial dalam jangka waktu tertentu',
                    'Diberikan nilai D pada mata kuliah terkait saat melakukan pelanggaran',
                ];
                break;
            case 3:
                $sanctions = [
                    'Membuat surat pernyataan tidak mengulangi perbuatan tersebut, dibubuhi materai',
                    'Melakukan tugas khusus seperti bertanggungjawab memperbaiki/ membersihkan kembali',
                ];
                break;
            case 4:
                $sanctions = [
                    'Teguran tertulis disertai surat pernyataan tidak mengulangi perbuatan, dibubuhi materai',
                ];
                break;
            case 5:
                $sanctions = [
                    'Teguran lisan disertai surat pernyataan tidak mengulangi perbuatan, dibubuhi materai',
                ];
                break;
            default:
                $sanctions = [];
        }

        // Kembalikan sanksi sebagai HTML <option> untuk dropdown
        foreach ($sanctions as $sanction) {
            echo "<option value='$sanction'>$sanction</option>";
        }

        exit; // Pastikan tidak ada output tambahan
    }
    ?>
</body>

</html>