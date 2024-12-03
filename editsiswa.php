<?php 
include('header.php');

// Periksa apakah pengguna sudah login dan memiliki peran admin atau pengurus
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'pengurus')) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$idpengurus = $_SESSION['iduser']; // Pastikan ID pengurus ada di sesi


if (isset($_GET['id'])) {
    $idsiswa = intval($_GET['id']);
    
    // Ambil data siswa dari database
    $sql = "SELECT s.idsiswa, s.namalengkapsiswa, s.nisn, s.nik, s.tanggallahir, s.namapanggilan, s.jeniskelamin, sc.idsekolah, s.notelp, s.alamat, u.username, u.email
            FROM tbsiswa s
            LEFT JOIN tbsekolah sc ON s.asalsekolah = sc.idsekolah
            LEFT JOIN tbusersiswa u ON s.idsiswa = u.idsiswa
            WHERE s.idsiswa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $idsiswa);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        die('Data siswa tidak ditemukan.');
    }
} else {
    die('ID siswa tidak valid.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $namalengkapsiswa = $_POST['namalengkapsiswa'];
    $nisn = $_POST['nisn'];
    $nik = $_POST['nik'];
    $tanggallahir = $_POST['tanggallahir'];
    $namapanggilan = $_POST['namapanggilan'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $asalsekolah = $_POST['asalsekolah'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    // Mulai transaksi
    $conn->begin_transaction();
    
    try {
        // Update data siswa di database
        $sql = "UPDATE tbsiswa SET namalengkapsiswa=?, nisn=?, nik=?, tanggallahir=?, namapanggilan=?, jeniskelamin=?, asalsekolah=?, notelp=?, alamat=?
                WHERE idsiswa=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssssssi', $namalengkapsiswa, $nisn, $nik, $tanggallahir, $namapanggilan, $jeniskelamin, $asalsekolah, $notelp, $alamat, $idsiswa);
        $stmt->execute();

        // Update username di tbusersiswa
        $sql = "UPDATE tbusersiswa SET username=?, email=? WHERE idsiswa=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $username, $email, $idsiswa);
        $stmt->execute();
        
        // Commit transaksi
        $conn->commit();

        echo "<script>
            alert('Data siswa berhasil diupdate');
            window.location.href = 'datasiswa.php';
        </script>";
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi error
        $conn->rollback();
        echo 'Error updating record: ' . $e->getMessage();
    }
}
?>

<style>
    body {
    overflow-x: hidden; /* Menghindari scroll bar horizontal */
}

.container, .row, .col-lg-12 {
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
        <div class="col-lg-12 mb-4">
            <!-- Data Siswa -->
            <div class="card shadow-sm mb-4 border-light">
                <div class="card-header py-3 bg-light d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Data Siswa</h6>
                    <i class="fas fa-school ml-auto text-primary"></i>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                    <div class="col-lg-12">
    <div class="card border-0" style="margin-top: -20px;">
        <div class="card-body p-4">
            <form method="POST" action="">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="namalengkapsiswa" class="text-primary">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-sm" id="namalengkapsiswa" name="namalengkapsiswa" value="<?php echo htmlspecialchars($data['namalengkapsiswa']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="username" class="text-primary">Username</label>
                        <input type="text" class="form-control form-control-sm" id="username" name="username" value="<?php echo htmlspecialchars($data['username']); ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="email" class="text-primary">Email</label>
                        <input type="email" class="form-control form-control-sm" id="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nisn" class="text-primary">NISN</label>
                        <input type="text" class="form-control form-control-sm" id="nisn" name="nisn" value="<?php echo htmlspecialchars($data['nisn']); ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="nik" class="text-primary">NIK</label>
                        <input type="text" class="form-control form-control-sm" id="nik" name="nik" value="<?php echo htmlspecialchars($data['nik']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggallahir" class="text-primary">Tanggal Lahir</label>
                        <input type="date" class="form-control form-control-sm" id="tanggallahir" name="tanggallahir" value="<?php echo htmlspecialchars($data['tanggallahir']); ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="namapanggilan" class="text-primary">Nama Panggilan</label>
                        <input type="text" class="form-control form-control-sm" id="namapanggilan" name="namapanggilan" value="<?php echo htmlspecialchars($data['namapanggilan']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="jeniskelamin" class="text-primary">Jenis Kelamin</label>
                        <select class="form-control form-control-sm" id="jeniskelamin" name="jeniskelamin" required>
                            <option value="laki-laki" <?php if ($data['jeniskelamin'] == 'laki-laki') echo 'selected'; ?>>Laki-laki</option>
                            <option value="perempuan" <?php if ($data['jeniskelamin'] == 'perempuan') echo 'selected'; ?>>Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="asalsekolah" class="text-primary">Asal Sekolah</label>
                        <select class="form-control form-control-sm" id="asalsekolah" name="asalsekolah" required>
                            <?php
                            // Ambil daftar sekolah
                            $sql = "SELECT idsekolah, namasekolah FROM tbsekolah";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                $selected = ($row['idsekolah'] == $data['idsekolah']) ? 'selected' : '';
                                echo "<option value='" . htmlspecialchars($row['idsekolah']) . "' $selected>" . htmlspecialchars($row['namasekolah']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="notelp" class="text-primary">No Telp</label>
                        <input type="text" class="form-control form-control-sm" id="notelp" name="notelp" value="<?php echo htmlspecialchars($data['notelp']); ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="alamat" class="text-primary">Alamat</label>
                        <textarea class="form-control form-control-sm" id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($data['alamat']); ?></textarea>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-sm btn-block">Update Data Siswa</button>
                </div>
            </form>
            <hr>
            <div class="text-center">
                <a class="small text-primary" href="profilsiswa.php?id=<?php echo $idsiswa; ?>">Kembali ke Profil Siswa</a>
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


<?php include('footer.php'); ?>

</div>
<!-- End of Main Content -->
