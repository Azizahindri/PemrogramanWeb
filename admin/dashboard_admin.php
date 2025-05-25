<?php
session_start();
include '../database/db.php';

// Cek apakah user admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: log/login2.php");
    exit();
}

// Ambil data statistik
$totalPenjual = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users WHERE role='penjual'"))[0];
$totalPembeli = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users WHERE role='pembeli'"))[0];
$totalProduk = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM crud_041_book"))[0];

// Cek apakah tabel transactions ada
$checkTrans = mysqli_query($conn, "SHOW TABLES LIKE 'transactions'");
if (mysqli_num_rows($checkTrans) > 0) {
    $totalTransaksi = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM transactions"))[0];
} else {
    $totalTransaksi = 0;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 240px;
            height: 100vh;
            background-color: rgb(102, 216, 115);
            color: white;
            position: fixed;
            padding-top: 30px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgb(26, 151, 53);
        }
        .content {
            margin-left: 240px;
            padding: 30px;
        }
        .card-box {
            border-radius: 12px;
            padding: 20px;
            color: white;
            margin-bottom: 20px;
        }
        .icon-box {
            font-size: 28px;
            margin-right: 10px;
        }
        .blue {
            background-color: #2c3eeb;
        }
        .green {
            background-color: #28a745;
        }
        .red {
            background-color: #dc3545;
        }
        .orange {
            background-color: #fd7e14;
        }
        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h4 class="text-center mb-4">LEAFY</h4>
    <a href="dashboard_admin.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
    <a href="produk_list.php"><i class="fas fa-box"></i> Produk</a>
    <a href="penjualan_list.php"><i class="fas fa-file-invoice-dollar"></i> Transaksi</a>
    <a href="user_list.php"><i class="fas fa-users"></i> Pengguna</a>
    <a href="../log/logout_adminseller.php" class="text-danger"><i class="fas fa-sign-out-alt"></i> >Logout</a>
</div>

<div class="content">
    <h2 class="mb-4">Dashboard Admin</h2>

    <div class="row">
        <div class="col-md-3">
            <div class="card-box blue d-flex align-items-center">
                <i class="fas fa-user icon-box"></i>
                <div>
                    <div>Total Penjual</div>
                    <div><strong><?= $totalPenjual ?> Pengguna</strong></div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box green d-flex align-items-center">
                <i class="fas fa-user icon-box"></i>
                <div>
                    <div>Total Pembeli</div>
                    <div><strong><?= $totalPembeli ?> Pengguna</strong></div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box red d-flex align-items-center">
                <i class="fas fa-box icon-box"></i>
                <div>
                    <div>Jumlah Produk</div>
                    <div><strong><?= $totalProduk ?> Produk</strong></div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box orange d-flex align-items-center">
                <i class="fas fa-receipt icon-box"></i>
                <div>
                    <div>Total Transaksi</div>
                    <div><strong><?= $totalTransaksi ?> Transaksi</strong></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Chart.js -->
    <div class="chart-container">
        <canvas id="dashboardChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('dashboardChart').getContext('2d');
    const dashboardChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Penjual', 'Pembeli', 'Produk', 'Transaksi'],
            datasets: [{
                label: 'Jumlah',
                data: [
                    <?= $totalPenjual ?>,
                    <?= $totalPembeli ?>,
                    <?= $totalProduk ?>,
                    <?= $totalTransaksi ?>
                ],
                backgroundColor: [
                    '#2c3eeb',
                    '#28a745',
                    '#dc3545',
                    '#fd7e14'
                ],
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });
</script>
</body>
</html>
