<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $idsekolah = $_GET['id'];

    // Query untuk menghapus data sekolah berdasarkan id
    $sql = "DELETE FROM tbsekolah WHERE idsekolah='$idsekolah'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Data sekolah berhasil dihapus');
            window.location.href = 'datasekolah.php';
        </script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
}
?>
