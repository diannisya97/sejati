<?php
include('header.php'); // Make sure you have included your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil idusersiswa dari POST (admin/pengurus) atau session (siswa)
    $idusersiswa = intval($_POST['idusersiswa']);

    // Retrieve POST data and validate
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

    // Calculate total score
    $totalSkor = $q1 + $q2 + $q3 + $q4 + $q5 + $q6 + $q7 + $q8 + $q9 + $q10;

    // Determine category
    if ($totalSkor >= 8) {
        $kategori = "Perubahan signifikan";
    } elseif ($totalSkor >= 5) {
        $kategori = "Perubahan sedang";
    } else {
        $kategori = "Perubahan ringan";
    }

    // Insert into database
    $sql = "INSERT INTO kuisionerperubahanlaki (idusersiswa, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, totalSkor, kategori)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Correct type definition string to match the number of variables
        mysqli_stmt_bind_param($stmt, "iiiiiiiiiiiis", 
            $idusersiswa, $q1, $q2, $q3, $q4, $q5, $q6, $q7, $q8, $q9, $q10, $totalSkor, $kategori);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Data berhasil disimpan.'); window.location.href='perubahan.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>
