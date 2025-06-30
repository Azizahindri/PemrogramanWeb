<?php
session_start();
include("layout/header.php");

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
<div class="container my-5">
  <h1 class="text-center mb-3">Freshure</h1>
  <p class="lead text-center mb-5">
    Panen Segar Setiap Hari! Pilih Sayur dan Buah Hidroponik Berkualitas untuk Hidangan Sehatmu!
  </p>

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
    <div class="mb-4 mx-auto" style="max-width:400px;">
    <input type="text" id="searchInput" class="form-control" placeholder="Cari tumbuhan..." onkeyup="searchBooks()">
  </div>
  <div class="book-list" id="bookList">
    <?php while($row = mysqli_fetch_assoc($resultAllBook)): ?>
      <div class="book-item <?= htmlspecialchars($row['genre']) ?>" 
           onclick="location.href='informasi.php?id_book=<?= urlencode($row['id_book']) ?>'">
        <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['title']) ?>" />
        <h5><?= htmlspecialchars($row['title']) ?></h5>
        <p>Rp <?= number_format($row['price'],0,',','.') ?></p>
        <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php include("layout/footer.php"); ?>

