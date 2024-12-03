<?php
// Mulai sesi
session_start();

// Koneksi ke database
include 'koneksi.php';

$error = '';
$success = '';

// Periksa apakah pengguna sudah diverifikasi sebelumnya
if (!isset($_SESSION['username'])) {
    header('Location: lupapassword_pengurus.php');
    exit();
}

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi password
    if ($new_password !== $confirm_password) {
        $error = "Password baru dan konfirmasi password tidak cocok.";
    } else {
        $username = $_SESSION['username'];
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password di database
        $query = "UPDATE tbuser SET pass = ? WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $hashed_password, $username);

        if ($stmt->execute()) {
            $success = "Password berhasil diperbarui. Silakan login dengan password baru Anda.";
            // Hapus username dari sesi setelah berhasil mengganti password
            unset($_SESSION['username']);
        } else {
            $error = "Gagal memperbarui password. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password Pengurus</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Ganti Password Pengurus</h1>
                        </div>
                        
                        <!-- Menampilkan pesan error atau sukses -->
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

                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="new_password">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" name="new_password" class="form-control" id="new_password" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" onclick="togglePasswordVisibility('new_password', 'eye-icon-new')">
                                            <i id="eye-icon-new" class="fa fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" onclick="togglePasswordVisibility('confirm_password', 'eye-icon-confirm')">
                                            <i id="eye-icon-confirm" class="fa fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">Ganti Password</button>
                        </form>

                        <div class="mt-2">
                            <a href="login.php" class="btn btn-secondary btn-user btn-block">Kembali ke Halaman Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>