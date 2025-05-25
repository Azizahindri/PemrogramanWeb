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
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color:#C1D8C3;

            /* Layout flex kolom supaya footer di bawah */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .topbar {
            display: flex;
            color: black; 
            background-color: #f1f8e9;
            padding: 10px 20px;
            height: 60px;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1001;
        }
        .topbar h4 {
            margin: 0;
            flex-grow: 1;
        }
        /* Ini tombol logout */
        .logout-top {
            color: white;
            background-color: #dc3545; /* merah normal */
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            margin-left: auto;
            transition: background-color 0.3s ease;
        }
        .logout-top:hover {
            background-color: #ff4d4d; /* merah terang saat hover */
            color: white; /* tulisan tetap putih */
        }
        .sidebar {
            position: fixed;
            top:60px;
            left: 0;
            height: calc(100vh - 60px);
            width: 220px;
            background-color:#80AF81;
            padding-top: 20px;
            color: white;
            overflow-y: auto;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            font-weight: 600;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #508D4E;
        }
        /* content harus fleksibel supaya mendorong footer */
        .content {
            margin-left: 220px;
            padding: 100px 30px 30px 30px;
            flex: 1 0 auto;  /* Kunci biar dorong footer */
        }
        .header {
            margin-bottom: 30px;
        }
        .product-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }
        .btn-action {
            margin-right: 10px;
        }
        .kategori-produk {
            padding: 20px;
            text-align: center;
            color: #33691e;
        }
        .kategori-slider-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }
        .kategori-slider {
            display: flex;
            overflow: hidden;
            width: 290px;
            scroll-behavior: smooth;
        }
        .kategori-card {
            background-color: #f1f8e9;
            color: #33691e;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 270px;
            flex-shrink: 0;
            padding: 15px;
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-right: 20px;
        }
        .kategori-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }
        .kategori-card h3 {
            margin: 0;
            color: #33691e;
        }
        .kategori-card p {
            color: #558b2f;
            font-size: 0.9em;
            margin: 0 0 10px 0;
        }
        .btn-prev, .btn-next {
            background-color: #33691e;
            color: white;
            border: none;
            font-size: 24px;
            padding: 10px 15px;
            border-radius: 50%;
            cursor: pointer;
            user-select: none;
        }
        .btn-prev:hover, .btn-next:hover {
            background-color: #558b2f;
        }
        footer {
            background-color: #f1f8e9;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            z-index: 1001;
            flex-shrink: 0; /* supaya footer tidak mengecil */
        }
    </style>
</head>
<body>
    <header>
        <div class="topbar">
            <h5>Sistem Penjualan Hidroponik</h5>
            <a href="../logout.php" class="logout-top">Logout</a>
        </div>
    </header>

    <div class="sidebar">
        <a href="?page=dashboard" class="<?= (!isset($_GET['page']) || $_GET['page'] == 'dashboard') ? 'active' : '' ?>"><i class="fas fa-user"></i> Dashboard</a>
        <a href="?page=products" class="<?= (isset($_GET['page']) && $_GET['page'] == 'products') ? 'active' : '' ?>"><i class="fas fa-box"></i> Produk</a>
        <a href="?page=reviews" class="<?= (isset($_GET['page']) && $_GET['page'] == 'reviews') ? 'active' : '' ?>"><i class="fas fa-star"></i> Review</a>
        <a href="?page=orders" class="<?= (isset($_GET['page']) && $_GET['page'] == 'orders') ? 'active' : '' ?>"><i class="fas fa-receipt"></i> Pemesanan</a>
        <a href="?page=profil" class="<?= (isset($_GET['page']) && $_GET['page'] == 'profil') ? 'active' : '' ?>"><i class="fas fa-user-circle"></i> Profil</a>
    </div>

    <div class="content">
        <?php
        $page = $_GET['page'] ?? 'dashboard';

        if ($page == 'dashboard') {
            ?>
            <div class="header">
                <h2>Hi, <?= htmlspecialchars($seller_name) ?>!</h2>
                <h2>Hope you are having great day!</h2>
            </div>
            <p class="mb-4">Selamat datang di sistem penjualan hidroponik. Di sini, Anda bisa mengelola produk-produk Anda, melihat pemesanan customer sekaligus memantau ulasan dari mereka.</p>
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
            $sql_reviews = "
                SELECT r.*, p.title 
                FROM crud_041_book_reviews r 
                JOIN crud_041_book p ON r.book_id = p.id 
                WHERE p.seller_id = ?
            ";
            $stmt_reviews = $conn->prepare($sql_reviews);
            $stmt_reviews->bind_param("i", $seller_id);
            $stmt_reviews->execute();
            $reviews = $stmt_reviews->get_result();
            ?>
            <div class="header">
                <h2>Review Produk Saya</h2>
            </div>
            <?php if ($reviews->num_rows > 0): ?>
                <?php while ($review = $reviews->fetch_assoc()): ?>
                    <div class="product-card">
                        <strong>Produk: <?= htmlspecialchars($review['title']) ?></strong><br>
                        <small>oleh: <?= htmlspecialchars($review['reviewer_name'] ?? 'Anonim') ?></small><br>
                        <p><?= htmlspecialchars($review['comment']) ?></p>
                        <p>Rating: <?= $review['rating'] ?>/5</p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Belum ada review.</p>
            <?php endif; ?>
            <?php
        } elseif ($page == 'orders') {
            $sql_orders = "SELECT * FROM orders WHERE seller_id = ?";
            $stmt_o = $conn->prepare($sql_orders);
            $stmt_o->bind_param("i", $seller_id);
            $stmt_o->execute();
            $orders = $stmt_o->get_result();
            ?>
            <div class="header">
                <h2>Pemesanan</h2>
            </div>
            <?php if ($orders->num_rows > 0): ?>
                <?php while ($order = $orders->fetch_assoc()): ?>
                    <div class="product-card">
                        <strong>Order ID: <?= $order['id'] ?></strong><br>
                        <p>Produk: <?= htmlspecialchars($order['product_name']) ?></p>
                        <p>Jumlah: <?= $order['quantity'] ?></p>
                        <p>Status: <?= htmlspecialchars($order['status']) ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Belum ada pemesanan.</p>
            <?php endif; ?>
            <?php
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
