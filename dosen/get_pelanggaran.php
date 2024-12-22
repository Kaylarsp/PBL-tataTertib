<?php
header('Content-Type: application/json');
require_once '../connection.php';

// Query untuk mengambil data pelanggaran
$query = "SELECT id_pelanggaran, nama_pelanggaran FROM pelanggaran";
$stmt = sqlsrv_query($conn, $query);

if ($stmt === false) {
    die(json_encode(['error' => sqlsrv_errors()]));
}

$data = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

// Kirim data sebagai JSON
echo json_encode($data);
?>
