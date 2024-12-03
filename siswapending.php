<?php
include 'header.php';

if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'pengurus') {
    die("Akses ditolak");
}

/// Mendapatkan ID pengguna dari sesi
$iduser = $_SESSION['iduser'];

// Query untuk mendapatkan asal sekolah pengurus
$queryAsalSekolah = "SELECT asalsekolah FROM tbuser WHERE iduser = ?";
$stmtAsalSekolah = $conn->prepare($queryAsalSekolah);
$stmtAsalSekolah->bind_param("i", $iduser);
$stmtAsalSekolah->execute();
$resultAsalSekolah = $stmtAsalSekolah->get_result();
$rowAsalSekolah = $resultAsalSekolah->fetch_assoc();
$asalsekolahPengurus = $rowAsalSekolah['asalsekolah'];
$stmtAsalSekolah->close();

// Menentukan query berdasarkan peran pengguna
if ($_SESSION['role'] === 'pengurus') {
    // Query untuk pengurus
    $sql = "SELECT tbusersiswa.idusersiswa, tbusersiswa.username, tbsiswa.jeniskelamin, tbsiswa.namalengkapsiswa, tbsekolah.namasekolah
            FROM tbusersiswa 
            JOIN tbsiswa ON tbusersiswa.idsiswa = tbsiswa.idsiswa
            JOIN tbsekolah ON tbsiswa.asalsekolah = tbsekolah.idsekolah
            WHERE tbusersiswa.status = 'pending' AND tbsiswa.asalsekolah = ?";
} else {
    // Query untuk admin
    $sql = "SELECT tbusersiswa.idusersiswa, tbusersiswa.username, tbsiswa.jeniskelamin, tbsiswa.namalengkapsiswa, tbsekolah.namasekolah
            FROM tbusersiswa 
            JOIN tbsiswa ON tbusersiswa.idsiswa = tbsiswa.idsiswa
            JOIN tbsekolah ON tbsiswa.asalsekolah = tbsekolah.idsekolah
            WHERE tbusersiswa.status = 'pending'";
}

// Menyiapkan statement
if ($stmt = $conn->prepare($sql)) {
    // Mengikat parameter untuk pengurus
    if ($_SESSION['role'] === 'pengurus') {
        $stmt->bind_param("i", $asalsekolahPengurus);
    }

    // Menjalankan statement
    $stmt->execute();

    // Mendapatkan hasil
    $result = $stmt->get_result();
    
    // Mengecek apakah query berhasil dijalankan
    if ($result === false) {
        echo "Error: " . $stmt->error;
        $stmt->close();
        $conn->close();
        exit();
    }
} else {
    echo "Terjadi kesalahan saat menyiapkan query: " . $conn->error;
    $conn->close();
    exit();
}
?>

<?php 
include 'sidebar.php';
include 'topbar.php';
?>

<div class="container-fluid">
    <!-- Tabel Validasi Siswa -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Validasi Siswa</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama Lengkap Siswa</th>
                            <th>Jenis Kelamin</th>
                            <th>Nama Sekolah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $no = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$no}</td>
                                        <td>{$row['username']}</td>
                                        <td>{$row['namalengkapsiswa']}</td>
                                        <td>{$row['jeniskelamin']}</td>
                                        <td>{$row['namasekolah']}</td>
                                        <td>
                                            <a href='validasi.php?id={$row['idusersiswa']}' class='btn btn-success'>Validasi</a>
                                            <a href='tolak.php?id={$row['idusersiswa']}' class='btn btn-danger'>Tolak</a>
                                        </td>
                                    </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='5'>Tidak ada data siswa dengan status pending.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php';?>

<?php
// Menutup koneksi
$conn->close();
?>
