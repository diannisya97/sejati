<?php
include ('header.php'); // pastikan Anda sudah membuat file koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil idusersiswa dari POST (admin/pengurus) atau session (siswa)
    $idusersiswa = intval($_POST['idusersiswa']);

    // Ambil jawaban kuisioner
    $q1 = intval($_POST['q1']);
    $q2 = intval($_POST['q2']);
    $q3 = intval($_POST['q3']);
    $q4 = intval($_POST['q4']);
    $q5 = intval($_POST['q5']);
    $q6 = intval($_POST['q6']);
    $q7 = intval($_POST['q7']);
    $q8 = intval($_POST['q8']);
    $q9 = intval($_POST['q9']);
    $q10 = intval($_POST['q10']);
    $q11 = intval($_POST['q11']);

    // Hitung total skor
    $totalSkor = $q1 + $q2 + $q3 + $q4 + $q5 + $q6 + $q7 + $q8 + $q9 + $q10 + $q11;

    // Tentukan kategori berdasarkan totalSkor
    if ($totalSkor <= 7) {
        $kategori = "Kurang Baik";
    } elseif ($totalSkor <= 14) {
        $kategori = "Cukup Baik";
    } else {
        $kategori = "Sangat Baik";
    }

    // Simpan ke database
    $sql = "INSERT INTO kuisionerkesehatanperempuan (idusersiswa, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, totalSkor, kategori) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "iiiiiiiiiiiiis", $idusersiswa, $q1, $q2, $q3, $q4, $q5, $q6, $q7, $q8, $q9, $q10, $q11, $totalSkor, $kategori);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Data berhasil disimpan.'); window.location.href='kesehatan.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>
