<?php
include('header.php'); 
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'undefined';
$gender = isset($_SESSION['jeniskelamin']) ? $_SESSION['jeniskelamin'] : 'undefined';

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
}

// Fungsi-fungsi untuk menampilkan halaman
function showPage1() {
    document.getElementById('page1').classList.remove('hidden');
    document.getElementById('page2').classList.add('hidden');
    document.getElementById('page3').classList.add('hidden');
    document.getElementById('page4').classList.add('hidden');
    document.getElementById('page5').classList.add('hidden');
}

function showPage2() {
    document.getElementById('page1').classList.add('hidden');
    document.getElementById('page2').classList.remove('hidden');
    document.getElementById('page3').classList.add('hidden');
    document.getElementById('page4').classList.add('hidden');
    document.getElementById('page5').classList.add('hidden');
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
}

function showPage4() {
    document.getElementById('page1').classList.add('hidden');
    document.getElementById('page2').classList.add('hidden');
    document.getElementById('page3').classList.add('hidden');
    document.getElementById('page4').classList.remove('hidden');
    document.getElementById('page5').classList.add('hidden');
}

function showPage5(gender) {
        document.getElementById('page3').classList.add('hidden');
        document.getElementById('page4').classList.add('hidden');
        document.getElementById('page5').classList.remove('hidden');

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
</script>";
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
        
        .text-center img {
  max-width: 40%; /* Ukuran gambar tetap kecil pada layar desktop */
  height: auto;   /* Pertahankan rasio aspek gambar */
  border-radius: 5%; /* Penambahan radius untuk sudut */
}

/* Style default untuk tampilan desktop */
ul.text-justify img {
  max-width: 20%; /* Ukuran gambar tetap kecil pada layar desktop */
  height: auto;   /* Pertahankan rasio aspek gambar */
  border-radius: 5%; /* Penambahan radius untuk sudut */
  margin-bottom: 10px;
}

        @media (max-width: 768px) {
            .text-center img {
  max-width: 80%; /* Ukuran gambar tetap kecil pada layar desktop */
  height: auto;   /* Pertahankan rasio aspek gambar */
  border-radius: 5%; /* Penambahan radius untuk sudut */
}

  ul.text-justify li {
    flex-direction: column; /* Susunan vertikal pada layar kecil */
    align-items: center;
  }
  
  ul.text-justify img {
    max-width: 80%; /* Perbesar gambar di layar kecil, bisa diatur sesuai keinginan */
    width: 100%; /* Lebar penuh kontainer induk */
    height: auto; /* Pertahankan proporsi gambar */
    margin: 10px auto; /* Mengatur gambar di tengah dengan jarak margin atas */
  }
  
  ul.text-justify div {
    text-align: justify; /* Teks tetap rata kiri-kanan */
  }
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
                            <h4 class="m-0 font-weight-bold text-primary">Menjaga Kesehatan Diriku</h4>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 18rem;"
                                    src="img/mikir2.png" alt="">
                                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 18rem;"
                                    src="img/mikir.png" alt="">
                                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 18rem;"
                                    src="img/mikir3.png" alt="">
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

    <!-- Halaman Ketiga (Laki-laki) -->
    <div id="page3" class="hidden">
        <div class="row">
            <div class="col-lg-8 mb-4">
                <!-- Content for Page 3 (Laki-laki) -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                    <h4 class="card-title">Materi tentang Menjaga Kebersihan bagi Laki-laki</h4>
                        <p>Menjaga kebersihan adalah bagian penting dari gaya hidup sehat. Berikut adalah beberapa tips yang dapat membantu laki-laki dalam menjaga kebersihan dan kesehatan tubuh mereka:</p>

                        <div class="text-center mb-4">
                            <img src="img/kebersihanlaki.jpg" alt="Menjaga Kesehatan Laki-laki" class="img-fluid">
                        </div>

                        <ul class="text-justify">
                            <li><strong>Mandi secara teratur:</strong> Mandi setidaknya sekali sehari untuk menghilangkan keringat, kotoran, dan minyak yang menumpuk di kulit. Mandi yang baik juga dapat membantu mencegah masalah kulit seperti jerawat dan iritasi.</li>
                            <li><strong>Menggunakan deodorant atau antiperspirant:</strong> Deodorant membantu mengatasi bau badan yang disebabkan oleh keringat, sementara antiperspirant mengurangi produksi keringat itu sendiri. Gunakan produk yang sesuai dengan jenis kulit Anda untuk hasil terbaik.</li>
                            <li><strong>Memotong kuku secara rutin:</strong> Kuku yang panjang dapat menjadi sarang kuman dan bakteri. Potong kuku secara rutin dan bersihkan area di bawahnya untuk mencegah infeksi.</li>
                            <li><strong>Menggunakan pakaian bersih setiap hari:</strong> Pakaian yang bersih membantu menjaga kesehatan kulit dan mengurangi risiko infeksi. Gantilah pakaian dalam setiap hari dan pilih bahan yang menyerap keringat.</li>
                            <li><strong>Menjaga kebersihan rambut dan kulit kepala:</strong> Cucilah rambut secara teratur menggunakan sampo yang sesuai dengan jenis rambut Anda. Ini membantu mencegah ketombe dan menjaga kulit kepala tetap sehat.</li>
                        </ul>
                        <div class="full-text" style="display: none;">
                            <h5>Perawatan Tambahan untuk Kesehatan</h5>
                            <ul class="text-justify">  
                                <li style="display: flex; align-items: flex-start; gap: 15px;">
                                    <img src="img/gigi.jpg" alt="Merawat Gigi dan Mulut" class="img-fluid">
                                    <div>
                                        <strong>Merawat kebersihan gigi dan mulut:</strong> 
                                        Sikat gigi setidaknya dua kali sehari dan gunakan benang gigi untuk menghilangkan sisa makanan yang tidak terjangkau oleh sikat gigi. Kebersihan mulut yang baik mencegah bau mulut, gigi berlubang, dan penyakit gusi.
                                    </div>
                                </li>
                                <li style="display: flex; align-items: flex-start; gap: 15px;">
                                    <img src="img/perawatan.jpg" alt="Membersihkan Wajah" class="img-fluid">
                                    <div>
                                        <strong>Membersihkan wajah sebelum tidur:</strong> 
                                        Bersihkan wajah dari kotoran dan minyak yang menumpuk sepanjang hari menggunakan pembersih wajah yang sesuai dengan jenis kulit. Ini membantu mencegah jerawat dan menjaga kulit tetap segar.
                                    </div>
                                </li>
                                <li style="display: flex; align-items: flex-start; gap: 15px;">
                                    <img src="img/cucitangan.jpg" alt="Memastikan Kebersihan Tangan" class="img-fluid">
                                    <div>
                                        <strong>Memastikan kebersihan tangan:</strong> 
                                        Cuci tangan secara teratur, terutama sebelum makan dan setelah menggunakan toilet. Ini adalah cara sederhana namun efektif untuk mencegah penyebaran penyakit.
                                    </div>
                                </li>
                                <li style="display: flex; align-items: flex-start; gap: 15px;">
                                    <img src="img/dalaman.jpg" alt="Kebersihan Area Genital" class="img-fluid">
                                    <div>
                                        <strong>Perhatikan kebersihan area genital:</strong> 
                                        Pastikan area genital tetap bersih dan kering. Gantilah pakaian dalam secara teratur dan hindari penggunaan produk yang mengandung bahan kimia keras di area sensitif.
                                    </div>
                                </li>
                            </ul>
                            <h4 class="card-title">Kesehatan Reproduksi</h4>
                            <p class="text-justify">Kesehatan Reproduksi meliputi keadaan sehat baik secara fisik, psikis, dan sosial yang berkaitan dengan sistem, fungsi, dan proses reproduksi pada laki-laki dan perempuan. Jadi, tidak semata-mata bebas dari penyakit atau kecacatan.</p>
                            <p class="text-justify"> Kita sebagai remaja perlu mengetahui informasi kesehatan reproduksi agar dapat bertanggung jawab dalam menjaga dan memelihara organ reproduksi kita.</p>
                            <h5>Cara Merawat Organ Reproduksi</h5>
                            <ul class="text-justify">
                                <li>Pakaian dalam dan celana dalam (CD) diganti minimal 2 kali sehari. Jangan pakai CD bolak-balik.</li>
                                <li>Menggunakan CD berbahan yang menyerap keringat.</li>
                                <li>Pakai handuk yang bersih, kering, tidak lembab dan bau. Masa sih kita mau pakai handuk yang bau?</li>
                                <li>Untuk laki-laki, sangat dianjurkan untuk disunat/khitan supaya terhindar dari kemungkinan kanker penis dan kanker leher rahim pada istrinya nanti.</li>
                                <li>Kalau habis pipis atau keluar air mani, minimal dicuci/dicebok.</li>
                            </ul>
                        </div>
                        <button class="btn btn-link show-more">Lihat Selengkapnya</button>
                        <div class="text-center mt-4">
                            <button id="backToPrevious" class="btn btn-secondary" onclick="showPage2()">Kembali</button>
                            <button id="backToStart" class="btn btn-secondary" onclick="showPage1()">Kembali ke Awal</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <!-- Content for Page 3 (Laki-laki) -->
                <div class="card shadow mb-4">
                    <div class="card-body text-center">
                        <div class="card-header py-3">
                            <h6 class="font-weight-bold text-primary">Cek Seberapa Joroknya Dirimu!</h6>
                        </div>
                        <button class="btn btn-primary btn-lg mt-3" onclick="showPage5('laki-laki')" style="width: 100%; font-size: 17px;">
                            Kuisioner: Seberapa Jorok kah Diriku?
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Halaman Keempat (Perempuan) -->
    <div id="page4" class="hidden">
        <div class="row">
            <div class="col-lg-8 mb-4">
                <!-- Content for Page 4 (Perempuan) -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Materi tentang Menjaga Kebersihan bagi Perempuan</h4>
                        <p class="text-justify">Menjaga kebersihan adalah hal yang sangat penting bagi perempuan untuk kesehatan dan kesejahteraan secara keseluruhan. Berikut adalah beberapa tips yang dapat membantu:</p>

                        <div class="text-center mb-4">
                            <img src="img/kebersihanperempuan.webp" alt="Menjaga Kesehatan Perempuan" class="img-fluid">
                        </div>

                        <ul class="text-justify">
                            <li><strong>Mandi secara teratur:</strong> Mandi setiap hari untuk membersihkan kotoran, minyak, dan keringat dari tubuh. Ini juga membantu menyegarkan tubuh dan mencegah bau badan yang tidak sedap.</li>
                            <li><strong>Menggunakan deodorant atau antiperspirant:</strong> Gunakan deodorant untuk mengatasi bau badan, dan pilih antiperspirant jika ingin mengurangi produksi keringat. Pastikan produk yang digunakan aman dan sesuai dengan jenis kulit.</li>
                            <li><strong>Memotong kuku secara rutin:</strong> Kuku yang bersih dan rapi tidak hanya terlihat lebih baik tetapi juga membantu mencegah penumpukan kuman yang dapat menyebabkan infeksi. Pastikan untuk memotong kuku kaki dan tangan secara rutin.</li>
                            <li><strong>Menggunakan pakaian bersih setiap hari:</strong> Pakaian yang bersih membantu menjaga kesehatan kulit dan mencegah infeksi kulit. Ganti pakaian dalam dan pakaian tidur setiap hari, dan pilih bahan yang lembut serta menyerap keringat untuk kenyamanan maksimal.</li>
                            <li><strong>Menjaga kebersihan rambut dan kulit kepala:</strong> Cuci rambut secara teratur dengan sampo yang sesuai dengan jenis rambut untuk menjaga kesehatan kulit kepala dan mencegah masalah seperti ketombe. Rambut yang bersih juga membantu penampilan lebih segar dan percaya diri.</li>
                            <li><strong>Menjaga kebersihan daerah intim:</strong> Sangat penting bagi perempuan untuk menjaga kebersihan daerah intim guna mencegah infeksi. Gunakan air bersih saat membersihkan, dan ceboklah dari depan ke belakang untuk menghindari perpindahan kuman dari anus ke organ reproduksi. Selain itu, ganti pembalut setiap 4 jam saat menstruasi untuk menjaga kebersihan dan kesehatan.</li>
                        </ul>
                        <div class="full-text" style="display: none;">
                            <h4 class="card-title">Kesehatan Reproduksi</h4>
                            <p class="text-justify">Kesehatan reproduksi adalah keadaan sehat secara fisik, psikis, dan sosial yang berhubungan dengan sistem reproduksi. Ini bukan hanya berarti bebas dari penyakit atau kecacatan, tetapi juga mampu menjalani proses reproduksi dengan sehat dan bertanggung jawab.</p>

                            <div class="text-center mb-4">
                                <img src="img/bersihperempuan.jpg" alt="Menjaga Kesehatan Perempuan" class="img-fluid">
                            </div>

                            <p class="text-justify">Sebagai remaja, penting untuk mengetahui informasi kesehatan reproduksi agar kita dapat menjaga dan memelihara organ reproduksi dengan baik.</p>
                            <h5>Cara Merawat Organ Reproduksi</h5>
                            <ul class="text-justify">
                                <li style="display: flex; align-items: flex-start; gap: 15px;">
                                    <img src="img/berkala.jpg" alt="Gambaran yang Harus Disiapkan Ketika Menikah" class="img-fluid">
                                    <div>
                                        <strong>Ganti pakaian dalam dan celana dalam (CD) minimal dua kali sehari:</strong>
                                        <p style="margin: 0;">
                                            Pakaian dalam yang bersih membantu menjaga kebersihan dan mencegah infeksi. Jangan menggunakan pakaian dalam yang sudah dipakai secara bolak-balik.
                                        </p>
                                    </div>
                                </li>

                                <li style="display: flex; align-items: flex-start; gap: 15px;">
                                    <img src="img/serapan.jpg" alt="Gambaran yang Harus Disiapkan Ketika Menikah" class="img-fluid">
                                    <div>
                                        <strong>Gunakan pakaian dalam berbahan yang menyerap keringat:</strong>
                                        <p style="margin: 0;">
                                            Pilih bahan yang nyaman dan bisa menyerap keringat untuk menghindari kelembapan berlebih yang bisa menyebabkan iritasi atau infeksi.
                                        </p>
                                    </div>
                                </li>

                                <li style="display: flex; align-items: flex-start; gap: 15px;">
                                    <img src="img/handuk.jpg" alt="Gambaran yang Harus Disiapkan Ketika Menikah" class="img-fluid">
                                    <div>
                                        <strong>Pakai handuk yang bersih dan kering:</strong>
                                        <p style="margin: 0;">
                                            Handuk yang bersih mencegah penyebaran kuman. Pastikan handuk tidak lembap atau berbau, dan cuci secara rutin.
                                        </p>
                                    </div>
                                </li>

                                <li style="display: flex; align-items: flex-start; gap: 15px;">
                                    <img src="img/cebok.jpg" alt="Gambaran yang Harus Disiapkan Ketika Menikah" class="img-fluid">
                                    <div>
                                        <strong>Setelah buang air kecil, cebok dari depan ke belakang:</strong>
                                        <p style="margin: 0;">
                                            Cara ini membantu mencegah perpindahan kuman dari anus ke organ reproduksi yang bisa menyebabkan infeksi.
                                        </p>
                                    </div>
                                </li>

                                <li style="display: flex; align-items: flex-start; gap: 15px;">
                                    <img src="img/pembalut.jpg" alt="Gambaran yang Harus Disiapkan Ketika Menikah" class="img-fluid">
                                    <div>
                                        <strong>Ganti pembalut setiap 4 jam saat menstruasi:</strong>
                                        <p style="margin: 0;">
                                            Ini penting untuk menjaga kebersihan dan mencegah iritasi atau infeksi.
                                        </p>
                                    </div>
                                </li>
                            </ul>

                        </div>    
                        <button class="btn btn-link show-more">Lihat Selengkapnya</button>
                        <div class="text-center mt-4">
                            <button id="backToPreviousW" class="btn btn-secondary" onclick="showPage2()">Kembali</button>
                            <button id="backToStartW" class="btn btn-secondary" onclick="showPage1()">Kembali ke Awal</button>
                        </div>    
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <!-- Content for Page 4 (Perempuan) -->
                <div class="card shadow mb-4">
                    <div class="card-body text-center">
                        <div class="card-header py-3">
                            <h6 class="font-weight-bold text-primary">Cek Seberapa Joroknya Dirimu!</h6>
                        </div>
                        <button class="btn btn-primary btn-lg mt-3" onclick="showPage5('perempuan')" style="width: 100%; font-size: 17px;">
                            Kuisioner: Seberapa Jorok kah Diriku?
                        </button>
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
                            <h4 class="card-title">Kuisioner: Seberapa Jorok kah Diriku?</h4>
                            <div id="questionnaire-male" class="hidden">
                            <form name="kuisionerForm1" action="submitkuisionerkesehatanlaki.php" method="POST" onsubmit="return validateForm1()">
                                <p>Kuisioner untuk laki-laki:</p>
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
                                    <div class="table-responsive mb-4">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Pertanyaan</th>
                                                <th>Tidak Pernah</th>
                                                <th>Kadang-Kadang</th>
                                                <th>Selalu</th>
                                            </tr>
                                            <tr>
                                                <td>Saya selalu mandi setiap pagi dan sore</td>
                                                <td><input type="radio" name="q1" value="0"></td>
                                                <td><input type="radio" name="q1" value="1"></td>
                                                <td><input type="radio" name="q1" value="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Saya mencuci tangan sebelum makan</td>
                                                <td><input type="radio" name="q2" value="0"></td>
                                                <td><input type="radio" name="q2" value="1"></td>
                                                <td><input type="radio" name="q2" value="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Saya sikat gigi sebelum tidur</td>
                                                <td><input type="radio" name="q3" value="0"></td>
                                                <td><input type="radio" name="q3" value="1"></td>
                                                <td><input type="radio" name="q3" value="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Saya sikat gigi saat bangun tidur</td>
                                                <td><input type="radio" name="q4" value="0"></td>
                                                <td><input type="radio" name="q4" value="1"></td>
                                                <td><input type="radio" name="q4" value="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Setelah bermain saya mencuci kaki dan tangan</td>
                                                <td><input type="radio" name="q5" value="0"></td>
                                                <td><input type="radio" name="q5" value="1"></td>
                                                <td><input type="radio" name="q5" value="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Sehabis buang air kecil saya cebok menggunakan air</td>
                                                <td><input type="radio" name="q6" value="0"></td>
                                                <td><input type="radio" name="q6" value="1"></td>
                                                <td><input type="radio" name="q6" value="2"></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                                    </div>
                                </form>
                            </div>
                            <div id="questionnaire-female" class="hidden">
                                <p>Kuisioner untuk perempuan:</p>
                                <form name="kuisionerForm2" action="submitkuisionerkesehatanperempuan.php" method="POST" onsubmit="return validateForm2()">
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
                                    <div class="table-responsive mb-4">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Pertanyaan</th>
                                                <th>Tidak Pernah</th>
                                                <th>Kadang-Kadang</th>
                                                <th>Selalu</th>
                                            </tr>
                                            <tr>
                                                <td>Saya selalu mandi setiap pagi dan sore</td>
                                                <td><input type="radio" name="q1" value="0"></td>
                                                <td><input type="radio" name="q1" value="1"></td>
                                                <td><input type="radio" name="q1" value="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Saya mencuci tangan sebelum makan</td>
                                                <td><input type="radio" name="q2" value="0"></td>
                                                <td><input type="radio" name="q2" value="1"></td>
                                                <td><input type="radio" name="q2" value="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Saya sikat gigi sebelum tidur</td>
                                                <td><input type="radio" name="q3" value="0"></td>
                                                <td><input type="radio" name="q3" value="1"></td>
                                                <td><input type="radio" name="q3" value="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Saya sikat gigi saat bangun tidur</td>
                                                <td><input type="radio" name="q4" value="0"></td>
                                                <td><input type="radio" name="q4" value="1"></td>
                                                <td><input type="radio" name="q4" value="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Setelah bermain saya mencuci kaki dan tangan</td>
                                                <td><input type="radio" name="q5" value="0"></td>
                                                <td><input type="radio" name="q5" value="1"></td>
                                                <td><input type="radio" name="q5" value="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Sehabis buang air kecil saya cebok menggunakan air</td>
                                                <td><input type="radio" name="q6" value="0"></td>
                                                <td><input type="radio" name="q6" value="1"></td>
                                                <td><input type="radio" name="q6" value="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Sehabis buang air kecil saya cebok dari arah depan ke belakang</td>
                                                <td><input type="radio" name="q7" value="0"></td>
                                                <td><input type="radio" name="q7" value="1"></td>
                                                <td><input type="radio" name="q7" value="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Saya mengeringkan kemaluan saya setelah cebok</td>
                                                <td><input type="radio" name="q8" value="0"></td>
                                                <td><input type="radio" name="q8" value="1"></td>
                                                <td><input type="radio" name="q8" value="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Saya mengganti celana dalam 2 kali sehari</td>
                                                <td><input type="radio" name="q9" value="0"></td>
                                                <td><input type="radio" name="q9" value="1"></td>
                                                <td><input type="radio" name="q9" value="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Saya mencuci pembalut yang digunakan saat menstruasi/haid</td>
                                                <td><input type="radio" name="q10" value="0"></td>
                                                <td><input type="radio" name="q10" value="1"></td>
                                                <td><input type="radio" name="q10" value="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Saat menstruasi/haid, saya mengganti pembalut lebih dari 2 kali sehari</td>
                                                <td><input type="radio" name="q11" value="0"></td>
                                                <td><input type="radio" name="q11" value="1"></td>
                                                <td><input type="radio" name="q11" value="2"></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                                    </div>
                                </form>
                            </div>
                            <button class="btn btn-secondary" id="backToGenderMaterial">Kembali</button>
                            <button id="backToBegin" class="btn btn-secondary" onclick="showPage1()">Kembali ke Awal</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
    <script>
        function validateForm1() {
            const form = document.forms["kuisionerForm1"];
            for (let i = 1; i <= 6; i++) {
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
            const form = document.forms["kuisionerForm2"];
            for (let i = 1; i <= 11; i++) {
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


<!-- /.container-fluid -->
<?php include('footer.php'); ?>

</div>
<!-- End of Main Content -->
