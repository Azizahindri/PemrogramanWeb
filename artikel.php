<?php
include 'layout/header.php'; 

$sql = "SELECT id, title, url FROM articles ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<link href = "css/styleberanda.css" rel = "stylesheet">

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

<?php include("layout/footer.php"); ?>

