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
    <link rel="stylesheet" href="../css/products.css" />
  
</head>
<body>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="m-0">Daftar Produk Saya</h2>
    </div>

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
                    <div style="width:100%; height:140px; background:#c8e6c9; display:flex; align-items:center; justify-content:center; color:#4caf50; border-radius:6px;">
                        Tidak ada gambar
                    </div>
                <?php endif; ?>

                <div class="product-info">
                    <span><strong>Harga:</strong> Rp <?= number_format($row['price'], 0, ',', '.') ?></span>
                    <span><strong>Stok:</strong> <?= htmlspecialchars($row['stock'] ?? 0) ?></span>
                </div>

                <div class="product-description">
                    <?= nl2br(htmlspecialchars($row['description'] ?? '')) ?>
                </div>
                
                <div class="btn-group">
                    <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                    <a href="detail_product.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Detail</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <?php endif; ?>
</div>
<!-- Tombol kembali di bagian bawah sebelum footer -->
<div class="text-center mt-5 mb-4">
    <a href="dashboard_seller.php" class="btn btn-link text-primary fw-bold">⟵ Kembali ke Dashboard</a>
</div>
</body>
</html>
