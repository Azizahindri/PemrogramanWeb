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
    <link rel="stylesheet" href="css/style.css" />
</head>

<body class="informasi-page">

    <div class="container">
        <h1 class="text-center title"><?= htmlspecialchars($data['title']) ?></h1>
        <div class="row mt-4">
            <div class="col-md-6">
                <img src="<?= htmlspecialchars($data['image_url']) ?>" alt="<?= htmlspecialchars($data['title']) ?>"
                    class="image-detail">
            </div>
            <div class="col-md-6 desc-box">
                <h4><strong>Harga:</strong> Rp.<?= htmlspecialchars($data['price']) ?></h4>
                <hr>
                <h5><strong>Deskripsi:</strong></h5>
                <p><?= nl2br(htmlspecialchars($data['description'])) ?></p>
                <div class="mt-4">
                    <a href="form.php?id_book=<?= urlencode($data['id_book']) ?>" class="btn btn-success">📝 Beri
                        Review</a>
                    <a href="Review.php?id_book=<?= urlencode($data['id_book']) ?>" class="btn btn-primary">⭐ Lihat
                        Review</a>
                    <a href="https://wa.me/6285960155228?text=Nama%20Produk%3A%20<?= htmlspecialchars($data['title']) ?>%0AJumlah%3A%201Ikat"
                        target="_blank" class="btn btn-primary"> 📞Hubungi via WhatsApp</a>

                </div>
            </div>
        </div>

        <div class="text-center back-btn mt-5">
            <a href="Beranda.php" class="btn btn-secondary">← Kembali ke Beranda</a>
        </div>
    </div>

</body>

</html>