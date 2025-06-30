<?php
session_start();
include 'layout/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: log/login2.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    
    if ($first_name && $last_name && $email) {
        $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE id = ?");
        $stmt->bind_param("sssi", $first_name, $last_name, $email, $user_id);
        if ($stmt->execute()) {
            $message = "Profil berhasil diperbarui.";
        } else {
            $message = "Gagal memperbarui profil: " . $conn->error;
        }
        $stmt->close();
    } else {
        $message = "Semua field harus diisi!";
    }
}

$stmt = $conn->prepare("SELECT first_name, last_name, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "User tidak ditemukan.";
    exit;
}
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profil Saya</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="css/styleberanda.css" rel="stylesheet" />
  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <main class="container d-flex flex-column align-items-center mt-5" role="main" style="max-width: 500px;">
    <h1 class="mb-4">Profil Saya</h1>

    <?php if (isset($message)): ?>
      <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" action="" class="w-100">
      <div class="mb-3">
        <label for="first_name" class="form-label">First Name</label>
        <input id="first_name" name="first_name" type="text" class="form-control" value="<?= htmlspecialchars($user['first_name']) ?>" required />
      </div>
      <div class="mb-3">
        <label for="last_name" class="form-label">Last Name</label>
        <input id="last_name" name="last_name" type="text" class="form-control" value="<?= htmlspecialchars($user['last_name']) ?>" required />
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" name="email" type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required />
      </div>
      
      <button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>
      <a href="Beranda.php" class="btn btn-primary">← Kembali ke Beranda</a>
      <button type="button" class="btn btn-danger w-100 mt-2" onclick="confirmLogout()">Logout</button>
    </form>
  </main>

  <!-- logout -->
  <script>
    function confirmLogout() {
      Swal.fire({
        title: 'Yakin ingin logout?',
        text: "Anda akan keluar dari akun Anda.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, logout!',
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
