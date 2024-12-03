<?php
// Mulai sesi
session_start();

// Koneksi ke database
include 'koneksi.php';

$error = '';
$success = '';
$verified = false;

// Periksa apakah form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan variabel POST ada sebelum mengaksesnya
    if (isset($_POST['tanggallahir']) && isset($_POST['nik']) && isset($_POST['nisn'])) {
        $tanggallahir = $_POST['tanggallahir'];
        $nik = $_POST['nik'];
        $nisn = $_POST['nisn'];

        // Cek apakah data ada di tbsiswa
        $query = "SELECT * FROM tbsiswa WHERE tanggallahir = ? AND nik = ? AND nisn = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $tanggallahir, $nik, $nisn);
        $stmt->execute();
        $result = $stmt->get_result();

        // Jika ada kecocokan
        if ($result->num_rows > 0) {
            $success = "Data valid. Anda dapat melanjutkan ke penggantian password.";
            $verified = true;  // Set flag menjadi true jika verifikasi berhasil
            $_SESSION['nisn'] = $nisn;  // Simpan NISN ke session untuk keperluan selanjutnya
        } else {
            $error = "Data tidak valid. Periksa kembali tanggal lahir, NIK, dan NISN Anda.";
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password Siswa</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Lupa Password Siswa</h1>
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
                                <label for="tanggallahir">Tanggal Lahir</label>
                                <input type="date" name="tanggallahir" class="form-control" id="tanggallahir" required>
                            </div>
                            <div class="form-group">
                                <label for="nik">NIK</label>
                                <input type="text" name="nik" class="form-control" id="nik" required>
                            </div>
                            <div class="form-group">
                                <label for="nisn">NISN</label>
                                <input type="text" name="nisn" class="form-control" id="nisn" required>
                            </div>
                            
                            <!-- Jika verifikasi belum berhasil, tampilkan tombol 'Submit', jika berhasil tombol 'Selanjutnya' -->
                            <?php if (!$verified): ?>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Submit</button>
                            <?php else: ?>
                                <a href="gantipassword_siswa.php" class="btn btn-success btn-user btn-block">Selanjutnya</a>
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
