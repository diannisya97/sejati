<?php
include('header.php'); // pastikan Anda sudah membuat file koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil idusersiswa dari POST (admin/pengurus) atau session (siswa)
    $idusersiswa = intval($_POST['idusersiswa']);

    // Get form data and assign scores
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

    // Calculate scores for questions 1-5
    $q1 = $q1; // 1 = Tidak Pernah, 2 = Kadang-Kadang, 3 = Selalu
    $q2 = $q2;
    $q3 = $q3;
    $q4 = $q4;
    $q5 = $q5;

    // Calculate scores for questions 6-10 (inverted scale)
    $q6 = 4 - $q6; // 3 = Tidak Pernah, 2 = Kadang-Kadang, 1 = Selalu
    $q7 = 4 - $q7;
    $q8 = 4 - $q8;
    $q9 = 4 - $q9;
    $q10 = 4 - $q10;

    // Calculate total score
    $totalSkor = $q1 + $q2 + $q3 + $q4 + $q5 + $q6 + $q7 + $q8 + $q9 + $q10;

    // Determine category based on total score
    if ($totalSkor <= 15) {
        $kategori = 'Kurang Sehat';
    } elseif ($totalSkor <= 25) {
        $kategori = 'Cukup Sehat';
    } else {
        $kategori = 'Sehat';
    }

    // Insert into database
    $sql = "INSERT INTO kuisionermakan (idusersiswa, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, totalSkor, kategori)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiiiiiiiiiis", $idusersiswa, $q1, $q2, $q3, $q4, $q5, $q6, $q7, $q8, $q9, $q10, $totalSkor, $kategori);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil disimpan.'); window.location.href='olahraga.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
