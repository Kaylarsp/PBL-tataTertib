<?php
require_once '../connection.php'; // Pastikan path menuju file connection.php benar

session_start();
if (!isset($_SESSION['id_user'])) {
    die("Anda harus login untuk melaporkan pelanggaran.");
}

// Periksa apakah data dikirim dengan metode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Metode tidak valid.");
}

// Ambil data dari form secara aman
$nim_pelaku = isset($_POST['nim_pelaku']) ? trim($_POST['nim_pelaku']) : null;
$id_pelanggaran = isset($_POST['pelanggaran']) ? trim($_POST['pelanggaran']) : null;
$deskripsi = isset($_POST['deskripsi']) ? trim($_POST['deskripsi']) : null;

// Validasi data yang diterima
if (empty($nim_pelaku) || empty($id_pelanggaran) || empty($deskripsi)) {
    die("Semua data wajib diisi.");
}

// Query untuk mencari ID pelaku berdasarkan nama
$sql_pelaku = "SELECT id_user FROM mahasiswa WHERE nim = ?";
$stmt_pelaku = sqlsrv_query($conn, $sql_pelaku, array($nim_pelaku));

// Cek jika query berhasil dan jika ada hasil
if ($stmt_pelaku === false) {
    die(print_r(sqlsrv_errors(), true));
}

$pelaku = sqlsrv_fetch_array($stmt_pelaku, SQLSRV_FETCH_ASSOC);

if (!$pelaku) {
    die("Pelaku tidak ditemukan.");
}

$id_pelaku = $pelaku['id_user'];

// Ambil ID tingkat berdasarkan pelanggaran
$sql_tingkat = "SELECT id_tingkat FROM pelanggaran WHERE id_pelanggaran = ?";
$stmt_tingkat = sqlsrv_query($conn, $sql_tingkat, array($id_pelanggaran));

if ($stmt_tingkat === false) {
    die(print_r(sqlsrv_errors(), true));
}

$tingkat = sqlsrv_fetch_array($stmt_tingkat, SQLSRV_FETCH_ASSOC);

if (!$tingkat) {
    die("Tingkat pelanggaran tidak ditemukan.");
}

$id_tingkat = $tingkat['id_tingkat'];

// Tangani file upload dengan aman
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = "../uploads/";
    $file_name = basename($_FILES['image']['name']);
    $target_file = $upload_dir . $file_name;

    // Validasi ukuran file
    if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
        die("Ukuran file terlalu besar. Maksimal 2MB.");
    }

    // Validasi tipe file
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['image']['type'], $allowed_types)) {
        die("Format file tidak didukung. Hanya JPEG, PNG, dan GIF yang diperbolehkan.");
    }

    // Pindahkan file ke folder tujuan
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $bukti_filepath = $target_file; // Simpan path untuk ke database
    } else {
        die("Gagal mengunggah file.");
    }
} else {
    die("File upload wajib diisi.");
}

// Ambil ID pelapor dari session
$id_pelapor = $_SESSION['id_user'];

// Masukkan data ke database
$sql_laporan = "INSERT INTO laporan (id_tingkat, id_pelapor, id_pelaku, id_pelanggaran, deskripsi, bukti_filepath)
                VALUES (?, ?, ?, ?, ?, ?)";
$params = [$id_tingkat, $id_pelapor, $id_pelaku, $id_pelanggaran, $deskripsi, $bukti_filepath];
$stmt = sqlsrv_query($conn, $sql_laporan, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Redirect setelah berhasil
echo "Laporan berhasil dibuat";
exit();
?>
