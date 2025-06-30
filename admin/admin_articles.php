<?php
include '../database/db.php';

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
    <link href="../css_admin/admin_articles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-success mb-4 text-center">Kelola Artikel Freshure</h1>

    <div class="mb-4 text-center">
        <a href="create_article.php" class="btn btn-primary">+ Tambah Artikel</a>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-success">
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
                    <td>
                        <a href="edit_article.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="admin_articles.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin ingin menghapus artikel ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <p class="text-center text-muted">Tidak ada artikel.</p>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="dashboard_admin.php" class="btn btn-success"><i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard</a>
    </div>
</div>

<!-- Bootstrap & Font Awesome -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</body>
</html>
