<?php
session_start();
include '../database/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../log/login2.php");
    exit();
}

// Ambil data statistik
$totalPenjual = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users WHERE role='seller'"))[0];
$totalPembeli = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users WHERE role='user'"))[0];
$totalProduk = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM crud_041_book"))[0];
$totalArtikel = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM articles"))[0];
$totalReview = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM crud_041_book_reviews"))[0];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard - LEAFY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <link href="../css_admin/dashboard_admin.css" rel="stylesheet" />
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
</div>

<div class="content">
    <h2 class="mb-4">Dashboard Admin</h2>
    <div class="row g-3">
        <div class="col">
            <div class="card-stat">
                <div class="icon"><i class="fas fa-store"></i></div>
                <h5>Total Penjual</h5>
                <h3><?= $totalPenjual ?></h3>
            </div>
        </div>
        <div class="col">
            <div class="card-stat">
                <div class="icon"><i class="fas fa-user"></i></div>
                <h5>Total Pembeli</h5>
                <h3><?= $totalPembeli ?></h3>
            </div>
        </div>
        <div class="col">
            <div class="card-stat">
                <div class="icon"><i class="fas fa-leaf"></i></div>
                <h5>Jumlah Produk</h5>
                <h3><?= $totalProduk ?></h3>
            </div>
        </div>
        <div class="col">
            <div class="card-stat">
                <div class="icon"><i class="fas fa-newspaper"></i></div>
                <h5>Total Artikel</h5>
                <h3><?= $totalArtikel ?></h3>
            </div>
        </div>
        <div class="col">
            <div class="card-stat">
                <div class="icon"><i class="fas fa-comments"></i></div>
                <h5>Total Review</h5>
                <h3><?= $totalReview ?></h3>
            </div>
        </div>
    </div>

    <div class="chart-container">
        <canvas id="adminChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('adminChart').getContext('2d');
    const adminChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Penjual', 'Pembeli', 'Produk', 'Artikel', 'Review'],
            datasets: [{
                label: 'Statistik Platform',
                data: [
                    <?= $totalPenjual ?>,
                    <?= $totalPembeli ?>,
                    <?= $totalProduk ?>,
                    <?= $totalArtikel ?>,
                    <?= $totalReview ?>
                ],
                fill: false,
                borderColor: '#388e3c',
                backgroundColor: '#66bb6a',
                tension: 0.3,
                pointBackgroundColor: '#2e7d32',
                pointBorderColor: '#ffffff',
                pointHoverBackgroundColor: '#ffffff',
                pointHoverBorderColor: '#388e3c',
                borderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: '#444',
                        font: {
                            family: 'Poppins',
                            size: 14,
                            weight: '600'
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: '#444',
                        font: {
                            family: 'Poppins'
                        }
                    },
                    grid: {
                        color: '#ddd'
                    }
                },
                x: {
                    ticks: {
                        color: '#444',
                        font: {
                            family: 'Poppins'
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
</body>
</html>
