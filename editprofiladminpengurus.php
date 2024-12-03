<?php
include 'header.php';

// Cek apakah pengguna sudah login dan memiliki role admin atau pengurus
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'pengurus')) {
    header('Location: login.php'); // Arahkan ke halaman login jika tidak memiliki akses
    exit();
}

// Ambil ID user dari session
$iduser = $_SESSION['iduser'];

if ($iduser) {
    // Kueri SQL untuk mendapatkan data user
    $query = "
        SELECT 
            u.username,
            u.email, 
            u.role, 
            u.asalsekolah 
        FROM 
            tbuser u 
        WHERE 
            u.iduser = ?";
    
    // Siapkan pernyataan
    $stmt = $conn->prepare($query);
    
    // Periksa jika prepare() berhasil
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    
    // Bind parameter
    $stmt->bind_param("i", $iduser);
    
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
        echo "Data pengguna tidak ditemukan.";
        exit();
    }
    
    // Ambil daftar sekolah untuk dropdown
    $sekolah_query = "SELECT idsekolah, namasekolah FROM tbsekolah";
    $sekolah_result = $conn->query($sekolah_query);
    if (!$sekolah_result) {
        die("Query failed: " . $conn->error);
    }
} else {
    echo "ID pengguna tidak ditemukan.";
    exit();
}

// Proses form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $idsekolah = $_POST['idsekolah'];

    // Validasi data form
    if (empty($username) || empty($idsekolah)) {
        echo "Semua field harus diisi.";
        exit();
    }

    // Update data pengguna di database
    $updateQuery = "UPDATE tbuser SET username = ?, email = ?, asalsekolah = ? WHERE iduser = ?";
    $stmt = $conn->prepare($updateQuery);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssii", $username, $email, $idsekolah, $iduser);

    if ($stmt->execute()) {
        echo "<script>
                alert('Edit profil berhasil');
                window.location.href = 'index.php';
              </script>";
        exit();
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
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
            <!-- Edit Profil Admin/Pengurus -->
            <div class="card shadow-sm mb-4 border-light">
                <div class="card-header py-3 bg-light d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Profil</h6>
                    <i class="fas fa-user-edit ml-auto text-primary"></i>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card border-0" style="margin-top: -20px;">
                                <div class="card-body p-4">
                                    <form method="POST" action="">
                                        <input type="hidden" name="iduser" value="<?php echo htmlspecialchars($iduser); ?>">
                                        
                                        <div class="form-group">
                                            <label for="username" class="text-primary">Username</label>
                                            <input type="text" class="form-control form-control-sm" id="username" name="username" placeholder="Username" value="<?php echo htmlspecialchars($row['username']); ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="role" class="text-primary">Role</label>
                                            <input type="text" class="form-control form-control-sm" id="role" name="role" value="<?php echo htmlspecialchars($row['role']); ?>" readonly>
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
                                                        <?php echo ($row['asalsekolah'] == $sekolah_row['idsekolah']) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($sekolah_row['namasekolah']); ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary btn-sm btn-block">
                                            Update Profil
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small text-primary" href="index.php">Kembali ke Profil</a>
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
