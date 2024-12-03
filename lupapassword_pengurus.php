<?php
// Mulai sesi untuk menyimpan data sementara
session_start();

// Koneksi ke database
include 'koneksi.php';

$error = '';
$success = '';
$verified = false;

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Periksa apakah username dan email ada di dalam form submission
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    if (!empty($username) && !empty($email)) {
        // Cek apakah username dan email ada di tbuser
        $query = "SELECT * FROM tbuser WHERE username = ? AND email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Jika ada kecocokan
        if ($result->num_rows > 0) {
            $success = "Username dan email valid. Anda dapat melanjutkan ke penggantian password.";
            $verified = true;  // Set flag menjadi true jika verifikasi berhasil
            $_SESSION['username'] = $username;  // Simpan username ke session untuk keperluan selanjutnya
        } else {
            $error = "Username atau email tidak valid.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password Pengurus</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Lupa Password Pengurus</h1>
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
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" id="username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>
                            
                            <!-- Jika verifikasi belum berhasil, tampilkan tombol 'Submit', jika berhasil tombol 'Selanjutnya' -->
                            <?php if (!$verified): ?>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Submit</button>
                            <?php else: ?>
                                <a href="gantipassword_pengurus.php" class="btn btn-success btn-user btn-block">Selanjutnya</a>
                            <?php endif; ?>
                        </form>

                        <div class="mt-2">
                            <a href="lupapassword.php" class="btn btn-secondary btn-user btn-block">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
