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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e8f5e9, #f1f8e9);
            font-family: 'Poppins', sans-serif;
            color: #2e7d32;
        }
        .container {
            margin-top: 60px;
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        .image-detail {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .desc-box {
            background-color: #f9fbe7;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h1.title {
            color: #1b5e20;
            font-weight: 600;
            margin-bottom: 30px;
        }
        .btn {
            margin-right: 10px;
            margin-top: 10px;
            border-radius: 10px;
        }
        .btn-success {
            background-color: #43a047;
            border: none;
        }
        .btn-success:hover {
            background-color: #388e3c;
        }
        .btn-primary {
            background-color: #2e7d32;
            border: none;
        }
        .btn-primary:hover {
            background-color: #1b5e20;
        }
        .btn-secondary {
            background-color: #c8e6c9;
            color: #2e7d32;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #a5d6a7;
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
            <h4><strong>Harga:</strong> Rp.<?= htmlspecialchars($data['price']) ?></h4>
            <hr>
            <h5><strong>Deskripsi:</strong></h5>
            <p><?= nl2br(htmlspecialchars($data['description'])) ?></p>
            <div class="mt-4">
                <a href="form.php?id_book=<?= urlencode($data['id_book']) ?>" class="btn btn-success">📝 Beri Review</a>
                <a href="Review.php?id_book=<?= urlencode($data['id_book']) ?>" class="btn btn-primary">⭐ Lihat Review</a>
            </div>
        </div>
    </div>

    <div class="text-center back-btn mt-5">
        <a href="Beranda.php" class="btn btn-secondary">← Kembali ke Beranda</a>
    </div>
</div>

</body>
</html>
