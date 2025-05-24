<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../database/db.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'seller') {
    header("Location: ../login2.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

// Ambil data produk milik seller ini
$sql = "SELECT * FROM crud_041_book WHERE seller_id = ? ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Daftar Produk Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #e9f5e9; /* hijau muda */
            font-family: Arial, sans-serif;
        }
        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h2 {
            color: #2f6d2f; /* hijau tua */
            margin-bottom: 20px;
            font-weight: 700;
        }
        .btn-success {
            background-color: #4caf50;
            border-color: #4caf50;
        }
        .btn-success:hover {
            background-color: #3a8c3a;
            border-color: #3a8c3a;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        @media (max-width: 992px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 576px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
        }
        .product-card {
            background: white;
            border: 2px solid #4caf50;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(76, 175, 80, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: box-shadow 0.3s ease;
            cursor: default;
        }
        .product-card:hover {
            box-shadow: 0 4px 16px rgba(76, 175, 80, 0.5);
        }
        .product-card h5 {
            margin-bottom: 12px;
            font-weight: 700;
            font-size: 1.2rem;
            color: #2f6d2f;
            text-align: center;
        }
        .product-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
            background: #dcedc8;
        }
        .product-info {
            font-size: 0.95rem;
            color: #3a5d3a;
            margin-bottom: 15px;
            text-align: center;
        }
        .product-info span {
            display: block;
            margin-bottom: 6px;
        }
        .btn-group {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .btn-group a {
            flex: 1;
            text-align: center;
            font-weight: 600;
            padding: 6px 0;
        }
        .btn-warning {
            background-color: #8bc34a;
            border-color: #8bc34a;
            color: #fff;
        }
        .btn-warning:hover {
            background-color: #7aa83d;
            border-color: #7aa83d;
            color: #fff;
        }
        .btn-danger {
            background-color: #e53935;
            border-color: #e53935;
            color: #fff;
        }
        .btn-danger:hover {
            background-color: #b71c1c;
            border-color: #b71c1c;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <h2>Daftar Produk Saya</h2>
    <a href="add_product.php" class="btn btn-success mb-4">Tambah Produk Baru</a>

    <?php if ($result->num_rows === 0): ?>
        <p>Belum ada produk yang kamu tambahkan.</p>
    <?php else: ?>
    <div class="product-grid">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-card">
                <h5><?= htmlspecialchars($row['title']) ?></h5>
                
                <?php if (!empty($row['image_url'])): ?>
                    <img src="../<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                <?php else: ?>
                    <div style="width:100%; height:180px; background:#c8e6c9; display:flex; align-items:center; justify-content:center; color:#4caf50; border-radius:8px;">
                        Tidak ada gambar
                    </div>
                <?php endif; ?>

                <div class="product-info">
                    <span><strong>Harga:</strong> Rp <?= number_format($row['price'], 0, ',', '.') ?></span>
                    <span><strong>Stok:</strong> <?= htmlspecialchars($row['stock']) ?></span>
                </div>
                
                <div class="btn-group">
                    <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <?php endif; ?>
</div>

</body>
</html>
