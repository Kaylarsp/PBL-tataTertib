<?php
session_start();
require_once '../connection.php';

// Pastikan sesi pengguna aktif
if (!isset($_SESSION['id_user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Sesi berakhir. Silakan login ulang.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_laporan = $_POST['id_laporan'] ?? null;
    $sanksi = $_POST['sanksi'] ?? null;

    // Validasi input
    if (!$id_laporan || !$sanksi) {
        echo json_encode(['status' => 'error', 'message' => 'ID laporan atau sanksi tidak valid.']);
        exit();
    }

    // Query untuk menyimpan sanksi ke tabel laporan
    $sql = "UPDATE laporan SET sanksi = ? WHERE id_laporan = ?";
    $params = [$sanksi, $id_laporan];
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan sanksi.']);
    } else {
        echo json_encode(['status' => 'success', 'message' => 'Sanksi berhasil disimpan.']);
    }
}
