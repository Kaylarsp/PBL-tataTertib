<?php
session_start();

// Cek apakah session sudah ada dan apakah role adalah dosen
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 1003) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Staff</title>
    <link rel="stylesheet" href="homeStyle.css">
</head>
<body>
    <!-- Navbar di bagian atas -->
    <nav class="navbar">
        <a href="staff.php" class="navbar-brand">Polinema</a>
        <ul class="navbar-menu">
            <li><a href="staff.php">Home</a></li>
            <li><a href="#">Profil</a></li>
            <li><a href="#">Bantuan</a></li>
        </ul>
    </nav>

    <!-- Sidebar di bagian kiri -->
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="staff.php">Dashboard</a></li>
            <li><a href="DataMahasiswa.html">Data Mahasiswa</a></li>
            <li><a href="Penjadwalan.html">Penjadwalan</a></li>
            <li><a href="Laporan.html">Laporan</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </aside>

    <!-- Konten utama -->
    <main class="main-content">
        <section class="hero">
            <h1>Selamat Datang, Staff!</h1>
            <p>Di Portal Akademik Polinema</p>
            <a href="#" class="hero-button">Explore Now</a>
        </section>
        <section class="content">
            <div class="content-box">
                <h2>Data Mahasiswa</h2>
                <p>Kelola informasi dan data perkembangan mahasiswa di sini.</p>
                <a href="DataMahasiswa.html" class="content-link">Lihat Data</a>
            </div>
            <div class="content-box">
                <h2>Penjadwalan</h2>
                <p>Atur dan kelola jadwal kegiatan akademik di sini.</p>
                <a href="Penjadwalan.html" class="content-link">Akses Penjadwalan</a>
            </div>
            <div class="content-box">
                <h2>Laporan</h2>
                <p>Periksa dan buat laporan administrasi kegiatan akademik.</p>
                <a href="Laporan.html" class="content-link">Lihat Laporan</a>
            </div>
        </section>
    </main>
</body>
</html>
