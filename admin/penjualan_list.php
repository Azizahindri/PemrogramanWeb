<?php
session_start();
include '../database/db.php';

// Cek role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login2.php");
    exit();
}

// Ambil data penjualan
$query = "
    SELECT t.*, b.title 
    FROM transactions t 
    JOIN crud_041_book b ON t.product_id = b.id_book
    ORDER BY t.date DESC
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            padding: 30px;
            font-family: 'Segoe UI', sans-serif;
        }
        h2 {
            margin-bottom: 20px;
        }
        .table {
            background-color: white;
        }
    </style>
</head>
<body>

    <h2>Riwayat Penjualan</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= (int)$row['quantity'] ?></td>
                        <td>Rp.<?= number_format($row['total_price'], 0, ',', '.') ?></td>
                        <td><?= date('d-m-Y', strtotime($row['date'])) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Belum ada transaksi.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="dashboard_admin.php" class="btn btn-secondary">← Kembali ke Dashboard</a>

</body>
</html>
