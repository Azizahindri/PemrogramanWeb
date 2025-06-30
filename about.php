<?php
include 'layout/header.php';
// Query buku hanya jika nanti dibutuhkan
$query = "SELECT * FROM crud_041_book";
$result = mysqli_query($conn, $query);
?>
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

<?php include("layout/footer.php"); ?>

