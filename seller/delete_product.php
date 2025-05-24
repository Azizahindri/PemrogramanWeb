<?php
session_start();
include '../database/db.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'seller') {
    header("Location: ../login2.php");
    exit();
}

$seller_id = $_SESSION['user_id'];
$id = intval($_GET['id'] ?? 0);

if (!$id) {
    die("ID produk tidak valid.");
}

// Pastikan produk milik seller
$sql = "SELECT * FROM crud_041_book WHERE id = ? AND seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $seller_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Produk tidak ditemukan atau Anda tidak berhak menghapus produk ini.");
}

// Hapus produk
$sql_delete = "DELETE FROM crud_041_book WHERE id = ? AND seller_id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("ii", $id, $seller_id);

if ($stmt_delete->execute()) {
    // Redirect kembali ke halaman produk
    header("Location: products.php?page=products");
    exit();
} else {
    die("Gagal menghapus produk: " . $conn->error);
}
