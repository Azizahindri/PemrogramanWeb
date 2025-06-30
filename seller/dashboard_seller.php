<?php
session_start();
include '../database/db.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'seller') {
    header("Location: log/login2.php");
    exit();
}

$seller_id = $_SESSION['user_id'];
$seller_name = $_SESSION['first_name'] ?? 'Penjual';

$sql = "SELECT * FROM crud_041_book WHERE seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$products = $stmt->get_result();
$total_products = $products->num_rows;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Sistem Penjual Hidroponik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../css/style_seller.css">

</head>
<body>
<header>
    <div class="topbar">
        <h5>Sistem Penjualan Hidroponik</h5>
        <a href="../logout.php" class="logout-top">Logout</a>
    </div>
</header>

    <div class="sidebar">
        <?php $page = $_GET['page'] ?? 'dashboard'; ?>
        <a href="?page=dashboard" class="<?= ($page == 'dashboard') ? 'active' : '' ?>"><i class="fas fa-user"></i> Dashboard</a>
        <a href="?page=products" class="<?= ($page == 'products') ? 'active' : '' ?>"><i class="fas fa-box"></i> Produk</a>
        <a href="?page=reviews" class="<?= ($page == 'reviews') ? 'active' : '' ?>"><i class="fas fa-star"></i> Review</a>
        <a href="?page=orders" class="<?= ($page == 'orders') ? 'active' : '' ?>"><i class="fas fa-receipt"></i> Pesanan</a>
        <a href="?page=profil" class="<?= ($page == 'profil') ? 'active' : '' ?>"><i class="fas fa-user-circle"></i> Profil</a>
    </div>

    <div class="content">
        <?php
        if ($page == 'dashboard') {
        ?>
            <div class="header">
                <h2>Hi, <?= htmlspecialchars($seller_name) ?>!</h2>
                <h2>Hope you are having great day!</h2>
            </div>
            <p class="mb-4">Selamat datang di sistem penjualan hidroponik...</p>
            <img src="../images/freshure.png" alt="freshure" style="max-width:100%; height:auto; border-radius: 10px;"><br><br>

            <section class="kategori-produk">
                <h4>Our Category</h4>
                <div class="kategori-slider-wrapper">
                    <button class="btn-prev">&#10094;</button>
                    <div class="kategori-slider">
                        <div class="kategori-card">
                            <img src="../images/sayur.jpg" alt="Sayuran">
                            <h3>Sayuran Segar</h3>
                            <p>You will find the fresh vegetables here!</p>
                        </div>
                        <div class="kategori-card">
                            <img src="../images/buah.jpg" alt="Buah">
                            <h3>Buah Segar</h3>
                            <p>The sweetest fruits here!</p>
                        </div>
                        <div class="kategori-card">
                            <img src="../images/bunga.jpg" alt="Bunga">
                            <h3>Bunga Hias</h3>
                            <p>Beautiful flowers that you can find here!</p>
                        </div>
                    </div>
                    <button class="btn-next">&#10095;</button>
                </div>
            </section>
        <?php
        } elseif ($page == 'products') {
            include 'products.php';
        } elseif ($page == 'reviews') {
            $sql_reviews = "SELECT r.*, p.title FROM crud_041_book_reviews r JOIN crud_041_book p ON r.book_id = p.id WHERE p.seller_id = ?";
            $stmt_reviews = $conn->prepare($sql_reviews);
            $stmt_reviews->bind_param("i", $seller_id);
            $stmt_reviews->execute();
            $reviews = $stmt_reviews->get_result();
        ?>
            <div class="header">
                <h2>Review Produk Saya</h2>
            </div>
            <?php if ($reviews->num_rows > 0): while ($review = $reviews->fetch_assoc()): ?>
                <div class="product-card">
                    <strong>Produk: <?= htmlspecialchars($review['title']) ?></strong><br>
                    <small>oleh: <?= htmlspecialchars($review['reviewer_name'] ?? 'Anonim') ?></small><br>
                    <p><?= htmlspecialchars($review['comment']) ?></p>
                    <p>Rating: <?= $review['rating'] ?>/5</p>
                </div>
            <?php endwhile; else: ?>
                <p>Belum ada review.</p>
            <?php endif; ?>
        <?php
        } elseif ($page == 'orders') {
            include 'pesanan_seller.php';
        } elseif ($page == 'profil') {
            include 'profil_seller.php';
        } else {
            echo "<p>Halaman tidak ditemukan.</p>";
        }
        ?>
    </div>

<footer>
    <div class="footer-content">
        <p>&copy; 2025 Freshure. Semua hak dilindungi.</p>
        <p>Kontak: <a href="mailto:info@Freshure.com">info@Freshure.com</a></p>
    </div>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const slider = document.querySelector(".kategori-slider");
        if (!slider) return;
        const btnPrev = document.querySelector(".btn-prev");
        const btnNext = document.querySelector(".btn-next");
        const kategoriCard = document.querySelector(".kategori-card");
        if (!kategoriCard) return;

        const cardWidth = kategoriCard.offsetWidth + 20;
        let scrollPosition = 0;

        btnNext.addEventListener("click", () => {
            if (scrollPosition < slider.scrollWidth - slider.clientWidth) {
                scrollPosition += cardWidth;
                slider.scrollTo({ left: scrollPosition, behavior: "smooth" });
            }
        });

        btnPrev.addEventListener("click", () => {
            if (scrollPosition > 0) {
                scrollPosition -= cardWidth;
                slider.scrollTo({ left: scrollPosition, behavior: "smooth" });
            }
        });
    });
</script>
</body>
</html>
