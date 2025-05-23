<?php
session_start();
include 'database/db.php';

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
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: rgb(17, 85, 45);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .signup-container {
            background: white;
            padding: 25px 20px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0,0,0,0.2);
            width: 320px;
            color: #333;
        }
        .signup-container h2 {
            color: brown;
            text-align: center;
            margin-bottom: 20px;
            font-size: 22px;
        }
        label {
            font-size: 14px;
            color: #000;
        }
        .form-control {
            font-size: 14px;
        }
        .btn-signup {
            background: rgb(81, 121, 91);
            color: white;
            padding: 8px;
            width: 100%;
            border-radius: 5px;
            transition: 0.3s;
            font-weight: bold;
            border: none;
            font-size: 15px;
            cursor: pointer;
        }
        .btn-signup:hover {
            background: rgb(3, 83, 18);
        }
        .signup-container p {
            font-size: 13px;
            text-align: center;
        }
        .mb-3 label.form-label {
            margin-bottom: 4px;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <form action="signup.php" method="POST">
            <div class="mb-2">
                <label class="form-label" for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" class="form-control" required />
            </div>
            <div class="mb-2">
                <label class="form-label" for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" class="form-control" required />
            </div>
            <div class="mb-2">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required />
            </div>
            <div class="mb-2">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Daftar Sebagai:</label><br />
                <input type="radio" id="seller" name="role" value="seller" required />
                <label for="seller">Penjual</label><br />
                <input type="radio" id="user" name="role" value="user" required />
                <label for="user">Pembeli</label>
            </div>
            <button type="submit" class="btn-signup">Daftar</button>
        </form>
        <p class="mt-3">
            Sudah punya akun? <a href="login2.php">Login di sini</a>
        </p>
    </div>
</body>
</html>
