<?php
include 'database/db.php';
$query = "SELECT * FROM crud_041_book";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tentang Kami - Freshure</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f6fff8;
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar {
      background-color: #ffffff;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .navbar-brand {
      color: #2b9348 !important;
      font-weight: bold;
    }
    .nav-link {
      color: #2b9348 !important;
      font-weight: 500;
    }
    .nav-link.active, .nav-link:hover {
      color: #40916c !important;
    }
    .section-title {
      color: #1b4332;
      font-weight: bold;
      margin-bottom: 20px;
    }
    .book-item {
      background-color: #ffffff;
      border: 1px solid #dbe9e2;
      border-radius: 10px;
      padding: 15px;
      margin: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .book-item img {
      width: 100%;
      border-radius: 8px;
      margin-bottom: 10px;
    }
    .about-section {
      background-color: #e9f5ec;
      padding: 40px 20px;
      border-radius: 12px;
      margin-bottom: 30px;
    }
    .about-text {
      color: #2d6a4f;
      text-align: justify;
    }
    .team-member img {
      border-radius: 50%;
      width: 120px;
      height: 120px;
      object-fit: cover;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .team-member h5 {
      margin-top: 10px;
      color: #081c15;
    }
    footer {
      background-color: #ffffff;
      padding: 20px;
      text-align: center;
      color: #40916c;
    }
    footer a {
      color: #1b4332;
      text-decoration: none;
    }
    footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container">
    <a class="navbar-brand" href="Beranda.php">Freshure</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link active" href="Beranda.php">Beranda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">Tentang Kami</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Jenis </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#" onclick="clearFilter()">All</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterGenre('Sayuran')">Sayur</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterGenre('Buah')">Buah</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterGenre('Bunga')">Bunga</a></li>
                </ul>
            </li>
        </ul>
    </div>
  </div>
</nav>

<div class="container my-5">
  <h2 class="section-title text-center">Tentang Freshure</h2>
  <div class="about-section">
    <p class="about-text">
      Selamat datang di <strong>Freshure</strong>, tempat di mana tanaman hidroponik berkualitas tinggi bertemu dengan para pecinta pertanian modern! Kami menghadirkan beragam pilihan sayur segar, buah lezat, dan bunga indah yang ditanam secara ramah lingkungan.
    </p>
    <p class="about-text">
      Kami percaya bahwa makanan sehat dan lingkungan yang lebih hijau adalah masa depan. Bergabunglah dengan kami dalam perjalanan menuju gaya hidup sehat dan berkelanjutan 🌱
    </p>
  </div>

  <h3 class="section-title text-center">Tim Kami</h3>
  <div class="row justify-content-center">
    <div class="col-md-3 text-center team-member">
      <img src="images/mh.jpg" alt="Xu Minghao">
      <h5>Xu Minghao</h5>
      <p>CEO & Founder</p>
    </div>
    <div class="col-md-3 text-center team-member">
      <img src="images/dk.jpg" alt="Lee Dokyeom">
      <h5>Lee Dokyeom</h5>
      <p>Creative Director</p>
    </div>
    <div class="col-md-3 text-center team-member">
      <img src="images/sc.jpg" alt="Choi Seungcheol">
      <h5>Choi Seungcheol</h5>
      <p>Lead Developer</p>
    </div>
  </div>

  <!-- Buku: Hanya Tampil Setelah Filter Dipilih -->
  <div id="bookSection" style="display: none;">
    <h3 class="section-title text-center mt-5">Daftar Buku</h3>
    <div class="row" id="bookList">
      <?php mysqli_data_seek($result, 0); while($row = mysqli_fetch_assoc($result)): ?>
        <div class="col-md-4 book-item <?= htmlspecialchars($row['genre']) ?>">
          <div class="book-item">
            <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
            <h5><?= htmlspecialchars($row['title']) ?></h5>
            <p><strong>Penulis:</strong> <?= htmlspecialchars($row['price']) ?></p>
            <details>
              <summary>Deskripsi buku</summary>
              <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
            </details>
            <a href="Review.php?id_book=<?= urlencode($row['id_book']) ?>" class="btn btn-success btn-sm mt-2">Review</a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</div>

<footer>
  <p>&copy; 2025 Freshure. Semua Hak Dilindungi.</p>
  <p><a href="#">Kebijakan Privasi</a> | <a href="#">Syarat & Ketentuan</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function filterGenre(genre) {
  const section = document.getElementById("bookSection");
  section.style.display = 'block';
  const items = document.querySelectorAll("#bookList .book-item");
  items.forEach(item => {
    item.style.display = item.classList.contains(genre) ? 'block' : 'none';
  });
}

function clearFilter() {
  const section = document.getElementById("bookSection");
  section.style.display = 'block';
  const items = document.querySelectorAll("#bookList .book-item");
  items.forEach(item => {
    item.style.display = 'block';
  });
}
</script>
</body>
</html>
