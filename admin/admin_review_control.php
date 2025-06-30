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
    <link href="../css_admin/admin_review_control.css" rel="stylesheet" />

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
