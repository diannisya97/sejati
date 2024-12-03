<?php
include 'header.php';

// Ambil idtopik dan idtopikperempuan dari URL
$idtopik = isset($_GET['idtopik']) ? intval($_GET['idtopik']) : 0;
$idtopikperempuan = isset($_GET['idtopikperempuan']) ? intval($_GET['idtopikperempuan']) : 0;

// Menentukan gender berdasarkan idtopik dan idtopikperempuan
$gender = $idtopik > 0 ? 'laki-laki' : ($idtopikperempuan > 0 ? 'perempuan' : '');
$kategori = ''; // Variabel kategori awal
$kategoriperempuan = ''; // Variabel kategori awal

$kategori = isset($_GET['kategori']) ? htmlspecialchars($_GET['kategori'], ENT_QUOTES, 'UTF-8') : '';
$kategoriperempuan = isset($_GET['kategoriperempuan']) ? htmlspecialchars($_GET['kategoriperempuan'], ENT_QUOTES, 'UTF-8') : '';
$gender = isset($_GET['gender']) ? htmlspecialchars($_GET['gender'], ENT_QUOTES, 'UTF-8') : '';


if ($idtopik > 0) {
    // Query untuk mengambil data dari tabel topik
    $sql = "SELECT t.idtopik, t.isitopik, t.tanggal, 
            CASE 
                WHEN t.iduser IS NOT NULL THEN u.username 
                WHEN t.idusersiswa IS NOT NULL THEN s.username 
            END as username,
            si.asalsekolah,
            sc.namasekolah
            FROM topik t
            LEFT JOIN tbuser u ON t.iduser = u.iduser
            LEFT JOIN tbusersiswa s ON t.idusersiswa = s.idusersiswa
            LEFT JOIN tbsiswa si ON s.idusersiswa = si.idsiswa
            LEFT JOIN tbsekolah sc ON si.asalsekolah = sc.idsekolah
            WHERE t.idtopik = $idtopik";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Menampilkan data topik
        $row = $result->fetch_assoc();
        $username = htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8');
        $tanggal = htmlspecialchars($row['tanggal'], ENT_QUOTES, 'UTF-8');
        $namasekolah = htmlspecialchars($row['namasekolah'], ENT_QUOTES, 'UTF-8'); // Add this line
        $isitopik = nl2br(htmlspecialchars($row['isitopik'], ENT_QUOTES, 'UTF-8'));
    } else {
        $error_message = "Topik tidak ditemukan.";
    }
} elseif ($idtopikperempuan > 0) {
    // Query untuk mengambil data dari tabel topikperempuan
    $sql = "SELECT tp.idtopikperempuan, tp.isitopikperempuan, tp.tanggal, 
            CASE 
                WHEN tp.iduser IS NOT NULL THEN u.username 
                WHEN tp.idusersiswa IS NOT NULL THEN s.username 
            END as username,
            si.asalsekolah,
            sc.namasekolah
            FROM topikperempuan tp
            LEFT JOIN tbuser u ON tp.iduser = u.iduser
            LEFT JOIN tbusersiswa s ON tp.idusersiswa = s.idusersiswa
            LEFT JOIN tbsiswa si ON s.idusersiswa = si.idsiswa
            LEFT JOIN tbsekolah sc ON si.asalsekolah = sc.idsekolah
            WHERE tp.idtopikperempuan = $idtopikperempuan";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Menampilkan data topik
        $row = $result->fetch_assoc();
        $username = htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8');
        $tanggal = htmlspecialchars($row['tanggal'], ENT_QUOTES, 'UTF-8');
        $namasekolah = htmlspecialchars($row['namasekolah'], ENT_QUOTES, 'UTF-8'); // Add this line
        $isitopik = nl2br(htmlspecialchars($row['isitopikperempuan'], ENT_QUOTES, 'UTF-8'));
    } else {
        $error_message = "Topik tidak ditemukan.";
    }
}

// Query untuk mengambil komentar berdasarkan idtopik
if ($idtopik > 0) {
    $sql_komentar = "SELECT k.idkomen, k.isikomen, k.tanggal, 
                     CASE 
                         WHEN k.iduser IS NOT NULL THEN u.username 
                         WHEN k.idusersiswa IS NOT NULL THEN s.username 
                     END as username,
                     k.iduser AS komentar_iduser,
                     k.idusersiswa AS komentar_idusersiswa,
                     u.asalsekolah, -- Ambil asalsekolah dari tbuser
                     sc.namasekolah -- Join dengan tbsekolah untuk mendapatkan namasekolah
                     FROM komentar k
                     LEFT JOIN tbuser u ON k.iduser = u.iduser
                     LEFT JOIN tbusersiswa s ON k.idusersiswa = s.idusersiswa
                     LEFT JOIN tbsekolah sc ON u.asalsekolah = sc.idsekolah -- Join dengan tbsekolah
                     WHERE k.idtopik = ? 
                     ORDER BY k.tanggal ASC"; // Mengurutkan komentar berdasarkan tanggal

    $stmt_komentar = $conn->prepare($sql_komentar);
    $stmt_komentar->bind_param('i', $idtopik);
    $stmt_komentar->execute();
    $result_komentar = $stmt_komentar->get_result();
} elseif ($idtopikperempuan > 0) {
    $sql_komentarperempuan = "SELECT kp.idkomenperempuan, kp.isikomenperempuan, kp.tanggal, 
                         CASE 
                             WHEN kp.iduser IS NOT NULL THEN u.username 
                             WHEN kp.idusersiswa IS NOT NULL THEN s.username 
                         END as username,
                         kp.iduser AS komentar_iduser,
                         kp.idusersiswa AS komentar_idusersiswa,
                         u.asalsekolah, -- Ambil asalsekolah dari tbuser
                         sc.namasekolah -- Join dengan tbsekolah untuk mendapatkan namasekolah
                         FROM komentarperempuan kp
                         LEFT JOIN tbuser u ON kp.iduser = u.iduser
                         LEFT JOIN tbusersiswa s ON kp.idusersiswa = s.idusersiswa
                         LEFT JOIN tbsekolah sc ON u.asalsekolah = sc.idsekolah -- Join dengan tbsekolah
                         WHERE kp.idtopikperempuan = ? 
                         ORDER BY kp.tanggal ASC"; // Mengurutkan komentar berdasarkan tanggal
    
    $stmt_komentarperempuan = $conn->prepare($sql_komentarperempuan);
    $stmt_komentarperempuan->bind_param('i', $idtopikperempuan);
    $stmt_komentarperempuan->execute();
    $result_komentarperempuan = $stmt_komentarperempuan->get_result();
}
    

$conn->close();
?>

<?php include('sidebar.php'); ?>
<?php include('topbar.php'); ?>

<div class="container">
<?php if (!empty($username) && !empty($tanggal) && !empty($isitopik)): ?>
    <div class="card">
        <div class="card-header">
            <h4><?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></h4>
            <h7 class="text-muted"><?php echo htmlspecialchars($namasekolah, ENT_QUOTES, 'UTF-8'); ?></h7> </br>
            <h7 class="text-muted"><?php echo htmlspecialchars($tanggal, ENT_QUOTES, 'UTF-8'); ?></h7>
        </div>
        <div class="card-body">
            <p><?php echo htmlspecialchars($isitopik, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    </div>
    <!-- Menampilkan komentar -->
    <div class="mt-4">
        <h5>Komentar:</h5>
        <?php if ($idtopik > 0 && $result_komentar->num_rows > 0): ?>
            <!-- Menampilkan komentar dari tabel komentar -->
            <?php while ($row_komentar = $result_komentar->fetch_assoc()): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0"><?php echo htmlspecialchars($row_komentar['username'], ENT_QUOTES, 'UTF-8'); ?></h5> </br>
                                <h6 class="card-subtitle text-muted mb-0"><?php echo htmlspecialchars($row_komentar['namasekolah'], ENT_QUOTES, 'UTF-8'); ?></h6> <!-- Display the school name -->
                            </div>
                            <div class="d-flex align-items-center">
                                <h6 class="card-subtitle text-muted mb-0 mr-2 mt-1"><?php echo htmlspecialchars($row_komentar['tanggal'], ENT_QUOTES, 'UTF-8'); ?></h6>
                                <?php
                                // Tampilkan tombol hapus jika pengguna adalah admin atau pemilik komentar
                                if ((isset($_SESSION['iduser']) && ($_SESSION['iduser'] == $row_komentar['komentar_iduser'] || $_SESSION['role'] == 'admin')) || 
                                (isset($_SESSION['idusersiswa']) && ($_SESSION['idusersiswa'] == $row_komentar['komentar_idusersiswa']))) {
                                    echo "<div class='dropdown no-arrow'>
                                            <a class='dropdown-toggle' href='#' role='button' id='dropdownMenuLink_" . $row_komentar['idkomen'] . "' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                <i class='fas fa-ellipsis-v fa-sm fa-fw text-gray-400'></i>
                                            </a>
                                            <div class='dropdown-menu dropdown-menu-right shadow animated--fade-in' aria-labelledby='dropdownMenuLink_" . $row_komentar['idkomen'] . "'>
                                                <a class='dropdown-item' href='hapuskomentar.php?idkomen=" . $row_komentar['idkomen'] . "&gender=" . htmlspecialchars($gender, ENT_QUOTES, 'UTF-8') . "&idtopik=" . htmlspecialchars($idtopik, ENT_QUOTES, 'UTF-8') . "&idtopikperempuan=" . htmlspecialchars($idtopikperempuan, ENT_QUOTES, 'UTF-8') . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus komentar ini?\")'>Hapus</a>
                                            </div>
                                        </div>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="mt-3">
                            <p class="card-text mt-2"><?php echo nl2br(htmlspecialchars($row_komentar['isikomen'], ENT_QUOTES, 'UTF-8')); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php elseif ($idtopikperempuan > 0 && $result_komentarperempuan->num_rows > 0): ?>
            <!-- Menampilkan komentar dari tabel komentarperempuan -->
            <?php while ($row_komentarperempuan = $result_komentarperempuan->fetch_assoc()): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0"><?php echo htmlspecialchars($row_komentarperempuan['username'], ENT_QUOTES, 'UTF-8'); ?></h5> </br>
                                <h6 class="card-subtitle text-muted mb-0"><?php echo htmlspecialchars($row_komentarperempuan['namasekolah'], ENT_QUOTES, 'UTF-8'); ?></h6> <!-- Display the school name -->
                            </div>
                            <div class="d-flex align-items-center">
                                <h6 class="card-subtitle text-muted mb-0 mr-2 mt-1"><?php echo htmlspecialchars($row_komentarperempuan['tanggal'], ENT_QUOTES, 'UTF-8'); ?></h6>
                                <?php
                                // Tampilkan tombol hapus jika pengguna adalah admin atau pemilik komentar
                                if ((isset($_SESSION['iduser']) && ($_SESSION['iduser'] == $row_komentarperempuan['komentar_iduser'] || $_SESSION['role'] == 'admin')) || 
                                (isset($_SESSION['idusersiswa']) && ($_SESSION['idusersiswa'] == $row_komentarperempuan['komentar_idusersiswa']))) {
                                    echo "<div class='dropdown no-arrow'>
                                            <a class='dropdown-toggle' href='#' role='button' id='dropdownMenuLink_" . $row_komentarperempuan['idkomenperempuan'] . "' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                <i class='fas fa-ellipsis-v fa-sm fa-fw text-gray-400'></i>
                                            </a>
                                            <div class='dropdown-menu dropdown-menu-right shadow animated--fade-in' aria-labelledby='dropdownMenuLink_" . $row_komentarperempuan['idkomenperempuan'] . "'>
                                                <a class='dropdown-item' href='hapuskomentar.php?idkomenperempuan=" . $row_komentarperempuan['idkomenperempuan'] . "&gender=" . htmlspecialchars($gender, ENT_QUOTES, 'UTF-8') . "&idtopikperempuan=" . htmlspecialchars($idtopikperempuan, ENT_QUOTES, 'UTF-8') . "&idtopik=" . htmlspecialchars($idtopik, ENT_QUOTES, 'UTF-8') . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus komentar ini?\")'>Hapus</a>
                                            </div>
                                        </div>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="mt-3">
                            <p class="card-text mt-2"><?php echo nl2br(htmlspecialchars($row_komentarperempuan['isikomenperempuan'], ENT_QUOTES, 'UTF-8')); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Belum ada komentar.</p>
        <?php endif; ?>
    </div>


    
    <!-- Form untuk memberikan jawaban -->
    <?php
    // Menampilkan form hanya jika pengguna adalah admin atau pengurus
    if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'pengurus')): ?>
        <form action="submitkomentar.php" method="POST">
            <input type="hidden" name="idtopik" value="<?php echo htmlspecialchars($idtopik, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="idtopikperempuan" value="<?php echo htmlspecialchars($idtopikperempuan, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="gender" value="<?php echo htmlspecialchars($gender, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="form-group">
                <label for="jawaban" class="mt-3"><h6>Jawaban:</h6></label>
                <textarea id="isikomen" name="isikomen" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
        </form>
    <?php endif; ?>

     <!-- Tombol kembali ke halaman sebelumnya -->
     <?php if ($gender === 'perempuan'): ?>
        <!-- Jika gender adalah perempuan, gunakan parameter kategoriperempuan -->
        <button onclick="window.location.href='tanyajawab.php?page=4&gender=<?php echo htmlspecialchars($gender, ENT_QUOTES, 'UTF-8'); ?>&kategori=<?php echo htmlspecialchars($kategoriperempuan, ENT_QUOTES, 'UTF-8'); ?>';" class="btn btn-secondary mt-3">Kembali</button>
    <?php else: ?>
        <!-- Untuk gender lainnya, gunakan parameter kategori -->
        <button onclick="window.location.href='tanyajawab.php?page=3&gender=<?php echo htmlspecialchars($gender, ENT_QUOTES, 'UTF-8'); ?>&kategori=<?php echo htmlspecialchars($kategori, ENT_QUOTES, 'UTF-8'); ?>';" class="btn btn-secondary mt-3">Kembali</button>
    <?php endif; ?>

<?php else: ?>
    <p><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></p>
    <!-- Tombol kembali ke halaman sebelumnya jika topik tidak ditemukan -->
    <?php if ($gender === 'perempuan'): ?>
        <!-- Jika gender adalah perempuan, gunakan parameter kategoriperempuan -->
        <button onclick="window.location.href='tanyajawab.php?page=4&gender=<?php echo htmlspecialchars($gender, ENT_QUOTES, 'UTF-8'); ?>&kategori=<?php echo htmlspecialchars($kategoriperempuan, ENT_QUOTES, 'UTF-8'); ?>';" class="btn btn-secondary mt-3">Kembali</button>
    <?php else: ?>
        <!-- Untuk gender lainnya, gunakan parameter kategori -->
        <button onclick="window.location.href='tanyajawab.php?page=3&gender=<?php echo htmlspecialchars($gender, ENT_QUOTES, 'UTF-8'); ?>&kategori=<?php echo htmlspecialchars($kategori, ENT_QUOTES, 'UTF-8'); ?>';" class="btn btn-secondary mt-3">Kembali</button>
    <?php endif; ?>
<?php endif; ?>
</div>

<?php include('footer.php'); ?>
