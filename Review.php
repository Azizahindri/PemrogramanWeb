<?php
include 'database/db.php';

if (!isset($_GET['id_book'])) {
    echo "Sayur tidak ditemukan.";
    exit;
}

$id_book = $_GET['id_book'];

$queryBook = "SELECT * FROM crud_041_book WHERE id_book = ?";
$stmt = $conn->prepare($queryBook);
$stmt->bind_param("s", $id_book);
$stmt->execute();
$resultBook = $stmt->get_result();

if ($resultBook->num_rows === 0) {
    echo "Sayur tidak ditemukan.";
    exit;
}

$book = $resultBook->fetch_assoc();

// Ambil review dari sayur
$queryReview = "SELECT id, name, review, rating, date FROM crud_041_book_reviews WHERE book_id = ? ORDER BY date DESC";
$stmtReview = $conn->prepare($queryReview);
$stmtReview->bind_param("s", $id_book);
$stmtReview->execute();
$resultReview = $stmtReview->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Review Sayur - <?= htmlspecialchars($book['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
</head>
<body class="review-page">

    <div class="container">
        <p class="intro">
            Kami percaya kualitas bisa dirasakan, bukan hanya diklaim. Lihat apa kata pelanggan tentang sayur hidroponik kami.
        </p>

        <h3 id="bookTitle"><?= htmlspecialchars($book['title']) ?></h3>

        <div class="mt-4">
            <?php if ($resultReview->num_rows > 0): ?>
                <?php while ($review = $resultReview->fetch_assoc()): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="review-header">
                                <div class="review-name"><?= htmlspecialchars($review['name']) ?></div>
                                <div class="review-date"><?= date('d M Y', strtotime($review['date'])) ?></div>
                            </div>
                            <p class="review-text"><strong>Review:</strong> <?= nl2br(htmlspecialchars($review['review'])) ?></p>
                            <p class="review-rating"><?= str_repeat("★", $review['rating']) . str_repeat("☆", 5 - $review['rating']) ?></p>

                            <div class="review-actions">
                                <a href="form.php?id=<?= urlencode($review['id']) ?>&id_book=<?= urlencode($id_book) ?>" class="btn btn-warning btn-sm">Edit</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-review">Belum ada review untuk sayur ini.</p>
            <?php endif; ?>
        </div>

        <div class="btn-back">
            <p>Ingin memberi review?</p>
            <a href="form.php?id_book=<?= urlencode($id_book) ?>" class="btn btn-secondary">Tulis Review</a>
        </div>
    </div>

</body>
</html>

<?php $conn->close(); ?>
