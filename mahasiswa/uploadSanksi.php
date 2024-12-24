<?php
session_start();
require_once '../connection.php'; // Koneksi database

if (!isset($_SESSION['id_user'])) {
    echo json_encode(['status' => 'error', 'message' => 'User tidak terautentikasi']);
    exit();
}

$id_user = $_SESSION['id_user']; // ID user yang login
$id_laporan = $_POST['id_laporan'] ?? null;

if (!$id_laporan || !isset($_FILES['sanksiFile'])) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    exit();
}

// Ambil id_mahasiswa berdasarkan id_user
$sqlMahasiswa = "SELECT id_mahasiswa FROM mahasiswa WHERE id_user = ?";
$paramsMahasiswa = [$id_user];
$stmtMahasiswa = sqlsrv_query($conn, $sqlMahasiswa, $paramsMahasiswa);

if ($stmtMahasiswa === false || !sqlsrv_has_rows($stmtMahasiswa)) {
    echo json_encode(['status' => 'error', 'message' => 'ID mahasiswa tidak ditemukan']);
    exit();
}

$rowMahasiswa = sqlsrv_fetch_array($stmtMahasiswa, SQLSRV_FETCH_ASSOC);
$id_mahasiswa = $rowMahasiswa['id_mahasiswa'];

// Proses upload file
$file = $_FILES['sanksiFile'];
$uploadDir = '../uploads/'; // Direktori penyimpanan file
$fileName = uniqid() . '-' . basename($file['name']);
$filePath = $uploadDir . $fileName;

if (move_uploaded_file($file['tmp_name'], $filePath)) {
    // Simpan ke tabel `upload`
    $sqlUpload = "INSERT INTO upload (lokasi_file, submit_time, id_mahasiswa, id_laporan)
                    VALUES (?, CURRENT_TIMESTAMP, ?, ?)";
    $paramsUpload = [$filePath, $id_mahasiswa, $id_laporan];
    $stmtUpload = sqlsrv_query($conn, $sqlUpload, $paramsUpload);

    if ($stmtUpload) {
        echo json_encode(['status' => 'success', 'message' => 'File berhasil diupload']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data ke database']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal mengupload file']);
}
