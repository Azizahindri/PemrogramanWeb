<?php
include '../database/db.php'; // sesuaikan path

// Hapus artikel jika diminta
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM articles WHERE id = $id");
    header("Location: admin_articles.php");
    exit();
}

// Ambil semua artikel
$result = mysqli_query($conn, "SELECT * FROM articles ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Artikel Freshure</title>
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
        .btn {
            padding: 8px 14px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            margin: 5px;
        }
        .btn:hover {
            background: #388e3c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        th {
            background-color: #e0f2f1;
            text-align: left;
        }
        .action {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>

<h1>Kelola Artikel Freshure</h1>
<a href="create_article.php" class="btn">+ Tambah Artikel</a>

<?php if (mysqli_num_rows($result) > 0): ?>
<table>
    <thead>
        <tr>
            <th>Judul</th>
            <th>URL</th>
            <th>Dibuat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><a href="<?= htmlspecialchars($row['url']) ?>" target="_blank">Lihat</a></td>
            <td><?= $row['created_at'] ?></td>
            <td class="action">
                <a href="edit_article.php?id=<?= $row['id'] ?>" class="btn">Edit</a>
                <a href="admin_articles.php?delete=<?= $row['id'] ?>" class="btn" onclick="return confirm('Yakin ingin menghapus artikel ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
    <p>Tidak ada artikel.</p>
<?php endif; ?>

</body>
</html>
