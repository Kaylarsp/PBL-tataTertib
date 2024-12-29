<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect ke halaman login
    exit();
}

// Ambil username dari sesi
$username = $_SESSION['username'];
?>

<style>
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 11;
        background: rgb(14, 11, 38);
        /* background: linear-gradient(90deg, rgba(14, 11, 38, 1) 6%, rgba(0, 31, 84, 1) 45%, rgba(165, 189, 236, 1) 96%); */
        background: linear-gradient(90deg, rgba(14, 11, 38, 1) 0%, rgba(0, 31, 84, 1) 50%, rgba(165, 191, 204, 1) 100%);
    }
</style>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-dongker navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dosen.php">
            <i class="bi bi-mortarboard-fill me-2"></i>TatibFlow
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Dropdown untuk Profil dan Logout -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" style="color: #001f54;" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-2" style="color: #001f54;"></i><?= htmlspecialchars($username); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <!-- <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2"></i>Profil</a></li> -->
                        <li><a class="dropdown-item" href="../login/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>