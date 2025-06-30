<?php
session_start();
include '../database/db.php';

// Cek apakah user login dan berperan sebagai admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login2.php");
    exit();
}

// Pastikan parameter ID dikirim melalui GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID produk tidak valid.'); window.location.href='produk_list.php';</script>";
    exit();
}

$id = $_GET['id'];

// Ambil data produk berdasarkan ID untuk mendapatkan path gambar
$stmtSelect = $conn->prepare("SELECT image_url FROM crud_041_book WHERE id_book = ?");
$stmtSelect->bind_param("s", $id);
$stmtSelect->execute();
$result = $stmtSelect->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Produk tidak ditemukan.'); window.location.href='produk_list.php';</script>";
    exit();
}

$product = $result->fetch_assoc();
$image_path = "../" . $product['image_url']; // Path lengkap gambar

$stmtSelect->close();

// Hapus produk dari database
$stmtDelete = $conn->prepare("DELETE FROM crud_041_book WHERE id_book = ?");
$stmtDelete->bind_param("s", $id);

if ($stmtDelete->execute()) {
    // Hapus gambar jika file benar-benar ada
    if (!empty($product['image_url']) && file_exists($image_path)) {
        unlink($image_path);
    }

    echo "<script>alert('Produk berhasil dihapus.'); window.location.href='produk_list.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus produk.'); window.location.href='produk_list.php';</script>";
}

$stmtDelete->close();
$conn->close();
?>
