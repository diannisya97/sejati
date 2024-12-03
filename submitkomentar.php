<?php
include('header.php');

// Ambil data dari POST
$idtopik = isset($_POST['idtopik']) ? intval($_POST['idtopik']) : 0;
$idtopikperempuan = isset($_POST['idtopikperempuan']) ? intval($_POST['idtopikperempuan']) : 0;
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$isikomen = isset($_POST['isikomen']) ? trim($_POST['isikomen']) : '';

// Validasi data
if (empty($isikomen)) {
    echo "<script>alert('Komentar tidak boleh kosong');window.location.href='jawab.php?idtopik=" . $idtopik . "&idtopikperempuan=" . $idtopikperempuan . "&gender=" . $gender . "';</script>";
    exit();
}

// Tentukan idtopik yang akan digunakan
$idtopik_komentar = ($idtopik > 0) ? $idtopik : $idtopikperempuan;

if ($idtopik_komentar > 0) {
    if ($idtopik > 0) {
        // Query untuk tabel komentar laki-laki
        $sql = "INSERT INTO komentar (iduser, idusersiswa, isikomen, tanggal, idtopik) VALUES (?, ?, ?, NOW(), ?)";
    } elseif ($idtopikperempuan > 0) {
        // Query untuk tabel komentar perempuan
        $sql = "INSERT INTO komentarperempuan (iduser, idusersiswa, isikomenperempuan, tanggal, idtopikperempuan) VALUES (?, ?, ?, NOW(), ?)";
    }

    if ($stmt = $conn->prepare($sql)) {
        // Tentukan parameter berdasarkan tipe pengguna
        if (isset($_SESSION['iduser'])) {
            $iduser = $_SESSION['iduser'];
            $idusersiswa = NULL;
        } elseif (isset($_SESSION['idusersiswa'])) {
            $iduser = NULL;
            $idusersiswa = $_SESSION['idusersiswa'];
        } else {
            echo "<script>alert('Pengguna tidak terdaftar');window.location.href='jawab.php?idtopik=" . $idtopik . "&idtopikperempuan=" . $idtopikperempuan . "&gender=" . $gender . "';</script>";
            exit();
        }

        if ($idtopik > 0) {
            $stmt->bind_param('iisi', $iduser, $idusersiswa, $isikomen, $idtopik_komentar);
        } elseif ($idtopikperempuan > 0) {
            $stmt->bind_param('iisi', $iduser, $idusersiswa, $isikomen, $idtopik_komentar);
        }

        if ($stmt->execute()) {
            header("Location: jawab.php?idtopik=" . $idtopik . "&idtopikperempuan=" . $idtopikperempuan . "&gender=" . $gender);
            exit();
        } else {
            echo "<script>alert('Gagal menyimpan komentar');window.location.href='jawab.php?idtopik=" . $idtopik . "&idtopikperempuan=" . $idtopikperempuan . "&gender=" . $gender . "';</script>";
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "<script>alert('ID topik tidak valid');window.location.href='jawab.php?idtopik=" . $idtopik . "&idtopikperempuan=" . $idtopikperempuan . "&gender=" . $gender . "';</script>";
}
$conn->close();
?>
