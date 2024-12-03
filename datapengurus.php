<?php include('header.php'); ?>

<?php
// Periksa apakah pengguna sudah login dan memiliki peran admin
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'admin')) {
    header("Location: login.php");
    exit();
}

// Ambil data pengurus dari database
$sql = "SELECT u.iduser, u.username, u.email, s.namasekolah, s.alamatsekolah, s.notelpsekolah, s.kepalasekolah, s.namapjsekolah, s.notelpj
        FROM tbuser u
        LEFT JOIN tbsekolah s ON u.asalsekolah = s.idsekolah
        WHERE u.role = 'pengurus'";
$result = $conn->query($sql);

// Periksa apakah query berhasil
if ($result === FALSE) {
    die("Query gagal: " . $conn->error);
}
?>

<?php include('sidebar.php'); ?>
<?php include('topbar.php'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pengurus</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Nama Sekolah</th>
                            <th>Alamat Sekolah</th>
                            <th>No Telp Sekolah</th>
                            <th>Kepala Sekolah</th>
                            <th>Nama PJ Sekolah</th>
                            <th>No Telp PJ</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $nomor = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $nomor . "</td>";
                                echo "<td>" . $row["username"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["namasekolah"] . "</td>";
                                echo "<td>" . $row["alamatsekolah"] . "</td>";
                                echo "<td>" . $row["notelpsekolah"] . "</td>";
                                echo "<td>" . $row["kepalasekolah"] . "</td>";
                                echo "<td>" . $row["namapjsekolah"] . "</td>";
                                echo "<td>" . $row["notelpj"] . "</td>";
                                echo "<td>";
                                echo "<a href='editpengurus.php?iduser=" . $row["iduser"] . "' class='btn btn-primary'> <i class='fas fa-edit'></i> Edit</a> ";
                                echo "<a href='hapuspengurus.php?iduser=" . $row["iduser"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>";
                                echo "</td>";
                                echo "</tr>";
                                $nomor++;
                            }
                        } else {
                            echo "<tr><td colspan='9'>Tidak ada data pengurus</td></tr>";
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
