</div> <!-- Tutup .container -->

<footer>
  <p>&copy; 2025 Freshure. Semua Hak Dilindungi.</p>
  <p>
    <a href="#">Kebijakan Privasi</a> | <a href="#">Syarat &amp; Ketentuan</a>
  </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function searchBooks() {
    const filter = document.getElementById('searchInput')?.value.toUpperCase();
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

  function konfirmasiLogout(event) {
    event.preventDefault();
    Swal.fire({
      title: 'Yakin ingin logout?',
      text: "Sesi kamu akan diakhiri.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Logout',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = 'log/logout.php';
      }
    });
  }
</script>

</body>
</html>
<?php $conn->close(); ?>
