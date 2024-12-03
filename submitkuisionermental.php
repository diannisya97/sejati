<?php
include ('header.php'); // pastikan Anda sudah membuat file koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil idusersiswa dari POST (admin/pengurus) atau session (siswa)
    $idusersiswa = intval($_POST['idusersiswa']);
    $q1 = isset($_POST['q1']) ? intval($_POST['q1']) : 0;
    $q2 = isset($_POST['q2']) ? intval($_POST['q2']) : 0;
    $q3 = isset($_POST['q3']) ? intval($_POST['q3']) : 0;
    $q4 = isset($_POST['q4']) ? intval($_POST['q4']) : 0;
    $q5 = isset($_POST['q5']) ? intval($_POST['q5']) : 0;
    $q6 = isset($_POST['q6']) ? intval($_POST['q6']) : 0;
    $q7 = isset($_POST['q7']) ? intval($_POST['q7']) : 0;
    $q8 = isset($_POST['q8']) ? intval($_POST['q8']) : 0;
    $q9 = isset($_POST['q9']) ? intval($_POST['q9']) : 0;
    $q10 = isset($_POST['q10']) ? intval($_POST['q10']) : 0;
    $q11 = isset($_POST['q11']) ? intval($_POST['q11']) : 0;
    $q12 = isset($_POST['q12']) ? intval($_POST['q12']) : 0;
    $q13 = isset($_POST['q13']) ? intval($_POST['q13']) : 0;
    $q14 = isset($_POST['q14']) ? intval($_POST['q14']) : 0;
    $q15 = isset($_POST['q15']) ? intval($_POST['q15']) : 0;
    
    $totalSkor = $q1 + $q2 + $q3 + $q4 + $q5 + $q6 + $q7 + $q8 + $q9 + $q10 + $q11 + $q12 + $q13 + $q14 + $q15;
    
    // Tentukan kategori berdasarkan totalSkor
    if ($totalSkor <= 15) {
        $kategori = "Tidak Terdapat Masalah";
    } elseif ($totalSkor <= 30) {
        $kategori = "Cukup Bermasalah";
    } elseif ($totalSkor <= 45) {
        $kategori = "Sangat Bermasalah";
    } else {
        $kategori = "Berbahaya";
    }
    
    // Simpan data ke database
    $sql = "INSERT INTO kuisionermental (idusersiswa, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, totalSkor, kategori) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Pengecekan kesalahan pada prepare
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("iiiiiiiiiiiiiiiiss", $idusersiswa, $q1, $q2, $q3, $q4, $q5, $q6, $q7, $q8, $q9, $q10, $q11, $q12, $q13, $q14, $q15, $totalSkor, $kategori);
    
    // Pengecekan kesalahan pada execute
    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil disimpan.'); window.location.href='mental.php';</script>";
    } else {
        echo "Execute failed: " . htmlspecialchars($stmt->error);
    }
    
    $stmt->close();
    $conn->close();
}
?>
