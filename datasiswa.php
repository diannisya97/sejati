<?php 
include('header.php');

// Periksa apakah pengguna sudah login dan memiliki peran admin atau pengurus
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'pengurus')) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$idpengurus = $_SESSION['iduser']; // Anda harus memiliki ID pengurus di sesi

// Jika peran adalah admin, tidak perlu membatasi berdasarkan sekolah
if ($_SESSION['role'] == 'admin') {
    $sql = "SELECT s.idsiswa, s.namalengkapsiswa, s.nisn, s.nik, s.tanggallahir, s.namapanggilan, s.jeniskelamin, sc.namasekolah AS asalsekolah, s.notelp, s.alamat
            FROM tbsiswa s
            LEFT JOIN tbsekolah sc ON s.asalsekolah = sc.idsekolah";
} else { // Jika peran adalah pengurus, batasi berdasarkan sekolah pengurus
    $sql = "SELECT s.idsiswa, s.namalengkapsiswa, s.nisn, s.nik, s.tanggallahir, s.namapanggilan, s.jeniskelamin, sc.namasekolah AS asalsekolah, s.notelp, s.alamat
            FROM tbsiswa s
            LEFT JOIN tbsekolah sc ON s.asalsekolah = sc.idsekolah
            WHERE sc.idsekolah = (
                SELECT asalsekolah FROM tbuser WHERE iduser = $idpengurus
            )";
}
$result = $conn->query($sql);

if (!$result) {
    die('Error executing query: ' . mysqli_error($conn));
}
?>

<?php include('sidebar.php'); ?>
<?php include('topbar.php'); ?>

<style>
    /* Tambahkan gaya untuk efek hover */
    tr:hover {
        background-color: #d1ecf1 !important; /* Ganti dengan warna yang Anda inginkan */
    }
</style>
                <!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Siswa</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>NISN</th>
                            <th>NIK</th>
                            <th>Tanggal Lahir</th>
                            <th>Nama Panggilan</th>
                            <th>Jenis Kelamin</th>
                            <th>Asal Sekolah</th>
                            <th>No Telp</th>
                            <th>Alamat</th>
                            <th>Aksi</th> <!-- Tambahkan kolom aksi -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            // Output data dari setiap baris
                            $nomor = 1;
                            while($row = $result->fetch_assoc()) {
                                echo "<tr style='cursor:pointer;' onclick=\"window.location.href='profilsiswa.php?id=" . $row["idsiswa"] . "'\">";
                                echo "<td>" . $nomor . "</td>";
                                echo "<td>" . $row["namalengkapsiswa"] . "</td>";
                                echo "<td>" . $row["nisn"] . "</td>";
                                echo "<td>" . $row["nik"] . "</td>";
                                echo "<td>" . $row["tanggallahir"] . "</td>";
                                echo "<td>" . $row["namapanggilan"] . "</td>";
                                echo "<td>" . $row["jeniskelamin"] . "</td>";
                                echo "<td>" . $row["asalsekolah"] . "</td>";
                                echo "<td>" . $row["notelp"] . "</td>";
                                echo "<td>" . $row["alamat"] . "</td>";
                                echo "<td>";
                                echo "<a href='editsiswa.php?id=" . $row["idsiswa"] . "' class='btn btn-primary btn-sm'>Edit</a> ";
                                echo "<a href='hapussiswa.php?id=" . $row["idsiswa"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Anda yakin ingin menghapus?\")'>Hapus</a>";
                                echo "</td>"; // Kolom aksi
                                echo "</tr>";
                                $nomor++;
                            }
                        } else {
                            echo "<tr><td colspan='10'>Tidak ada data siswa</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
                <!-- /.container-fluid -->

    <?php include('footer.php'); ?>

</div>
            <!-- End of Main Content -->