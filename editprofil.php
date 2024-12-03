<?php
include 'header.php';

// Cek apakah pengguna sudah login dan memiliki role siswa
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    header('Location: login.php'); // Arahkan ke halaman login jika tidak memiliki akses
    exit();
}

// Ambil ID siswa dari session
$idsiswa = $_SESSION['idsiswa'];

if ($idsiswa) {
    // Kueri SQL dengan join untuk mendapatkan data siswa dan nama sekolah
    $query = "
        SELECT 
            tbsiswa.*, 
            tbsekolah.namasekolah, 
            tbusersiswa.username,
            tbusersiswa.email 
        FROM 
            tbsiswa 
        JOIN 
            tbsekolah ON tbsiswa.asalsekolah = tbsekolah.idsekolah 
        JOIN 
            tbusersiswa ON tbsiswa.idsiswa = tbusersiswa.idsiswa
        WHERE 
            tbsiswa.idsiswa = ?";
    
    // Siapkan pernyataan
    $stmt = $conn->prepare($query);
    
    // Periksa jika prepare() berhasil
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    
    // Bind parameter
    $stmt->bind_param("i", $idsiswa);
    
    // Eksekusi pernyataan
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    
    // Ambil hasil
    $result = $stmt->get_result();
    
    // Ambil data
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data siswa tidak ditemukan.";
        exit();
    }
    
    // Ambil daftar sekolah
    $sekolah_query = "SELECT idsekolah, namasekolah FROM tbsekolah";
    $sekolah_result = $conn->query($sekolah_query);
    if (!$sekolah_result) {
        die("Query failed: " . $conn->error);
    }
} else {
    echo "ID siswa tidak ditemukan.";
    exit();
}

// Proses form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $namalengkapsiswa = $_POST['namalengkapsiswa'];
    $nik = $_POST['nik'];
    $nisn = $_POST['nisn'];
    $tanggallahir = $_POST['tanggallahir'];
    $namapanggilan = $_POST['namapanggilan'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $idsekolah = $_POST['idsekolah']; // Ubah variabel ini sesuai dengan nama field dalam form
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Mulai transaksi
    $conn->begin_transaction();

    try {
        // Update data siswa di tabel tbsiswa
        $updateQuery = "UPDATE tbsiswa SET namalengkapsiswa = ?, nik = ?, nisn = ?, tanggallahir = ?, namapanggilan = ?, jeniskelamin = ?, asalsekolah = ?, notelp = ?, alamat = ? WHERE idsiswa = ?";
        $stmt = $conn->prepare($updateQuery);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("sssssssisi", $namalengkapsiswa, $nik, $nisn, $tanggallahir, $namapanggilan, $jeniskelamin, $idsekolah, $notelp, $alamat, $idsiswa);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        // Update username di tabel tbusersiswa
        $updateUserQuery = "UPDATE tbusersiswa SET username = ?, email = ? WHERE idsiswa = ?";
        $stmt = $conn->prepare($updateUserQuery);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ssi", $username, $email, $idsiswa);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        // Commit transaksi jika semua query berhasil
        $conn->commit();

        echo "<script>
                alert('Edit profil berhasil');
                window.location.href = 'index.php';
                </script>";
        exit();
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        $conn->rollback();
        echo "Terjadi kesalahan: " . $e->getMessage();
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
    <!-- Edit Profil Siswa -->
    <div class="card shadow-sm mb-4 border-light">
        <div class="card-header py-3 bg-light d-flex align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Edit Profil Siswa</h6>
            <i class="fas fa-user-edit ml-auto text-primary"></i>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <input type="hidden" name="idsiswa" value="<?php echo htmlspecialchars($row['idsiswa']); ?>">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="namalengkapsiswa" class="text-primary">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-sm" id="namalengkapsiswa" name="namalengkapsiswa" placeholder="Nama Lengkap" value="<?php echo htmlspecialchars($row['namalengkapsiswa']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username" class="text-primary">Username</label>
                            <input type="text" class="form-control form-control-sm" id="username" name="username" placeholder="Username" value="<?php echo htmlspecialchars($row['username']); ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nik" class="text-primary">NIK</label>
                            <input type="text" class="form-control form-control-sm" id="nik" name="nik" placeholder="NIK" value="<?php echo htmlspecialchars($row['nik']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nisn" class="text-primary">NISN</label>
                            <input type="text" class="form-control form-control-sm" id="nisn" name="nisn" placeholder="NISN" value="<?php echo htmlspecialchars($row['nisn']); ?>" required>
                        </div>
                    </div>
                </div>

                <!-- Tambahan untuk email dan tanggal lahir -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="text-primary">Email</label>
                            <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggallahir" class="text-primary">Tanggal Lahir</label>
                            <input type="date" class="form-control form-control-sm" id="tanggallahir" name="tanggallahir" placeholder="Tanggal Lahir" value="<?php echo htmlspecialchars($row['tanggallahir']); ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="namapanggilan" class="text-primary">Nama Panggilan</label>
                            <input type="text" class="form-control form-control-sm" id="namapanggilan" name="namapanggilan" placeholder="Nama Panggilan" value="<?php echo htmlspecialchars($row['namapanggilan']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jeniskelamin" class="text-primary">Jenis Kelamin</label>
                            <select class="form-control form-control-sm" id="jeniskelamin" name="jeniskelamin" required>
                                <option value="laki-laki" <?php echo $row['jeniskelamin'] == 'laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="perempuan" <?php echo $row['jeniskelamin'] == 'perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
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
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="notelp" class="text-primary">No Telp</label>
                            <input type="text" class="form-control form-control-sm" id="notelp" name="notelp" placeholder="No Telp" value="<?php echo htmlspecialchars($row['notelp']); ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="alamat" class="text-primary">Alamat</label>
                            <textarea class="form-control form-control-sm" id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($row['alamat']); ?></textarea>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-sm btn-block">
                    Update Profil
                </button>
            </form>
            <hr>
            <div class="text-center">
                <a class="small text-primary" href="index.php?idsiswa=<?php echo htmlspecialchars($row['idsiswa']); ?>">Kembali ke Profil Siswa</a>
            </div>
        </div>
    </div>
</div>

    </div>    
</div>


<?php include('footer.php'); ?>

</div>
<!-- End of Main Content -->
