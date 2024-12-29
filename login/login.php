<?php
session_start();
include '../connection.php'; // Include koneksi

// Kelas User untuk menangani login
class User
{
    private $conn; //enkapsuplasi

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public function login($username, $password)
    {
        $query = "SELECT * FROM [user] WHERE username = ?";
        $params = array($username);
        $stmt = sqlsrv_query($this->conn, $query, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if ($password == $row['password']) {
                $_SESSION['id_user'] = $row['id_user'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'];

                return array(
                    'status' => 'success',
                    'role' => $row['role']
                );
            } else {
                return array('status' => 'error', 'message' => 'Password salah!');
            }
        } else {
            return array('status' => 'error', 'message' => 'Username tidak ditemukan!');
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User($conn);
    $response = $user->login($username, $password);

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
        body {
            background-image: url('backgroundLogin1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Overlay untuk background */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(14, 11, 38, 0.8);
            /* Overlay warna */
            z-index: -1;
            /* Overlay di belakang konten */
        }

        .bg-dongker {
            /* background-color: #001f54 !important; */
            background: rgb(14, 11, 38);
            background: linear-gradient(90deg, rgba(14, 11, 38, 1) 0%, rgba(0, 31, 84, 1) 50%, rgba(165, 191, 204, 1) 100%);
        }

        .bg {
            background: rgb(14, 11, 38);
            background: linear-gradient(125deg, rgba(14, 11, 38, 1) 0%, rgba(0, 31, 84, 1) 50%, rgba(79, 103, 143, 1) 99%);
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
    <!-- Kontainer Login -->
    <div class="card card-login" style="margin-top: 150px;">
        <div class="card-body">
            <h1 class="bi bi-mortarboard-fill me-2 fw-bold text-center">TatibFlow</h1>
            <p class="text-center mb-4">Selamat Datang, Silahkan Login</p>
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
                <button type="submit" class="btn btn-primary w-100 bg">Login</button>
            </form>
        </div>
    </div>

    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(event) {
                event.preventDefault();

                var username = $('#username').val();
                var password = $('#password').val();

                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                        username: username,
                        password: password
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            if (response.role == 1) {
                                window.location.href = '../admin/admin.php';
                            } else if (response.role == 2) {
                                window.location.href = '../dosen/dosen.php';
                            } else if (response.role == 3) {
                                window.location.href = '../staff/staff.php';
                            } else if (response.role == 4) {
                                window.location.href = '../mahasiswa/mahasiswa.php';
                            }
                        } else {
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