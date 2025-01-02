<?php
$servername = "localhost";
$username = "root";
$password = "kaskus2727";
$dbname = "db_sejati";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
