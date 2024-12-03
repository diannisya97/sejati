<?php 
include('header.php'); 

$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'undefined';
$gender = isset($_SESSION['jeniskelamin']) ? $_SESSION['jeniskelamin'] : 'undefined';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $iduser = isset($_SESSION['iduser']) ? $_SESSION['iduser'] : null;
    $idusersiswa = isset($_SESSION['idusersiswa']) ? $_SESSION['idusersiswa'] : null;
    $isitopik = mysqli_real_escape_string($conn, $_POST['isitopik']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    
    // Perbaiki pengambilan nilai kategori dari POST
    $kategori = ($gender === 'laki-laki') ? mysqli_real_escape_string($conn, $_POST['kategori']) : mysqli_real_escape_string($conn, $_POST['kategoriperempuan']);
    
    $isitopik = str_replace(array("\\r\\n", "\\r", "\\n"), "\n", $isitopik);
    $tanggal = date('Y-m-d H:i:s');

    if ($gender === 'laki-laki') {
        $stmt = $conn->prepare("INSERT INTO topik (iduser, idusersiswa, isitopik, tanggal, kategori) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("iisss", $iduser, $idusersiswa, $isitopik, $tanggal, $kategori);
    } else {
        $stmt = $conn->prepare("INSERT INTO topikperempuan (iduser, idusersiswa, isitopikperempuan, tanggal, kategoriperempuan) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("iisss", $iduser, $idusersiswa, $isitopik, $tanggal, $kategori);
    }

    if ($stmt->execute()) {
        // Redirect ke halaman dengan kategori yang sama
        header("Location: tanyajawab.php?page=ajukan&gender=" . urlencode($gender) . "&kategori=" . urlencode($kategori));
        exit();
    } else {
        // Debugging: Tampilkan kesalahan SQL jika ada
        echo "<script>alert('Gagal menyimpan topik');window.location.href='tanyajawab.php?page=ajukan&gender=" . urlencode($gender) . "&kategori=" . urlencode($kategori) . "';</script>";
    }

    $stmt->close();
}

// Ambil kategori yang dipilih dari query string jika tersedia
$selectedKategori = isset($_GET['kategori']) ? htmlspecialchars($_GET['kategori'], ENT_QUOTES, 'UTF-8') : '';

echo "<script>
var userRole = '$role';
var gender = '$gender';

function initializePage() {
    if (userRole === 'admin' || userRole === 'pengurus') {
        // Tampilkan tombol untuk admin dan pengurus
        document.getElementById('backToPrevious').style.display = 'inline-block';
        document.getElementById('backToPreviousW').style.display = 'inline-block';
        showPage1(); // Menampilkan halaman pertama
    } else if (userRole === 'siswa') {
        // Sembunyikan tombol untuk siswa
        document.getElementById('backToPrevious').style.display = 'none';
        document.getElementById('backToPreviousW').style.display = 'none';

        // Menampilkan halaman berdasarkan gender siswa
        if (gender === 'laki-laki') {
            showPage3(); // Menampilkan halaman materi laki-laki
        } else if (gender === 'perempuan') {
            showPage4(); // Menampilkan halaman materi perempuan
        }
    }
}

// Fungsi-fungsi untuk menampilkan halaman
function showPage1() {
    document.getElementById('page1').classList.remove('hidden');
    document.getElementById('page2').classList.add('hidden');
    document.getElementById('page3').classList.add('hidden');
    document.getElementById('page4').classList.add('hidden');
}

function showPage2() {
    document.getElementById('page1').classList.add('hidden');
    document.getElementById('page2').classList.remove('hidden');
    document.getElementById('page3').classList.add('hidden');
    document.getElementById('page4').classList.add('hidden');
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
}

function showPage4() {
    document.getElementById('page1').classList.add('hidden');
    document.getElementById('page2').classList.add('hidden');
    document.getElementById('page3').classList.add('hidden');
    document.getElementById('page4').classList.remove('hidden');
}

window.onload = function() {
    initializePage();
};
</script>";
?>

<?php include('sidebar.php'); ?>
<?php include('topbar.php'); ?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <style>
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
    </style>

<div class="container mt-5">
    <!-- Halaman Pertama -->
    <div id="page1">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h4 class="m-0 font-weight-bold text-primary">Tanyakan Apa yang ingin Kamu Ketahui</h4>
                    </div>
                        <div class="card-body">
                            <div class="text-center">
                                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 18rem;"
                                    src="img/diskusi.png" alt="">
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
</div>

<!-- Halaman Ketiga (Laki-laki) -->
<div id="page3" class="hidden">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <!-- Form untuk Mengirim Topik -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="card-header py-3">
                        <h3 class="m-0 font-weight-bold text-primary">Ajukan Pertanyaan</h3>
                    </div>
                    <form method="POST" action="tanyajawab.php?page=ajukan" class="mt-3">
                        <input type="hidden" name="gender" value="laki-laki">
                        <div class="form-group">
                            <label for="kategoriLaki">Kategori:</label>
                            <select name="kategori" id="kategoriLaki" class="form-control" required>
                                <option value="" <?php if (empty($selectedKategori)) echo 'selected'; ?>>Pilih Kategori</option>
                                <option value="kesehatan" <?php if ($selectedKategori == 'kesehatan') echo 'selected'; ?>>Kesehatan</option>
                                <option value="perubahan" <?php if ($selectedKategori == 'perubahan') echo 'selected'; ?>>Perubahan</option>
                                <option value="olahraga" <?php if ($selectedKategori == 'olahraga') echo 'selected'; ?>>Olahraga</option>
                                <option value="mental" <?php if ($selectedKategori == 'mental') echo 'selected'; ?>>Mental</option>
                                <option value="pernikahan" <?php if ($selectedKategori == 'pernikahan') echo 'selected'; ?>>Pernikahan</option>
                                <option value="kenakalan" <?php if ($selectedKategori == 'kenakalan') echo 'selected'; ?>>Kenakalan</option>
                                <option value="lain-lain" <?php if ($selectedKategori == 'lain-lain') echo 'selected'; ?>>Lain-lain</option>
                            </select>
                        </div>
                        <textarea name="isitopik" class="form-control" required></textarea><br>
                        <button type="submit" class="btn btn-primary">Kirim Pertanyaan</button>
                        <button id="backToPrevious" class="btn btn-secondary" onclick="showPage2()">Kembali</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h3 class="m-0 font-weight-bold text-primary">Daftar Topik</h3>
                </div>
                <div class="card-body">
                    <div class="row" id="topikList">
                        <!-- Daftar topik akan dimuat di sini oleh AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Halaman Keempat (perempuan) -->
<div id="page4" class="hidden">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <!-- Form untuk Mengirim Topik -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="card-header py-3">
                        <h3 class="m-0 font-weight-bold text-primary">Ajukan Pertanyaan</h3>
                    </div>
                    <form method="POST" action="tanyajawab.php?page=ajukan" class="mt-3">
                        <input type="hidden" name="gender" value="perempuan">
                        <div class="form-group">
                        <label for="kategoriPerempuan">Kategori:</label>
                            <select name="kategoriperempuan" id="kategoriPerempuan" class="form-control" required>
                                <option value="" <?php if (empty($selectedKategori)) echo 'selected'; ?>>Pilih Kategori</option>
                                <option value="kesehatan" <?php if ($selectedKategori == 'kesehatan') echo 'selected'; ?>>Kesehatan</option>
                                <option value="perubahan" <?php if ($selectedKategori == 'perubahan') echo 'selected'; ?>>Perubahan</option>
                                <option value="olahraga" <?php if ($selectedKategori == 'olahraga') echo 'selected'; ?>>Olahraga</option>
                                <option value="mental" <?php if ($selectedKategori == 'mental') echo 'selected'; ?>>Mental</option>
                                <option value="pernikahan" <?php if ($selectedKategori == 'pernikahan') echo 'selected'; ?>>Pernikahan</option>
                                <option value="kenakalan" <?php if ($selectedKategori == 'kenakalan') echo 'selected'; ?>>Kenakalan</option>
                                <option value="lain-lain" <?php if ($selectedKategori == 'lain-lain') echo 'selected'; ?>>Lain-lain</option>
                            </select>
                        </div>
                        <textarea name="isitopik" class="form-control" required></textarea><br>
                        <button type="submit" class="btn btn-primary">Kirim Pertanyaan</button>
                        <button id="backToPreviousW" class="btn btn-secondary" onclick="showPage2()">Kembali</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h3 class="m-0 font-weight-bold text-primary">Daftar Topik</h3>
                </div>
                <div class="card-body">
                    <div class="row" id="topikListPerempuan">
                        <!-- Daftar topik akan dimuat di sini oleh AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    // Fungsi untuk memuat topik berdasarkan kategori dan gender
    function loadTopik(gender, kategori) {
        $.ajax({
            url: 'load_topik.php',
            type: 'GET',
            data: {
                gender: gender,
                kategori: kategori
            },
            success: function(response) {
                if (gender === 'laki-laki') {
                    $('#topikList').html(response);
                } else if (gender === 'perempuan') {
                    $('#topikListPerempuan').html(response);
                }
            }
        });
    }

    // Ambil parameter dari URL
    function getQueryParam(param) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    // Ambil parameter kategori dan gender dari URL
    var gender = getQueryParam('gender');
    var kategori = getQueryParam('kategori');

    // Muat topik berdasarkan kategori dan gender saat halaman dimuat
    if (gender && kategori) {
        loadTopik(gender, kategori);
    }

    // Event listener untuk dropdown kategori laki-laki
    $('#kategoriLaki').change(function() {
        var kategori = $(this).val();
        loadTopik('laki-laki', kategori);
    });

    // Event listener untuk dropdown kategori perempuan
    $('#kategoriPerempuan').change(function() {
        var kategori = $(this).val();
        loadTopik('perempuan', kategori);
    });
});

</script>

<!-- /.container-fluid -->
<?php include('footer.php'); ?>
</div>
<!-- End of Main Content -->
