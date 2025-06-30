<?php
include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $url = mysqli_real_escape_string($conn, $_POST['url']);
    mysqli_query($conn, "INSERT INTO articles (title, url, created_at) VALUES ('$title', '$url', NOW())");
    header("Location: admin_articles.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tambah Artikel - Admin Freshure</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css_admin/create_article.css" rel="stylesheet" />

</head>
<body>

<div class="container shadow-sm">
    <h2>Tambah Artikel Baru</h2>
    <form method="post" novalidate>
        <div class="mb-3">
            <label for="title" class="form-label">Judul Artikel</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul artikel" required>
            <div class="invalid-feedback">
                Judul artikel wajib diisi.
            </div>
        </div>
        <div class="mb-3">
            <label for="url" class="form-label">URL Artikel</label>
            <input type="url" class="form-control" id="url" name="url" placeholder="https://contoh.com/artikel" required>
            <div class="invalid-feedback">
                URL harus valid dan wajib diisi.
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Simpan Artikel</button>
    </form>
    <a href="admin_articles.php" class="back-link">← Kembali ke Daftar Artikel</a>
</div>

<!-- Bootstrap JS + Popper (untuk validasi form) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Bootstrap form validation
(() => {
    'use strict'
    const forms = document.querySelectorAll('form')
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})();
</script>

</body>
</html>
