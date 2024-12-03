<?php
include('header.php');

// Ambil data dari GET
$idkomen = isset($_GET['idkomen']) ? intval($_GET['idkomen']) : 0;
$idkomenperempuan = isset($_GET['idkomenperempuan']) ? intval($_GET['idkomenperempuan']) : 0;
$idtopik = isset($_GET['idtopik']) ? intval($_GET['idtopik']) : 0;
$idtopikperempuan = isset($_GET['idtopikperempuan']) ? intval($_GET['idtopikperempuan']) : 0;
$gender = isset($_GET['gender']) ? $_GET['gender'] : '';

// Validasi ID komen dan ID topik
if (($gender === 'laki-laki' && $idkomen <= 0) || ($gender === 'perempuan' && $idkomenperempuan <= 0)) {
    header("Location: tanyajawab.php?gender=" . $gender);
    exit();
}

// Validasi user yang sedang login
$user_id = isset($_SESSION['iduser']) ? $_SESSION['iduser'] : null;
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

if ($gender === 'laki-laki' && $idkomen > 0) {
    // Query untuk memastikan hanya pemilik komentar atau admin yang bisa menghapus komentar laki-laki
    $sql = "SELECT iduser FROM komentar WHERE idkomen = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param('i', $idkomen);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($komentar_user_id);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && ($user_id == $komentar_user_id || $user_role == 'admin')) {
        // Hapus komentar laki-laki
        $sql_delete = "DELETE FROM komentar WHERE idkomen = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        if ($stmt_delete === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt_delete->bind_param('i', $idkomen);
        if ($stmt_delete->execute()) {
            header("Location: jawab.php?idtopik=" . $idtopik . "&gender=" . $gender);
            exit();
        } else {
            header("Location: tanyajawab.php?idtopik=" . $idtopik . "&gender=" . $gender);
            exit();
        }
    } else {
        header("Location: tanyajawab.php?idtopik=" . $idtopik . "&gender=" . $gender);
        exit();
    }

} elseif ($gender === 'perempuan' && $idkomenperempuan > 0) {
    // Query untuk memastikan hanya pemilik komentar atau admin yang bisa menghapus komentar perempuan
    $sql = "SELECT iduser FROM komentarperempuan WHERE idkomenperempuan = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param('i', $idkomenperempuan);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($komentar_user_id);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && ($user_id == $komentar_user_id || $user_role == 'admin')) {
        // Hapus komentar perempuan
        $sql_delete = "DELETE FROM komentarperempuan WHERE idkomenperempuan = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        if ($stmt_delete === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt_delete->bind_param('i', $idkomenperempuan);
        if ($stmt_delete->execute()) {
            header("Location: jawab.php?idtopikperempuan=" . $idtopikperempuan . "&gender=" . $gender);
            exit();
        } else {
            header("Location: tanyajawab.php?idtopikperempuan=" . $idtopikperempuan . "&gender=" . $gender);
            exit();
        }
    } else {
        header("Location: tanyajawab.php?idtopikperempuan=" . $idtopikperempuan . "&gender=" . $gender);
        exit();
    }
} else {
    header("Location: tanyajawab.php?gender=" . $gender);
    exit();
}

$stmt->close();
$conn->close();
?>
