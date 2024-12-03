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
    
    $totalSkor = $q1 + $q2 + $q3 + $q4 + $q5 + $q6 + $q7;
    
    // Tentukan kategori berdasarkan totalSkor
    if ($totalSkor <= 7) {
        $kategori = "Tidak Siap";
    } elseif ($totalSkor <= 14) {
        $kategori = "Ragu-ragu";
    } else {
        $kategori = "Siap";
    }
    
    // Simpan data ke database
    $sql = "INSERT INTO kuisionermenikah (idusersiswa, q1, q2, q3, q4, q5, q6, q7, totalSkor, kategori) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiiiiiiis", $idusersiswa, $q1, $q2, $q3, $q4, $q5, $q6, $q7, $totalSkor, $kategori);
    
    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil disimpan.'); window.location.href='menikah.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>