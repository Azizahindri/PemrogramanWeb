<?php
include '../database/db.php';

// Ambil artikel pertama (tanpa pakai id)
$article = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM articles LIMIT 1"));

// Jika artikel tidak ditemukan
if (!$article) {
    echo "Artikel tidak ditemukan.";
    exit;
}

$article_id = $article['id']; // Tetap butuh id dari database untuk proses update

// Proses update jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $url = mysqli_real_escape_string($conn, $_POST['url']);
    mysqli_query($conn, "UPDATE articles SET title = '$title', url = '$url' WHERE id = $article_id");
    header("Location: admin_articles.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Artikel</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9f9f9;
            padding: 30px;
        }
        h1 {
            color: #2e7d32;
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        input[type="url"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }
        .btn {
            padding: 10px 18px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            margin-right: 10px;
        }
        .btn:hover {
            background: #388e3c;
        }
        .btn-secondary {
            background: #9e9e9e;
        }
        .btn-secondary:hover {
            background: #757575;
        }
        .form-actions {
            text-align: right;
        }
    </style>
</head>
<body>

<h1>Edit Artikel</h1>

<form method="post">
    <label for="title">Judul Artikel</label>
    <input type="text" id="title" name="title" value="<?= htmlspecialchars($article['title']) ?>" required>

    <label for="url">URL Artikel</label>
    <input type="url" id="url" name="url" value="<?= htmlspecialchars($article['url']) ?>" required>

    <div class="form-actions">
        <button type="submit" class="btn">Simpan Perubahan</button>
        <a href="admin_articles.php" class="btn btn-secondary">Batal</a>
    </div>
</form>

</body>
</html>
