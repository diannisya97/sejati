<?php
include('header.php'); 
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'undefined';
$gender = isset($_SESSION['jeniskelamin']) ? $_SESSION['jeniskelamin'] : 'undefined';

// Periksa apakah pengguna sudah login dan memiliki peran yang sesuai
if (!isset($_SESSION['username']) || !in_array($_SESSION['role'], ['admin', 'pengurus', 'siswa'])) {
    header("Location: login.php");
    exit();
}

$idsiswa = $_SESSION['idsiswa'] ?? null; // Set idsiswa hanya jika ada dalam sesi

$hasilimt = $bmr = $keterangan = '';

if (isset($_POST['hitung_bmr'])) {
    $idsiswa = $_POST['idsiswa']; // Untuk admin/pengurus atau siswa
    $umur = $_POST['umur'];
    $bb = $_POST['bb'];
    $tb = $_POST['tb'] / 100; // Convert cm to meters
    $tingkataktif = $_POST['tingkataktif'];
    
    // Calculate IMT
    $hasilimt = $bb / ($tb * $tb);
    $keterangan = '';
    
    if ($hasilimt < 18.5) {
        $keterangan = 'Kurus';
    } elseif ($hasilimt >= 18.5 && $hasilimt < 25) {
        $keterangan = 'Normal';
    } elseif ($hasilimt >= 25 && $hasilimt < 30) {
        $keterangan = 'Kelebihan Berat Badan';
    } else {
        $keterangan = 'Obesitas';
    }

    // Insert IMT data into the database
    $sql_imt = "INSERT INTO imt (idsiswa, bb, tb, hasilimt, keterangan, tglperiksa) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt_imt = $conn->prepare($sql_imt);
    $stmt_imt->bind_param("iddds", $idsiswa, $bb, $tb, $hasilimt, $keterangan);
    $stmt_imt->execute();
    
    $bmr = 665 + (13.7 * $bb) + (5 * ($tb * 100)) - (6.8 * $umur);
    
    // Adjust BMR based on activity level
    $factor = 1.2; // Default value for "tidak pernah berolahraga"
    if ($tingkataktif == 'jarang berolahraga') {
        $factor = 1.3;
    } elseif ($tingkataktif == 'sering berolahraga') {
        $factor = 1.4;
    }
    $bmr *= $factor;

    // Insert BMR data into the database
    $sql_bmr = "INSERT INTO kebutuhanenergi (iduser, idsiswa, bb, tb, usia, tingkataktif, hasil, tglperiksa) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt_bmr = $conn->prepare($sql_bmr);
    $stmt_bmr->bind_param("iidssss", $iduser, $idsiswa, $bb, $tb, $umur, $tingkataktif, $bmr);
    if ($stmt_bmr->execute()) {
        echo "<script>alert('Data berhasil disimpan.'); window.location.href='olahraga.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<?php
$hasilimt = $bmr = $keterangan = '';

if (isset($_POST['hitung_bmrperempuan'])) {
    $idsiswa = $_POST['idsiswa']; // Untuk admin/pengurus atau siswa
    $umur = $_POST['umur'];
    $bb = $_POST['bb'];
    $tb = $_POST['tb'] / 100; // Convert cm to meters
    $tingkataktif = $_POST['tingkataktif'];

    // Calculate IMT
    $hasilimt = $bb / ($tb * $tb);
    $keterangan = '';

    if ($hasilimt < 18.5) {
        $keterangan = 'Kurus';
    } elseif ($hasilimt >= 18.5 && $hasilimt < 25) {
        $keterangan = 'Normal';
    } elseif ($hasilimt >= 25 && $hasilimt < 30) {
        $keterangan = 'Kelebihan Berat Badan';
    } else {
        $keterangan = 'Obesitas';
    }

    // Insert IMT data into the database
    $sql_imt = "INSERT INTO imtperempuan (idsiswa, bb, tb, hasilimtperempuan, keterangan, tglperiksa) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt_imt = $conn->prepare($sql_imt);
    $stmt_imt->bind_param("iddds", $idsiswa, $bb, $tb, $hasilimt, $keterangan);
    $stmt_imt->execute();

    // Calculate BMR for females
    $bmr = 665 + (9.6 * $bb) + (1.8 * ($tb * 100)) - (4.7 * $umur);

    // Adjust BMR based on activity level
    $factor = 1.2; // Default value for "tidak pernah berolahraga"
    if ($tingkataktif == 'jarang berolahraga') {
        $factor = 1.3;
    } elseif ($tingkataktif == 'sering berolahraga') {
        $factor = 1.4;
    }
    $bmr *= $factor;

    // Insert BMR data into the database
    $sql_bmr = "INSERT INTO kebutuhanenergiperempuan (iduser, idsiswa, bb, tb, usia, tingkataktif, hasil, tglperiksa) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt_bmr = $conn->prepare($sql_bmr);
    $stmt_bmr->bind_param("iidssss", $iduser, $idsiswa, $bb, $tb, $umur, $tingkataktif, $bmr);
    if ($stmt_bmr->execute()) {
        echo "<script>alert('Data berhasil disimpan.'); window.location.href='olahraga.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<?php include('sidebar.php'); ?>
<?php include('topbar.php'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

<style>

.wrapper {
    position: relative;
    min-height: 100vh; /* Full height of the viewport */
    padding-bottom: 60px; /* Ensure content doesn't overlap with the footer */
    display: flex;
    flex-direction: column;
}

footer {
    margin-top: auto; /* Pushes footer to the bottom */
    height: 50px; /* Footer height */
    background-color: #f8f9fa; /* or any color you prefer */
    display: flex;
    justify-content: center;
    align-items: center;
}
        .hidden {
            display: none;
        }

        .gender-box {
            padding: 20px;
            font-size: 1.5rem;
            width: 100%;
            max-width: 300px;
        }

        .gender-box.male {
            background-color: #007bff;
            color: white;
        }

        .gender-box.female {
            background-color: pink;
            color: white;
            margin-bottom: 20px;
        }

        .gender-box + .gender-box {
            margin-top: 20px;
        }

        .result-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        margin: 20px 0;
        background-color: #f8f9fa;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .result-card h3 {
        margin-bottom: 10px;
        color: #007bff;
    }

    .result-card p {
        margin: 5px 0;
        font-size: 1.1em;
    }

    .result-card .highlight {
        font-weight: bold;
        color: #dc3545;
    }

    .disabled-field {
        background-color: #f0f0f0;
        color: #a0a0a0;
        border: 1px solid #ccc;
        cursor: not-allowed;
    }

    .enabled-field {
        background-color: #ffffff;
        color: #000000;
        border: 1px solid #ccc;
        cursor: text;
    }
    </style>

<div class="wrapper">
    <div class="container mt-5">
        <!-- Halaman Pertama -->
        <div id="page1">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <!-- Illustrations -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h4 class="m-0 font-weight-bold text-primary">Diet dan Olah raga</h4>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 18rem;" src="img/makanan.png" alt="">
                                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 18rem;" src="img/olahraga.png" alt="">
                                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 18rem;" src="img/olahraga3.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary" onclick="showPage2()">Selanjutnya</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Halaman Kedua -->
        <div id="page2" class="hidden">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <!-- Content for Page 2 -->
                    <div class="card shadow mb-4">
                        <div class="card-body text-center">
                            <h4>Aku adalah</h4>
                            <button class="btn gender-box male" onclick="selectGender('laki-laki')">Laki-laki</button>
                            <button class="btn gender-box female" onclick="selectGender('perempuan')">Perempuan</button>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-secondary" onclick="showPage1()">Kembali</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Halaman Ketiga -->
        <div id="page3" class="hidden">
            <div class="row">
                <div class="col-lg-7 mb-4">
                    <!-- Content for Page 3 (Laki-laki) -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Materi tentang Gizi Seimbang</h4>
                            <p class="text-justify">Di masa remaja, kita sedang dalam masa pertumbuhan. Tentunya dibutuhkan gizi yang seimbang supaya kita sehat, tumbuh optimal, dan terhindar dari masalah gizi seperti anemia, obesitas, dan gizi kurang. Berikut adalah beberapa tips gizi seimbang:</p>
                            <ul class="text-justify">
                                <li>Biasakan makan 3 kali sehari (pagi, siang, malam) bersama keluarga.</li>
                                <li>Biasakan mengonsumsi ikan dan sumber protein lainnya.</li>
                                <li>Perbanyak makan sayuran dan buah-buahan.</li>
                                <li>Biasakan membawa bekal makanan dan air putih yang cukup dari rumah.</li>
                                <li>Batasi makan makanan cepat saji, jajanan, dan makanan selingan yang manis, asin, dan berlemak.</li>
                                <li>Biasakan menyikat gigi sekurang-kurangnya dua kali sehari setelah makan pagi dan sebelum tidur.</li>
                                <li>Hindari merokok dan minum minuman beralkohol.</li>
                                <li>Lakukan kegiatan fisik dan olahraga secara teratur.</li>
                            </ul>

                            <div class="full-text" style="display: none;">
                                <h4 class="card-title">Piring Makanku: Sajian Sekali Makan</h4>
                                <p class="text-justify">Makanan yang kita makan dianjurkan merupakan makanan yang beragam. Setiap kali makan, terdiri dari makanan pokok, sayuran, lauk-pauk, buah-buahan, dan air.</p>
                                <p class="text-justify">Porsi makanan pokok adalah 1/3 dari total porsi makanan di piring, porsi sayuran sebanding (1:1) dengan porsi makanan pokok, atau 1/3 dari total porsi makanan di piringmu.</p>
                                <p class="text-justify">Porsi lauk-pauk dan buah-buahan juga 1/3 dari total porsi makanan di piringmu.</p>
                                <p class="text-justify">Batasi konsumsi makanan yang mengandung tinggi gula, garam, dan minyak, seperti gorengan, junk food, minuman bersoda, dll.</p>

                                <div class="text-center mb-3">
                                    <img src="img/piring.jpg" alt="Sajian Sekali Makan" class="img-fluid" style="max-width: 50%; height: auto; border-radius: 10px;">
                                </div>

                                <h4 class="card-title">Biasakan Minum Air Putih</h4>
                                <p class="text-justify">Air putih sangat diperlukan untuk proses pertumbuhan dan perkembangan tubuh. Keseimbangan air dalam tubuh perlu diperhatikan dengan mengatur jumlah asupan dan keluaran air yang seimbang.</p>
                                <p class="text-justify">Berikut adalah kebutuhan air putih berdasarkan kelompok umur:</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Kelompok Umur</th>
                                                <th>Laki-laki</th>
                                                <th>Perempuan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>10-12 Tahun</td>
                                                <td>1800 ml (7-8 gelas)</td>
                                                <td>1800 ml (7-8 gelas)</td>
                                            </tr>
                                            <tr>
                                                <td>13-15 Tahun</td>
                                                <td>2000 ml (8-9 gelas)</td>
                                                <td>2000 ml (8-9 gelas)</td>
                                            </tr>
                                            <tr>
                                                <td>16-18 Tahun</td>
                                                <td>2200 ml (8-9 gelas)</td>
                                                <td>2100 ml (8-9 gelas)</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p class="text-justify">Untuk mengetahui apakah kita sudah cukup minum air putih atau tidak, 
                                    kita bisa melihat warna urin saat ke toilet. Bandingkan warna urin dengan gambar yang menunjukkan tingkat hidrasi, 
                                    untuk memastikan apakah tubuh kita sudah terhidrasi dengan baik.</p>
                            
                                <div class="text-center mb-3">
                                    <img src="img/urin.jpg" alt="Tingkat Hidrasi Berdasarkan Warna Urin" class="img-fluid" style="max-width: 50%; height: auto;">
                                </div>

                                <p class="text-justify">Gizi seimbang sangat penting untuk mencegah stunting, yaitu gangguan pertumbuhan akibat 
                                    kekurangan gizi. Dengan mengikuti tips makan sehat seperti mengonsumsi makanan beragam dan menjaga hidrasi, 
                                    kita mendukung pertumbuhan optimal dan mencegah masalah gizi seperti stunting.</p>

                                <h4 class="card-title">Stunting</h4>
                                <p class="text-justify">Stunting adalah kekurangan gizi pada bayi di 1000 hari pertama kehidupan yang berlangsung lama dan menyebabkan terhambatnya perkembangan otak serta tumbuh kembang anak. Bayi dengan stunting tumbuh lebih pendek dari standar tinggi balita seumurannya.</p>
                                <p class="text-justify">Stunting merupakan gangguan pertumbuhan dan perkembangan anak akibat kekurangan gizi kronis dan infeksi berulang yang ditandai dengan tinggi atau panjang badan di bawah standar.</p>

                                <div class="text-center mb-3">
                                    <img src="img/pohon.jpg" alt="Ilustrasi Stunting" class="img-fluid" style="max-width: 50%; height: auto;">
                                </div>

                                <p class="text-justify">Penyebab stunting meliputi gizi buruk, infeksi berulang, dan kurangnya stimulasi psikososial. Jika ketiga faktor ini terjadi secara simultan dan terus menerus pada 1.000 hari pertama hidup bayi, maka dapat menyebabkan stunting.</p>
            
                                <h4 class="card-title">Cara Mengatasi Stunting</h4>
                                <ul class="text-justify">
                                    <li>Menjalankan pendampingan kepada keluarga dan calon pasangan usia subur sebelum proses kehamilan, seperti mendorong calon pengantin untuk melakukan pemeriksaan kesehatan sebelum menikah dan hamil.</li>
                                    <li>Mengoptimalkan pelayanan melalui kader posyandu. Dimulai dari sebelum anak lahir, yaitu saat para ibu atau pasangan usia subur merencanakan pernikahan, mereka harus diperiksa kesehatannya.</li>
                                    <li>Penilaian status gizi dan kesiapan untuk hamil guna mencegah stunting.</li>
                                    <li>Menyiapkan remaja putri yang akan menikah dengan memastikan mereka dalam kondisi sehat.</li>
                                </ul>

                                <h4 class="card-title">Stunting pada Remaja</h4>
                                <p class="text-justify">Remaja putri termasuk salah satu kelompok yang rawan menderita malnutrisi. Menstruasi menjadi salah satu faktor yang menyebabkan malnutrisi, karena selama menstruasi darah akan terus keluar sehingga membutuhkan asupan zat gizi terutama besi untuk membantu produksi hemoglobin pada tubuh. Status gizi pada remaja merupakan pantulan dari permulaan kejadian kekurangan gizi pada anak usia dini. Negara dengan penghasilan menengah, remaja merupakan masa penurunan malnutrisi dari anak usia dini, baik itu stunting atau anemia sebelumnya yang disebabkan oleh defisiensi mikronutrien (Thurnham et al, 2013).</p>
                                <p class="text-justify">Dampak buruk stunting ada tiga, yaitu: 1. tinggi badan tidak cukup, 2. kemampuan intelektual di bawah rata-rata, 3. di hari tua dapat memiliki potensi besar untuk mengalami penyakit tidak menular seperti diabetes, kardiovaskular, gangguan metabolik, dan lainnya (Siaran pers, Kepala BKKBN, Dr. (Hc) dr. Hasto Wardoyo, Sp.OG, 21 Juni 2021).</p>
                                <p class="text-justify">Cara pencegahan stunting meliputi memperhatikan gizi ibu hamil, memantau 1000 hari pertama kehidupan mulai dari konsepsi hingga anak lahir dengan ASI eksklusif minimal 6 bulan, memberikan MPASI bergizi, serta menjaga kebersihan lingkungan (Siaran pers, Kepala Lembaga Demografi UI, Turro S Wongkaren, Ph.D, 21 Juni 2021).</p>

                                <div class="text-center mb-3">
                                    <img src="img/siklus.jpg" alt="Ilustrasi Penanggulangan / Pencegahan Stunting" class="img-fluid" style="max-width: 50%; height: auto;">
                                </div>

                                <p class="text-justify">Apa yang harus dilakukan remaja untuk mencegah stunting: 1. Menjaga kesehatan diri sendiri dengan olahraga, makanan sehat dengan gizi seimbang, jaga kebersihan lingkungan, sanitasi, tidak merokok dan tidak menggunakan NAPZA. 2. Mempersiapkan diri untuk menjadi anggota keluarga yang mandiri secara sosial maupun ekonomi melalui pendidikan dan pekerjaan. 3. Menyiapkan diri menjadi orang tua dengan persiapan sejak muda. 4. Berperan aktif dalam pencegahan stunting dengan menjadi peer educator, memberi edukasi dan informasi kepada teman sebaya (Siaran pers, Kepala Lembaga Demografi UI, Turro S Wongkaren, Ph.D, 21 Juni 2021).</p>

                                <h4 class="card-title">Materi tentang Diet Sehat dan Olahraga bagi Laki-laki</h4>
                                <p>Berikut adalah beberapa tips diet sehat dan olahraga bagi laki-laki:</p>
                                <h5>Diet Sehat:</h5>
                                <ul class="text-justify">
                                    <li>Konsumsi makanan yang kaya akan protein, seperti daging tanpa lemak, ikan, dan kacang-kacangan.</li>
                                    <li>Perbanyak makan buah-buahan dan sayuran setiap hari.</li>
                                    <li>Hindari makanan cepat saji dan makanan olahan yang tinggi lemak dan gula.</li>
                                    <li>Minum air putih yang cukup, minimal 8 gelas sehari.</li>
                                    <li>Batasi konsumsi alkohol dan minuman manis.</li>
                                </ul>
                                <h5>Olahraga:</h5>
                                <ul class="text-justify">
                                    <li>Berolahraga secara rutin, minimal 30 menit setiap hari.</li>
                                    <li>Lakukan latihan kardio seperti berlari, bersepeda, atau berenang untuk menjaga kesehatan jantung.</li>
                                    <li>Lakukan latihan kekuatan seperti angkat beban untuk membangun otot.</li>
                                    <li>Jangan lupa untuk melakukan pemanasan sebelum berolahraga dan pendinginan setelahnya.</li>
                                    <li>Tetap aktif sepanjang hari, seperti dengan berjalan kaki atau menggunakan tangga daripada lift.</li>
                                </ul>
                            </div>
                            <button class="btn btn-link show-more">Lihat Selengkapnya</button>
                            
                            <div class="text-center mt-4">
                                <button id="backToPrevious" class="btn btn-secondary" onclick="showPage2()">Kembali</button>
                                <button id="backToStart" class="btn btn-secondary" onclick="showPage1()">Kembali ke Awal</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-body text-center">
                                <div class="card-header py-3">
                                    <h6 class="font-weight-bold text-primary">Cek Seberapa Malasnya Dirimu!</h6>
                                </div>
                                <button class="btn btn-primary btn-lg mt-3" onclick="showPage5('laki-laki')" style="width: 100%; font-size: 17px;">
                                        Kuisioner: Seberapa Mager kah Aku?
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Form untuk IMT dan BMR -->
                <div class="col-lg-5 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Hitung IMT dan BMR</h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info" role="alert">
                                <h4 class="alert-heading">Apa itu IMT?</h4>
                                <p class="text-justify">Indeks Massa Tubuh (IMT) adalah ukuran yang digunakan untuk menilai apakah berat badan seseorang proporsional dengan tinggi badannya. 
                                    IMT dapat membantu menentukan apakah seseorang memiliki berat badan yang sehat, kurang berat badan, atau kelebihan berat badan.</p>
                            </div>
                            
                            <div class="alert alert-info" role="alert">
                                <h4 class="alert-heading">Apa itu BMR?</h4>
                                <p class="text-justify">Basal Metabolic Rate (BMR) adalah jumlah energi yang diperlukan tubuh untuk menjalankan fungsi vital seperti bernapas dan menjaga suhu tubuh saat dalam keadaan istirahat.</p>
                            </div>

                            <form method="POST" action="">
                            <?php if ($role == 'admin' || $role == 'pengurus'): ?>
                                <!-- Dropdown untuk admin/pengurus memilih siswa -->
                                <div class="form-group">
                                    <label for="idsiswa">Pilih Siswa:</label>
                                    <select id="idsiswa" name="idsiswa" class="form-control" required>
                                        <option value="" disabled selected>Pilih Siswa</option>
                                        <?php
                                        // Koneksi ke database
                                        include('koneksi.php');

                                        // Ambil role pengguna
                                        $role = $_SESSION['role'];
                                        $iduser = $_SESSION['iduser'];

                                        // Query SQL tergantung peran pengguna
                                        if ($role == 'admin') {
                                            // Untuk admin, tampilkan semua siswa laki-lakiS yang telah divalidasi
                                            $query = "SELECT tbsiswa.idsiswa, tbsiswa.namalengkapsiswa 
                                                    FROM tbsiswa 
                                                    INNER JOIN tbusersiswa ON tbsiswa.idsiswa = tbusersiswa.idsiswa 
                                                    WHERE tbsiswa.jeniskelamin = 'laki-laki' 
                                                    AND tbusersiswa.status = 'validated'";
                                        } elseif ($role == 'pengurus') {
                                            // Untuk pengurus, tampilkan siswa laki-laki dari sekolah yang sama dengan pengurus
                                            $query = "SELECT tbsiswa.idsiswa, tbsiswa.namalengkapsiswa 
                                                    FROM tbsiswa 
                                                    INNER JOIN tbusersiswa ON tbsiswa.idsiswa = tbusersiswa.idsiswa 
                                                    INNER JOIN tbsekolah ON tbsiswa.asalsekolah = tbsekolah.idsekolah 
                                                    INNER JOIN tbuser ON tbuser.asalsekolah = tbsekolah.idsekolah 
                                                    WHERE tbsiswa.jeniskelamin = 'laki-laki' 
                                                    AND tbusersiswa.status = 'validated' 
                                                    AND tbuser.iduser = ?";
                                        }

                                        if ($stmt = mysqli_prepare($conn, $query)) {
                                            if ($role == 'pengurus') {
                                                mysqli_stmt_bind_param($stmt, "i", $iduser);
                                            }
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='" . $row['idsiswa'] . "'>" . $row['namalengkapsiswa'] . "</option>";
                                            }

                                            mysqli_stmt_close($stmt);
                                        }

                                        mysqli_close($conn);
                                        ?>
                                    </select>
                                </div>
                                <?php else: ?>
                                    <!-- Hidden input untuk siswa biasa -->
                                    <input type="hidden" name="idsiswa" value="<?php echo $idsiswa; ?>">
                                <?php endif; ?>

                                <div class="form-group">
                                    <label for="umur">Usia (tahun):</label>
                                    <input type="number" id="umur" name="umur" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="bb">Berat Badan (kg):</label>
                                    <input type="number" id="bb" name="bb" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="tb">Tinggi Badan (cm):</label>
                                    <input type="number" id="tb" name="tb" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="tingkataktif">Tingkat Aktivitas:</label>
                                    <select id="tingkataktif" name="tingkataktif" class="form-control" required>
                                        <option value="tidak pernah berolahraga">Tidak pernah berolahraga</option>
                                        <option value="jarang berolahraga">Jarang berolahraga</option>
                                        <option value="sering berolahraga">Sering berolahraga</option>
                                    </select>
                                </div>
                                <button type="submit" name="hitung_bmr" class="btn btn-primary">Hitung IMT dan BMR</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <!-- Halaman Keempat untuk Perempuan -->
        <div id="page4" class="hidden">
            <div class="row">
                <div class="col-lg-7 mb-4">
                    <!-- Content for Page 4 (Perempuan) -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Materi tentang Gizi Seimbang</h4>
                            <p class="text-justify">Di masa remaja, kita sedang dalam masa pertumbuhan. Tentunya dibutuhkan gizi yang seimbang supaya kita sehat, tumbuh optimal, dan terhindar dari masalah gizi seperti anemia, obesitas, dan gizi kurang. Berikut adalah beberapa tips gizi seimbang:</p>
                            <ul>
                                <li>Biasakan makan 3 kali sehari (pagi, siang, malam) bersama keluarga.</li>
                                <li>Biasakan mengonsumsi ikan dan sumber protein lainnya.</li>
                                <li>Perbanyak makan sayuran dan buah-buahan.</li>
                                <li>Biasakan membawa bekal makanan dan air putih yang cukup dari rumah.</li>
                                <li>Batasi makan makanan cepat saji, jajanan, dan makanan selingan yang manis, asin, dan berlemak.</li>
                                <li>Biasakan menyikat gigi sekurang-kurangnya dua kali sehari setelah makan pagi dan sebelum tidur.</li>
                                <li>Hindari merokok dan minum minuman beralkohol.</li>
                                <li>Lakukan kegiatan fisik dan olahraga secara teratur.</li>
                            </ul>

                            <div class="full-text" style="display: none;">
                                <h4 class="card-title">Piring Makanku: Sajian Sekali Makan</h4>
                                <p class="text-justify">Makanan yang kita makan dianjurkan merupakan makanan yang beragam. Setiap kali makan, terdiri dari makanan pokok, sayuran, lauk-pauk, buah-buahan, dan air.</p>
                                <p class="text-justify">Porsi makanan pokok adalah 1/3 dari total porsi makanan di piring, porsi sayuran sebanding (1:1) dengan porsi makanan pokok, atau 1/3 dari total porsi makanan di piringmu.</p>
                                <p class="text-justify">Porsi lauk-pauk dan buah-buahan juga 1/3 dari total porsi makanan di piringmu.</p>
                                <p class="text-justify">Batasi konsumsi makanan yang mengandung tinggi gula, garam, dan minyak, seperti gorengan, junk food, minuman bersoda, dll.</p>

                                <div class="text-center mb-3">
                                    <img src="img/piring.jpg" alt="Sajian Sekali Makan" class="img-fluid" style="max-width: 50%; height: auto; border-radius: 10px;">
                                </div>

                                <h4 class="card-title">Biasakan Minum Air Putih</h4>
                                <p class="text-justify">Air putih sangat diperlukan untuk proses pertumbuhan dan perkembangan tubuh. Keseimbangan air dalam tubuh perlu diperhatikan dengan mengatur jumlah asupan dan keluaran air yang seimbang.</p>
                                <p class="text-justify">Berikut adalah kebutuhan air putih berdasarkan kelompok umur:</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Kelompok Umur</th>
                                                <th>Laki-laki</th>
                                                <th>Perempuan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>10-12 Tahun</td>
                                                <td>1800 ml (7-8 gelas)</td>
                                                <td>1800 ml (7-8 gelas)</td>
                                            </tr>
                                            <tr>
                                                <td>13-15 Tahun</td>
                                                <td>2000 ml (8-9 gelas)</td>
                                                <td>2000 ml (8-9 gelas)</td>
                                            </tr>
                                            <tr>
                                                <td>16-18 Tahun</td>
                                                <td>2200 ml (8-9 gelas)</td>
                                                <td>2100 ml (8-9 gelas)</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p class="text-justify">Untuk mengetahui apakah kita sudah cukup minum air putih atau tidak, 
                                    kita bisa melihat warna urin saat ke toilet. Bandingkan warna urin dengan gambar yang menunjukkan tingkat hidrasi, 
                                    untuk memastikan apakah tubuh kita sudah terhidrasi dengan baik.</p>
                            
                                <div class="text-center mb-3">
                                    <img src="img/urin.jpg" alt="Tingkat Hidrasi Berdasarkan Warna Urin" class="img-fluid" style="max-width: 50%; height: auto;">
                                </div>

                                <p class="text-justify">Gizi seimbang sangat penting untuk mencegah stunting, yaitu gangguan pertumbuhan akibat 
                                    kekurangan gizi. Dengan mengikuti tips makan sehat seperti mengonsumsi makanan beragam dan menjaga hidrasi, 
                                    kita mendukung pertumbuhan optimal dan mencegah masalah gizi seperti stunting.</p>

                                <h4 class="card-title">Stunting</h4>
                                <p class="text-justify">Stunting adalah kekurangan gizi pada bayi di 1000 hari pertama kehidupan yang berlangsung lama dan menyebabkan terhambatnya perkembangan otak serta tumbuh kembang anak. Bayi dengan stunting tumbuh lebih pendek dari standar tinggi balita seumurannya.</p>
                                <p class="text-justify">Stunting merupakan gangguan pertumbuhan dan perkembangan anak akibat kekurangan gizi kronis dan infeksi berulang yang ditandai dengan tinggi atau panjang badan di bawah standar.</p>

                                <div class="text-center mb-3">
                                    <img src="img/pohon.jpg" alt="Ilustrasi Stunting" class="img-fluid" style="max-width: 50%; height: auto;">
                                </div>

                                <p class="text-justify">Penyebab stunting meliputi gizi buruk, infeksi berulang, dan kurangnya stimulasi psikososial. Jika ketiga faktor ini terjadi secara simultan dan terus menerus pada 1.000 hari pertama hidup bayi, maka dapat menyebabkan stunting.</p>
            
                                <h4 class="card-title">Cara Mengatasi Stunting</h4>
                                <ul class="text-justify">
                                    <li>Menjalankan pendampingan kepada keluarga dan calon pasangan usia subur sebelum proses kehamilan, seperti mendorong calon pengantin untuk melakukan pemeriksaan kesehatan sebelum menikah dan hamil.</li>
                                    <li>Mengoptimalkan pelayanan melalui kader posyandu. Dimulai dari sebelum anak lahir, yaitu saat para ibu atau pasangan usia subur merencanakan pernikahan, mereka harus diperiksa kesehatannya.</li>
                                    <li>Penilaian status gizi dan kesiapan untuk hamil guna mencegah stunting.</li>
                                    <li>Menyiapkan remaja putri yang akan menikah dengan memastikan mereka dalam kondisi sehat.</li>
                                </ul>

                                <h4 class="card-title">Stunting pada Remaja</h4>
                                <p class="text-justify">Remaja putri termasuk salah satu kelompok yang rawan menderita malnutrisi. Menstruasi menjadi salah satu faktor yang menyebabkan malnutrisi, karena selama menstruasi darah akan terus keluar sehingga membutuhkan asupan zat gizi terutama besi untuk membantu produksi hemoglobin pada tubuh. Status gizi pada remaja merupakan pantulan dari permulaan kejadian kekurangan gizi pada anak usia dini. Negara dengan penghasilan menengah, remaja merupakan masa penurunan malnutrisi dari anak usia dini, baik itu stunting atau anemia sebelumnya yang disebabkan oleh defisiensi mikronutrien (Thurnham et al, 2013).</p>
                                <p class="text-justify">Dampak buruk stunting ada tiga, yaitu: 1. tinggi badan tidak cukup, 2. kemampuan intelektual di bawah rata-rata, 3. di hari tua dapat memiliki potensi besar untuk mengalami penyakit tidak menular seperti diabetes, kardiovaskular, gangguan metabolik, dan lainnya (Siaran pers, Kepala BKKBN, Dr. (Hc) dr. Hasto Wardoyo, Sp.OG, 21 Juni 2021).</p>
                                <p class="text-justify">Cara pencegahan stunting meliputi memperhatikan gizi ibu hamil, memantau 1000 hari pertama kehidupan mulai dari konsepsi hingga anak lahir dengan ASI eksklusif minimal 6 bulan, memberikan MPASI bergizi, serta menjaga kebersihan lingkungan (Siaran pers, Kepala Lembaga Demografi UI, Turro S Wongkaren, Ph.D, 21 Juni 2021).</p>

                                <div class="text-center mb-3">
                                    <img src="img/siklus.jpg" alt="Ilustrasi Penanggulangan / Pencegahan Stunting" class="img-fluid" style="max-width: 50%; height: auto;">
                                </div>

                                <p class="text-justify">Apa yang harus dilakukan remaja untuk mencegah stunting: 1. Menjaga kesehatan diri sendiri dengan olahraga, makanan sehat dengan gizi seimbang, jaga kebersihan lingkungan, sanitasi, tidak merokok dan tidak menggunakan NAPZA. 2. Mempersiapkan diri untuk menjadi anggota keluarga yang mandiri secara sosial maupun ekonomi melalui pendidikan dan pekerjaan. 3. Menyiapkan diri menjadi orang tua dengan persiapan sejak muda. 4. Berperan aktif dalam pencegahan stunting dengan menjadi peer educator, memberi edukasi dan informasi kepada teman sebaya (Siaran pers, Kepala Lembaga Demografi UI, Turro S Wongkaren, Ph.D, 21 Juni 2021).</p>

                                <h4 class="card-title">Materi tentang Diet Sehat dan Olahraga bagi perempuan</h4>
                                <p>Berikut adalah beberapa tips diet sehat dan olahraga bagi perempuan:</p>
                                <h5>Diet Sehat:</h5>
                                <ul class="text-justify">
                                    <li>Konsumsi makanan yang kaya akan serat, seperti buah-buahan, sayuran, dan biji-bijian.</li>
                                    <li>Pastikan untuk mendapatkan kalsium yang cukup melalui susu, yogurt, atau sumber lainnya.</li>
                                    <li>Hindari makanan cepat saji dan makanan olahan yang tinggi lemak dan gula.</li>
                                    <li>Minum air putih yang cukup, minimal 8 gelas sehari.</li>
                                    <li>Batasi konsumsi minuman berkafein dan beralkohol.</li>
                                </ul>
                                <h5>Olahraga:</h5>
                                <ul class="text-justify">
                                    <li>Berolahraga secara rutin, minimal 30 menit setiap hari.</li>
                                    <li>Lakukan latihan kardio seperti berlari, bersepeda, atau berenang untuk menjaga kesehatan jantung.</li>
                                    <li>Lakukan latihan kekuatan seperti angkat beban untuk membangun otot dan menjaga kesehatan tulang.</li>
                                    <li>Jangan lupa untuk melakukan pemanasan sebelum berolahraga dan pendinginan setelahnya.</li>
                                    <li>Tetap aktif sepanjang hari, seperti dengan berjalan kaki atau menggunakan tangga daripada lift.</li>
                                </ul>
                            </div>
                            <button class="btn btn-link show-more">Lihat Selengkapnya</button>
                            <div class="text-center mt-4">
                                <button id="backToPreviousW" class="btn btn-secondary" onclick="showPage2()">Kembali</button>
                                <button id="backToStartW" class="btn btn-secondary" onclick="showPage1()">Kembali ke Awal</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-body text-center">
                                <div class="card-header py-3">
                                    <h6 class="font-weight-bold text-primary">Cek Seberapa Malasnya Dirimu!</h6>
                                </div>
                                <button class="btn btn-primary btn-lg mt-3" onclick="showPage5('perempuan')" style="width: 100%; font-size: 17px;">
                                    Kuisioner: Seberapa Mager kah Aku?
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form untuk IMT dan BMR -->
                <div class="col-lg-5 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Hitung IMT dan BMR</h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info" role="alert">
                                <h4 class="alert-heading">Apa itu IMT?</h4>
                                <p class="text-justify">Indeks Massa Tubuh (IMT) adalah ukuran yang digunakan untuk menilai apakah berat badan seseorang proporsional dengan tinggi badannya. 
                                    IMT dapat membantu menentukan apakah seseorang memiliki berat badan yang sehat, kurang berat badan, atau kelebihan berat badan.</p>
                            </div>
                            
                            <div class="alert alert-info" role="alert">
                                <h4 class="alert-heading">Apa itu BMR?</h4>
                                <p class="text-justify">Basal Metabolic Rate (BMR) adalah jumlah energi yang diperlukan tubuh untuk menjalankan fungsi vital seperti bernapas dan menjaga suhu tubuh saat dalam keadaan istirahat.</p>
                            </div>

                            <form method="POST" action="">
                                <?php if ($role == 'admin' || $role == 'pengurus'): ?>
                                <!-- Dropdown untuk admin/pengurus memilih siswa -->
                                <div class="form-group">
                                    <label for="idsiswa">Pilih Siswa:</label>
                                    <select id="idsiswa" name="idsiswa" class="form-control" required>
                                        <option value="" disabled selected>Pilih Siswa</option>
                                        <?php
                                        // Koneksi ke database
                                        include('koneksi.php');

                                        // Ambil role pengguna
                                        $role = $_SESSION['role'];
                                        $iduser = $_SESSION['iduser'];

                                        // Query SQL tergantung peran pengguna
                                        if ($role == 'admin') {
                                            // Untuk admin, tampilkan semua siswa perempuan yang telah divalidasi
                                            $query = "SELECT tbsiswa.idsiswa, tbsiswa.namalengkapsiswa 
                                                    FROM tbsiswa 
                                                    INNER JOIN tbusersiswa ON tbsiswa.idsiswa = tbusersiswa.idsiswa 
                                                    WHERE tbsiswa.jeniskelamin = 'perempuan' 
                                                    AND tbusersiswa.status = 'validated'";
                                        } elseif ($role == 'pengurus') {
                                            // Untuk pengurus, tampilkan siswa perempuan dari sekolah yang sama dengan pengurus
                                            $query = "SELECT tbsiswa.idsiswa, tbsiswa.namalengkapsiswa 
                                                    FROM tbsiswa 
                                                    INNER JOIN tbusersiswa ON tbsiswa.idsiswa = tbusersiswa.idsiswa 
                                                    INNER JOIN tbsekolah ON tbsiswa.asalsekolah = tbsekolah.idsekolah 
                                                    INNER JOIN tbuser ON tbuser.asalsekolah = tbsekolah.idsekolah 
                                                    WHERE tbsiswa.jeniskelamin = 'perempuan' 
                                                    AND tbusersiswa.status = 'validated' 
                                                    AND tbuser.iduser = ?";
                                        }

                                        if ($stmt = mysqli_prepare($conn, $query)) {
                                            if ($role == 'pengurus') {
                                                mysqli_stmt_bind_param($stmt, "i", $iduser);
                                            }
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='" . $row['idsiswa'] . "'>" . $row['namalengkapsiswa'] . "</option>";
                                            }

                                            mysqli_stmt_close($stmt);
                                        }

                                        mysqli_close($conn);
                                        ?>
                                    </select>
                                </div>
                                <?php else: ?>
                                    <!-- Hidden input untuk siswa biasa -->
                                    <input type="hidden" name="idsiswa" value="<?php echo $idsiswa; ?>">
                                <?php endif; ?>
                                <div class="form-group">
                                    <label for="umur">Usia (tahun):</label>
                                    <input type="number" id="umur" name="umur" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="bb">Berat Badan (kg):</label>
                                    <input type="number" id="bb" name="bb" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="tb">Tinggi Badan (cm):</label>
                                    <input type="number" id="tb" name="tb" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="tingkataktif">Tingkat Aktivitas:</label>
                                    <select id="tingkataktif" name="tingkataktif" class="form-control" required>
                                        <option value="tidak pernah berolahraga">Tidak pernah berolahraga</option>
                                        <option value="jarang berolahraga">Jarang berolahraga</option>
                                        <option value="sering berolahraga">Sering berolahraga</option>
                                    </select>
                                </div>
                                <button type="submit" name="hitung_bmrperempuan" class="btn btn-primary">Hitung IMT dan BMR</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
        <!-- Halaman Kelima (Kuisioner) -->
        <div id="page5" class="hidden">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <!-- Content for Page 5 (Kuisioner) -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Kuisioner: Makanan yang Aku Makan</h4>
                            <!-- Form for Male Questionnaire -->
                            <div id="questionnaire-male" class="hidden">
                                <div class="table-responsive mb-4">
                                    <form name="kuisionerForm1" action="submitkuisionermakan.php" method="post" onsubmit="return validateForm1()">
                                    <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'pengurus'): ?>
                                        <!-- Dropdown untuk admin/pengurus memilih siswa -->
                                        <div class="form-group">
                                            <label for="idusersiswa">Pilih Siswa:</label>
                                            <select id="idusersiswa" name="idusersiswa" class="form-control" required>
                                                <option value="" disabled selected>Pilih Siswa</option>
                                                <?php
                                                // Koneksi ke database
                                                include('koneksi.php'); 

                                                // Ambil role pengguna
                                                $role = $_SESSION['role'];
                                                $iduser = $_SESSION['iduser'];

                                                // Query SQL tergantung peran pengguna
                                                if ($role == 'admin') {
                                                    // Untuk admin, tampilkan semua siswa laki-laki
                                                    $query = "SELECT tbusersiswa.idusersiswa, tbsiswa.namalengkapsiswa 
                                                            FROM tbusersiswa 
                                                            INNER JOIN tbsiswa ON tbusersiswa.idsiswa = tbsiswa.idsiswa 
                                                            WHERE tbsiswa.jeniskelamin = 'laki-laki'
                                                            AND tbusersiswa.status = 'validated'";
                                                } elseif ($role == 'pengurus') {
                                                    // Untuk pengurus, tampilkan siswa laki-laki dari sekolah yang sama dengan pengurus
                                                    $query = "SELECT tbusersiswa.idusersiswa, tbsiswa.namalengkapsiswa 
                                                            FROM tbusersiswa 
                                                            INNER JOIN tbsiswa ON tbusersiswa.idsiswa = tbsiswa.idsiswa 
                                                            INNER JOIN tbsekolah ON tbsiswa.asalsekolah = tbsekolah.idsekolah 
                                                            INNER JOIN tbuser ON tbuser.asalsekolah = tbsekolah.idsekolah 
                                                            WHERE tbsiswa.jeniskelamin = 'laki-laki'
                                                            AND tbusersiswa.status = 'validated'
                                                            AND tbuser.iduser = ?";
                                                }

                                                if ($stmt = mysqli_prepare($conn, $query)) {
                                                    if ($role == 'pengurus') {
                                                        mysqli_stmt_bind_param($stmt, "i", $iduser);
                                                    }
                                                    mysqli_stmt_execute($stmt);
                                                    $result = mysqli_stmt_get_result($stmt);

                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<option value='" . $row['idusersiswa'] . "'>" . $row['namalengkapsiswa'] . "</option>";
                                                    }

                                                    mysqli_stmt_close($stmt);
                                                }

                                                mysqli_close($conn);
                                                ?>
                                            </select>
                                        </div>
                                    <?php else: ?>
                                        <!-- Hidden input untuk siswa biasa -->
                                        <input type="hidden" name="idusersiswa" value="<?php echo $_SESSION['idusersiswa']; ?>">
                                    <?php endif; ?>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Pernyataan</th>
                                                    <th>Tidak Pernah</th>
                                                    <th>Kadang-Kadang</th>
                                                    <th>Selalu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Saya sarapan setiap hari</td>
                                                    <td><input type="radio" name="q1" value="1"></td>
                                                    <td><input type="radio" name="q1" value="2"></td>
                                                    <td><input type="radio" name="q1" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya makan nasi lebih dari 1 kali dalam sehari</td>
                                                    <td><input type="radio" name="q2" value="1"></td>
                                                    <td><input type="radio" name="q2" value="2"></td>
                                                    <td><input type="radio" name="q2" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya makan sayur setiap hari</td>
                                                    <td><input type="radio" name="q3" value="1"></td>
                                                    <td><input type="radio" name="q3" value="2"></td>
                                                    <td><input type="radio" name="q3" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya makan tempe atau tahu</td>
                                                    <td><input type="radio" name="q4" value="1"></td>
                                                    <td><input type="radio" name="q4" value="2"></td>
                                                    <td><input type="radio" name="q4" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya makan buah-buahan</td>
                                                    <td><input type="radio" name="q5" value="1"></td>
                                                    <td><input type="radio" name="q5" value="2"></td>
                                                    <td><input type="radio" name="q5" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya makan "seblak"</td>
                                                    <td><input type="radio" name="q6" value="3"></td>
                                                    <td><input type="radio" name="q6" value="2"></td>
                                                    <td><input type="radio" name="q6" value="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya minum minuman manis</td>
                                                    <td><input type="radio" name="q7" value="3"></td>
                                                    <td><input type="radio" name="q7" value="2"></td>
                                                    <td><input type="radio" name="q7" value="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya makan makanan pedas</td>
                                                    <td><input type="radio" name="q8" value="3"></td>
                                                    <td><input type="radio" name="q8" value="2"></td>
                                                    <td><input type="radio" name="q8" value="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya makan ayam tepung</td>
                                                    <td><input type="radio" name="q9" value="3"></td>
                                                    <td><input type="radio" name="q9" value="2"></td>
                                                    <td><input type="radio" name="q9" value="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya makan usus goreng</td>
                                                    <td><input type="radio" name="q10" value="3"></td>
                                                    <td><input type="radio" name="q10" value="2"></td>
                                                    <td><input type="radio" name="q10" value="1"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Form Kuisioner Mager -->
                                <h4 class="card-title">Kuisioner: Seberapa Magerkah Aku?</h4>
                                <div class="table-responsive mb-4">
                                    <form id="questionnaire-mager" action="submitkuisionermager.php" method="post">
                                    <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'pengurus'): ?>
                                        <!-- Dropdown untuk admin/pengurus memilih siswa -->
                                        <div class="form-group">
                                            <label for="idusersiswa">Pilih Siswa:</label>
                                            <select id="idusersiswa" name="idusersiswa" class="form-control" required>
                                                <option value="" disabled selected>Pilih Siswa</option>
                                                <?php
                                                // Koneksi ke database
                                                include('koneksi.php'); 

                                                // Ambil role pengguna
                                                $role = $_SESSION['role'];
                                                $iduser = $_SESSION['iduser'];

                                                // Query SQL tergantung peran pengguna
                                                if ($role == 'admin') {
                                                    // Untuk admin, tampilkan semua siswa laki-laki
                                                    $query = "SELECT tbusersiswa.idusersiswa, tbsiswa.namalengkapsiswa 
                                                            FROM tbusersiswa 
                                                            INNER JOIN tbsiswa ON tbusersiswa.idsiswa = tbsiswa.idsiswa 
                                                            WHERE tbsiswa.jeniskelamin = 'laki-laki'
                                                            AND tbusersiswa.status = 'validated'";
                                                } elseif ($role == 'pengurus') {
                                                    // Untuk pengurus, tampilkan siswa laki-laki dari sekolah yang sama dengan pengurus
                                                    $query = "SELECT tbusersiswa.idusersiswa, tbsiswa.namalengkapsiswa 
                                                            FROM tbusersiswa 
                                                            INNER JOIN tbsiswa ON tbusersiswa.idsiswa = tbsiswa.idsiswa 
                                                            INNER JOIN tbsekolah ON tbsiswa.asalsekolah = tbsekolah.idsekolah 
                                                            INNER JOIN tbuser ON tbuser.asalsekolah = tbsekolah.idsekolah 
                                                            WHERE tbsiswa.jeniskelamin = 'laki-laki'
                                                            AND tbusersiswa.status = 'validated'
                                                            AND tbuser.iduser = ?";
                                                }

                                                if ($stmt = mysqli_prepare($conn, $query)) {
                                                    if ($role == 'pengurus') {
                                                        mysqli_stmt_bind_param($stmt, "i", $iduser);
                                                    }
                                                    mysqli_stmt_execute($stmt);
                                                    $result = mysqli_stmt_get_result($stmt);

                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<option value='" . $row['idusersiswa'] . "'>" . $row['namalengkapsiswa'] . "</option>";
                                                    }

                                                    mysqli_stmt_close($stmt);
                                                }

                                                mysqli_close($conn);
                                                ?>
                                            </select>
                                        </div>
                                    <?php else: ?>
                                        <!-- Hidden input untuk siswa biasa -->
                                        <input type="hidden" name="idusersiswa" value="<?php echo $_SESSION['idusersiswa']; ?>">
                                    <?php endif; ?>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Pernyataan</th>
                                                    <th>Tidak</th>
                                                    <th>Ya</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Aktivitas Berat -->
                                                <tr>
                                                    <td>Apakah Anda melakukan aktivitas berat selama paling sedikit 10 menit?</td>
                                                    <td><input type="radio" name="aktivitasberat" id="aktivitasberat-tidak" value="Tidak"></td>
                                                    <td><input type="radio" name="aktivitasberat" id="aktivitasberat-ya" value="Ya"></td>
                                                </tr>
                                                <tr>
                                                    <td>Dalam 1 minggu, berapa hari Anda melakukan aktivitas berat?</td>
                                                    <td colspan="2"><input type="number" id="hariberat" name="hariberat" class="form-control" placeholder="Jumlah hari"></td>
                                                </tr>
                                                <tr>
                                                    <td>Berapa lama waktu yang dihabiskan untuk aktivitas berat?</td>
                                                    <td colspan="2">
                                                        <div class="input-group">
                                                            <input type="number" id="jamberat" name="jamberat" class="form-control" placeholder="Jam" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                            <input type="number" id="menitberat" name="menitberat" class="form-control" placeholder="Menit" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Aktivitas Sedang -->
                                                <tr>
                                                    <td>Apakah Anda melakukan aktivitas sedang selama paling sedikit 10 menit?</td>
                                                    <td><input type="radio" name="aktivitassedang" id="aktivitassedang-tidak" value="Tidak"></td>
                                                    <td><input type="radio" name="aktivitassedang" id="aktivitassedang-ya" value="Ya"></td>
                                                </tr>
                                                <tr>
                                                    <td>Dalam 1 minggu, berapa hari Anda melakukan aktivitas sedang?</td>
                                                    <td colspan="2"><input type="number" id="harisedang" name="harisedang" class="form-control" placeholder="Jumlah hari"></td>
                                                </tr>
                                                <tr>
                                                    <td>Berapa lama waktu yang dihabiskan untuk aktivitas sedang?</td>
                                                    <td colspan="2">
                                                        <div class="input-group">
                                                            <input type="number" id="jamsedang" name="jamsedang" class="form-control" placeholder="Jam" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                            <input type="number" id="menitsedang" name="menitsedang" class="form-control" placeholder="Menit" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Jalan Sepeda -->
                                                <tr>
                                                    <td>Apakah Anda berjalan kaki atau menaiki sepeda manual selama paling sedikit 10 menit?</td>
                                                    <td><input type="radio" name="jalansepeda" id="jalansepeda-tidak" value="Tidak"></td>
                                                    <td><input type="radio" name="jalansepeda" id="jalansepeda-ya" value="Ya"></td>
                                                </tr>
                                                <tr>
                                                    <td>Dalam 1 minggu, berapa hari Anda berjalan kaki atau menaiki sepeda?</td>
                                                    <td colspan="2"><input type="number" id="hariberjalan" name="hariberjalan" class="form-control" placeholder="Jumlah hari"></td>
                                                </tr>
                                                <tr>
                                                    <td>Berapa lama waktu yang dihabiskan untuk berjalan kaki atau menaiki sepeda?</td>
                                                    <td colspan="2">
                                                        <div class="input-group">
                                                            <input type="number" id="jamberjalan" name="jamberjalan" class="form-control" placeholder="Jam" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                            <input type="number" id="menitberjalan" name="menitberjalan" class="form-control" placeholder="Menit" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Olahraga Berat -->
                                                <tr>
                                                    <td>Apakah Anda melakukan olahraga berat selama paling sedikit 10 menit?</td>
                                                    <td><input type="radio" id="olahragaberat-tidak" name="olahragaberat" value="Tidak"></td>
                                                    <td><input type="radio" id="olahragaberat-ya" name="olahragaberat" value="Ya"></td>
                                                </tr>
                                                <tr>
                                                    <td>Dalam 1 minggu, berapa hari Anda melakukan olahraga berat?</td>
                                                    <td colspan="2"><input type="number" id="hariberatolahraga" name="hariberatolahraga" class="form-control" placeholder="Jumlah hari"></td>
                                                </tr>
                                                <tr>
                                                    <td>Berapa lama waktu yang dihabiskan untuk olahraga berat?</td>
                                                    <td colspan="2">
                                                        <div class="input-group">
                                                            <input type="number" id="jamberatolahraga" name="jamberatolahraga" class="form-control" placeholder="Jam" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                            <input type="number" id="menitberatolahraga" name="menitberatolahraga" class="form-control" placeholder="Menit" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Olahraga Sedang -->
                                                <tr>
                                                    <td>Apakah Anda melakukan olahraga sedang selama paling sedikit 10 menit?</td>
                                                    <td><input type="radio" id="olahragasedang-tidak" name="olahragasedang" value="Tidak"></td>
                                                    <td><input type="radio" id="olahragasedang-ya" name="olahragasedang" value="Ya"></td>
                                                </tr>
                                                <tr>
                                                    <td>Dalam 1 minggu, berapa hari Anda melakukan olahraga sedang?</td>
                                                    <td colspan="2"><input type="number" id="harisedangolahraga" name="harisedangolahraga" class="form-control" placeholder="Jumlah hari"></td>
                                                </tr>
                                                <tr>
                                                    <td>Berapa lama waktu yang dihabiskan untuk olahraga sedang?</td>
                                                    <td colspan="2">
                                                        <div class="input-group">
                                                            <input type="number" id="jamsedangolahraga" name="jamsedangolahraga" class="form-control" placeholder="Jam" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                            <input type="number" id="menitsedangolahraga" name="menitsedangolahraga" class="form-control" placeholder="Menit" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Berapa lama waktu yang dihabiskan untuk duduk atau berbaring dan bukan tertidru?</td>
                                                    <td colspan="2">
                                                        <div class="input-group">
                                                            <input type="number" id="waktududuk" name="waktududuk" class="form-control" placeholder="Jam" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                            <input type="number" id="menitduduk" name="menitduduk" class="form-control" placeholder="Menit" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <div id="questionnaire-female" class="hidden">    
                                <div class="table-responsive mb-4">    
                                    <form name="kuisionerForm2" action="submitkuisionermakan.php" method="post" onsubmit="return validateForm2()">
                                        <p>Kuisioner untuk perempuan:</p>
                                        <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'pengurus'): ?>
                                        <!-- Dropdown untuk admin/pengurus memilih siswa -->
                                        <div class="form-group">
                                            <label for="idusersiswa">Pilih Siswa:</label>
                                            <select id="idusersiswa" name="idusersiswa" class="form-control" required>
                                                <option value="" disabled selected>Pilih Siswa</option>
                                                <?php
                                                // Koneksi ke database
                                                include('koneksi.php'); 

                                                // Ambil role pengguna
                                                $role = $_SESSION['role'];
                                                $iduser = $_SESSION['iduser'];

                                                // Query SQL tergantung peran pengguna
                                                if ($role == 'admin') {
                                                    // Untuk admin, tampilkan semua siswa perempuan
                                                    $query = "SELECT tbusersiswa.idusersiswa, tbsiswa.namalengkapsiswa 
                                                            FROM tbusersiswa 
                                                            INNER JOIN tbsiswa ON tbusersiswa.idsiswa = tbsiswa.idsiswa 
                                                            WHERE tbsiswa.jeniskelamin = 'perempuan'
                                                            AND tbusersiswa.status = 'validated'";
                                                } elseif ($role == 'pengurus') {
                                                    // Untuk pengurus, tampilkan siswa perempuan dari sekolah yang sama dengan pengurus
                                                    $query = "SELECT tbusersiswa.idusersiswa, tbsiswa.namalengkapsiswa 
                                                            FROM tbusersiswa 
                                                            INNER JOIN tbsiswa ON tbusersiswa.idsiswa = tbsiswa.idsiswa 
                                                            INNER JOIN tbsekolah ON tbsiswa.asalsekolah = tbsekolah.idsekolah 
                                                            INNER JOIN tbuser ON tbuser.asalsekolah = tbsekolah.idsekolah 
                                                            WHERE tbsiswa.jeniskelamin = 'perempuan'
                                                            AND tbusersiswa.status = 'validated'
                                                            AND tbuser.iduser = ?";
                                                }

                                                if ($stmt = mysqli_prepare($conn, $query)) {
                                                    if ($role == 'pengurus') {
                                                        mysqli_stmt_bind_param($stmt, "i", $iduser);
                                                    }
                                                    mysqli_stmt_execute($stmt);
                                                    $result = mysqli_stmt_get_result($stmt);

                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<option value='" . $row['idusersiswa'] . "'>" . $row['namalengkapsiswa'] . "</option>";
                                                    }

                                                    mysqli_stmt_close($stmt);
                                                }

                                                mysqli_close($conn);
                                                ?>
                                            </select>
                                        </div>
                                    <?php else: ?>
                                        <!-- Hidden input untuk siswa biasa -->
                                        <input type="hidden" name="idusersiswa" value="<?php echo $_SESSION['idusersiswa']; ?>">
                                    <?php endif; ?>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Pernyataan</th>
                                                    <th>Tidak Pernah</th>
                                                    <th>Kadang-Kadang</th>
                                                    <th>Selalu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Saya sarapan setiap hari</td>
                                                    <td><input type="radio" name="q1" value="0"></td>
                                                    <td><input type="radio" name="q1" value="1"></td>
                                                    <td><input type="radio" name="q1" value="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya makan nasi lebih dari 1 kali dalam sehari</td>
                                                    <td><input type="radio" name="q2" value="0"></td>
                                                    <td><input type="radio" name="q2" value="1"></td>
                                                    <td><input type="radio" name="q2" value="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya makan sayur setiap hari</td>
                                                    <td><input type="radio" name="q3" value="0"></td>
                                                    <td><input type="radio" name="q3" value="1"></td>
                                                    <td><input type="radio" name="q3" value="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya makan tempe atau tahu</td>
                                                    <td><input type="radio" name="q4" value="0"></td>
                                                    <td><input type="radio" name="q4" value="1"></td>
                                                    <td><input type="radio" name="q4" value="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya maka buah-buahan</td>
                                                    <td><input type="radio" name="q5" value="0"></td>
                                                    <td><input type="radio" name="q5" value="1"></td>
                                                    <td><input type="radio" name="q5" value="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya makan "seblak"</td>
                                                    <td><input type="radio" name="q6" value="0"></td>
                                                    <td><input type="radio" name="q6" value="1"></td>
                                                    <td><input type="radio" name="q6" value="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya minum, minuman manis</td>
                                                    <td><input type="radio" name="q7" value="0"></td>
                                                    <td><input type="radio" name="q7" value="1"></td>
                                                    <td><input type="radio" name="q7" value="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya makan, makanan pedas</td>
                                                    <td><input type="radio" name="q8" value="0"></td>
                                                    <td><input type="radio" name="q8" value="1"></td>
                                                    <td><input type="radio" name="q8" value="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya makan ayam tepung</td>
                                                    <td><input type="radio" name="q9" value="0"></td>
                                                    <td><input type="radio" name="q9" value="1"></td>
                                                    <td><input type="radio" name="q9" value="2"></td>
                                                </tr>
                                                <tr> 
                                                    <td>Saya makan usus goreng</td>
                                                    <td><input type="radio" name="q10" value="0"></td>
                                                    <td><input type="radio" name="q10" value="1"></td>
                                                    <td><input type="radio" name="q10" value="2"></td>
                                                </tr>
                                                </tbody>
                                        </table>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                                        </div>
                                        <div class="text-right">
                                            <button class="btn btn-info mt-3" type="button" onclick="showPage6()">Pentingnya Minum Tablet Penambah Darah</button>
                                        </div>
                                    </form>
                                </div>    
                                
                                <!-- Form Kuisioner Mager -->
                                <h4 class="card-title">Kuisioner: Seberapa Magerkah Aku?</h4>
                                <div class="table-responsive mb-4">
                                    <form id="questionnaire-mager" action="submitkuisionermager.php" method="post">
                                    <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'pengurus'): ?>
                                        <!-- Dropdown untuk admin/pengurus memilih siswa -->
                                        <div class="form-group">
                                            <label for="idusersiswa">Pilih Siswa:</label>
                                            <select id="idusersiswa" name="idusersiswa" class="form-control" required>
                                                <option value="" disabled selected>Pilih Siswa</option>
                                                <?php
                                                // Koneksi ke database
                                                include('koneksi.php'); 

                                                // Ambil role pengguna
                                                $role = $_SESSION['role'];
                                                $iduser = $_SESSION['iduser'];

                                                // Query SQL tergantung peran pengguna
                                                if ($role == 'admin') {
                                                    // Untuk admin, tampilkan semua siswa perempuan
                                                    $query = "SELECT tbusersiswa.idusersiswa, tbsiswa.namalengkapsiswa 
                                                            FROM tbusersiswa 
                                                            INNER JOIN tbsiswa ON tbusersiswa.idsiswa = tbsiswa.idsiswa 
                                                            WHERE tbsiswa.jeniskelamin = 'perempuan'
                                                            AND tbusersiswa.status = 'validated'";
                                                } elseif ($role == 'pengurus') {
                                                    // Untuk pengurus, tampilkan siswa perempuan dari sekolah yang sama dengan pengurus
                                                    $query = "SELECT tbusersiswa.idusersiswa, tbsiswa.namalengkapsiswa 
                                                            FROM tbusersiswa 
                                                            INNER JOIN tbsiswa ON tbusersiswa.idsiswa = tbsiswa.idsiswa 
                                                            INNER JOIN tbsekolah ON tbsiswa.asalsekolah = tbsekolah.idsekolah 
                                                            INNER JOIN tbuser ON tbuser.asalsekolah = tbsekolah.idsekolah 
                                                            WHERE tbsiswa.jeniskelamin = 'perempuan'
                                                            AND tbusersiswa.status = 'validated'
                                                            AND tbuser.iduser = ?";
                                                }

                                                if ($stmt = mysqli_prepare($conn, $query)) {
                                                    if ($role == 'pengurus') {
                                                        mysqli_stmt_bind_param($stmt, "i", $iduser);
                                                    }
                                                    mysqli_stmt_execute($stmt);
                                                    $result = mysqli_stmt_get_result($stmt);

                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<option value='" . $row['idusersiswa'] . "'>" . $row['namalengkapsiswa'] . "</option>";
                                                    }

                                                    mysqli_stmt_close($stmt);
                                                }

                                                mysqli_close($conn);
                                                ?>
                                            </select>
                                        </div>
                                    <?php else: ?>
                                        <!-- Hidden input untuk siswa biasa -->
                                        <input type="hidden" name="idusersiswa" value="<?php echo $_SESSION['idusersiswa']; ?>">
                                    <?php endif; ?>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Pernyataan</th>
                                                    <th>Tidak</th>
                                                    <th>Ya</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Aktivitas Berat -->
                                                <tr>
                                                    <td>Apakah Anda melakukan aktivitas berat selama paling sedikit 10 menit?</td>
                                                    <td><input type="radio" name="aktivitasberat" id="aktivitasberat-tidak" value="Tidak"></td>
                                                    <td><input type="radio" name="aktivitasberat" id="aktivitasberat-ya" value="Ya"></td>
                                                </tr>
                                                <tr>
                                                    <td>Dalam 1 minggu, berapa hari Anda melakukan aktivitas berat?</td>
                                                    <td colspan="2"><input type="number" id="hariberat" name="hariberat" class="form-control" placeholder="Jumlah hari"></td>
                                                </tr>
                                                <tr>
                                                    <td>Berapa lama waktu yang dihabiskan untuk aktivitas berat?</td>
                                                    <td colspan="2">
                                                        <div class="input-group">
                                                            <input type="number" id="jamberat" name="jamberat" class="form-control" placeholder="Jam" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                            <input type="number" id="menitberat" name="menitberat" class="form-control" placeholder="Menit" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Aktivitas Sedang -->
                                                <tr>
                                                    <td>Apakah Anda melakukan aktivitas sedang selama paling sedikit 10 menit?</td>
                                                    <td><input type="radio" name="aktivitassedang" id="aktivitassedang-tidak" value="Tidak"></td>
                                                    <td><input type="radio" name="aktivitassedang" id="aktivitassedang-ya" value="Ya"></td>
                                                </tr>
                                                <tr>
                                                    <td>Dalam 1 minggu, berapa hari Anda melakukan aktivitas sedang?</td>
                                                    <td colspan="2"><input type="number" id="harisedang" name="harisedang" class="form-control" placeholder="Jumlah hari"></td>
                                                </tr>
                                                <tr>
                                                    <td>Berapa lama waktu yang dihabiskan untuk aktivitas sedang?</td>
                                                    <td colspan="2">
                                                        <div class="input-group">
                                                            <input type="number" id="jamsedang" name="jamsedang" class="form-control" placeholder="Jam" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                            <input type="number" id="menitsedang" name="menitsedang" class="form-control" placeholder="Menit" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Jalan Sepeda -->
                                                <tr>
                                                    <td>Apakah Anda berjalan kaki atau menaiki sepeda manual selama paling sedikit 10 menit?</td>
                                                    <td><input type="radio" name="jalansepeda" id="jalansepeda-tidak" value="Tidak"></td>
                                                    <td><input type="radio" name="jalansepeda" id="jalansepeda-ya" value="Ya"></td>
                                                </tr>
                                                <tr>
                                                    <td>Dalam 1 minggu, berapa hari Anda berjalan kaki atau menaiki sepeda?</td>
                                                    <td colspan="2"><input type="number" id="hariberjalan" name="hariberjalan" class="form-control" placeholder="Jumlah hari"></td>
                                                </tr>
                                                <tr>
                                                    <td>Berapa lama waktu yang dihabiskan untuk berjalan kaki atau menaiki sepeda?</td>
                                                    <td colspan="2">
                                                        <div class="input-group">
                                                            <input type="number" id="jamberjalan" name="jamberjalan" class="form-control" placeholder="Jam" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                            <input type="number" id="menitberjalan" name="menitberjalan" class="form-control" placeholder="Menit" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Olahraga Berat -->
                                                <tr>
                                                    <td>Apakah Anda melakukan olahraga berat selama paling sedikit 10 menit?</td>
                                                    <td><input type="radio" id="olahragaberat-tidak" name="olahragaberat" value="Tidak"></td>
                                                    <td><input type="radio" id="olahragaberat-ya" name="olahragaberat" value="Ya"></td>
                                                </tr>
                                                <tr>
                                                    <td>Dalam 1 minggu, berapa hari Anda melakukan olahraga berat?</td>
                                                    <td colspan="2"><input type="number" id="hariberatolahraga" name="hariberatolahraga" class="form-control" placeholder="Jumlah hari"></td>
                                                </tr>
                                                <tr>
                                                    <td>Berapa lama waktu yang dihabiskan untuk olahraga berat?</td>
                                                    <td colspan="2">
                                                        <div class="input-group">
                                                            <input type="number" id="jamberatolahraga" name="jamberatolahraga" class="form-control" placeholder="Jam" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                            <input type="number" id="menitberatolahraga" name="menitberatolahraga" class="form-control" placeholder="Menit" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Olahraga Sedang -->
                                                <tr>
                                                    <td>Apakah Anda melakukan olahraga sedang selama paling sedikit 10 menit?</td>
                                                    <td><input type="radio" id="olahragasedang-tidak" name="olahragasedang" value="Tidak"></td>
                                                    <td><input type="radio" id="olahragasedang-ya" name="olahragasedang" value="Ya"></td>
                                                </tr>
                                                <tr>
                                                    <td>Dalam 1 minggu, berapa hari Anda melakukan olahraga sedang?</td>
                                                    <td colspan="2"><input type="number" id="harisedangolahraga" name="harisedangolahraga" class="form-control" placeholder="Jumlah hari"></td>
                                                </tr>
                                                <tr>
                                                    <td>Berapa lama waktu yang dihabiskan untuk olahraga sedang?</td>
                                                    <td colspan="2">
                                                        <div class="input-group">
                                                            <input type="number" id="jamsedangolahraga" name="jamsedangolahraga" class="form-control" placeholder="Jam" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                            <input type="number" id="menitsedangolahraga" name="menitsedangolahraga" class="form-control" placeholder="Menit" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Berapa lama waktu yang dihabiskan untuk duduk atau berbaring dan bukan tertidru?</td>
                                                    <td colspan="2">
                                                        <div class="input-group">
                                                            <input type="number" id="waktududuk" name="waktududuk" class="form-control" placeholder="Jam" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                            <input type="number" id="menitduduk" name="menitduduk" class="form-control" placeholder="Menit" style="width: 45%; display: inline-block;">
                                                            <span style="display: inline-block; width: 10%; text-align: center;"></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <button class="btn btn-secondary" id="backToGenderMaterial">Kembali ke Materi</button>
                            <button id="backToBegin" class="btn btn-secondary" type="button" onclick="showPage1()">Kembali ke Awal</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Halaman Keenam -->
        <div id="page6" class="hidden">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <!-- Content for Page 6 (Tablet Penambah Darah) -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Pentingnya Minum Tablet Penambah Darah untuk Remaja Putri</h4>
                            <p>Tablet penambah darah sangat penting bagi remaja putri untuk menjaga kesehatan dan mencegah anemia. Berikut adalah beberapa manfaatnya:</p>
                            <ul>
                                <li>Menjaga kadar hemoglobin dalam darah tetap normal.</li>
                                <li>Meningkatkan energi dan mengurangi kelelahan.</li>
                                <li>Mendukung pertumbuhan dan perkembangan yang sehat.</li>
                                <li>Memperbaiki konsentrasi dan kinerja akademis.</li>
                                <li>Mencegah komplikasi kesehatan akibat kekurangan zat besi.</li>
                            </ul>
                            <p>Remaja putri disarankan untuk rutin meminum tablet penambah darah sesuai dengan anjuran dokter atau tenaga kesehatan.</p>
                            <a href="dokumen/pedoman-pemberian-tablet-tambah-darah.pdf" download class="btn btn-primary">Download Informasi Tambahan</a>
                            <button class="btn btn-secondary" onclick="showPage5('perempuan')">Kembali</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
echo "<script>
var userRole = '$role';
var gender = '$gender';

window.onload = function() {
    initializePage();
};

function initializePage() {
    if (userRole === 'admin' || userRole === 'pengurus') {
        document.getElementById('backToStart').style.display = 'inline-block';
        document.getElementById('backToPrevious').style.display = 'inline-block';
        document.getElementById('backToStartW').style.display = 'inline-block';
        document.getElementById('backToPreviousW').style.display = 'inline-block';
        document.getElementById('backToBegin').style.display = 'inline-block';
    } else {
        document.getElementById('backToStart').style.display = 'none';
        document.getElementById('backToPrevious').style.display = 'none';
        document.getElementById('backToStartW').style.display = 'none';
        document.getElementById('backToPreviousW').style.display = 'none';
        document.getElementById('backToBegin').style.display = 'none';
    }

    if (userRole === 'admin' || userRole === 'pengurus') {
        showPage1();
    } else if (userRole === 'siswa') {
        if (gender === 'laki-laki') {
            showPage3(); // Menampilkan halaman materi laki-laki
        } else if (gender === 'perempuan') {
            showPage4(); // Menampilkan halaman materi perempuan
        }
    }

    // Attach event listeners to radio buttons
    const radioButtons = document.querySelectorAll('input[type=\"radio\"]');
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            handleRadioChange(this);
        });
    });
}

// Fungsi-fungsi untuk menampilkan halaman
function showPage1() {
    document.getElementById('page1').classList.remove('hidden');
    document.getElementById('page2').classList.add('hidden');
    document.getElementById('page3').classList.add('hidden');
    document.getElementById('page4').classList.add('hidden');
    document.getElementById('page5').classList.add('hidden');
    document.getElementById('page6').classList.add('hidden');
}

function showPage2() {
    document.getElementById('page1').classList.add('hidden');
    document.getElementById('page2').classList.remove('hidden');
    document.getElementById('page3').classList.add('hidden');
    document.getElementById('page4').classList.add('hidden');
    document.getElementById('page5').classList.add('hidden');
    document.getElementById('page6').classList.add('hidden');
}

function selectGender(gender) {
    if (gender === 'laki-laki') {
        showPage3();
    } else if (gender === 'perempuan') {
        showPage4();
    }
}

function showPage3() {
    document.getElementById('page1').classList.add('hidden');
    document.getElementById('page2').classList.add('hidden');
    document.getElementById('page3').classList.remove('hidden');
    document.getElementById('page4').classList.add('hidden');
    document.getElementById('page5').classList.add('hidden');
    document.getElementById('page6').classList.add('hidden');
}

function showPage4() {
    document.getElementById('page1').classList.add('hidden');
    document.getElementById('page2').classList.add('hidden');
    document.getElementById('page3').classList.add('hidden');
    document.getElementById('page4').classList.remove('hidden');
    document.getElementById('page5').classList.add('hidden');
    document.getElementById('page6').classList.add('hidden');
}

function showPage5(gender) {
    document.getElementById('page3').classList.add('hidden');
    document.getElementById('page4').classList.add('hidden');
    document.getElementById('page5').classList.remove('hidden');
    document.getElementById('page6').classList.add('hidden');

    if (gender === 'laki-laki') {
        document.getElementById('questionnaire-male').classList.remove('hidden');
        document.getElementById('questionnaire-female').classList.add('hidden');
        document.getElementById('backToGenderMaterial').textContent = 'Kembali ke Materi Laki-laki';
        document.getElementById('backToGenderMaterial').onclick = function() {
            showPage3();
        };
    } else if (gender === 'perempuan') {
        document.getElementById('questionnaire-female').classList.remove('hidden');
        document.getElementById('questionnaire-male').classList.add('hidden');
        document.getElementById('backToGenderMaterial').textContent = 'Kembali ke Materi Perempuan';
        document.getElementById('backToGenderMaterial').onclick = function() {
            showPage4();
        };
    }
}

function showPage6() {
    document.getElementById('page1').classList.add('hidden');
    document.getElementById('page2').classList.add('hidden');
    document.getElementById('page3').classList.add('hidden');
    document.getElementById('page4').classList.add('hidden');
    document.getElementById('page5').classList.add('hidden');
    document.getElementById('page6').classList.remove('hidden');
}

function handleRadioChange(radio) {
    const groupName = radio.name;
    const isCheckedYes = radio.value === 'Ya';

    const inputFields = {
        'aktivitasberat': ['hariberat', 'jamberat', 'menitberat'],
        'aktivitassedang': ['harisedang', 'jamsedang', 'menitsedang'],
        'jalansepeda': ['hariberjalan', 'jamberjalan', 'menitberjalan'],
        'olahragaberat': ['hariberatolahraga', 'jamberatolahraga', 'menitberatolahraga'],
        'olahragasedang': ['harisedangolahraga', 'jamsedangolahraga', 'menitsedangolahraga']
    };

    const fieldsToUpdate = inputFields[groupName];

    if (fieldsToUpdate) {
        fieldsToUpdate.forEach(id => {
            const field = document.getElementById(id);
            if (field) {
                if (isCheckedYes) {
                    field.disabled = false;
                    field.classList.remove('disabled-field');
                } else {
                    field.disabled = true;
                    field.classList.add('disabled-field');
                }
            }
        });
    }
}
</script>";
?>
    <script>
    function validateForm1() {
            const form = document.forms["kuisionerForm1"];
            for (let i = 1; i <= 10; i++) {
                const radios = form["q" + i];
                let filled = false;
                for (const radio of radios) {
                    if (radio.checked) {
                        filled = true;
                        break;
                    }
                }
                if (!filled) {
                    alert("Pertanyaan " + i + " belum diisi.");
                    return false;
                }
            }
            return true;
        }

    function validateForm2() {
        const form = document.forms["kuisionerForm1"];
        for (let i = 1; i <= 10; i++) {
            const radios = form["q" + i];
            let filled = false;
            for (const radio of radios) {
                if (radio.checked) {
                    filled = true;
                    break;
                }
            }
            if (!filled) {
                alert("Pertanyaan " + i + " belum diisi.");
                return false;
            }
        }
        return true;
    }
</script>

<script>
    document.querySelectorAll('.show-more').forEach(function(button) {
    button.addEventListener('click', function() {
        var card = this.closest('.card-body');
        var fullText = card.querySelector('.full-text');
        var shortText = card.querySelectorAll('.short-text');

        if (fullText.style.display === 'none' || !fullText.style.display) {
            fullText.style.display = 'block';
            this.textContent = 'Lihat Lebih Sedikit';
            shortText.forEach(function(element) {
                element.style.display = 'none';
            });
        } else {
            fullText.style.display = 'none';
            this.textContent = 'Lihat Selengkapnya';
            shortText.forEach(function(element) {
                element.style.display = 'block';
            });
        }
    });
});
</script>


<?php include('footer.php'); ?>

</div>
<!-- End of Main Content -->
