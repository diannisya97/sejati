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

    // Query untuk mengambil data kuisioner mager terbaru dari siswa yang berasal dari sekolah yang sama dengan pengurus
    $queryMager = "SELECT k.idkuisioner, s.namalengkapsiswa, k.hariberat, k.jamberat, k.menitberat, k.harisedang, k.jamsedang, k.menitsedang,
                           k.hariberjalan, k.jamberjalan, k.menitberjalan, k.hariberatolahraga, k.jamberatolahraga, k.menitberatolahraga,
                           k.harisedangolahraga, k.jamsedangolahraga, k.menitsedangolahraga, k.waktududuk, k.menitduduk, sch.namasekolah
                    FROM kuisionermager k
                    JOIN tbsiswa s ON k.idusersiswa = s.idsiswa
                    JOIN tbsekolah sch ON s.asalsekolah = sch.idsekolah
                    WHERE sch.idsekolah = '$asalsekolahPengurus' AND k.idkuisioner IN (
                        SELECT MAX(idkuisioner)
                        FROM kuisionermager
                        GROUP BY idusersiswa
                    )
                    ORDER BY k.idkuisioner DESC";
} else if ($role == 'admin') {
    // Query untuk mengambil data kuisioner mager terbaru dari semua siswa
    $queryMager = "SELECT k.idkuisioner, s.namalengkapsiswa, k.hariberat, k.jamberat, k.menitberat, k.harisedang, k.jamsedang, k.menitsedang,
                           k.hariberjalan, k.jamberjalan, k.menitberjalan, k.hariberatolahraga, k.jamberatolahraga, k.menitberatolahraga,
                           k.harisedangolahraga, k.jamsedangolahraga, k.menitsedangolahraga, k.waktududuk, k.menitduduk, sch.namasekolah
                    FROM kuisionermager k
                    JOIN tbsiswa s ON k.idusersiswa = s.idsiswa
                    JOIN tbsekolah sch ON s.asalsekolah = sch.idsekolah
                    WHERE k.idkuisioner IN (
                        SELECT MAX(idkuisioner)
                        FROM kuisionermager
                        GROUP BY idusersiswa
                    )
                    ORDER BY k.idkuisioner DESC";
}

$resultMager = mysqli_query($conn, $queryMager);
?>

<?php include 'sidebar.php';?>
<?php include 'topbar.php';?>

<div class="container-fluid">
    <!-- Tabel Kuisioner Mager -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Kuisioner Mager</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Asal Sekolah</th>
                            <th>Aktivitas Berat (Hari)</th>
                            <th>Aktivitas Berat (Jam)</th>
                            <th>Aktivitas Berat (Menit)</th>
                            <th>Aktivitas Sedang (Hari)</th>
                            <th>Aktivitas Sedang (Jam)</th>
                            <th>Aktivitas Sedang (Menit)</th>
                            <th>Berjalan/ Sepeda (Hari)</th>
                            <th>Berjalan/ Sepeda (Jam)</th>
                            <th>Berjalan/ Sepeda (Menit)</th>
                            <th>Olahraga Berat (Hari)</th>
                            <th>Olahraga Berat (Jam)</th>
                            <th>Olahraga Berat (Menit)</th>
                            <th>Olahraga Sedang (Hari)</th>
                            <th>Olahraga Sedang (Jam)</th>
                            <th>Olahraga Sedang (Menit)</th>
                            <th>Duduk/ Berbaring (Jam)</th>
                            <th>Duduk/ Berbaring (Menit)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($resultMager) > 0) {
                            // Tampilkan data jika ada
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($resultMager)) {
                                echo "<tr>
                                        <td>{$no}</td>
                                        <td>{$row['namalengkapsiswa']}</td>
                                        <td>{$row['namasekolah']}</td>
                                        <td>{$row['hariberat']}</td>
                                        <td>{$row['jamberat']}</td>
                                        <td>{$row['menitberat']}</td>
                                        <td>{$row['harisedang']}</td>
                                        <td>{$row['jamsedang']}</td>
                                        <td>{$row['menitsedang']}</td>
                                        <td>{$row['hariberjalan']}</td>
                                        <td>{$row['jamberjalan']}</td>
                                        <td>{$row['menitberjalan']}</td>
                                        <td>{$row['hariberatolahraga']}</td>
                                        <td>{$row['jamberatolahraga']}</td>
                                        <td>{$row['menitberatolahraga']}</td>
                                        <td>{$row['harisedangolahraga']}</td>
                                        <td>{$row['jamsedangolahraga']}</td>
                                        <td>{$row['menitsedangolahraga']}</td>
                                        <td>{$row['waktududuk']}</td>
                                        <td>{$row['menitduduk']}</td>
                                    </tr>";
                                $no++;
                            }
                        } else {
                            // Tampilkan pesan jika tidak ada data
                            echo "<tr>
                                    <td colspan='19' class='text-center'>Belum ada data yang dimasukkan</td>
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
