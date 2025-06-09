<?php
session_start();
include '../database/db.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'seller') {
    header("Location: ../login2.php");
    exit();
}

$seller_id = $_SESSION['user_id'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $jenis = trim($_POST['genre'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    $description = trim($_POST['description'] ?? '');

    if (!$title || !$jenis || $price <= 0 || $stock < 0) {
        $error = "Mohon isi semua data dengan benar.";
    } else {
        // Proses upload gambar
        $image_url = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileType = $_FILES['image']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($fileExtension, $allowedfileExtensions)) {
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

                $uploadFileDir = '../uploads/';
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0755, true);
                }
                $dest_path = $uploadFileDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $image_url = 'uploads/' . $newFileName;
                } else {
                    $error = "Terjadi kesalahan saat mengupload gambar.";
                }
            } else {
                $error = "Format file tidak didukung. Gunakan jpg, jpeg, png, atau gif.";
            }
        }

        if (!$error) {
            $sql = "INSERT INTO crud_041_book (seller_id, title, genre, price, stock, image_url, description) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issdiss", $seller_id, $title, $jenis, $price, $stock, $image_url, $description);

            if ($stmt->execute()) {
                $success = "Produk berhasil ditambahkan.";
                header("Location: products.php?page=products");
                exit();
            } else {
                $error = "Gagal menambahkan produk: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #e6f2e6;
            font-family: 'Poppins', sans-serif;
        }
        .form-container {
            max-width: 500px;
            background: #d4e8d4;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(50, 205, 50, 0.3);
            margin: 60px auto;
            color: #2e7d32;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 700;
            color: #2e7d32;
        }
        label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            color: #2e7d32;
        }
        select, input[type="text"], input[type="number"], input[type="file"], textarea {
            border-radius: 8px;
            border: 2px solid #4caf50;
            padding: 10px 14px;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s;
            background-color: #fff;
        }
        select:focus, input:focus, textarea:focus {
            outline: none;
            border-color: #2d7a2d;
            box-shadow: 0 0 6px #2d7a2d;
        }
        textarea {
            resize: vertical;
        }
        .btn-primary {
            background-color: #4caf50;
            border: none;
            padding: 12px;
            font-weight: 700;
            font-size: 1.05rem;
            border-radius: 10px;
            width: 48%;
            transition: background-color 0.3s ease;
            cursor: pointer;
            color: white;
        }
        .btn-primary:hover {
            background-color: #388e3c;
        }
        .btn-secondary {
            background-color: #a3d1a3;
            border: none;
            padding: 12px;
            font-weight: 600;
            font-size: 1.05rem;
            border-radius: 10px;
            width: 48%;
            color: #2d5d2d;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }
        .btn-secondary:hover {
            background-color: #7bb37b;
            color: white;
        }
        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }
        .alert {
            border-radius: 10px;
            font-weight: 600;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Tambah Produk Baru</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title">Nama Produk</label>
            <input type="text" id="title" name="title" required value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" />
        </div>

        <div class="mb-3">
            <label for="genre">Jenis Produk</label>
            <select id="genre" name="genre" required>
                <option value="" disabled <?= empty($_POST['genre']) ? 'selected' : '' ?>>-- Pilih Jenis --</option>
                <option value="Sayuran" <?= (($_POST['genre'] ?? '') === 'Sayuran') ? 'selected' : '' ?>>Sayuran</option>
                <option value="Buah" <?= (($_POST['genre'] ?? '') === 'Buah') ? 'selected' : '' ?>>Buah</option>
                <option value="Bunga" <?= (($_POST['genre'] ?? '') === 'Bunga') ? 'selected' : '' ?>>Bunga</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="price">Harga (Rp)</label>
            <input type="text" id="price" name="price" required value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" />
        </div>

        <div class="mb-3">
            <label for="stock">Stok</label>
            <input type="number" id="stock" name="stock" min="0" required value="<?= htmlspecialchars($_POST['stock'] ?? '') ?>" />
        </div>

        <div class="mb-3">
            <label for="description">Deskripsi Produk</label>
            <textarea id="description" name="description" rows="4"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label for="image">Gambar Produk</label>
            <input type="file" id="image" name="image" accept="image/*" />
        </div>

        <div class="form-actions">
            <a href="dashboard_seller.php?page=products" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Tambah Produk</button>
        </div>
    </form>
</div>

</body>
</html>
