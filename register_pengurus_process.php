<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
$email = $_POST['email'];
$asalsekolah = $_POST['asalsekolah'];

// Memasukkan data ke dalam tabel tbuser
$sql = "INSERT INTO tbuser (username, pass, role, email, asalsekolah) VALUES (?, ?, 'pengurus', ?, ?)";
$stmt = $conn->prepare($sql);
// Periksa apakah `prepare()` berhasil
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameter dan eksekusi statement
$stmt->bind_param("ssss", $username, $password, $email, $asalsekolah);

if ($stmt->execute()) {
    // Menampilkan pesan peringatan dan mengalihkan ke halaman login
        echo "<script>
                alert('Pendaftaran berhasil, silakan tunggu akun untuk divalidasi');
                window.location.href = 'login.php';
              </script>";
        exit();
} else {
    echo "Terjadi kesalahan: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
