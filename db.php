<?php
$host = "localhost";
$user = "root";
$pass = "";  // saya sengaja kosongkan, karena password pak.
$db   = "film_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
