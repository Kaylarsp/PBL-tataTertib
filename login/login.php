<?php
session_start();
include '../connection.php'; // Include koneksi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mendapatkan data pengguna termasuk role
    $query = "SELECT * FROM [user] WHERE username = ?";
    $params = array($username);
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Validasi data pengguna
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Cek apakah password cocok
        if ($password == $row['password']) {
            // Jika login berhasil, simpan username dan role di session
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Arahkan pengguna berdasarkan role
            if ($row['role'] == 1001) {
                header("Location: admin.php");
            } elseif ($row['role'] == 1002) {
                header("Location: ../dosen/dosen.php");
            } elseif ($row['role'] == 1003) {
                header("Location: staff.php");
            } elseif ($row['role'] == 1004) {
                header("Location: mahasiswa.php");
            }
            exit; // Menghentikan eksekusi script setelah redirect
        } else {
            // Jika password salah
            $error = "Password salah!";
        }
    } else {
        // Jika username tidak ditemukan
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="loginStyle.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a class="navbar-brand">Polinema</a>
        <ul class="navbar-menu">
            <li>Login Page</li>
        </ul>
    </nav>

    <!-- Kontainer Login -->
    <div class="login-container">
        <h2>Login</h2>
        <!-- Form Login -->
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <?php
            // Tampilkan pesan error jika ada
            if (isset($error)) {
                echo "<p style='color: red;'>$error</p>";
            }
            ?>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
