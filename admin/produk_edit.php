<?php
session_start();
include '../database/db.php';

// Cek role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login2.php");
    exit();
}

// Pastikan ID produk ada
if (!isset($_GET['id'])) {
    echo "ID produk tidak ditemukan.";
    exit();
}

$id = $_GET['id'];

// Ambil data produk dari database
$stmt = $conn->prepare("SELECT * FROM crud_041_book WHERE id_book = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "Produk tidak ditemukan.";
    exit();
}

$product = $result->fetch_assoc();

// Proses update saat form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $genre = $_POST['genre'];
    $description = $_POST['description'];

    $image_path = $product['image_url'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../images/";
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $image_path = "images/" . $fileName;
        }
    }

    $stmt = $conn->prepare("UPDATE crud_041_book SET title=?, price=?, genre=?, description=?, image_url=? WHERE id_book=?");
    $stmt->bind_param("sdssss", $title, $price, $genre, $description, $image_path, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Produk berhasil diperbarui!'); window.location.href='produk_list.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui produk.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 30px; background-color: #f4f4f4; }
        .form-container {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
        }
        img.preview {
            width: 100px;
            height: auto;
            margin-top: 10px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2 class="mb-4">Edit Produk</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($product['title']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= $product['price'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="genre" class="form-label">Kategori</label>
            <select name="genre" class="form-control" id="genre" required>
                <option value="Sayur" <?= $product['genre'] === 'Sayur' ? 'selected' : '' ?>>Sayur</option>
                <option value="Buah" <?= $product['genre'] === 'Buah' ? 'selected' : '' ?>>Buah</option>
                <option value="Bunga" <?= $product['genre'] === 'Bunga' ? 'selected' : '' ?>>Bunga</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Gambar Produk</label>
            <input class="form-control" type="file" name="image" id="image" accept="image/*">
            <img src="../<?= $product['image_url'] ?>" alt="Preview" class="preview">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="produk_list.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

</body>
</html>
