<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../database/db.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'seller') {
    header("Location: ../login2.php");
    exit();
}

$seller_name = $_SESSION['first_name'] ?? 'Penjual';
$wa_number = $_SESSION['whatsapp'] ?? '6281234567890';
$wa_number_clean = preg_replace('/[^0-9]/', '', $wa_number);

$pesan = "Halo kak $seller_name, saya ingin melihat produk Anda. Silakan hubungi lewat WhatsApp.";
$wa_link = "https://wa.me/" . $wa_number_clean . "?text=" . urlencode($pesan);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lihat Pesanan - <?= htmlspecialchars($seller_name) ?></title>
    <link rel="stylesheet" href="../css/pesanan.css"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="pesanan-container">
    <h2>Lihat Pesanan</h2>
    <p>Silakan klik tombol di bawah untuk menghubungi dan menanggapi pesanan pelanggan Anda.</p>
    <a href="<?= $wa_link ?>" target="_blank" class="btn-wa">
        <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
    </a>
</div>

</body>
</html>
