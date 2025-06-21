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
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            background-color:rgb(162, 210, 165);
            color: white;
            padding-top: 30px;
        }
        .sidebar h4 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            letter-spacing: 1.5px;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background-color: #1b5e20;
        }
        .content {
            margin-left: 240px;
            padding: 40px 30px;
            max-width: calc(100% - 240px);
            box-sizing: border-box;
        }
        .card-stat {
            height: 160px;
            background-color: #ffffff;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            text-align: center;
            transition: transform 0.2s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: default;
        }
        .card-stat:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.12);
        }
        .card-stat .icon {
            font-size: 36px;
            margin-bottom: 15px;
            color:rgb(43, 165, 47);
        }
        .card-stat h5 {
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }
        .card-stat h3 {
            font-weight: 700;
            color:rgb(12, 172, 20);
            font-size: 32px;
            margin: 0;
        }
        .chart-container {
            background: white;
            padding: 30px 30px 40px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-top: 50px;
            max-width: 900px;
            /* Center chart */
            margin-left: auto;
            margin-right: auto;
        }
        /* Responsive for cards row */
        @media (min-width: 768px) {
            .row.g-3 > .col {
                flex: 1 1 0;
                max-width: 20%; /* 5 cards per row */
            }
        }
        @media (max-width: 767px) {
            .row.g-3 > .col {
                max-width: 50%;
                margin-bottom: 20px;
            }
        }
        /* Canvas responsive height */
        #adminChart {
            width: 100% !important;
            height: 350px !important;
        }
    </style>
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
