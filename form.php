<?php
session_start();
include 'database/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$isEdit = isset($_GET['id']) ? true : false;

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Review tumbuhan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.5/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        body {
            background-color: rgb(28, 79, 45);
            font-family: 'Poppins', sans-serif;
        }
        .header {
            text-align: center;
            color: rgb(255, 255, 255);
            margin-top: 30px;
        }
        .header h1 {
            font-size: 72px;
            font-weight: bold;
        }
        .header p {
            font-size: 18px;
            margin-top: 10px;
        }
        .container {
            max-width: 600px;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .rating {
            display: flex;
            justify-content: center;
            margin-top: 10px;
            direction: row;
        }
        .rating input {
            display: none;
        }
        .rating label {
            font-size: 35px;
            color: #ccc;
            cursor: pointer;
        }
        .rating input:checked ~ label,
        .rating label:hover,
        .rating label:hover ~ label {
            color: #ffcc00; 
        }
        .rating input:checked + label {
            color: #ffcc00;
        }
    </style>
</head>
<body>

<div class="header">
        <h1><?= $isEdit ? "Edit Review" : "Tulis Review" ?> ✎</h1>
        <p><?= $isEdit ? "Ubah ulasan Anda untuk tumbuhan ini." : "Tulis ulasan dan beri rating tumbuhan ini." ?></p>
        <hr>
    </div>

    <div class="container">
        <form id="reviewForm" action="<?= $isEdit ? 'database/update.php' : 'database/create.php' ?>" method="POST">
            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= $isEdit ? htmlspecialchars($review['name']) : '' ?>" placeholder="Masukkan nama Anda" required>
            </div>

            <div class="form-group">
                <label for="bookTitle">Jenis:</label>
                <select id="book_title" name="book_title" class="form-control" required>
                    <option value="">Pilih jenis tumbuhan</option>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        $selected = ($isEdit && $review['book_id'] == $row['id_book']) ? 'selected' : '';
                        echo "<option value='" . $row['id_book'] . "' $selected>" . $row['title'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="reviewContent">Isi Review:</label>
                <textarea id="review" name="review" class="form-control" rows="4" placeholder="Tulis review Anda..." required><?= $isEdit ? htmlspecialchars($review['review']) : '' ?></textarea>
            </div>

            <div class="form-group">
                <label for="rating">Rating (1-5):</label>
                <div class="rating">
                    <?php
                    for ($i = 5; $i >= 1; $i--) {
                        $checked = ($isEdit && $review['rating'] == $i) ? 'checked' : '';
                        echo "<input type='radio' name='rating' id='rating$i' value='$i' $checked><label for='rating$i'>★</label>";
                    }
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label for="date">Tanggal:</label>
                <input type="date" id="date" name="date" class="form-control" value="<?= $isEdit ? $review['date'] : '' ?>" required>
            </div>

            <input type="hidden" name="id" value="<?= $isEdit ? $review['id'] : '' ?>"> <!-- Hanya ada jika edit -->

            <?php if ($isEdit): ?>
                <input type="button" value="Update Review" class="btn btn-primary mb-3" onclick="return showUpdateAlert();">
            <?php else: ?>
                <input type="button" value="Save" class="btn btn-primary mb-3" onclick="return showSaveAlert();">
            <?php endif; ?>
            <?php if ($isEdit): ?>
                <a href="database/delete.php?id=<?= urlencode($review['id']) ?>" class="btn btn-danger mb-3" onclick="return showDeleteAlert(<?= $review['id'] ?>);">Delete</a>
            <?php endif; ?>
            <?php if (!$isEdit): ?>
                <input type="reset" value="Reset" class="btn btn-secondary mb-3" onclick="return showResetAlert();">
            <?php endif; ?>
            <a href="Beranda.php" class="btn btn-link">Back</a>
        </form>
    </div>

  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function showSaveAlert() {
        Swal.fire({
            title: 'Berhasil!',
            text: 'Review telah ditambahkan!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("reviewForm").submit(); 
            }
        });
        return false;
    }

    function showUpdateAlert() {
        Swal.fire({
            title: 'Berhasil!',
            text: 'Review telah diperbarui!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("reviewForm").submit(); 
            }
        });
        return false;
    }

    function showResetAlert() {
        Swal.fire({
            title: 'Reset?',
            text: 'Formulir akan dikosongkan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, reset',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('reviewForm').reset();
            }
        });
        return false;
    }

    function showDeleteAlert(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Review ini akan dihapus permanen!',
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

</body>
</html>

<?php $conn->close(); ?>
