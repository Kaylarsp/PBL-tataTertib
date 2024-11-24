<?php
// Memanggil koneksi
require_once '../connection.php';

// Query untuk mengambil data mahasiswa
$sql = "
    SELECT m.nama, m.nim, k.nama_kelas, m.status_akademik
    FROM mahasiswa AS m
    INNER JOIN kelas AS k ON m.kelas = k.id_kelas
";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        <?php include 'style.css'; // File CSS yang berisi kode CSS Anda ?>
    </style>
</head>

<body>
    <!-- Navbar di bagian atas -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a href="dosen.php" class="navbar-brand">Polinema</a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a href="dosen.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Profil</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Jadwal</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Bantuan</a></li>
        </ul>
    </nav>

    <!-- Sidebar di bagian kiri -->
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="dosen.php">Dashboard</a></li>
            <li><a href="dataMahasiswa.php">Data Mahasiswa</a></li>
            <li><a href="Penilaian.html">Penilaian</a></li>
            <li><a href="Pelanggaran.html">Pelanggaran</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </aside>

    <div class="main-content">
        <h1>Data Mahasiswa</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Kelas</th>
                        <th>Status Akademik</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td>" . $row['nim'] . "</td>";
                        echo "<td>" . $row['nama_kelas'] . "</td>";
                        echo "<td>" . $row['status_akademik'] . "</td>";
                        echo "</tr>";
                    }

                    // Jika tidak ada data
                    if ($no === 1) {
                        echo "<tr><td colspan='5'>Tidak ada data mahasiswa</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Link ke Bootstrap JS dan dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

