<?php
include('header.php');

// Mengatur zona waktu ke Asia/Jakarta
date_default_timezone_set('Asia/Jakarta');

// Ambil idtopik dan idtopikperempuan dari URL
$idtopik = isset($_GET['idtopik']) ? $_GET['idtopik'] : null;
$idtopikperempuan = isset($_GET['idtopikperempuan']) ? $_GET['idtopikperempuan'] : null;
$gender = isset($_GET['gender']) ? $_GET['gender'] : ''; // Default ke string kosong jika tidak ada
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : ''; // Default ke string kosong jika tidak ada

// Ambil ID pengguna dari sesi
$iduser = isset($_SESSION['iduser']) ? $_SESSION['iduser'] : null;
$idusersiswa = isset($_SESSION['idusersiswa']) ? $_SESSION['idusersiswa'] : null;
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

if ($idtopik) {
    // Menghapus topik laki-laki
    if ($role == 'admin' || ($iduser && is_owner($conn, 'topik', 'idtopik', $idtopik, $iduser, 'iduser')) || ($idusersiswa && is_owner($conn, 'topik', 'idtopik', $idtopik, $idusersiswa, 'idusersiswa'))) {
        $stmt = $conn->prepare("DELETE FROM topik WHERE idtopik = ?");
        $stmt->bind_param("i", $idtopik);
        if ($stmt->execute()) {
            // Debug: cek URL sebelum redirect
            $url = "tanyajawab.php?page=ajukan";
            if (!empty($gender)) $url .= "&gender=" . urlencode($gender);
            if (!empty($kategori)) $url .= "&kategori=" . urlencode($kategori);
            header("Location: $url");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Anda tidak memiliki izin untuk menghapus topik ini.";
    }
} elseif ($idtopikperempuan) {
    // Menghapus topik perempuan
    if ($role == 'admin' || ($iduser && is_owner($conn, 'topikperempuan', 'idtopikperempuan', $idtopikperempuan, $iduser, 'iduser')) || ($idusersiswa && is_owner($conn, 'topikperempuan', 'idtopikperempuan', $idtopikperempuan, $idusersiswa, 'idusersiswa'))) {
        $stmt = $conn->prepare("DELETE FROM topikperempuan WHERE idtopikperempuan = ?");
        $stmt->bind_param("i", $idtopikperempuan);
        if ($stmt->execute()) {
            // Debug: cek URL sebelum redirect
            $url = "tanyajawab.php?page=ajukan";
            if (!empty($gender)) $url .= "&gender=" . urlencode($gender);
            if (!empty($kategori)) $url .= "&kategori=" . urlencode($kategori);
            header("Location: $url");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Anda tidak memiliki izin untuk menghapus topik ini.";
    }
} else {
    echo "ID topik tidak valid.";
}

// Fungsi untuk mengecek kepemilikan topik
function is_owner($conn, $table, $id_column, $id_value, $user_id, $user_column) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM $table WHERE $id_column = ? AND $user_column = ?");
    $stmt->bind_param("ii", $id_value, $user_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count > 0;
}
?>
