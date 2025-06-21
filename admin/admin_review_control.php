<?php
session_start();
include '../database/db.php';

// Cek role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login2.php");
    exit();
}

// Proses hapus review
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_review'])) {
    $review_id = $_POST['review_id'];
    $stmt = $conn->prepare("DELETE FROM crud_041_book_reviews WHERE id = ?");
    $stmt->bind_param("i", $review_id);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Review berhasil dihapus.'); window.location.href='admin_review_control.php';</script>";
    exit();
}

// Ambil semua review beserta judul sayur
$query = "
    SELECT r.id, r.name, r.review, r.rating, r.date, b.title 
    FROM crud_041_book_reviews r 
    JOIN crud_041_book b ON r.book_id = b.id_book
    ORDER BY r.date DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Manajemen Review Sayur - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: #f9fafb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            max-width: 1100px;
            margin: auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 12px 30px rgb(0 0 0 / 0.1);
        }
        h2 {
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 30px;
            letter-spacing: 1.2px;
        }
        table {
            border-collapse: separate !important;
            border-spacing: 0 12px !important;
        }
        thead tr {
            background-color: #007bff;
            color: #fff;
            border-radius: 15px;
        }
        thead th {
            border: none !important;
            font-weight: 600;
            text-align: center;
        }
        tbody tr {
            background: #fefefe;
            box-shadow: 0 3px 8px rgb(0 0 0 / 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        tbody tr:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgb(0 0 0 / 0.1);
        }
        tbody td {
            vertical-align: middle;
            padding: 18px 15px;
            text-align: center;
            font-size: 14px;
            color: #444;
        }
        .rating-stars {
            color: #f5c518;
            font-size: 18px;
        }
        .btn-warning {
            font-weight: 600;
        }
        .btn-danger {
            font-weight: 600;
        }
        .btn-secondary {
            font-weight: 600;
        }
        .btn-group {
            display: flex;
            gap: 8px;
            justify-content: center;
        }
        .no-data {
            color: #6c757d;
            font-style: italic;
            font-size: 16px;
            text-align: center;
            padding: 30px 0;
        }
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            thead tr {
                display: none;
            }
            tbody tr {
                margin-bottom: 20px;
                box-shadow: none;
                border-radius: 10px;
                background: #fff;
                padding: 15px;
            }
            tbody td {
                text-align: right;
                padding-left: 50%;
                position: relative;
                font-size: 13px;
            }
            tbody td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 45%;
                padding-left: 10px;
                font-weight: 700;
                text-align: left;
                color: #333;
                white-space: nowrap;
            }
            .btn-group {
                justify-content: flex-start;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manajemen Review Sayur</h2>
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th>Judul Sayur</th>
                    <th>Nama Reviewer</th>
                    <th>Rating</th>
                    <th>Tanggal</th>
                    <th>Review</th>
                    <th style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td data-label="No"><?= $no++ ?></td>
                            <td data-label="Judul Sayur"><?= htmlspecialchars($row['title']) ?></td>
                            <td data-label="Nama Reviewer"><?= htmlspecialchars($row['name']) ?></td>
                            <td data-label="Rating" class="rating-stars" aria-label="Rating <?= $row['rating'] ?> dari 5">
                                <?= str_repeat("★", $row['rating']) . str_repeat("☆", 5 - $row['rating']) ?>
                            </td>
                            <td data-label="Tanggal"><?= date('d M Y', strtotime($row['date'])) ?></td>
                            <td data-label="Review" style="text-align:left; max-width: 280px; white-space: pre-wrap;">
                                <?= htmlspecialchars($row['review']) ?>
                            </td>
                            <td data-label="Aksi">
                                <div class="btn-group">
                                    <form method="POST" onsubmit="return confirm('Yakin ingin menghapus review ini?');" style="display:inline;">
                                        <input type="hidden" name="review_id" value="<?= $row['id'] ?>">
                                        <button type="submit" name="delete_review" class="btn btn-danger btn-sm" title="Hapus Review">
                                            Hapus
                                         </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="no-data">Belum ada review yang tersedia.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="dashboard_admin.php" class="btn btn-secondary mt-3">← Kembali ke Dashboard</a>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
