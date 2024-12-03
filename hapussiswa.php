<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $idsiswa = $_GET['id'];

    // Query untuk menghapus data siswa berdasarkan id
    $sql = "DELETE FROM tbsiswa WHERE idsiswa='$idsiswa'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Data siswa berhasil dihapus');
            window.location.href = 'datasiswa.php';
        </script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
}
?>
