<?php
$serverName = "LAPTOP-CCV6QK6I";

$connectionInfo = array("Database"=>"PBL");
$conn = sqlsrv_connect($serverName, $connectionInfo);

// if ($conn) {
//     echo "Koneksi berhasil.<br />";
//     } else {
//     echo "Koneksi Gagal";
//     die(print_r(sqlsrv_errors(), true));
// }