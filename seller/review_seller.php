<?php
session_start();
include '../database/db.php';

// Pastikan hanya seller yang bisa akses halaman ini
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'seller') {
    header("Location: ../login2.php");
    exit();
}

$seller_id = $_SESSION['user_id'];
$seller_name = $_SESSION['first_name'] ?? 'Penjual';

$sql = "
    SELECT r.*, p.title 
    FROM crud_041_book_reviews r
    JOIN crud_041_book p ON r.book_id = p.id_book
    WHERE p.seller_id = ?
    ORDER BY r.date DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$reviews = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Review Produk Saya - <?= htmlspecialchars($seller_name) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <link href="../css/reviewseller.css" rel="stylesheet" />
</head>
<body>
    <header>
        <h2>Review Produk Saya</h2>
        <a href="dashboard_seller.php" class="btn btn-secondary btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
    </header>

    <?php if ($reviews->num_rows > 0): ?>
        <?php while ($review = $reviews->fetch_assoc()): ?>
            <div class="review-card">
                <h5>Produk: <?= htmlspecialchars($review['title']) ?></h5>
                <small>Oleh: <?= htmlspecialchars($review['name'] ?? 'Anonim') ?> | <?= date('d M Y', strtotime($review['date'])) ?></small>
                <p><?= nl2br(htmlspecialchars($review['review'])) ?></p>
                <div class="rating">
                    <?= str_repeat('<i class="fas fa-star"></i>', $review['rating']) ?>
                    <?= str_repeat('<i class="far fa-star"></i>', 5 - $review['rating']) ?>
                    <span class="ms-2">(<?= $review['rating'] ?>/5)</span>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Belum ada review untuk produk Anda.</p>
    <?php endif; ?>
</body>
</html>
