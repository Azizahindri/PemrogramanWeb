<?php
session_start();
include '../database/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../log/login2.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data admin
$sql = "SELECT first_name, last_name, email, role FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Query gagal: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Data tidak ditemukan.");
}

$admin = $result->fetch_assoc();
$full_name = $admin['first_name'] . ' ' . $admin['last_name'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Profil Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    body {
        background-color: #f4f7f6;
        font-family: 'Poppins', sans-serif;
        margin: 0;
    }
    .profile-container {
        max-width: 800px;
        margin: 60px auto;
        background: white;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }
    .profile-container h2 {
        font-weight: 600;
        margin-bottom: 30px;
        color: #2e7d32;
    }
    .profile-row {
        margin-bottom: 20px;
    }
    .label {
        font-weight: 500;
        color: #555;
    }
    .value {
        font-size: 16px;
        color: #222;
    }
    .action-buttons {
        margin-top: 30px;
    }
    .avatar-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: #c1d8c3;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 36px;
        color: white;
        margin-bottom: 20px;
    }
  </style>
</head>
<body>

<div class="profile-container text-center">
    <div class="avatar-circle mx-auto"><?= strtoupper($admin['first_name'][0]) ?></div>
    <h2>Profil Admin</h2>

    <div class="text-start">
        <div class="profile-row">
            <span class="label">Nama Lengkap:</span>
            <div class="value"><?= htmlspecialchars($full_name) ?></div>
        </div>
        <div class="profile-row">
            <span class="label">Email:</span>
            <div class="value"><?= htmlspecialchars($admin['email']) ?></div>
        </div>
        <div class="profile-row">
            <span class="label">Peran:</span>
            <div class="value text-capitalize"><?= htmlspecialchars($admin['role']) ?></div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="dashboard_admin.php" class="btn btn-secondary me-2"><i class="fas fa-arrow-left"></i> Kembali</a>
        <a href="edit_profil.php" class="btn btn-outline-primary"><i class="fas fa-edit"></i> Edit Profil</a>
        <a href="../log/logout_adminseller.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

</body>
</html>
