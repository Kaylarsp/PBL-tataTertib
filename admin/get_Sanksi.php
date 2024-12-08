<?php
// Pastikan koneksi sudah benar
require_once '../connection.php';

// Pastikan data id_tingkat diterima dengan benar
if (isset($_POST['id_tingkat'])) {
    $id_tingkat = $_POST['id_tingkat'];
    $sanctions = [];

    // Tentukan sanksi berdasarkan id_tingkat
    switch ($id_tingkat) {
        case 1:
            $sanctions = [
                'Dinonaktifkan (Cuti Akademik/ Terminal) selama dua semester',
                'Diberhentikan sebagai mahasiswa',
            ];
            break;
        case 2:
            $sanctions = [
                'Dikenakan penggantian kerugian atau penggantian benda/barang semacamnya',
                'Melakukan tugas layanan sosial dalam jangka waktu tertentu',
                'Diberikan nilai D pada mata kuliah terkait saat melakukan pelanggaran',
            ];
            break;
        case 3:
            $sanctions = [
                'Membuat surat pernyataan tidak mengulangi perbuatan tersebut, dibubuhi materai',
                'Melakukan tugas khusus seperti bertanggungjawab memperbaiki/ membersihkan kembali',
            ];
            break;
        case 4:
            $sanctions = [
                'Teguran tertulis disertai surat pernyataan tidak mengulangi perbuatan, dibubuhi materai',
            ];
            break;
        case 5:
            $sanctions = [
                'Teguran lisan disertai surat pernyataan tidak mengulangi perbuatan, dibubuhi materai',
            ];
            break;
        default:
            $sanctions = [];
    }

    // Kembalikan data sanksi sebagai option dalam format HTML
    foreach ($sanctions as $sanction) {
        echo "<option value='$sanction'>$sanction</option>";
    }
}
?>
