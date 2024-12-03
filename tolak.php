<?php
include 'header.php';

// Mengecek apakah ID siswa dikirim melalui URL
if (isset($_GET['id'])) {
    $idusersiswa = $_GET['id'];
    
    // Menyiapkan query untuk mengubah status siswa
    $sql = "UPDATE tbusersiswa SET status = 'rejected' WHERE idusersiswa = ?";
    
    // Menyiapkan statement
    if ($stmt = $conn->prepare($sql)) {
        // Mengikat parameter
        $stmt->bind_param("i", $idusersiswa);
        
        // Menjalankan statement
        if ($stmt->execute()) {
            echo "Status siswa telah diperbarui menjadi 'rejected'.";
        } else {
            echo "Terjadi kesalahan saat memperbarui status siswa: " . $stmt->error;
        }
        
        // Menutup statement
        $stmt->close();
    } else {
        echo "Terjadi kesalahan saat menyiapkan query: " . $conn->error;
    }
} else {
    echo "ID siswa tidak ditemukan.";
}

// Menutup koneksi
$conn->close();

// Redirect kembali ke halaman validasi setelah proses
header("Location: siswatolak.php");
exit();
?>
