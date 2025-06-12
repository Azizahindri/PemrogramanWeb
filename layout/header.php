<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();

include("database/db.php");

// Cegah error kalau variabel belum diset
$pageTitle = $pageTitle ?? 'Freshure';
$pageCSS = $pageCSS ?? 'css/styleberanda.css';

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
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= htmlspecialchars($pageCSS) ?>" />
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand text-success fw-bold" href="Beranda.php">Freshure</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="Beranda.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link" href="artikel.php"> Artikel</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="jenisDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Jenis</a>
                        <ul class="dropdown-menu" aria-labelledby="jenisDropdown">
                            <li><a class="dropdown-item" href="#" onclick="clearFilter()">All</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterGenre('Sayuran')">Sayur</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterGenre('Buah')">Buah</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterGenre('Bunga')">Bunga</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="profile.php"> 👤</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <?php if ($username): ?>
            <p class="text-end fst-italic">Hai, <?= htmlspecialchars($first_name) ?>!</p>
        <?php endif; ?>