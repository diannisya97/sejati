<?php
include 'koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data for tbsiswa
    $namalengkapsiswa = $_POST['namalengkapsiswa'];
    $nisn = $_POST['nisn'];
    $nik = $_POST['nik'];
    $namapanggilan = $_POST['namapanggilan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $asalsekolah = $_POST['asalsekolah'];
    $tanggallahir = $_POST['tanggallahir'];

    // Insert into tbsiswa first
    $stmt_siswa = $conn->prepare("INSERT INTO tbsiswa (namalengkapsiswa, nisn, nik, namapanggilan, tanggallahir, notelp, alamat, jeniskelamin, asalsekolah) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt_siswa->bind_param("sssssisss", $namalengkapsiswa, $nisn, $nik, $namapanggilan, $tanggallahir, $notelp, $alamat, $jeniskelamin, $asalsekolah);

    if ($stmt_siswa->execute()) {
        // Get the last inserted ID for tbsiswa
        $idsiswa = $stmt_siswa->insert_id;

        // Retrieve form data for tbusersiswa
        $username = $_POST['username'];
        $password = $_POST['pass'];
        $email = $_POST['email'];
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert into tbusersiswa with the new idsiswa
        $stmt_user = $conn->prepare("INSERT INTO tbusersiswa (username, pass, email, idsiswa) VALUES (?, ?, ?, ?)");
        $stmt_user->bind_param("sssi", $username, $hashed_password, $email, $idsiswa);

        if ($stmt_user->execute()) {
            // Clear session variables
            unset($_SESSION['idsiswa']);
            unset($_SESSION['jeniskelamin']);
            unset($_SESSION['asalsekolah']);

            // Redirect to login page
            echo "<script>
                    alert('Pendaftaran berhasil, silakan tunggu akun untuk divalidasi');
                    window.location.href = 'login.php';
                  </script>";
            exit();
        } else {
            echo "Error: " . $stmt_user->error;
        }

        $stmt_user->close();
    } else {
        echo "Error: " . $stmt_siswa->error;
    }

    $stmt_siswa->close();
}

$conn->close();
?>
