<?php
include 'database/db.php';
// Query buku hanya jika nanti dibutuhkan
$query = "SELECT * FROM crud_041_book";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tentang Kami - Freshure</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
</head>
<body class="about-page">

<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container">
    <a class="navbar-brand" href="Beranda.php">Freshure</a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="Beranda.php">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="about.php" aria-current="page">Tentang Kami</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container my-5">
  <h2 class="section-title">Tentang Freshure</h2>
  <div class="about-section">
    <p class="about-text">
      Selamat datang di <strong>Freshure</strong>, tempat di mana tanaman hidroponik berkualitas tinggi bertemu dengan para pecinta pertanian modern! Kami menghadirkan beragam pilihan sayur segar, buah lezat, dan bunga indah yang ditanam secara ramah lingkungan.
    </p>
    <p class="about-text">
      Kami percaya bahwa makanan sehat dan lingkungan yang lebih hijau adalah masa depan. Bergabunglah dengan kami dalam perjalanan menuju gaya hidup sehat dan berkelanjutan 🌱
    </p>
  </div>

  <h3 class="section-title">Tim Kami</h3>
  <div class="row justify-content-center">
    <div class="col-md-3 text-center team-member">
      <img src="images/mh.jpg" alt="Xu Minghao" />
      <h5>Xu Minghao</h5>
      <p>CEO & Founder</p>
    </div>
    <div class="col-md-3 text-center team-member">
      <img src="images/dk.jpg" alt="Lee Dokyeom" />
      <h5>Lee Dokyeom</h5>
      <p>Creative Director</p>
    </div>
    <div class="col-md-3 text-center team-member">
      <img src="images/sc.jpg" alt="Choi Seungcheol" />
      <h5>Choi Seungcheol</h5>
      <p>Lead Developer</p>
    </div>
  </div>
</div>

<footer>
  <p>&copy; 2025 Freshure. Semua Hak Dilindungi.</p>
  <p>
    <a href="#">Kebijakan Privasi</a> | <a href="#">Syarat &amp; Ketentuan</a>
  </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
