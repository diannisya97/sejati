<?php
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $idsekolah = $_GET["id"];

    // Ambil data sekolah berdasarkan id
    $sql = "SELECT * FROM tbsekolah WHERE idsekolah='$idsekolah'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idsekolah = $_POST['idsekolah'];
    $namasekolah = $_POST['namasekolah'];
    $alamatsekolah = $_POST['alamatsekolah'];
    $notelpsekolah = $_POST['notelpsekolah'];
    $kepalasekolah = $_POST['kepalasekolah'];
    $namapjsekolah = $_POST['namapjsekolah'];
    $notelpj = $_POST['notelpj'];

    // Query untuk mengupdate data ke tabel tbsekolah
    $sql = "UPDATE tbsekolah SET namasekolah='$namasekolah', alamatsekolah='$alamatsekolah', notelpsekolah='$notelpsekolah', kepalasekolah='$kepalasekolah', namapjsekolah='$namapjsekolah', notelpj='$notelpj' WHERE idsekolah='$idsekolah'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Data sekolah berhasil diupdate');
            window.location.href = 'datasekolah.php';
        </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

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

<?php include('sidebar.php'); ?>
<?php include('topbar.php'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mb-4">
            <!-- Data Sekolah -->
            <div class="card shadow-sm mb-4 border-light">
                <div class="card-header py-3 bg-light d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Data Sekolah</h6>
                    <i class="fas fa-school ml-auto text-primary"></i>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card border-0" style="margin-top: -20px;">
                                <div class="card-body p-4">
                                    <form method="POST" action="">
                                        <input type="hidden" name="idsekolah" value="<?php echo $row['idsekolah']; ?>">
                                        
                                        <div class="form-group">
                                            <label for="namasekolah" class="text-primary">Nama Sekolah</label>
                                            <input type="text" class="form-control form-control-sm" id="namasekolah" name="namasekolah" placeholder="Nama Sekolah" value="<?php echo htmlspecialchars($row['namasekolah']); ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="alamatsekolah" class="text-primary">Alamat Sekolah</label>
                                            <input type="text" class="form-control form-control-sm" id="alamatsekolah" name="alamatsekolah" placeholder="Alamat Sekolah" value="<?php echo htmlspecialchars($row['alamatsekolah']); ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="notelpsekolah" class="text-primary">No Telp Sekolah</label>
                                            <input type="text" class="form-control form-control-sm" id="notelpsekolah" name="notelpsekolah" placeholder="No Telp Sekolah" value="<?php echo htmlspecialchars($row['notelpsekolah']); ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="kepalasekolah" class="text-primary">Kepala Sekolah</label>
                                            <input type="text" class="form-control form-control-sm" id="kepalasekolah" name="kepalasekolah" placeholder="Kepala Sekolah" value="<?php echo htmlspecialchars($row['kepalasekolah']); ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="namapjsekolah" class="text-primary">Nama PJ Sekolah</label>
                                            <input type="text" class="form-control form-control-sm" id="namapjsekolah" name="namapjsekolah" placeholder="Nama PJ Sekolah" value="<?php echo htmlspecialchars($row['namapjsekolah']); ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="notelpj" class="text-primary">No Telp PJ</label>
                                            <input type="text" class="form-control form-control-sm" id="notelpj" name="notelpj" placeholder="No Telp PJ" value="<?php echo htmlspecialchars($row['notelpj']); ?>" required>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary btn-sm btn-block">
                                            Update Data Sekolah
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small text-primary" href="datasekolah.php">Kembali ke Data Sekolah</a>
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