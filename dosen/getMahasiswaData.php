<?php
require_once '../connection.php'; // Pastikan path menuju file connection.php benar

// Periksa apakah ada parameter NIM yang diterima
if (isset($_GET['nim'])) {
    $nim = trim($_GET['nim']);
    
    // Query untuk mengambil nama dan kelas berdasarkan NIM
    $sql = "SELECT m.nama, k.id_kelas, k.nama_kelas
            FROM mahasiswa m
            JOIN kelas k ON m.id_kelas = k.id_kelas
            WHERE m.nim = ?";
    
    $stmt = sqlsrv_query($conn, $sql, array($nim));

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Ambil data mahasiswa
    $data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    
    if ($data) {
        // Mengembalikan data sebagai JSON
        echo json_encode([
            'success' => true,
            'nama' => $data['nama'],
            'kelas' => $data['nama_kelas'],
            'kelas_id' => $data['id_kelas']
        ]);
    } else {
        // Jika NIM tidak ditemukan
        echo json_encode(['success' => false]);
    }
}
?>
