<?php
include('header.php');

// Bagian untuk menyimpan topik baru ke database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $iduser = isset($_SESSION['iduser']) ? $_SESSION['iduser'] : null;
    $idusersiswa = isset($_SESSION['idusersiswa']) ? $_SESSION['idusersiswa'] : null;
    $isitopik = mysqli_real_escape_string($conn, $_POST['isitopik']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    // Mengganti karakter escape literal \r\n dengan newline yang sebenarnya
    $isitopik = str_replace(array("\\r\\n", "\\r", "\\n"), "\n", $isitopik);
    $tanggal = date('Y-m-d H:i:s');

    if ($gender === 'laki-laki') {
        $stmt = $conn->prepare("INSERT INTO topik (iduser, idusersiswa, isitopik, tanggal) VALUES (?, ?, ?, ?)");
    } else {
        $stmt = $conn->prepare("INSERT INTO topikperempuan (iduser, idusersiswa, isitopikperempuan, tanggal) VALUES (?, ?, ?, ?)");
    }

    if ($stmt === false) {
        die("Error: " . $conn->error);
    }
    $stmt->bind_param("iiss", $iduser, $idusersiswa, $isitopik, $tanggal);

    if ($stmt->execute()) {
        // Redirect setelah berhasil
        header("Location: tanyajawab.php?page=ajukan&gender=" . $gender);
        exit();
    } else {
        echo "<script>alert('Gagal menyimpan topik');window.location.href='tanyajawab.php?page=ajukan&gender=" . $gender . "';</script>";
    }

    $stmt->close();
}
?>