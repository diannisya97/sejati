<?php
session_start();
$role = $_POST['role'];
$_SESSION['role'] = $role;

include 'koneksi.php';
// Mengambil data sekolah dari database
$sql = "SELECT idsekolah, namasekolah FROM tbsekolah";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Form Pendaftaran Siswa</h1>
                    </div>
                    <form method="POST" action="register_process.php">
                        <div class="form-group">
                            <label for="asalsekolah" class="text-primary">Asal Sekolah</label>
                            <select class="form-control form-control-user" name="asalsekolah" required>
                                <option value="">Pilih Asal Sekolah</option>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['idsekolah'] . "'>" . $row['namasekolah'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email" class="text-primary">Email</label>
                            <input type="email" class="form-control form-control-user" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label for="username" class="text-primary">Username</label>
                            <input type="text" class="form-control form-control-user" name="username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                                <label for="pass" class="text-primary">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-user" name="pass" id="password" placeholder="Password" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" onclick="togglePasswordVisibility()">
                                            <i class="fa fa-eye-slash" id="eye-icon"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <div class="form-group">
                            <label for="jeniskelamin" class="text-primary">Jenis Kelamin</label>
                            <select class="form-control form-control-user" name="jeniskelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <!-- Additional fields for student information -->
                        <div class="form-group">
                            <label for="namalengkapsiswa" class="text-primary">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-user" name="namalengkapsiswa" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggallahir" class="text-primary">Tanggal Lahir</label>
                            <input type="date" class="form-control form-control-user" name="tanggallahir" required>
                        </div>
                        <div class="form-group">
                            <label for="nisn" class="text-primary">NISN</label>
                            <input type="text" class="form-control form-control-user" name="nisn" placeholder="NISN" required>
                        </div>
                        <div class="form-group">
                            <label for="nik" class="text-primary">NIK</label>
                            <input type="text" class="form-control form-control-user" name="nik" placeholder="NIK" required>
                        </div>
                        <div class="form-group">
                            <label for="namapanggilan" class="text-primary">Nama Panggilan</label>
                            <input type="text" class="form-control form-control-user" name="namapanggilan" placeholder="Nama Panggilan" required>
                        </div>
                        <div class="form-group">
                            <label for="notelp" class="text-primary">No Telp</label>
                            <input type="text" class="form-control form-control-user" name="notelp" placeholder="Nomor Telepon" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="text-primary">Alamat</label>
                            <textarea class="form-control form-control-user" name="alamat" placeholder="Alamat" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">Daftar</button>
                    </form>
                    <div class="mt-2">
                        <a href="register.php" class="btn btn-secondary btn-user btn-block">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php
// Menutup koneksi database
$conn->close();
?>

<script>
function togglePasswordVisibility() {
    var passwordField = document.getElementById("password");
    var eyeIcon = document.getElementById("eye-icon");
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    } else {
        passwordField.type = "password";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    }
}
</script>
</body>
</html>
