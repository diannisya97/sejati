<?php
include 'header.php';

// Cek apakah id siswa ada di URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idSiswa = $_GET['id'];
} else {
    // Jika tidak ada id, arahkan kembali ke halaman datasiswa atau tampilkan pesan error
    header('Location: datasiswa.php');
    exit();
}

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


$idSiswa = $_GET['id']; // Ambil idsiswa dari URL

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
$sqlBMRP = "SELECT hasil, tglperiksa FROM kebutuhanenergiperempuan WHERE idsiswa = ? ORDER BY tglperiksa DESC LIMIT 3";
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


include 'sidebar.php';
include 'topbar.php';
?>

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

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mb-4">
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
                                ["label" => "Asal Sekolah", "value" => $siswa['namasekolah'], "icon" => "fas fa-school"],
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
                <?php if ($siswa): ?>
                    <div class="card-footer text-right">
                        <a href="editsiswa.php?id=<?php echo $idSiswa; ?>" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-12 mb-4">
            <!-- IMT Section -->
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
                                <strong>Hasil BMR:</strong> <?php echo htmlspecialchars($bmr['hasil']); ?></br>
                                <small>Tanggal: <?php echo htmlspecialchars($imt['tglperiksa']); ?></small>
                            </div>
                        <?php endforeach;
                    else: ?>
                        <div class="alert alert-warning" role="alert">
                            Tidak ada data BMR ditemukan.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mb-4">
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
        </div>
    </div>
</div>

<?php include 'footer.php';?>
