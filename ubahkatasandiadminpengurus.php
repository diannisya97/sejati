<?php
include 'header.php';
// Cek apakah pengguna sudah login dan apakah form telah disubmit
if (!isset($_SESSION['iduser'])) {
    header("Location: login.php"); // Redirect ke halaman login jika belum login
    exit;
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idUser = $_SESSION['iduser'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Ambil data pengguna dari database
    $sql = "SELECT pass FROM tbuser WHERE iduser = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUser);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi kata sandi lama
        if (password_verify($old_password, $user['pass'])) {
            // Cek apakah kata sandi baru sesuai dengan konfirmasi
            if ($new_password === $confirm_password) {
                // Enkripsi kata sandi baru
                $new_password_hashed = password_hash($new_password, PASSWORD_BCRYPT);

                // Update kata sandi di database
                $update_sql = "UPDATE tbuser SET pass = ? WHERE iduser = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("si", $new_password_hashed, $idUser);

                if ($update_stmt->execute()) {
                    $success = "Kata sandi berhasil diubah.";
                } else {
                    $error = "Terjadi kesalahan saat mengubah kata sandi. Silakan coba lagi.";
                }
            } else {
                $error = "Konfirmasi kata sandi baru tidak cocok.";
            }
        } else {
            $error = "Kata sandi lama tidak benar.";
        }
    } else {
        $error = "Pengguna tidak ditemukan.";
    }
}

?>

<?php
include 'sidebar.php';
include 'topbar.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="m-0">
                        <i class="fas fa-key"></i> Ubah Kata Sandi
                    </h5>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="old_password">Kata Sandi Lama</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="old_password" name="old_password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="togglePasswordVisibility('old_password', 'eye-icon-old')">
                                        <i class="fa fa-eye-slash" id="eye-icon-old"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Kata Sandi Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="togglePasswordVisibility('new_password', 'eye-icon-new')">
                                        <i class="fa fa-eye-slash" id="eye-icon-new"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Konfirmasi Kata Sandi Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="togglePasswordVisibility('confirm_password', 'eye-icon-confirm')">
                                        <i class="fa fa-eye-slash" id="eye-icon-confirm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-key"></i> Ubah Kata Sandi
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

<script>
function togglePasswordVisibility(passwordFieldId, eyeIconId) {
    var passwordField = document.getElementById(passwordFieldId);
    var eyeIcon = document.getElementById(eyeIconId);
    
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

<?php include 'footer.php';?>
