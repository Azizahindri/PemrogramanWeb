<?php
session_start();
include '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $email      = trim($_POST['email']);
    $password   = $_POST['password'];
    $role       = $_POST['role'];

    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($password) && !empty($role)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $hashed_password, $role);

        if ($stmt->execute()) {
            echo "<script>alert('Pendaftaran berhasil! Silakan login.'); window.location.href='login2.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menyimpan data.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Semua kolom harus diisi.');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar | Freshure</title>

    <!-- Bootstrap & Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #26734d, #a1efbc);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .signup-box {
            background: #fff;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 420px;
            animation: slideUp 0.8s ease-in-out;
        }

        h2 {
            text-align: center;
            color: #2e7d5a;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
            border: 1.5px solid #ccc;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #2e7d5a;
            box-shadow: 0 0 0 0.2rem rgba(46, 125, 90, 0.25);
        }

        .btn-signup {
            background-color: #2e7d5a;
            border: none;
            color: #fff;
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .btn-signup:hover {
            background-color: #239b6c;
        }

        .footer-text {
            margin-top: 15px;
            font-size: 0.95rem;
            text-align: center;
            color: #555;
        }

        .footer-text a {
            color: #2e7d5a;
            font-weight: 600;
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="signup-box">
        <h2><i class="fa-solid fa-user-plus me-2"></i>Sign Up</h2>
        <form action="signup.php" method="POST">
            <div class="mb-3">
                <label class="form-label" for="first_name">Nama Depan</label>
                <input type="text" id="first_name" name="first_name" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label" for="last_name">Nama Belakang</label>
                <input type="text" id="last_name" name="last_name" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required />
            </div>
            <div class="mb-4">
                <label class="form-label">Daftar sebagai</label><br />
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="seller" name="role" value="seller" required />
                    <label class="form-check-label" for="seller">Penjual</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="user" name="role" value="user" required />
                    <label class="form-check-label" for="user">Pembeli</label>
                </div>
            </div>
            <button type="submit" class="btn-signup">Daftar</button>
        </form>
        <div class="footer-text mt-3">
            Sudah punya akun? <a href="login2.php">Login di sini</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
