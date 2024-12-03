<?php
include 'header.php';

if ($_SESSION['role'] !== 'admin') {
    die("Akses ditolak");
}

// Query untuk mendapatkan data pengurus dengan status 'pending'
$sql = "SELECT tbuser.iduser, tbuser.username, tbuser.role, tbsekolah.namasekolah
        FROM tbuser 
        JOIN tbsekolah ON tbuser.asalsekolah = tbsekolah.idsekolah
        WHERE tbuser.role = 'pengurus' AND tbuser.status = 'pending'";

// Menjalankan query
$result = $conn->query($sql);

// Mengecek apakah query berhasil dijalankan
if ($result === false) {
    echo "Error: " . $conn->error;
    $conn->close();
    exit();
}
?>

<?php 
include 'sidebar.php';
include 'topbar.php';
?>

<div class="container-fluid">
    <!-- Tabel Validasi Pengurus -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Validasi Pengurus</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Asal Sekolah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $no = 1;
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$no}</td>
                                        <td>{$row['username']}</td>
                                        <td>{$row['namasekolah']}</td>
                                        <td>
                                            <a href='validasipengurus.php?id={$row['iduser']}' class='btn btn-success'>Validasi</a>
                                            <a href='tolakpengurus.php?id={$row['iduser']}' class='btn btn-danger'>Tolak</a>
                                        </td>
                                    </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='4'>Tidak ada data pengurus dengan status pending.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php';?>