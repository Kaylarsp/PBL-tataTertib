<?php
// Memanggil koneksi database
require_once '../connection.php';

// Ambil data dari form
$nama_pelaku = $_POST['nama_pelaku'];
$id_kelas = $_POST['kelas'];
$id_pelanggaran = $_POST['pelanggaran'];
$deskripsi = $_POST['deskripsi'];

// Query untuk mencari ID pelaku berdasarkan nama
$sql_pelaku = "SELECT id_user FROM [user] WHERE username = ?";
$stmt_pelaku = sqlsrv_query($conn, $sql_pelaku, array($nama_pelaku));

// Cek jika query berhasil dan jika ada hasil
if ($stmt_pelaku === false) {
    die(print_r(sqlsrv_errors(), true));
}

$pelaku = sqlsrv_fetch_array($stmt_pelaku, SQLSRV_FETCH_ASSOC);

if (!$pelaku) {
    die("Pelaku tidak ditemukan");
}

$id_pelaku = $pelaku['id_user'];

// Ambil ID pelapor dari session atau sumber lain
session_start();
$id_pelapor = $_SESSION['id_user'];  // Pastikan ID pelapor sudah ada di session

// Query untuk memasukkan laporan ke tabel laporan
$sql_laporan = "INSERT INTO laporan (id_tingkat, id_pelapor, id_pelaku, id_pelanggaran, deskripsi)
                VALUES (?, ?, ?, ?, ?)";
$stmt_laporan = sqlsrv_query($conn, $sql_laporan, array($id_kelas, $id_pelapor, $id_pelaku, $id_pelanggaran, $deskripsi));

// Cek jika query berhasil
if ($stmt_laporan === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    echo "Laporan berhasil dikirim!";
    // Redirect atau tampilkan pesan sukses
    // header("Location: laporanPelanggaran.php");  // Anda bisa mengarahkan ke halaman lain
}
?>
