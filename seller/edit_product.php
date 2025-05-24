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

// Ambil data produk dari database, pastikan produk milik seller ini
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
    $jenis = trim($_POST['jenis'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);

    if (!$title || !$jenis || $price <= 0 || $stock < 0) {
        $error = "Mohon isi semua data dengan benar.";
    } else {
        $sql_update = "UPDATE crud_041_book SET title = ?, jenis = ?, price = ?, stock = ? WHERE id = ? AND seller_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssdiii", $title, $jenis, $price, $stock, $id, $seller_id);

        if ($stmt_update->execute()) {
            $success = "Produk berhasil diperbarui.";
            // Refresh data produk
            $product['title'] = $title;
            $product['jenis'] = $jenis;
            $product['price'] = $price;
            $product['stock'] = $stock;
            // Optional: redirect ke halaman produk
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
</head>
<body class="p-4">

<div class="container">
    <h2>Edit Produk</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="title" class="form-label">Nama Produk</label>
            <input type="text" name="title" id="title" class="form-control" required value="<?= htmlspecialchars($product['title']) ?>" />
        </div>
        <div class="mb-3">
            <label for="jenis" class="form-label">Jenis Produk</label>
            <input type="text" name="jenis" id="jenis" class="form-control" required value="<?= htmlspecialchars($product['jenis']) ?>" />
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Harga (Rp)</label>
            <input type="number" name="price" id="price" class="form-control" required min="0" step="0.01" value="<?= htmlspecialchars($product['price']) ?>" />
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stok</label>
            <input type="number" name="stock" id="stock" class="form-control" required min="0" value="<?= htmlspecialchars($product['stock']) ?>" />
        </div>

        <a href="dashboard.php?page=products" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>

</body>
</html>
