<?php
include '../database/db.php';

// Validasi ID dari parameter GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID artikel tidak valid.";
    exit;
}

$article_id = (int) $_GET['id'];

// Ambil artikel berdasarkan ID
$article = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM articles WHERE id = $article_id"));

if (!$article) {
    echo "Artikel tidak ditemukan.";
    exit;
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $url = mysqli_real_escape_string($conn, $_POST['url']);

    mysqli_query($conn, "UPDATE articles SET title = '$title', url = '$url' WHERE id = $article_id");

    // Redirect setelah update
    header("Location: admin_articles.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Artikel</title>
    <link rel="stylesheet" href="../css_admin/edit_article.css">
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
