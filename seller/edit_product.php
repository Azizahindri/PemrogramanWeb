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

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    die("ID produk tidak valid.");
}

// Ambil data produk milik seller ini
$sql = "SELECT * FROM crud_041_book WHERE id = ? AND seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $seller_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Produk tidak ditemukan atau Anda tidak berhak mengedit produk ini.");
}

$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    $description = trim($_POST['description'] ?? '');

    // Handle upload gambar
    $image_url = $product['image_url']; // default image lama
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = basename($_FILES['image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_ext, $allowed_ext)) {
            // Folder upload
            $upload_dir = '../uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            // Generate nama file unik
            $new_filename = uniqid('prod_') . '.' . $file_ext;
            $upload_path = $upload_dir . $new_filename;

            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Hapus gambar lama jika ada
                if (!empty($image_url) && file_exists('../' . $image_url)) {
                    unlink('../' . $image_url);
                }
                $image_url = 'uploads/' . $new_filename;
            } else {
                $error = "Gagal mengupload gambar.";
            }
        } else {
            $error = "Format gambar tidak didukung. Gunakan JPG, PNG, GIF.";
        }
    }

    if (!$title || $price <= 0 || $stock < 0) {
        $error = "Mohon isi data dengan benar.";
    }

    if (!$error) {
        $sql_update = "UPDATE crud_041_book SET title = ?, price = ?, stock = ?, description = ?, image_url = ? WHERE id = ? AND seller_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sdissii", $title, $price, $stock, $description, $image_url, $id, $seller_id);

        if ($stmt_update->execute()) {
            $success = "Produk berhasil diperbarui.";
            header("Location: products.php?page=products");
            exit();
        } else {
            $error = "Gagal memperbarui produk: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body { background-color: #e9f5e9; font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; padding: 20px; border-radius: 8px; border: 2px solid #4caf50; box-shadow: 0 2px 8px rgba(76,175,80,0.3);}
        h2 { color: #2f6d2f; font-weight: 700; margin-bottom: 20px; text-align: center; }
        label { font-weight: 600; color: #3a5d3a; }
        .btn-primary { background-color: #4caf50; border-color: #4caf50; }
        .btn-primary:hover { background-color: #3a8c3a; border-color: #3a8c3a; }
        .btn-secondary { border-color: #4caf50; color: #4caf50; }
        .btn-secondary:hover { background-color: #e9f5e9; color: #3a5d3a; }
        .img-preview { width: 100%; height: 180px; object-fit: contain; border-radius: 6px; background: #fff; margin-bottom: 12px; border: 1px solid #4caf50; }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Produk</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Nama Produk</label>
            <input type="text" name="title" id="title" class="form-control" required value="<?= htmlspecialchars($product['title']) ?>" />
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga (Rp)</label>
            <input type="number" name="price" id="price" class="form-control" required min="0" step="0.01" value="<?= htmlspecialchars($product['price']) ?>" />
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stok</label>
            <input type="number" name="stock" id="stock" class="form-control" required min="0" value="<?= htmlspecialchars($product['stock']) ?>" />
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Produk</label>
            <textarea name="description" id="description" rows="4" class="form-control"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Gambar Produk (opsional)</label>
            <?php if (!empty($product['image_url'])): ?>
                <img src="../<?= htmlspecialchars($product['image_url']) ?>" alt="Preview Gambar" class="img-preview" />
            <?php else: ?>
                <div class="img-preview" style="display:flex; align-items:center; justify-content:center; color:#4caf50;">Tidak ada gambar</div>
            <?php endif; ?>
            <input type="file" name="image" id="image" accept=".jpg,.jpeg,.png,.gif" class="form-control mt-2" />
        </div>

        <a href="products.php?page=products" class="btn btn-secondary me-2">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>

</body>
</html>
