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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="../css/stylelogin.css" rel="stylesheet" />
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
        Belum punya akun? <a href="signup.php">Daftar sekarang</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
