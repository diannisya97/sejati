<?php
include 'header.php';

// Mengecek apakah ID pengurus dikirim melalui URL
if (isset($_GET['id'])) {
    $iduser = $_GET['id'];
    
    // Menyiapkan query untuk mengubah status pengurus
    $sql = "UPDATE tbuser SET status = 'validated' WHERE iduser = ?";
    
    // Menyiapkan statement
    if ($stmt = $conn->prepare($sql)) {
        // Mengikat parameter
        $stmt->bind_param("i", $iduser);
        
        // Menjalankan statement
        if ($stmt->execute()) {
            echo "Status pengurus telah diperbarui menjadi 'validated'.";
        } else {
            echo "Terjadi kesalahan saat memperbarui status pengurus: " . $stmt->error;
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
header("Location: penguruspending.php");
exit();
?>
