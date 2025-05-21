<?php
include 'database/db.php';

if (isset($_GET['id_book'])) {
    $id_book = $_GET['id_book'];

    $query = "SELECT * FROM crud_041_book WHERE id_book = '$id_book'";
    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo "Data tidak ditemukan.";
        exit;
    }

    $data = mysqli_fetch_assoc($result);
} else {
    echo "ID tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Tumbuhan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color:rgb(255, 255, 255);
            color: #333;
        }
        .container {
            margin-top: 50px;
        }
        .image-detail {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .back-btn {
            margin-top: 20px;
        }
        .desc-box {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
        }
        .title {
            color: #2e7d32;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center title"><?= htmlspecialchars($data['title']) ?></h1>
    <div class="row mt-4">
        <div class="col-md-6">
            <img src="<?= htmlspecialchars($data['image_url']) ?>" alt="<?= htmlspecialchars($data['title']) ?>" class="image-detail">
        </div>
        <div class="col-md-6 desc-box">
            <p><strong>Harga:</strong> Rp.<?= htmlspecialchars($data['price']) ?></p>
            <p><strong>Deskripsi:</strong></p>
            <p><?= nl2br(htmlspecialchars($data['description'])) ?></p>
            <a href="form.php?id_book=<?= urlencode($data['id_book']) ?>" class="btn btn-success">Beri Review</a>
            <a href="Review.php?id_book=<?= urlencode($data['id_book']) ?>" class="btn btn-primary">Lihat Review</a>
        </div>
    </div>

    <div class="text-center back-btn">
        <a href="Beranda.php" class="btn btn-secondary">← Kembali ke Beranda</a>
    </div>
</div>
</body>
</html>
