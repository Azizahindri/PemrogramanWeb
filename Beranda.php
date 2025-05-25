<?php
session_start();
include("database/db.php");

$username = '';
$first_name = '';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($first_name, $last_name);
    $stmt->fetch();
    $username = "$first_name $last_name";
    $stmt->close();
}

$query = "
    SELECT b.id_book, b.title, b.price,
           ROUND(AVG(br.rating),1) AS average_rating
    FROM crud_041_book b
    LEFT JOIN crud_041_book_reviews br ON b.id_book = br.book_id
    GROUP BY b.id_book, b.title, b.price
    ORDER BY average_rating DESC
";
$result = mysqli_query($conn, $query);

$queryAllBook = "SELECT * FROM crud_041_book";
$resultAllBook = mysqli_query($conn, $queryAllBook);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Freshure - Beranda</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/styleberanda.css" />
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container">
    <a class="navbar-brand text-success fw-bold" href="Beranda.php">Freshure</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="Beranda.php">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">Tentang Kami</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="jenisDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Jenis</a>
          <ul class="dropdown-menu" aria-labelledby="jenisDropdown">
            <li><a class="dropdown-item" href="#" onclick="clearFilter()">All</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterGenre('Sayuran')">Sayur</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterGenre('Buah')">Buah</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterGenre('Bunga')">Bunga</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="artikel.php"> Artikel</a></li>
        <li class="nav-item">
          <?php if ($username): ?>
            <a class="nav-link" href="log/logout.php">Logout</a>
          <?php else: ?>
            <a class="nav-link" href="log/login2.php">Login</a>
          <?php endif; ?>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container my-5">

  <?php if ($username): ?>
    <p class="text-end fst-italic">Hai, <?= htmlspecialchars($first_name) ?>!</p>
  <?php endif; ?>

  <h1 class="text-center mb-3">Freshure</h1>
  <p class="lead text-center mb-5">
    Panen Segar Setiap Hari! Pilih Sayur dan Buah Hidroponik Berkualitas untuk Hidangan Sehatmu!
  </p>

  <div class="mb-4 mx-auto" style="max-width:400px;">
    <input type="text" id="searchInput" class="form-control" placeholder="Cari tumbuhan..." onkeyup="searchBooks()">
  </div>

  <h2 class="text-center mt-5 mb-4">Pilihan Terbaik Menurut Rating</h2>
<table class="table-custom">
  <thead>
    <tr>
      <th>Tumbuhan</th>
      <th>Rating</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): 
      $fullStars = floor($row['average_rating']);
      $halfStar = ($row['average_rating'] - $fullStars) >= 0.5 ? true : false;
      $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
    ?>
    <?php if ($row['average_rating'] > 4): ?>
      <tr onclick="location.href='review.php?id_book=<?= urlencode($row['id_book']) ?>'">
        <td><?= htmlspecialchars($row['title']) ?></td>
        <td>
          <?php 
          for ($i = 0; $i < $fullStars; $i++) echo '<span class="star-icon">★</span>'; 
          if ($halfStar) echo '<span class="star-icon">☆</span>'; 
          for ($i = 0; $i < $emptyStars; $i++) echo '<span class="star-icon">☆</span>'; 
          ?>
        </td>
        <td>
          <a href="review.php?id_book=<?= urlencode($row['id_book']) ?>" class="btn-sm">Review</a>
        </td>
      </tr>
    <?php endif; ?>
    <?php endwhile; ?>
  <?php else: ?>
    <tr><td colspan="3">Tidak ada data.</td></tr>
  <?php endif; ?>
  </tbody>
</table>
<hr>
  <h2 class="text-center mb-4">Daftar Tumbuhan</h2>
  <div class="book-list" id="bookList">
    <?php while($row = mysqli_fetch_assoc($resultAllBook)): ?>
      <div class="book-item <?= htmlspecialchars($row['genre']) ?>" 
           onclick="location.href='informasi.php?id_book=<?= urlencode($row['id_book']) ?>'">
        <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['title']) ?>" />
        <h5><?= htmlspecialchars($row['title']) ?></h5>
        <p>Rp <?= number_format($row['price'],0,',','.') ?></p>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<footer class="text-center py-4 bg-light text-success fw-semibold">
  &copy; 2025 Freshure. Semua Hak Dilindungi.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function searchBooks() {
  const filter = document.getElementById('searchInput').value.toUpperCase();
  document.querySelectorAll('.book-item').forEach(item => {
    const title = item.querySelector('h5').innerText.toUpperCase();
    item.style.display = title.includes(filter) ? '' : 'none';
  });
}
function filterGenre(genre) {
  document.querySelectorAll('.book-item').forEach(item => {
    item.style.display = item.classList.contains(genre) ? '' : 'none';
  });
}
function clearFilter() {
  document.querySelectorAll('.book-item').forEach(item => {
    item.style.display = '';
  });
}
</script>
</body>
</html>

<?php $conn->close(); ?>
