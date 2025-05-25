<?php
ob_start();
session_start();
include '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, first_name, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id']    = $user['id'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['role']       = $user['role'];
                $_SESSION['email']      = $email;

                if ($user['role'] === 'admin') {
                    header("Location: ../admin/dashboard_admin.php");
                } elseif ($user['role'] === 'seller') {
                    header("Location: ../seller/dashboard_seller.php");
                } else {
                    header("Location: ../beranda.php");
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
    <title>Login | Freshure</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg,rgb(35, 122, 86),rgb(221, 235, 223));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-box {
            background: #fff;
            padding: 50px 40px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 420px;
            animation: fadeIn 1s ease-in-out;
        }

        .login-box h2 {
            margin-bottom: 30px;
            color: #2f7f5e;
            font-weight: 700;
        }

        .form-label {
            font-weight: 600;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1.5px solid #ccc;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: #2f7f5e;
            box-shadow: 0 0 0 0.2rem rgba(47, 127, 94, 0.25);
        }

        .btn-login {
            background-color: #2f7f5e;
            border: none;
            border-radius: 10px;
            padding: 12px;
            color: #fff;
            font-weight: 600;
            width: 100%;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background-color: #249e72;
        }

        .footer-text {
            margin-top: 20px;
            text-align: center;
            font-size: 0.95rem;
            color: #666;
        }

        .footer-text a {
            color: #2f7f5e;
            text-decoration: none;
            font-weight: 600;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        .icon-box {
            text-align: center;
            font-size: 48px;
            color: #2f7f5e;
            margin-bottom: 15px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="login-box">
    <div class="icon-box">
        <i class="fas fa-leaf"></i>
    </div>
    <h2 class="text-center">Login Freshure</h2>
    <form action="login2.php" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Email</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
        </div>
        <button type="submit" class="btn btn-login">Masuk</button>
    </form>
    <div class="footer-text mt-3">
        Belum punya akun? <a href="log/signup.php">Daftar sekarang</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
