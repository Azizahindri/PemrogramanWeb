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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Produk - LEAFY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <link href="../css_admin/produk_edit.css" rel="stylesheet" />

</head>
<body>

<div class="form-container shadow-sm">
    <h2><i class="fas fa-edit me-2"></i>Edit Produk</h2>
    <form action="" method="POST" enctype="multipart/form-data" novalidate>
        <div class="mb-4">
            <label for="title" class="form-label">Nama Produk</label>
            <input 
                type="text" 
                class="form-control form-control-lg" 
                id="title" 
                name="title" 
                value="<?= htmlspecialchars($product['title']) ?>" 
                required 
                placeholder="Masukkan nama produk"
            >
        </div>

        <div class="mb-4">
            <label for="price" class="form-label">Harga (Rp)</label>
            <input 
                type="number" 
                step="0.01" 
                min="0"
                class="form-control form-control-lg" 
                id="price" 
                name="price" 
                value="<?= $product['price'] ?>" 
                required
                placeholder="Masukkan harga produk"
            >
        </div>

        <div class="mb-4">
            <label for="genre" class="form-label">Kategori</label>
            <select name="genre" class="form-select form-select-lg" id="genre" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Sayur" <?= $product['genre'] === 'Sayur' ? 'selected' : '' ?>>Sayur</option>
                <option value="Buah" <?= $product['genre'] === 'Buah' ? 'selected' : '' ?>>Buah</option>
                <option value="Bunga" <?= $product['genre'] === 'Bunga' ? 'selected' : '' ?>>Bunga</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="description" class="form-label">Deskripsi Produk</label>
            <textarea 
                class="form-control form-control-lg" 
                id="description" 
                name="description" 
                rows="4" 
                required
                placeholder="Masukkan deskripsi produk"
            ><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <div class="mb-4">
            <label for="image" class="form-label">Gambar Produk <small class="text-muted">(Opsional)</small></label>
            <input class="form-control form-control-lg" type="file" name="image" id="image" accept="image/*" />
            <img src="../<?= htmlspecialchars($product['image_url']) ?>" alt="Preview Gambar Produk" class="preview" id="imgPreview" />
        </div>

        <div class="d-flex justify-content-between">
            <a href="produk_list.php" class="btn btn-outline-secondary btn-lg"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
            <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save me-2"></i>Update</button>
        </div>
    </form>
</div>

<script>
    // Preview gambar sebelum upload
    document.getElementById('image').addEventListener('change', function(event){
        const [file] = event.target.files;
        if (file) {
            document.getElementById('imgPreview').src = URL.createObjectURL(file);
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
