<?php include('header.php'); 

// Inisialisasi variabel jumlah
$jumlahSekolah = 0;
$jumlahSiswa = 0;

// Periksa peran pengguna
if ($_SESSION['role'] == 'admin') {
    // Ambil jumlah sekolah dari database
    $sqlCountSekolah = "SELECT COUNT(*) as jumlahSekolah FROM tbsekolah";
    $resultCountSekolah = $conn->query($sqlCountSekolah);
    if ($resultCountSekolah === FALSE) {
        die("Query gagal: " . $conn->error);
    }
    $rowCountSekolah = $resultCountSekolah->fetch_assoc();
    $jumlahSekolah = $rowCountSekolah['jumlahSekolah'];

    // Ambil jumlah siswa dari database
    $sqlCountSiswa = "SELECT COUNT(*) as jumlahSiswa FROM tbsiswa";
    $resultCountSiswa = $conn->query($sqlCountSiswa);
    if ($resultCountSiswa === FALSE) {
        die("Query gagal: " . $conn->error);
    }
    $rowCountSiswa = $resultCountSiswa->fetch_assoc();
    $jumlahSiswa = $rowCountSiswa['jumlahSiswa'];
} elseif ($_SESSION['role'] == 'pengurus') {
    $idpengurus = $_SESSION['iduser'];
    // Ambil jumlah siswa dari database berdasarkan sekolah pengurus
    $sqlCountSiswa = "SELECT COUNT(*) as jumlahSiswa FROM tbsiswa s
                      LEFT JOIN tbsekolah sc ON s.asalsekolah = sc.idsekolah
                      WHERE sc.idsekolah = (
                          SELECT asalsekolah FROM tbuser WHERE iduser = $idpengurus
                      )";
    $resultCountSiswa = $conn->query($sqlCountSiswa);
    if ($resultCountSiswa === FALSE) {
        die("Query gagal: " . $conn->error);
    }
    $rowCountSiswa = $resultCountSiswa->fetch_assoc();
    $jumlahSiswa = $rowCountSiswa['jumlahSiswa'];
}


if ($role === 'admin' || $role === 'pengurus') {
    // Ambil ID user dari session
    $idUser = $_SESSION['iduser']; // Assuming 'iduser' is stored in the session

    // Query untuk mengambil data user
    $sql = "SELECT u.username, u.role, u.email, s.namasekolah 
            FROM tbuser u 
            JOIN tbsekolah s ON u.asalsekolah = s.idsekolah 
            WHERE u.iduser = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUser);
    $stmt->execute();
    $result = $stmt->get_result();

    // Ambil data user
    $user = $result->fetch_assoc();
}

// Ambil role dari session
$role = $_SESSION['role']; // Diasumsikan 'role' disimpan dalam session saat login

if ($role === 'pengurus') {
    // Ambil iduser dari session
    $idpengurus = $_SESSION['iduser'];

    // Query untuk mendapatkan asalsekolah pengurus berdasarkan iduser
    $sqlGetSekolah = "SELECT asalsekolah FROM tbuser WHERE iduser = $idpengurus";
    $resultGetSekolah = mysqli_query($conn, $sqlGetSekolah);
    $rowGetSekolah = mysqli_fetch_assoc($resultGetSekolah);
    $asalsekolahPengurus = $rowGetSekolah['asalsekolah'];

    // Query untuk pengurus: hanya menampilkan data siswa dari sekolah yang sama
    $queryIMT = "SELECT keterangan, COUNT(*) AS jumlah
                 FROM (
                     SELECT imt.keterangan
                     FROM imt
                     JOIN tbsiswa ON imt.idsiswa = tbsiswa.idsiswa
                     WHERE tbsiswa.asalsekolah = '$asalsekolahPengurus'
                     AND (imt.idsiswa, imt.tglperiksa) IN (
                         SELECT idsiswa, MAX(tglperiksa)
                         FROM imt
                         GROUP BY idsiswa
                     )
                 ) AS latest_imt
                 GROUP BY keterangan";

    $queryIMTPerempuan = "SELECT keterangan, COUNT(*) AS jumlah
                          FROM (
                              SELECT imtperempuan.keterangan
                              FROM imtperempuan
                              JOIN tbsiswa ON imtperempuan.idsiswa = tbsiswa.idsiswa
                              WHERE tbsiswa.asalsekolah = '$asalsekolahPengurus'
                              AND (imtperempuan.idsiswa, imtperempuan.tglperiksa) IN (
                                  SELECT idsiswa, MAX(tglperiksa)
                                  FROM imtperempuan
                                  GROUP BY idsiswa
                              )
                          ) AS latest_imtperempuan
                          GROUP BY keterangan";

                          // Eksekusi query
    $resultIMT = mysqli_query($conn, $queryIMT);
    $resultIMTPerempuan = mysqli_query($conn, $queryIMTPerempuan);

    // Inisialisasi array untuk menyimpan jumlah kategori
    $categoriesCount = [
        'Kurus' => 0,
        'Normal' => 0,
        'Kelebihan Berat Badan' => 0,
        'Obesitas' => 0
    ];

    // Hitung jumlah dari tabel imt
    while ($row = mysqli_fetch_assoc($resultIMT)) {
        $categoriesCount[$row['keterangan']] += $row['jumlah'];
    }

    // Hitung jumlah dari tabel imtperempuan
    while ($row = mysqli_fetch_assoc($resultIMTPerempuan)) {
        $categoriesCount[$row['keterangan']] += $row['jumlah'];
    }
} else if ($role === 'admin') {
    // Query untuk admin: menampilkan semua data tanpa filter asalsekolah
    $queryIMT = "SELECT keterangan, COUNT(*) AS jumlah
                 FROM (
                     SELECT keterangan
                     FROM imt
                     WHERE (idsiswa, tglperiksa) IN (
                         SELECT idsiswa, MAX(tglperiksa)
                         FROM imt
                         GROUP BY idsiswa
                     )
                 ) AS latest_imt
                 GROUP BY keterangan";

    $queryIMTPerempuan = "SELECT keterangan, COUNT(*) AS jumlah
                          FROM (
                              SELECT keterangan
                              FROM imtperempuan
                              WHERE (idsiswa, tglperiksa) IN (
                                  SELECT idsiswa, MAX(tglperiksa)
                                  FROM imtperempuan
                                  GROUP BY idsiswa
                              )
                          ) AS latest_imtperempuan
                          GROUP BY keterangan";

    // Eksekusi query
    $resultIMT = mysqli_query($conn, $queryIMT);
    $resultIMTPerempuan = mysqli_query($conn, $queryIMTPerempuan);

    // Inisialisasi array untuk menyimpan jumlah kategori
    $categoriesCount = [
        'Kurus' => 0,
        'Normal' => 0,
        'Kelebihan Berat Badan' => 0,
        'Obesitas' => 0
    ];

    // Hitung jumlah dari tabel imt
    while ($row = mysqli_fetch_assoc($resultIMT)) {
        $categoriesCount[$row['keterangan']] += $row['jumlah'];
    }

    // Hitung jumlah dari tabel imtperempuan
    while ($row = mysqli_fetch_assoc($resultIMTPerempuan)) {
        $categoriesCount[$row['keterangan']] += $row['jumlah'];
    }
}

if ($role === 'siswa') {
    // Ambil ID siswa dari session
    $idSiswa = $_SESSION['idsiswa'];

    // Query untuk mengambil data siswa
    $sql = "SELECT s.namalengkapsiswa, s.nik, s.nisn, s.tanggallahir, s.namapanggilan, s.jeniskelamin, s.asalsekolah, s.notelp, s.alamat, sk.namasekolah, u.username, u.email
        FROM tbsiswa s
        JOIN tbsekolah sk ON s.asalsekolah = sk.idsekolah
        JOIN tbusersiswa u ON s.idsiswa = u.idsiswa
        WHERE s.idsiswa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idSiswa);
    $stmt->execute();
    $result = $stmt->get_result();
    $siswa = $result->fetch_assoc();

// Ambil 3 data terakhir IMT untuk siswa laki-laki
$sqlIMT = "SELECT hasilimt, keterangan, tglperiksa FROM imt WHERE idsiswa = ? ORDER BY tglperiksa DESC LIMIT 3";
$stmtIMT = $conn->prepare($sqlIMT);
$stmtIMT->bind_param("i", $idSiswa);
$stmtIMT->execute();
$resultIMT = $stmtIMT->get_result();
$dataIMT = $resultIMT->fetch_all(MYSQLI_ASSOC);

// Ambil 3 data terakhir IMT untuk siswa perempuan
$sqlIMTP = "SELECT hasilimtperempuan AS hasilimt, keterangan, tglperiksa FROM imtperempuan WHERE idsiswa = ? ORDER BY tglperiksa DESC LIMIT 3";
$stmtIMTP = $conn->prepare($sqlIMTP);
$stmtIMTP->bind_param("i", $idSiswa);
$stmtIMTP->execute();
$resultIMTP = $stmtIMTP->get_result();
$dataIMTP = $resultIMTP->fetch_all(MYSQLI_ASSOC);

// Ambil 3 data terakhir BMR untuk siswa laki-laki
$sqlBMR = "SELECT hasil, tglperiksa FROM kebutuhanenergi WHERE idsiswa = ? ORDER BY tglperiksa DESC LIMIT 3";
$stmtBMR = $conn->prepare($sqlBMR);
$stmtBMR->bind_param("i", $idSiswa);
$stmtBMR->execute();
$resultBMR = $stmtBMR->get_result();
$dataBMR = $resultBMR->fetch_all(MYSQLI_ASSOC);

// Ambil 3 data terakhir BMR untuk siswa perempuan
$sqlBMRP = "SELECT hasil,tglperiksa FROM kebutuhanenergiperempuan WHERE idsiswa = ? ORDER BY tglperiksa DESC LIMIT 3";
$stmtBMRP = $conn->prepare($sqlBMRP);
$stmtBMRP->bind_param("i", $idSiswa);
$stmtBMRP->execute();
$resultBMRP = $stmtBMRP->get_result();
$dataBMRP = $resultBMRP->fetch_all(MYSQLI_ASSOC);

// Ambil idusersiswa dan jenis kelamin berdasarkan idsiswa
$sqlUserSiswa = "SELECT us.idusersiswa, s.jeniskelamin 
FROM tbusersiswa us
JOIN tbsiswa s ON us.idsiswa = s.idsiswa
WHERE us.idsiswa = ?";
$stmtUserSiswa = $conn->prepare($sqlUserSiswa);
if ($stmtUserSiswa === FALSE) {
die("Prepare failed: " . $conn->error);
}
$stmtUserSiswa->bind_param("i", $idSiswa);
$stmtUserSiswa->execute();
$resultUserSiswa = $stmtUserSiswa->get_result();
$dataUserSiswa = $resultUserSiswa->fetch_assoc();
$idUserSiswa = $dataUserSiswa['idusersiswa'];
$jenisKelamin = $dataUserSiswa['jeniskelamin'];

// Fungsi untuk mengambil data kuisioner terbaru
function ambilDataKuisionerTerbaru($conn, $table, $idUserSiswa) {
$sql = "SELECT totalSkor, kategori FROM $table WHERE idusersiswa = ? ORDER BY idkuisioner DESC LIMIT 1";
$stmt = $conn->prepare($sql);
if ($stmt === FALSE) {
die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $idUserSiswa);
$stmt->execute();
return $stmt->get_result()->fetch_assoc();
}

// Ambil data dari tabel kuisioner berdasarkan jenis kelamin
$kuisionerKesehatan = ($jenisKelamin == 'laki-laki') ? ambilDataKuisionerTerbaru($conn, 'kuisionerkesehatanlaki', $idUserSiswa) : ambilDataKuisionerTerbaru($conn, 'kuisionerkesehatanperempuan', $idUserSiswa);
$kuisionerPerubahan = ($jenisKelamin == 'laki-laki') ? ambilDataKuisionerTerbaru($conn, 'kuisionerperubahanlaki', $idUserSiswa) : ambilDataKuisionerTerbaru($conn, 'kuisionerperubahanperempuan', $idUserSiswa);
$kuisionerMakan = ambilDataKuisionerTerbaru($conn, 'kuisionermakan', $idUserSiswa);
$kuisionerMental = ambilDataKuisionerTerbaru($conn, 'kuisionermental', $idUserSiswa);
$kuisionerMenikah = ambilDataKuisionerTerbaru($conn, 'kuisionermenikah', $idUserSiswa);

$stmt->close();
} else {
// Handle logic untuk admin atau pengurus
// Misalnya, ambil semua data siswa atau data lain sesuai kebutuhan
$siswa = []; // Inisialisasi array kosong atau data lain yang diperlukan
}
?>

<?php include('sidebar.php'); ?>
<?php include('topbar.php'); ?>

<style>
@media (max-width: 576px) {
    .card-body h6 {
        font-size: 16px; /* Mengecilkan ukuran tulisan title */
    }
    .list-group-item span {
        font-size: 14px; /* Mengecilkan ukuran tulisan totalSkor dan kategori */
    }
}
</style>


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Selamat datang, <?php echo htmlspecialchars($username); ?>!</h1>
                </div>

                    <!-- Content Row -->
                <div class="row">

                    <?php if ($_SESSION['role'] == 'admin'): ?>
                    <!-- Card Jumlah Sekolah -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Jumlah Sekolah</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $jumlahSekolah; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-school fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Jumlah Siswa -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Jumlah Siswa</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $jumlahSiswa; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Jumlah Kategori IMT -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Jumlah IMT Kategori Kurus</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $categoriesCount['Kurus']; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-slash fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Jumlah Kategori IMT Normal -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Jumlah IMT Kategori Normal</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $categoriesCount['Normal']; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Jumlah Kategori Kelebihan Berat Badan -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Jumlah IMT Kategori Kelebihan Berat Badan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $categoriesCount['Kelebihan Berat Badan']; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Jumlah Kategori Obesitas -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            Jumlah IMT Kategori Obesitas</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $categoriesCount['Obesitas']; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-times fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php elseif ($_SESSION['role'] == 'pengurus'): ?>
                        <!-- Card Jumlah Siswa -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Jumlah Siswa</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $jumlahSiswa; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Jumlah Kategori IMT -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Jumlah IMT Kategori Kurus</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $categoriesCount['Kurus']; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-slash fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Jumlah Kategori IMT Normal -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Jumlah IMT Kategori Normal</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $categoriesCount['Normal']; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Jumlah Kategori Kelebihan Berat Badan -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Jumlah IMT Kategori Kelebihan Berat Badan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $categoriesCount['Kelebihan Berat Badan']; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Jumlah Kategori Obesitas -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            Jumlah IMT Kategori Obesitas</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $categoriesCount['Obesitas']; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-times fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'pengurus'): ?>
                <!-- Profil Admin/Pengurus -->
                <div class="card shadow-sm mb-3 border-light">
                    <div class="card-header py-2 bg-light text-primary d-flex align-items-center">
                        <h6 class="m-0 font-weight-bold">Profil <?php echo ($_SESSION['role'] == 'admin') ? 'Admin' : 'Pengurus'; ?></h6>
                        <i class="fas fa-user-shield ml-auto"></i>
                    </div>
                    <div class="card-body">
                        <?php if ($user): ?>
                            <div class="row">
                                <?php 
                                // Define the fields to display
                                $fields = [
                                    ["label" => "Username", "value" => $user['username'], "icon" => "fas fa-user"],
                                    ["label" => "Role", "value" => ucfirst($_SESSION['role']), "icon" => "fas fa-user-tag"],
                                    ["label" => "Email", "value" => $user['email'], "icon" => "fas fa-envelope"],
                                    ["label" => "Asal Instansi", "value" => $user['namasekolah'], "icon" => "fas fa-school"]
                                ];

                                // Loop through each field and display it
                                foreach ($fields as $field): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="profile-info bg-white p-2 rounded d-flex align-items-center shadow-sm" style="border-left: 3px solid #007bff;">
                                            <div class="profile-icon text-primary mr-2">
                                                <i class="<?php echo $field['icon']; ?> fa-lg mr-1"></i>
                                            </div>
                                            <div>
                                                <h6 class="font-weight-bold text-primary mb-1"><?php echo $field['label']; ?></h6>
                                                <p class="mb-0" style="font-size: 0.9rem;"><?php echo htmlspecialchars($field['value']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning" role="alert">
                                <i class="fas fa-exclamation-triangle"></i> Data pengguna tidak ditemukan.
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer text-right">
                        <a href="editprofiladminpengurus.php" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="ubahkatasandiadminpengurus.php" class="btn btn-warning ml-2">
                            <i class="fas fa-key"></i> Ubah Kata Sandi
                        </a>
                    </div>
                </div>
            <?php endif; ?>


                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <?php if ($_SESSION['role'] == 'siswa'): ?>
                        <!-- Profil Siswa -->
                        <div class="card shadow-sm mb-3 border-light">
                            <div class="card-header py-2 bg-light text-primary d-flex align-items-center">
                                <h6 class="m-0 font-weight-bold">Profil Siswa</h6>
                                <i class="fas fa-user-graduate ml-auto"></i>
                            </div>
                            <div class="card-body">
                                <?php if ($siswa): ?>
                                    <div class="row">
                                        <?php 
                                        $fields = [
                                            ["label" => "Nama Lengkap", "value" => $siswa['namalengkapsiswa'], "icon" => "fas fa-user"],
                                            ["label" => "Username", "value" => $siswa['username'], "icon" => "fas fa-user-circle"],
                                            ["label" => "Email", "value" => $siswa['email'], "icon" => "fas fa-envelope"],
                                            ["label" => "NIK", "value" => $siswa['nik'], "icon" => "fas fa-id-card"],
                                            ["label" => "NISN", "value" => $siswa['nisn'], "icon" => "fas fa-id-badge"],
                                            ["label" => "Tanggal Lahir", "value" => $siswa['tanggallahir'], "icon" => "fas fa-birthday-cake"],
                                            ["label" => "Nama Panggilan", "value" => $siswa['namapanggilan'], "icon" => "fas fa-smile"],
                                            ["label" => "Jenis Kelamin", "value" => $siswa['jeniskelamin'], "icon" => "fas fa-venus-mars"],
                                            ["label" => "Asal Instansi", "value" => $siswa['namasekolah'], "icon" => "fas fa-school"],
                                            ["label" => "No. Telepon", "value" => $siswa['notelp'], "icon" => "fas fa-phone"],
                                            ["label" => "Alamat", "value" => $siswa['alamat'], "icon" => "fas fa-map-marker-alt"]
                                        ];

                                        foreach ($fields as $field): ?>
                                            <div class="col-md-4 mb-3">
                                                <div class="profile-info bg-white p-2 rounded d-flex align-items-center shadow-sm" style="border-left: 3px solid #007bff;">
                                                    <div class="profile-icon text-primary mr-2">
                                                        <i class="<?php echo $field['icon']; ?> fa-lg mr-1"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="font-weight-bold text-primary mb-1"><?php echo $field['label']; ?></h6>
                                                        <p class="mb-0" style="font-size: 0.9rem;"><?php echo htmlspecialchars($field['value']); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-warning" role="alert">
                                        <i class="fas fa-exclamation-triangle"></i> Data siswa tidak ditemukan.
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer text-right">
                                <a href="editprofil.php" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="ubahkatasandisiswa.php" class="btn btn-warning ml-2">
                                    <i class="fas fa-key"></i> Ubah Kata Sandi
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($_SESSION['role'] == 'siswa'): ?>
                            <!-- Hasil IMT dan BMR -->
                            <div class="card shadow-sm mb-3 border-light">
                                <div class="card-header py-2 bg-light text-primary">
                                    <h6 class="m-0 font-weight-bold">Hasil IMT Terakhir</h6>
                                </div>
                                <div class="card-body">
                                    <?php 
                                    $dataIMT = !empty($dataIMT) ? $dataIMT : $dataIMTP;
                                    if ($dataIMT): 
                                        foreach ($dataIMT as $index => $imt): ?>
                                            <div class="mb-2 p-2 rounded <?php echo $index === 0 ? 'bg-primary text-white' : 'bg-light'; ?>">
                                                <strong>Hasil IMT:</strong> <?php echo htmlspecialchars($imt['hasilimt']); ?><br>
                                                <strong>Keterangan:</strong> <?php echo htmlspecialchars($imt['keterangan']); ?><br>
                                                <small>Tanggal: <?php echo htmlspecialchars($imt['tglperiksa']); ?></small>
                                            </div>
                                        <?php endforeach;
                                    else: ?>
                                        <div class="alert alert-warning" role="alert">
                                            Tidak ada data IMT ditemukan.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- BMR Section -->
                            <div class="card shadow-sm mb-3 border-light">
                                <div class="card-header py-2 bg-light text-primary">
                                    <h6 class="m-0 font-weight-bold">Hasil BMR Terakhir</h6>
                                </div>
                                <div class="card-body">
                                    <?php 
                                    $dataBMR = !empty($dataBMR) ? $dataBMR : $dataBMRP;
                                    if ($dataBMR):
                                        foreach ($dataBMR as $index => $bmr): ?>
                                            <div class="mb-2 p-2 rounded <?php echo $index === 0 ? 'bg-primary text-white' : 'bg-light'; ?>">
                                                <strong>Hasil BMR:</br>
                                                </strong> <?php echo htmlspecialchars($bmr['hasil']); ?> Kalori/hari<br>
                                                <small>Tanggal: <?php echo htmlspecialchars($bmr['tglperiksa']); ?></small>
                                            </div>
                                        <?php endforeach;
                                    else: ?>
                                        <div class="alert alert-warning" role="alert">
                                            Tidak ada data BMR ditemukan.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Hasil Evaluasi Section -->
                            <div class="card shadow-sm mb-3 border-light">
                                <div class="card-header py-2 bg-light text-primary">
                                    <h6 class="m-0 font-weight-bold">Hasil Evaluasi</h6>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $allResults = [
                                        'Kuisioner Kesehatan' => $kuisionerKesehatan,
                                        'Kuisioner Perubahan' => $kuisionerPerubahan,
                                        'Kuisioner Makanan yang Aku Makan' => $kuisionerMakan,
                                        'Kuisioner Mental' => $kuisionerMental,
                                        'Kuisioner Pernikahan' => $kuisionerMenikah,
                                    ];

                                    foreach ($allResults as $title => $result): 
                                        if (!empty($result)): ?>
                                            <div class="mb-4">
                                                <h6><?php echo $title; ?></h6>
                                                <ul class="list-group">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>Total Skor: <?php echo htmlspecialchars($result['totalSkor']); ?></span>
                                                        <span>Kategori: <?php echo htmlspecialchars($result['kategori']); ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-warning" role="alert">
                                                Tidak ada data <?php echo $title; ?> ditemukan.
                                            </div>
                                        <?php endif;
                                    endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- /.container-fluid -->
                <?php include('footer.php'); ?>

            </div>
        <?php
            // Tutup koneksi database
$conn->close();
?>
            <!-- End of Main Content -->
