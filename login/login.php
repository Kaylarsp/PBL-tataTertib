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

            // Mengirim respons JSON dengan redirect URL sesuai role
            $response = array(
                'status' => 'success',
                'role' => $row['role']
            );
        } else {
            // Jika password salah
            $response = array('status' => 'error', 'message' => 'Password salah!');
        }
    } else {
        // Jika username tidak ditemukan
        $response = array('status' => 'error', 'message' => 'Username tidak ditemukan!');
    }

    // Mengirim respons JSON
    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="loginStyle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Menambahkan jQuery -->
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
        <form id="loginForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div id="errorMessage" style="color: red;"></div> <!-- Menampilkan error di sini -->
            <button type="submit">Login</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(event) {
                event.preventDefault(); // Mencegah form submit default

                var username = $('#username').val();
                var password = $('#password').val();

                $.ajax({
                    url: '', // Mengirim ke halaman yang sama
                    type: 'POST',
                    data: {
                        username: username,
                        password: password
                    },
                    dataType: 'json', // Mengambil respons dalam format JSON
                    success: function(response) {
                        if (response.status === 'success') {
                            // Redirect berdasarkan role
                            if (response.role == 1001) {
                                window.location.href = 'admin.php';
                            } else if (response.role == 1002) {
                                window.location.href = '../dosen/dosen.php';
                            } else if (response.role == 1003) {
                                window.location.href = 'staff.php';
                            } else if (response.role == 1004) {
                                window.location.href = 'mahasiswa.php';
                            }
                        } else {
                            // Menampilkan pesan error
                            $('#errorMessage').text(response.message);
                        }
                    },
                    error: function() {
                        $('#errorMessage').text('Terjadi kesalahan, coba lagi!');
                    }
                });
            });
        });
    </script>
</body>
</html>
