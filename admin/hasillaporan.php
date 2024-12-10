<?php
require_once '../connection.php';

// Mendapatkan ID laporan dari URL atau form
$id_laporan = isset($_GET['report_id']) ? $_GET['report_id'] : 0;

// Query untuk mengambil data laporan berdasarkan ID
$sql = "
    SELECT
        l.id_laporan,
        u.username AS nama_pelapor,
        m.nim,
        k.nama_kelas,
        d.nama AS dosen,
        p.nama_pelanggaran AS pelanggaran,
        t.tingkat,
        l.sanksi,
        l.deskripsi,
        up.statusSanksi
    FROM laporan l
    JOIN [user] u ON l.id_pelaku = u.id_user
    JOIN mahasiswa m ON u.id_user = m.id_user
    JOIN kelas k ON m.kelas = k.id_kelas
    JOIN dosen d ON k.id_kelas = d.id_kelas
    JOIN tingkat t ON l.id_tingkat = t.id_tingkat
    JOIN pelanggaran p ON t.id_tingkat = p.id_tingkat
    JOIN upload up ON m.id_mahasiswa = up.id_mahasiswa
    WHERE l.id_laporan = ? AND up.statusSanksi = 1
";

// Menyiapkan query untuk eksekusi
$params = array($id_laporan);
$stmt = sqlsrv_prepare($conn, $sql, $params);

// Eksekusi query
if( sqlsrv_execute($stmt) ) {
    $laporan = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
} else {
    die( print_r(sqlsrv_errors(), true));
}

// Menutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

// Jika data laporan tidak ditemukan
if (!$laporan) {
    die("Laporan tidak ditemukan.");
}

// Fungsi untuk mengunduh laporan
if (isset($_POST['unduh'])) {
    $laporanContent = "
Laporan Pelanggaran
------------------------------
Nama Pelapor: " . $laporan['nama_pelapor'] . "
NIM: " . $laporan['nim'] . "
Kelas: " . $laporan['nama_kelas'] . "
Dosen: " . $laporan['dosen'] . "
Pelanggaran: " . $laporan['pelanggaran'] . "
Deskripsi Pelanggaran: " . $laporan['deskripsi'] . "
Sanksi: " . $laporan['sanksi'] . "
";

    // Menyiapkan nama file unduhan
    $fileName = "laporan_pelanggaran_" . $id_laporan . ".txt";
    
    // Mengatur header untuk mengunduh file
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    echo $laporanContent;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Format Laporan Pelanggaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Latar belakang dan gaya umum */
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Judul halaman */
        h1 {
            text-align: center;
            margin: 20px 0;
            color: #333;
        }

        /* Desain laporan utama */
        .report-container {
            max-width: 800px;
            margin: 20px auto;
            border: 1px solid #333;
            border-radius: 8px;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        /* Logo pada kiri atas konten laporan */
        .report-logo {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 90px;
            height: auto;
        }

        /* Header laporan */
        .report-header {
            text-align: center;
            border-bottom: 2px solid #333;
            margin-bottom: 15px;
            padding-bottom: 10px;
            color: #555;
        }

        /* Bagian informasi utama laporan */
        .report-section {
            margin-bottom: 20px;
        }

        .report-section-title {
            font-weight: bold;
            color: #004080;
            margin-bottom: 10px;
        }

        /* Informasi tabel laporan */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table th,
        table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #333;
        }

        table th {
            background-color: #fffdfd;
            color: rgb(0, 0, 0);
        }

        /* Tempat untuk tanda tangan */
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 30%;
            border: 1px solid #333;
            height: 100px;
            text-align: center;
            line-height: 100px;
            color: #555;
            font-style: italic;
        }

        /* Tombol untuk aksi tambahan */
        .btn-custom {
            background-color: #004080;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #00264d;
        }

        /* Responsivitas */
        @media (max-width: 768px) {
            .report-container {
                padding: 10px;
            }

            h1 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>

    <!-- Container untuk laporan -->
    <div class="report-container">
        <!-- Logo pada pojok kiri atas konten laporan -->
        <img src="polinemalogo.jpg" alt="Logo" class="report-logo">

        <!-- Header Laporan -->
        <div class="report-header">
            <h2>Laporan Pelanggaran - Format Resmi</h2>
            <p>Tanggal: <?php echo date('d F Y'); ?></p>
        </div>

        <!-- Informasi Pelanggaran -->
        <div class="report-section">
            <p class="report-section-title">Identitas Pelanggar</p>
            <table>
                <tr>
                    <th>Nama</th>
                    <td><?php echo $laporan['nama_pelapor']; ?></td>
                </tr>
                <tr>
                    <th>NIM</th>
                    <td><?php echo $laporan['nim']; ?></td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td><?php echo $laporan['nama_kelas']; ?></td>
                </tr>
                <tr>
                    <th>Dosen</th>
                    <td><?php echo $laporan['dosen']; ?></td>
                </tr>
            </table>
        </div>

        <div class="report-section">
            <p class="report-section-title">Pelanggaran</p>
            <p style="text-align: justify;"><?php echo $laporan['pelanggaran']; ?></p>
            <p class="report-section-title">Deskripsi Pelanggaran</p>
            <p><?php echo $laporan['deskripsi']; ?></p>
        </div>

        <!-- Data Sanksi yang Diberikan -->
        <div class="report-section">
            <p class="report-section-title">Rincian Sanksi</p>
            <table>
                <tr>
                    <th>Sanksi</th>
                    <td><?php echo $laporan['sanksi']; ?></td>
                </tr>
            </table>
        </div>

        <!-- Tempat untuk Tanda Tangan -->
        <div class="signature-section">
            <div class="signature-box">Mahasiswa <br /> (Tanda Tangan)</div>
            <div class="signature-box">Dosen <br /> (Tanda Tangan)</div>
            <div class="signature-box">Admin <br /> (Tanda Tangan)</div>
        </div>

        <!-- Tombol Unduh Laporan -->
        <form method="post">
            <div class="text-center mt-3">
                <button type="submit" name="unduh" class="btn-custom">Unduh Laporan</button>
            </div>
        </form>
    </div>

</body>
</html>
