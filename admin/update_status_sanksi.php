<?php
require_once '../connection.php'; // Pastikan koneksi sudah benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_upload = isset($_POST['id_upload']) ? intval($_POST['id_upload']) : 0;
    $status_sanksi = isset($_POST['status_sanksi']) ? intval($_POST['status_sanksi']) : 0;
    $alasan_tolak = isset($_POST['alasan_tolak']) ? trim($_POST['alasan_tolak']) : null;

    if ($id_upload > 0 && ($status_sanksi === 1 || $status_sanksi === 2)) {
        if ($status_sanksi === 2 && empty($alasan_tolak)) {
            echo json_encode(['success' => false, 'message' => 'Alasan penolakan harus diisi.']);
            exit;
        }

        $sql = "UPDATE upload SET statusSanksi = ?, alasanTolak = ? WHERE id_upload = ?";
        $params = [$status_sanksi, $alasan_tolak, $id_upload];
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt) {
            echo json_encode(['success' => true, 'message' => 'Status berhasil diperbarui.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal memperbarui status.']);
        }
        sqlsrv_free_stmt($stmt);
    } else {
        echo json_encode(['success' => false, 'message' => 'Parameter tidak valid.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Metode tidak valid.']);
}
