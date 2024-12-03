<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $namasekolah = $_POST['namasekolah'];
    $alamatsekolah = $_POST['alamatsekolah'];
    $notelpsekolah = $_POST['notelpsekolah'];
    $kepalasekolah = $_POST['kepalasekolah'];
    $namapjsekolah = $_POST['namapjsekolah'];
    $notelpj = $_POST['notelpj'];

    // Query untuk menambahkan data ke tabel tbsekolah
    $sql = "INSERT INTO tbsekolah (namasekolah, alamatsekolah, notelpsekolah, kepalasekolah, namapjsekolah, notelpj) 
    VALUES ('$namasekolah', '$alamatsekolah', '$notelpsekolah', '$kepalasekolah', '$namapjsekolah', '$notelpj')";

    // Eksekusi query
    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Data sekolah berhasil ditambahkan');
            window.location.href = 'datasekolah.php';
        </script>";
    } else {
        echo "<script>
            alert('Error: " . $sql . "<br>" . $conn->error . "');
            window.location.href = 'tambahdatasekolah.php';
        </script>";
    }

    // Tutup koneksi
    $conn->close();

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

<?php include('header.php'); ?>
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
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="card o-hidden border-0 shadow-lg my-5">
                                            <div class="card-body p-5">
                                                <div class="text-center">
                                                    <h1 class="h4 text-gray-900 mb-4">Tambah Data Sekolah</h1>
                                                </div>
                                                <form class="user" method="POST" action="">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" name="namasekolah" placeholder="Nama Sekolah" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" name="alamatsekolah" placeholder="Alamat Sekolah" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" name="notelpsekolah" placeholder="No Telp Sekolah" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" name="kepalasekolah" placeholder="Kepala Sekolah" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" name="namapjsekolah" placeholder="Nama PJ Sekolah" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" name="notelpj" placeholder="No Telp PJ" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                                        Tambah Data Sekolah
                                                    </button>
                                                </form>
                                                <hr>
                                                <div class="text-center">
                                                    <a class="small" href="datasekolah.php">Kembali ke Data Sekolah</a>
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