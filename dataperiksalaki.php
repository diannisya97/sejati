<?php
include 'header.php';

$iduser = $_SESSION['iduser']; // ID pengguna yang sedang login
$role = $_SESSION['role']; // Role pengguna (admin atau pengurus)

if ($role == 'pengurus') {
    // Query untuk mendapatkan asal sekolah pengurus
    $queryAsalSekolah = "SELECT asalsekolah FROM tbuser WHERE iduser = '$iduser'";
    $resultAsalSekolah = mysqli_query($conn, $queryAsalSekolah);
    $rowAsalSekolah = mysqli_fetch_assoc($resultAsalSekolah);
    $asalsekolahPengurus = $rowAsalSekolah['asalsekolah'];

    // Query untuk mengambil semua data IMT dan BMR dari siswa yang berasal dari sekolah yang sama dengan pengurus
    $queryIMT_BMR = "SELECT i.idimt, s.namalengkapsiswa, i.hasilimt, i.keterangan, i.tglperiksa, 
                            (SELECT e.hasil 
                             FROM kebutuhanenergi e 
                             WHERE e.idsiswa = i.idsiswa 
                               AND e.tglperiksa = i.tglperiksa 
                             LIMIT 1) AS hasilBMR, 
                            sch.namasekolah
                     FROM imt i
                     JOIN tbsiswa s ON i.idsiswa = s.idsiswa
                     JOIN tbsekolah sch ON s.asalsekolah = sch.idsekolah
                     WHERE sch.idsekolah = '$asalsekolahPengurus'
                     ORDER BY i.tglperiksa DESC";
} else if ($role == 'admin') {
    // Query untuk mengambil semua data IMT dan BMR dari semua siswa
    $queryIMT_BMR = "SELECT i.idimt, s.namalengkapsiswa, i.hasilimt, i.keterangan, i.tglperiksa, 
                            (SELECT e.hasil 
                             FROM kebutuhanenergi e 
                             WHERE e.idsiswa = i.idsiswa 
                               AND e.tglperiksa = i.tglperiksa 
                             LIMIT 1) AS hasilBMR, 
                            sch.namasekolah
                     FROM imt i
                     JOIN tbsiswa s ON i.idsiswa = s.idsiswa
                     JOIN tbsekolah sch ON s.asalsekolah = sch.idsekolah
                     ORDER BY i.tglperiksa DESC";
}

$resultIMT_BMR = mysqli_query($conn, $queryIMT_BMR);
?>

<?php include 'sidebar.php';?>
<?php include 'topbar.php';?>

<div class="container-fluid">
    <!-- Tabel IMT dan BMR -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data IMT dan BMR Siswa Laki-laki</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Asal Sekolah</th>
                            <th>Hasil IMT</th>
                            <th>Keterangan IMT</th>
                            <th>Hasil BMR</th>
                            <th>Tanggal Periksa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($resultIMT_BMR) > 0) {
                            // Tampilkan data jika ada
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($resultIMT_BMR)) {
                                echo "<tr>
                                        <td>{$no}</td>
                                        <td>{$row['namalengkapsiswa']}</td>
                                        <td>{$row['namasekolah']}</td>
                                        <td>{$row['hasilimt']}</td>
                                        <td>{$row['keterangan']}</td>
                                        <td>{$row['hasilBMR']}</td>
                                        <td>{$row['tglperiksa']}</td>   
                                    </tr>";
                                $no++;
                            }
                        } else {
                            // Tampilkan pesan jika tidak ada data
                            echo "<tr>
                                    <td colspan='7' class='text-center'>Belum ada data yang dimasukkan</td>
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
