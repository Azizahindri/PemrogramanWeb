<?php
session_start();
include '../database/db.php';

// Cek role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login2.php");
    exit();
}

// Pastikan parameter id dikirim
if (!isset($_GET['id'])) {
    echo "ID produk tidak ditemukan.";
    exit();
}

$id = $_GET['id'];

// Ambil data produk dulu untuk hapus gambar (jika perlu)
$stmtSelect = $conn->prepare("SELECT image_url FROM crud_041_book WHERE id_book = ?");
$stmtSelect->bind_param("s", $id);
$stmtSelect->execute();
$result = $stmtSelect->get_result();

if ($result->num_rows === 0) {
    echo "Produk tidak ditemukan.";
    exit();
}

$product = $result->fetch_assoc();
$image_path = "../" . $product['image_url']; // path ke file gambar

// Hapus produk dari database
$stmtDelete = $conn->prepare("DELETE FROM crud_041_book WHERE id_book = ?");
$stmtDelete->bind_param("s", $id);

if ($stmtDelete->execute()) {
    // Hapus file gambar jika ada
    if (file_exists($image_path)) {
        unlink($image_path);
    }

    echo "<script>alert('Produk berhasil dihapus.'); window.location.href='produk_list.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus produk.'); window.location.href='produk_list.php';</script>";
}

$stmtDelete->close();
$conn->close();
?>
