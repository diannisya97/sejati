<?php
include 'koneksi.php';

// Cek apakah ID user dikirimkan melalui GET
if (isset($_GET['iduser'])) {
    $iduser = $_GET['iduser'];

    // Pastikan ID user ada dan valid
    if (empty($iduser)) {
        echo "ID user tidak valid.";
        exit();
    }

    // Siapkan query untuk menghapus data pengurus
    $sql = "DELETE FROM tbuser WHERE iduser = ?";
    
    // Siapkan pernyataan
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameter
    $stmt->bind_param("i", $iduser);

    // Eksekusi pernyataan
    if ($stmt->execute()) {
        // Redirect ke halaman datapengurus.php setelah berhasil dihapus
        echo "<script>
                alert('Data pengurus berhasil dihapus');
                window.location.href = 'datapengurus.php';
              </script>";
    } else {
        echo "Terjadi kesalahan saat menghapus data: " . $stmt->error;
    }

    // Tutup pernyataan
    $stmt->close();
} else {
    echo "ID user tidak ditemukan.";
}

// Tutup koneksi
$conn->close();
?>
