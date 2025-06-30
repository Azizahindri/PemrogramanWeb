<?php
session_start();
include '../database/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login2.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM crud_041_book");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Produk - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

</head>
<body>

<div class="sidebar">
    <h4>Freshure</h4>
    <a href="dashboard_admin.php" class="active"><i class="fas fa-home me-2"></i>Dashboard</a>
    <a href="produk_list.php"><i class="fas fa-box me-2"></i>Produk</a>
    <a href="user_list.php"><i class="fas fa-users me-2"></i>Pengguna</a>
    <a href="admin_articles.php"><i class="fas fa-newspaper me-2"></i>Artikel</a>
    <a href="admin_review_control.php"><i class="fas fa-comments me-2"></i>Review</a>
    <a href="../log/logout_adminseller.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
    <link href="../css_admin/dashboard_admin.css" rel="stylesheet" />
</div>

<div class="container-custom">
    <h2><i class="fas fa-box me-2"></i>Manajemen Produk</h2>

    <a href="produk_add.php" class="btn btn-add mb-3"><i class="fas fa-plus"></i> Tambah Produk</a>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="text-center">
                <tr>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Genre</th>
                    <th style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td class="text-center">
                            <img src="../<?= htmlspecialchars($row['image_url']) ?>" alt="<?= $row['title'] ?>">
                        </td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td>Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($row['genre']) ?></td>
                        <td class="text-center">
                            <a href="produk_edit.php?id=<?= $row['id_book'] ?>" class="btn btn-warning btn-sm me-1"><i class="fas fa-edit"></i></a>
                            <a href="produk_delete.php?id=<?= $row['id_book'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?');"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <a href="dashboard_admin.php" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard</a>
</div>

</body>
</html>
