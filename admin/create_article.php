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
    <style>
        body {
            background-color: #f7fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 60px;
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #2f855a;
            margin-bottom: 25px;
            font-weight: 700;
            text-align: center;
        }
        .btn-primary {
            background-color: #2f855a;
            border-color: #2f855a;
        }
        .btn-primary:hover {
            background-color: #276749;
            border-color: #276749;
        }
        a.back-link {
            display: inline-block;
            margin-top: 15px;
            color: #2f855a;
            text-decoration: none;
            font-weight: 600;
        }
        a.back-link:hover {
            text-decoration: underline;
        }
    </style>
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
