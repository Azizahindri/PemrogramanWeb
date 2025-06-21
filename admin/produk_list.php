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
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Poppins', sans-serif;
            padding: 40px;
        }
        .container-custom {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.07);
        }
        h2 {
            font-weight: 600;
            color: #2e7d32;
            margin-bottom: 30px;
        }
        .table th {
            background-color: #c1d8c3;
            color: #333;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .table img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .btn-sm {
            font-size: 0.85rem;
            padding: 4px 10px;
        }
        .btn-add {
            background-color: #4caf50;
            color: white;
        }
        .btn-add:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>

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
