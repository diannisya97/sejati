<?php
include 'header.php';

$iduser = $_SESSION['iduser']; // ID pengguna yang sedang login
$role = $_SESSION['role']; // Role pengguna (admin atau pengurus)

// Jika role pengurus, ambil asal sekolah
if ($role == 'pengurus') {
    // Query untuk mendapatkan asal sekolah pengurus
    $queryAsalSekolah = "SELECT asalsekolah FROM tbuser WHERE iduser = '$iduser'";
    $resultAsalSekolah = mysqli_query($conn, $queryAsalSekolah);
    $rowAsalSekolah = mysqli_fetch_assoc($resultAsalSekolah);
    $asalsekolahPengurus = $rowAsalSekolah['asalsekolah'];

    // Query untuk mengambil data kuisioner perubahan laki-laki terbaru dari siswa yang berasal dari sekolah yang sama dengan pengurus
    $queryMental = "SELECT k.idkuisioner, s.namalengkapsiswa, s.jeniskelamin, k.totalSkor, k.kategori, sch.namasekolah
                    FROM kuisionermenikah k
                    JOIN tbsiswa s ON k.idusersiswa = s.idsiswa
                    JOIN tbsekolah sch ON s.asalsekolah = sch.idsekolah
                    WHERE sch.idsekolah = '$asalsekolahPengurus' AND k.idkuisioner IN (
                        SELECT MAX(idkuisioner)
                        FROM kuisionermenikah
                        GROUP BY idusersiswa
                    )
                    ORDER BY k.idkuisioner DESC";
} else if ($role == 'admin') {
    // Query untuk mengambil data kuisioner perubahan laki-laki terbaru dari semua siswa
    $queryMental = "SELECT k.idkuisioner, s.namalengkapsiswa, s.jeniskelamin, k.totalSkor, k.kategori, sch.namasekolah
                    FROM kuisionermenikah k
                    JOIN tbsiswa s ON k.idusersiswa = s.idsiswa
                    JOIN tbsekolah sch ON s.asalsekolah = sch.idsekolah
                    WHERE k.idkuisioner IN (
                        SELECT MAX(idkuisioner)
                        FROM kuisionermenikah
                        GROUP BY idusersiswa
                    )
                    ORDER BY k.idkuisioner DESC";
}

$resultMental = mysqli_query($conn, $queryMental);
?>

<?php include 'sidebar.php';?>
<?php include 'topbar.php';?>

<div class="container-fluid">
    <!-- Tabel Kuisioner Makan -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Kuisioner Seberapa Siapkah Aku?</h6>
        </div>
        <div class="card-body">
        <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th> <!-- Kolom baru untuk Jenis Kelamin -->
                            <th>Asal Sekolah</th>
                            <th>Total Skor</th>
                            <th>Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($resultMental) > 0) {
                            // Tampilkan data jika ada
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($resultMental)) {
                                echo "<tr>
                                        <td>{$no}</td>
                                        <td>{$row['namalengkapsiswa']}</td>
                                        <td>{$row['jeniskelamin']}</td> 
                                        <td>{$row['namasekolah']}</td>
                                        <td>{$row['totalSkor']}</td>
                                        <td>{$row['kategori']}</td>
                                    </tr>";
                                $no++;
                            }
                        } else {
                            // Tampilkan pesan jika tidak ada data
                            echo "<tr>
                                    <td colspan='6' class='text-center'>Belum ada data yang dimasukkan</td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php';?>
