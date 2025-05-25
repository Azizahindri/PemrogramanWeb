<?php
include 'database/db.php'; // sesuaikan path jika perlu

$sql = "SELECT id, title, url FROM articles ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Daftar Artikel Freshure</title>
    <style>
        /* CSS sama seperti sebelumnya */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f8;
            margin: 40px;
            color: #333;
        }
        h1 {
            color: #2f7f5e;
            margin-bottom: 20px;
            text-align: center;
        }
        ul.article-list {
            list-style: none;
            padding: 0;
            max-width: 600px;
            margin: 0 auto;
        }
        ul.article-list li {
            background: #fff;
            margin-bottom: 12px;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(47, 127, 94, 0.2);
            transition: background 0.3s ease;
        }
        ul.article-list li:hover {
            background: #e6f0e9;
        }
        ul.article-list li a {
            color: #2f7f5e;
            font-weight: 600;
            text-decoration: none;
            font-size: 1.1rem;
            display: block;
        }
        ul.article-list li a:hover {
            text-decoration: underline;
        }
        .no-articles {
            text-align: center;
            color: #777;
            margin-top: 50px;
            font-style: italic;
        }
    </style>
</head>
<body>

<h1>Daftar Artikel Freshure</h1>

<?php if ($result && $result->num_rows > 0): ?>
    <ul class="article-list">
        <?php while($row = $result->fetch_assoc()): ?>
            <li>
                <a href="<?= htmlspecialchars($row['url']) ?>" target="_blank" rel="noopener noreferrer">
                    <?= htmlspecialchars($row['title']) ?>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p class="no-articles">Belum ada artikel yang tersedia.</p>
<?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
