<?php
ob_start();
session_start();
include 'database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['username']); // nama input form
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header("Location: admin/dashboard_admin.php");
                } else {
                    header("Location: beranda.php");
                }
                exit();
            } else {
                echo "<script>alert('Password salah'); window.location.href='login2.php';</script>";
            }
        } else {
            echo "<script>alert('Email tidak ditemukan'); window.location.href='login2.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Email dan Password harus diisi'); window.location.href='login2.php';</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: rgb(28, 79, 45);
            color: whitesmoke;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 400px;
        }
        .login-container h2 {
            color: brown;
            margin-bottom: 20px;
        }
        .form-control {
            border: 2px solid #d3bbbb;
            border-radius: 6px;
        }
        .btn-login {
            background:rgb(81, 121, 91);
            color: white;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            transition: 0.3s;
            font-weight: bold;
        }
        .btn-login:hover {
            background:rgb(56, 217, 86);
        }
        .navbar {
            background-color: #ffffff;
            padding: 10px 0;
            position: absolute;
            top: 0;
            width: 100%;
        }
        .navbar .navbar-brand {
            color: crimson;
            font-weight: bold;
        }
        .navbar-nav .nav-link {
            color: rgb(17, 85, 45) !important;
        }
        .navbar-nav .nav-link:hover {
            color: rgb(0, 0, 0) !important;
        }
        .navbar-nav .nav-link.active {
            color: rgb(30, 93, 23) !important;
        }
        footer {
            background-color: transparent;
            color: rgb(255, 255, 255);
            padding: 15px;
            text-align: center;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="Beranda.php">Freshure</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="login-container">
        <h2>Login</h2>
        <form action="login2.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-login">Login</button>
        </form>
        <p class="mt-3">Belum punya akun? <a href="signup.php">Daftar di sini</a></p>
    </div>

    <footer>
        <p>&copy; 2025 Semua Hak Dilindungi</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>