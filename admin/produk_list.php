<?php
session_start();
include '../database/db.php';

// Cek apakah user admin
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
    <title>Manajemen Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; background-color: #f9f9f9; }
        .table img { width: 50px; height: auto; }
    </style>
</head>
<body>
    <h2>Manajemen Produk</h2>
    <a href="produk_add.php" class="btn btn-success mb-3">+ Tambah Produk</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Genre</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><img src="../<?= htmlspecialchars($row['image_url']) ?>" alt=""></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td>Rp.<?= number_format($row['price'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['genre']) ?></td>
                    <td>
                        <a href="produk_edit.php?id=<?= $row['id_book'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="produk_delete.php?id=<?= $row['id_book'] ?>" onclick="return confirm('Yakin hapus?');" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
