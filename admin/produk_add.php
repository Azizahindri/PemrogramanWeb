<?php
session_start();
include '../database/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login2.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $genre = $_POST['genre'];
    $description = $_POST['description'];

    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../images/";
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $image_path = "images/" . $fileName;
        }
    }

    $stmt = $conn->prepare("INSERT INTO crud_041_book (title, price, genre, description, image_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsss", $title, $price, $genre, $description, $image_path);

    if ($stmt->execute()) {
        echo "<script>alert('Produk berhasil ditambahkan!'); window.location.href='produk_list.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan produk.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Poppins', sans-serif;
            padding: 40px;
        }
        .form-container {
            background-color: white;
            padding: 40px;
            border-radius: 16px;
            max-width: 700px;
            margin: auto;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        }
        h2 {
            font-weight: 600;
            color: #2e7d32;
            margin-bottom: 30px;
        }
        label {
            font-weight: 500;
            color: #333;
        }
        .btn-submit {
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        .btn-submit:hover {
            background-color: #388e3c;
        }
        .btn-back {
            background-color: #e0e0e0;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2><i class="fas fa-plus me-2"></i>Tambah Produk Baru</h2>
    <form action="produk_add.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="title" name="title" required placeholder="Contoh: Selada Hidroponik">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga (Rp)</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" required placeholder="Contoh: 15000">
        </div>

        <div class="mb-3">
            <label for="genre" class="form-label">Kategori</label>
            <select name="genre" class="form-control" id="genre" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Sayur">Sayur</option>
                <option value="Buah">Buah</option>
                <option value="Bunga">Bunga</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="4" required placeholder="Jelaskan keunggulan produk..."></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Gambar Produk</label>
            <input class="form-control" type="file" name="image" id="image" accept="image/*" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="produk_list.php" class="btn btn-back"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
            <button type="submit" class="btn btn-submit"><i class="fas fa-save me-1"></i> Simpan Produk</button>
        </div>
    </form>
</div>

</body>
</html>
