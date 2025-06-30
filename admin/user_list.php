<?php
session_start();
include '../database/db.php';

// Cek otorisasi admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login2.php");
    exit();
}

$message = "";

// Hapus pengguna
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $id = $_POST['user_id'];

    // Ambil role pengguna
    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($role_to_delete);
    $stmt->fetch();
    $stmt->close();

    if ($_SESSION['user_id'] == $id) {
        $message = "Akun Anda sendiri tidak dapat dihapus.";
    } elseif ($role_to_delete === 'admin') {
        $message = "Tidak dapat menghapus akun admin lain.";
    } else {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $message = "Pengguna berhasil dihapus.";
    }
}

// Ambil semua user non-admin
$users = mysqli_query($conn, "SELECT id, first_name, last_name, email, role FROM users WHERE role != 'admin' ORDER BY role");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Manajemen Pengguna - Freshure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <link href="../css_admin/user_list.css" rel="stylesheet" />

</head>
<body>
    <div class="container">
        <h2>Manajemen Pengguna</h2>

        <?php if ($message): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
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
                                <td>
                                    <span class="role-badge badge 
                                        <?= $user['role'] === 'buyer' ? 'badge-buyer' : 'badge-seller' ?>">
                                        <?= htmlspecialchars($user['role']) ?>
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" action="" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                        <input type="hidden" name="delete_user" value="1" />
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>" />
                                        <button type="submit" class="btn btn-delete" title="Hapus Pengguna">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Tidak ada pengguna selain admin.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="dashboard_admin.php" class="btn btn-back"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
