<?php
// Konfigurasi koneksi ke database
$serverName = "LAPTOP-2R5AJL0O"; // Ganti dengan nama server Anda
$connectionOptions = [
    "Database" => "tatib", // Nama database Anda
];
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Periksa koneksi
if ($conn === false) {
    die(json_encode(['status' => 'error', 'message' => 'Koneksi ke database gagal.']));
}

// Proses data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = htmlspecialchars($_POST['nama']);
    $nim = htmlspecialchars($_POST['nim']);
    $id_pelanggaran = htmlspecialchars($_POST['pelanggaran']);

    // Proses upload file
    if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['bukti']['tmp_name'];
        $fileName = $_FILES['bukti']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Validasi tipe file
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo json_encode(['status' => 'error', 'message' => 'Tipe file tidak diizinkan.']);
            exit;
        }

        // Tentukan folder tujuan penyimpanan file
        $uploadFolder = 'uploads/';
        if (!is_dir($uploadFolder)) {
            mkdir($uploadFolder, 0777, true);
        }

        // Buat nama file unik
        $newFileName = uniqid('bukti_', true) . '.' . $fileExtension;
        $destinationPath = $uploadFolder . $newFileName;

        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($fileTmpPath, $destinationPath)) {
            // Simpan informasi ke database
            $uploadTime = date('Y-m-d H:i:s');
            $sql = "INSERT INTO dbo.upload (nama_file, lokasi_file, waktu) VALUES (?, ?, ?)";
            $params = [$fileName, $destinationPath, $uploadTime];
            $stmt = sqlsrv_query($conn, $sql, $params);

            if ($stmt === false) {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan ke database.']);
            } else {
                echo json_encode(['status' => 'success', 'message' => 'File berhasil diunggah dan data disimpan.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat memindahkan file.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengunggah file.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode pengiriman tidak valid.']);
}

// Tutup koneksi
sqlsrv_close($conn);
