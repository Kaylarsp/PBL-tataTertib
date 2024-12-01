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
        if ($password == $row['password']) {
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            $response = array(
                'status' => 'success',
                'role' => $row['role']
            );
        } else {
            $response = array('status' => 'error', 'message' => 'Password salah!');
        }
    } else {
        $response = array('status' => 'error', 'message' => 'Username tidak ditemukan!');
    }

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
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .bg-dongker {
            background-color: #001f54 !important;
        }

        .card-login {
            max-width: 400px;
            margin: 100px auto;
            border-radius: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #001f54;
            border: none;
        }

        .btn-primary:hover {
            background-color: #003080;
        }

        #errorMessage {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar bg-dongker navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="bi bi-mortarboard-fill me-2"></i>Polinema
            </a>
        </div>
    </nav>

    <!-- Kontainer Login -->
    <div class="card card-login">
        <div class="card-body">
            <h2 class="text-center mb-4 fw-bold">Login</h2>
            <form id="loginForm">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div id="errorMessage"></div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>

    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#loginForm').submit(function (event) {
                event.preventDefault();

                var username = $('#username').val();
                var password = $('#password').val();

                $.ajax({
                    url: '',
                    type: 'POST',
                    data: { username: username, password: password },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            if (response.role == 1001) {
                                window.location.href = '../admin/admin.php';
                            } else if (response.role == 1002) {
                                window.location.href = '../dosen/dosen.php';
                            } else if (response.role == 1003) {
                                window.location.href = '../staff/staff.php';
                            } else if (response.role == 1004) {
                                window.location.href = '../mahasiswa/mahasiswa.php';
                            }
                        } else {
                            $('#errorMessage').text(response.message);
                        }
                    },
                    error: function () {
                        $('#errorMessage').text('Terjadi kesalahan, coba lagi!');
                    }
                });
            });
        });
    </script>
</body>

</html>
