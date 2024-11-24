<?php

// Query untuk mengambil data mahasiswa
$sql = "SELECT * FROM mahasiswa";
// $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <style>
        <?php include 'style.css'; // File CSS yang berisi kode CSS Anda ?>
    </style>
</head>
<body>
    <div class="navbar">
        <a href="#" class="navbar-brand">Sistem Informasi Mahasiswa</a>
        <ul class="navbar-menu">
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </div>

    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Mahasiswa</a></li>
            <li><a href="#">Dosen</a></li>
            <li><a href="#">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Data Mahasiswa</h1>
        <table border="1" cellspacing="0" cellpadding="10" style="width: 100%; text-align: left; margin-top: 20px; background: rgba(255, 255, 255, 0.8);">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Jurusan</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td>" . $row['nim'] . "</td>";
                        echo "<td>" . $row['jurusan'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data mahasiswa</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
