<?php
include '../database/db.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'seller') {
    header("Location: ../login2.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $field = $_POST['field'] ?? '';
    $value = trim($_POST['value'] ?? '');

    if (in_array($field, ['first_name', 'last_name', 'email'])) {
        $stmt = $conn->prepare("UPDATE users SET $field = ? WHERE id = ?");
        $stmt->bind_param("si", $value, $seller_id);
        $stmt->execute();
        $_SESSION[$field] = $value;
        $success_msg = ucfirst(str_replace("_", " ", $field)) . " berhasil diperbarui!";
    }
}

// Ambil data
$stmt = $conn->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$first_name = $user['first_name'];
$last_name = $user['last_name'];
$email = $user['email'];

$avatar_url = "https://ui-avatars.com/api/?name=" . urlencode($first_name . ' ' . $last_name) . "&background=4CAF50&color=fff";

$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM crud_041_book WHERE seller_id = ?");
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$total_products = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

$stmt = $conn->prepare("
    SELECT COUNT(*) AS total 
    FROM crud_041_book_reviews r
    JOIN crud_041_book p ON r.book_id = p.id
    WHERE p.seller_id = ?");
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$total_reviews = $stmt->get_result()->fetch_assoc()['total'] ?? 0;
?>

<link rel="stylesheet" href="../css/profilseller.css">

<div class="container-center">
  <div class="profile-box">
    <div class="d-flex align-items-center mb-4">
      <img src="<?= $avatar_url ?>" class="rounded-circle me-3" width="80" height="80" />
      <div>
        <h5 class="mb-0"><?= htmlspecialchars($first_name . ' ' . $last_name) ?></h5>
        <small class="text-muted"><?= htmlspecialchars($email) ?></small>
      </div>
    </div>

    <?php if (isset($success_msg)): ?>
      <div class="alert alert-success"><?= htmlspecialchars($success_msg) ?></div>
    <?php endif; ?>

    <div class="mb-4">
      <h6 class="text-muted">Informasi Akun</h6>
      <?php
      $fields = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
      ];
      foreach ($fields as $key => $value):
      ?>
        <form method="POST" class="d-flex align-items-center mb-2" onsubmit="return handleSave(this)">
          <label for="<?= $key ?>" class="form-label me-2 text-capitalize" style="min-width: 100px;">
            <?= ucwords(str_replace("_", " ", $key)) ?>:
          </label>
          <input type="text" class="form-control me-2" id="<?= $key ?>" name="value" value="<?= htmlspecialchars($value) ?>" readonly style="max-width: 200px; padding: 6px 10px;">
          <input type="hidden" name="field" value="<?= $key ?>">
          <i class="fas fa-pencil-alt edit-icon" onclick="editField(this)"></i>
          <button type="submit" class="btn btn-sm btn-success d-none save-icon"><i class="fas fa-check"></i></button>
        </form>
      <?php endforeach; ?>
    </div>

    <div>
      <h6 class="text-muted">Statistik</h6>
      <p>Jumlah Produk: <strong><?= $total_products ?></strong></p>
      <p>Total Review: <strong><?= $total_reviews ?></strong></p>
    </div>
  </div>
</div>

<script>
function editField(icon) {
  const form = icon.closest('form');
  const input = form.querySelector('input[type="text"]');
  const saveBtn = form.querySelector('button.save-icon');
  const allForms = document.querySelectorAll('form');

  allForms.forEach(f => {
    f.querySelector('input[type="text"]').setAttribute('readonly', true);
    f.querySelector('button.save-icon').classList.add('d-none');
    f.querySelector('.edit-icon').classList.remove('d-none');
  });

  input.removeAttribute('readonly');
  input.focus();
  const val = input.value;
  input.value = '';
  input.value = val;

  icon.classList.add('d-none');
  saveBtn.classList.remove('d-none');
}

function handleSave(form) {
  const input = form.querySelector('input[type="text"]');
  if (input.value.trim() === '') {
    alert("Isi tidak boleh kosong.");
    return false;
  }
  return true;
}
</script>
