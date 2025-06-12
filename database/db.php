<?php
$host = "localhost";
$user = "root"; // default user XAMPP
$pass = "";     // kosong jika belum diubah
$db   = "bookview";

$conn = new mysqli($host, $user,  $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>