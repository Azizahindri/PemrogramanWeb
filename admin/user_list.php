<?php
session_start();
include '../database/db.php';

// Cek apakah user adalah admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login2.php");
    exit();
}

// Hapus pengguna
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $id = $_POST['user_id'];
    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($role_to_delete);
    $stmt->fetch();
    $stmt->close();

    if ($_SESSION['user_id'] == $id) {
        echo "<script>alert('Tidak bisa menghapus akun Anda sendiri.');</script>";
    } elseif ($role_to_delete === 'admin') {
        echo "<script>alert('Tidak bisa menghapus akun admin lain.');</script>";
    } else {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('Pengguna berhasil dihapus.'); window.location.href='user_list.php';</script>";
    }
}

// Ambil semua user non-admin
$users = mysqli_query($conn, "SELECT id, first_name, last_name, email, role FROM users WHERE role != 'admin' ORDER BY role");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 30px;
            background-color: #f4f4f4;
            font-family: 'Segoe UI', sans-serif;
        }
        .card-box {
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<h2>Manajemen Pengguna</h2>

<!-- Tabel User -->
<div class="card-box">
    <h4>Daftar Pengguna (Penjual & Pembeli)</h4>
    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Peran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($users) > 0): ?>
                <?php $no = 1; while ($user = mysqli_fetch_assoc($users)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= ucfirst($user['role']) ?></td>
                        <td>
                            <form method="POST" action="" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                <input type="hidden" name="delete_user" value="1">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Belum ada pengguna penjual atau pembeli.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<a href="dashboard_admin.php" class="btn btn-secondary">← Kembali ke Dashboard</a>

</body>
</html>
