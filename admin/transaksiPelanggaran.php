<?php
// Memanggil koneksi database
require_once '../connection.php'; // Pastikan koneksi menggunakan `sqlsrv_connect`

// Proses verifikasi jika ada request verifikasi
if (isset($_GET['action']) && $_GET['action'] == 'verify' && isset($_GET['id_laporan'])) {
    $id_laporan = $_GET['id_laporan'];
    $admin_id = 1; // Ganti dengan ID admin yang sedang login
    $verify_at = date("Y-m-d H:i:s");

    // Menggunakan prepared statement untuk update
    $sql = "UPDATE laporan SET verify_by = ?, verify_at = ? WHERE id_laporan = ?";
    $params = [$admin_id, $verify_at, $id_laporan];

    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        $message = "Error: " . print_r(sqlsrv_errors(), true);
    } else {
        $message = "Laporan berhasil diverifikasi.";
    }
}

// Query untuk mengambil data laporan
$sql = "SELECT
            l.id_laporan,
            t.tingkat,
            up.username AS nama_pelapor,
            ut.username AS nama_terlapor,
            m.nim AS nim_terlapor,
            p.nama_pelanggaran,
            l.verify_by,
            l.verify_at
        FROM laporan l
        JOIN tingkat t ON l.id_tingkat = t.id_tingkat
        JOIN [user] up ON l.id_pelapor = up.id_user
        JOIN [user] ut ON l.id_pelaku = ut.id_user
        JOIN mahasiswa m ON ut.id_user = m.id_user
        JOIN pelanggaran p ON l.id_pelanggaran = p.id_pelanggaran";

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
    <title>Riwayat Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body class="bg-light">
    <div class="container mt-4">
        <h1 class="text-center">Riwayat Laporan</h1>

        <?php if (isset($message)) : ?>
            <div class="alert alert-info text-center">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <table class="table table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Tingkat</th>
                    <th>Pelapor</th>
                    <th>Terlapor</th>
                    <th>NIM Terlapor</th>
                    <th>Pelanggaran</th>
                    <th>Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>
                <td>{$no}</td>
                <td>{$row['tingkat']}</td>
                <td>{$row['pelapor']}</td>
                <td>{$row['pelaku']}</td>
                <td>{$row['nim']}</td>
                <td>{$row['nama_pelanggaran']}</td>
                <td>";
                    if ($row['verify_by'] && $row['verify_at']) {
                        echo "Verified by {$row['verify_by']} at {$row['verify_at']}";
                    } else {
                        echo "<a href='?action=verify&id_laporan={$row['id_laporan']}' class='btn btn-success btn-sm'>Verifikasi</a>";
                    }
                    echo "</td>
            </tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>