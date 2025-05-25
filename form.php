<?php
session_start();
include 'database/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$isEdit = isset($_GET['id']);
if ($isEdit) {
    $id_review = $_GET['id'];
    $queryReview = "SELECT * FROM crud_041_book_reviews WHERE id = ?";
    $stmtReview = $conn->prepare($queryReview);
    $stmtReview->bind_param("s", $id_review);
    $stmtReview->execute();
    $resultReview = $stmtReview->get_result();

    if ($resultReview->num_rows > 0) {
        $review = $resultReview->fetch_assoc();
    } else {
        echo "Review tidak ditemukan.";
        exit;
    }
}

$queryBook = "SELECT * FROM crud_041_book";
$result = mysqli_query($conn, $queryBook);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $isEdit ? "Edit Review" : "Tulis Review" ?> Tumbuhan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.5/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="form-page">

<div class="header">
    <h1><?= $isEdit ? "Edit Review" : "Tulis Review" ?> ✎</h1>
    <p><?= $isEdit ? "Ubah ulasan Anda untuk tumbuhan ini." : "Tulis ulasan dan beri rating tumbuhan hidroponik favorit Anda!" ?></p>
    <hr>
</div>

<div class="container">
    <form id="reviewForm" action="<?= $isEdit ? 'database/update.php' : 'database/create.php' ?>" method="POST">
        <div class="form-group">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?= $isEdit ? htmlspecialchars($review['name']) : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="book_title">Jenis Tumbuhan:</label>
            <select id="book_title" name="book_title" class="form-control" required>
                <option value="">Pilih jenis tumbuhan</option>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= $row['id_book'] ?>" <?= ($isEdit && $review['book_id'] == $row['id_book']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['title']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="review">Isi Review:</label>
            <textarea id="review" name="review" class="form-control" rows="4" required><?= $isEdit ? htmlspecialchars($review['review']) : '' ?></textarea>
        </div>

        <div class="form-group">
            <label for="rating">Rating:</label>
            <div class="rating">
                <?php for ($i = 5; $i >= 1; $i--): ?>
                    <input type="radio" name="rating" id="rating<?= $i ?>" value="<?= $i ?>" <?= ($isEdit && $review['rating'] == $i) ? 'checked' : '' ?>>
                    <label for="rating<?= $i ?>">★</label>
                <?php endfor; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="date">Tanggal:</label>
            <input type="date" id="date" name="date" class="form-control" value="<?= $isEdit ? $review['date'] : '' ?>" required>
        </div>

        <input type="hidden" name="id" value="<?= $isEdit ? $review['id'] : '' ?>">

        <?php if ($isEdit): ?>
            <input type="button" value="Update Review" class="btn btn-success" onclick="return showUpdateAlert();">
            <a href="database/delete.php?id=<?= urlencode($review['id']) ?>" class="btn btn-danger" onclick="return showDeleteAlert(<?= $review['id'] ?>);">Hapus</a>
        <?php else: ?>
            <input type="button" value="Simpan" class="btn btn-primary" onclick="return showSaveAlert();">
            <input type="reset" value="Reset" class="btn btn-secondary" onclick="return showResetAlert();">
        <?php endif; ?>
        <a href="Beranda.php" class="btn btn-link">Kembali</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showSaveAlert() {
        Swal.fire({ title: 'Berhasil!', text: 'Review berhasil ditambahkan!', icon: 'success' }).then(() => {
            document.getElementById("reviewForm").submit();
        });
        return false;
    }

    function showUpdateAlert() {
        Swal.fire({ title: 'Berhasil!', text: 'Review berhasil diperbarui!', icon: 'success' }).then(() => {
            document.getElementById("reviewForm").submit();
        });
        return false;
    }

    function showResetAlert() {
        Swal.fire({
            title: 'Reset formulir?',
            text: 'Semua isian akan dikosongkan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, reset',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("reviewForm").reset();
            }
        });
        return false;
    }

    function showDeleteAlert(id) {
        Swal.fire({
            title: 'Yakin hapus review ini?',
            text: 'Data akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'database/delete.php?id=' + id;
            }
        });
        return false;
    }
</script>

</body>
</html>

<?php $conn->close(); ?>
