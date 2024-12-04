<?php
// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect ke halaman login
    exit();
}
?>