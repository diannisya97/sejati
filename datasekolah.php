<?php include('header.php'); ?>

<?php

// Periksa apakah pengguna sudah login dan memiliki peran admin atau pengurus
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'admin')) {
    header("Location: login.php");
    exit();
}

// Ambil data sekolah dari database
$sql = "SELECT idsekolah, namasekolah, alamatsekolah, notelpsekolah, kepalasekolah, namapjsekolah, notelpj FROM tbsekolah";
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
                            <h6 class="m-0 font-weight-bold text-primary">Data Sekolah</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <?php
                                echo '<a href="tambahdatasekolah.php" class="btn btn-success btn-icon-split btn-sm float-right">
                                        <span class="icon text-white">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                    </a>';
                                ?>
                                    <thead>
                                        <tr>
                                            <th>No</th>
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
                                            // Output data dari setiap baris
                                            $nomor = 1;
                                            while($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $nomor . "</td>";
                                                echo "<td>" . $row["namasekolah"] . "</td>";
                                                echo "<td>" . $row["alamatsekolah"] . "</td>";
                                                echo "<td>" . $row["notelpsekolah"] . "</td>";
                                                echo "<td>" . $row["kepalasekolah"] . "</td>";
                                                echo "<td>" . $row["namapjsekolah"] . "</td>";
                                                echo "<td>" . $row["notelpj"] . "</td>";
                                                echo "<td>";
                                                echo "<a href='editsekolah.php?id=" . $row["idsekolah"] . "' class='btn btn-primary'> <i class='fas fa-edit'></i> Edit</a> ";
                                                echo "<a href='hapussekolah.php?id=" . $row["idsekolah"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>";
                                                echo "</td>";
                                                echo "</tr>";
                                                $nomor++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='7'>Tidak ada data sekolah</td></tr>";
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
