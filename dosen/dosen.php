<?php
session_start();

// Cek apakah session sudah ada dan apakah role adalah dosen
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 1002) {
    header("Location: ../login/login.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Dosen</title>
    <link rel="stylesheet" href="../homeStyle.css">
</head>
<body>
    <!-- Navbar di bagian atas -->
    <nav class="navbar">
        <a href="dosen.php" class="navbar-brand">Polinema</a>
        <ul class="navbar-menu">
            <li><a href="dosen.php">Home</a></li>
            <li><a href="#">Profil</a></li>
            <li><a href="#">Jadwal</a></li>
            <li><a href="#">Bantuan</a></li>
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

    <!-- Konten utama -->
    <main class="main-content">
        <section class="hero">
            <h1>Selamat Datang, Dosen!</h1>
            <p>Di Portal Akademik Polinema</p>
            <a href="#" class="hero-button">Explore Now</a>
        </section>
        <section class="content">
            <div class="content-box">
                <h2>Data Mahasiswa</h2>
                <p>Kelola informasi dan perkembangan mahasiswa di sini.</p>
                <a href="dataMahasiswa.php" class="content-link">Lihat Data</a>
            </div>
            <div class="content-box">
                <h2>Penilaian</h2>
                <p>Masukkan atau perbarui nilai mahasiswa dengan mudah.</p>
                <a href="Penilaian.html" class="content-link">Akses Penilaian</a>
            </div>
            <div class="content-box">
                <h2>Pelanggaran</h2>
                <p>Catat dan pantau pelanggaran yang terjadi.</p>
                <a href="Pelanggaran.html" class="content-link">Kelola Pelanggaran</a>
            </div>
        </section>
    </main>
</body>
</html>
