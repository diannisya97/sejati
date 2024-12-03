<?php
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["iduser"])) {
    $iduser = $_GET["iduser"];

    // Ambil data pengurus berdasarkan iduser
    $sql = "SELECT u.iduser, u.username, u.email, u.asalsekolah, s.namasekolah 
            FROM tbuser u
            LEFT JOIN tbsekolah s ON u.asalsekolah = s.idsekolah
            WHERE u.iduser='$iduser' AND u.role = 'pengurus'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan";
        exit();
    }

    // Ambil daftar sekolah untuk dropdown
    $sekolah_sql = "SELECT idsekolah, namasekolah FROM tbsekolah";
    $sekolah_result = $conn->query($sekolah_sql);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $iduser = $_POST['iduser'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $idsekolah = $_POST['idsekolah'];

    // Query untuk mengupdate data pengurus
    $sql = "UPDATE tbuser SET username='$username', email='$email', asalsekolah='$idsekolah' WHERE iduser='$iduser'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Data pengurus berhasil diupdate');
            window.location.href = 'datapengurus.php';
        </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<?php include('sidebar.php'); ?>
<?php include('topbar.php'); ?>

<style>
    body {
        overflow-x: hidden; /* Menghindari scroll bar horizontal */
    }

    .container, .row, .col-lg-8 {
        width: 100%; /* Pastikan lebar penuh */
        padding-right: 0;
        padding-left: 0;
        margin-right: auto;
        margin-left: auto;
    }

    /* Pastikan input dan tombol tidak melebihi lebar container */
    .form-control, .btn {
        max-width: 100%; /* Pastikan lebar maksimum tidak melebihi container */
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mb-4">
            <!-- Edit Pengurus -->
            <div class="card shadow-sm mb-4 border-light">
                <div class="card-header py-3 bg-light d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Data Pengurus</h6>
                    <i class="fas fa-user-tie ml-auto text-primary"></i>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card border-0" style="margin-top: -20px;">
                                <div class="card-body p-4">
                                    <form method="POST" action="">
                                        <input type="hidden" name="iduser" value="<?php echo htmlspecialchars($row['iduser']); ?>">
                                        
                                        <div class="form-group">
                                            <label for="username" class="text-primary">Username</label>
                                            <input type="text" class="form-control form-control-sm" id="username" name="username" placeholder="Username" value="<?php echo htmlspecialchars($row['username']); ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="email" class="text-primary">Email</label>
                                            <input type="text" class="form-control form-control-sm" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="idsekolah" class="text-primary">Asal Sekolah</label>
                                            <select class="form-control form-control-sm" id="idsekolah" name="idsekolah" required>
                                                <?php while ($sekolah_row = $sekolah_result->fetch_assoc()): ?>
                                                    <option value="<?php echo htmlspecialchars($sekolah_row['idsekolah']); ?>"
                                                        <?php echo (isset($row['asalsekolah']) && $row['asalsekolah'] == $sekolah_row['idsekolah']) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($sekolah_row['namasekolah']); ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary btn-sm btn-block">
                                            Update Data Pengurus
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small text-primary" href="datapengurus.php">Kembali ke Data Pengurus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
<!-- /.container-fluid -->

<?php include('footer.php'); ?>
</div>
<!-- End of Main Content -->
