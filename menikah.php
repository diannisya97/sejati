<?php include('header.php'); 
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
        var element = document.getElementById('myElement');
if (element !== null) {
    element.style.display = 'none';
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

        /* Style default untuk tampilan desktop */
ul.text-justify img {
  max-width: 25%; /* Ukuran gambar tetap kecil pada layar desktop */
  height: auto;   /* Pertahankan rasio aspek gambar */
  border-radius: 5%; /* Penambahan radius untuk sudut */
  margin-right: 20px;
}

/* Gaya khusus untuk gambar fisik */
ul.text-justify img.img-fisik {
  margin-top: 80px;
}

/* Gaya khusus untuk gambar fisik */
ul.text-justify img.img-dompet {
  margin-top: 10px;
}

ul.text-justify img.img-pohonbunga {
  max-width: 20%;
  margin-bottom: 5px;
}

ul.text-justify img.img-otakhati {
    max-width: 20%;
    margin-bottom: 5px;
}

ul.text-justify img.img-ibu {
    max-width: 20%;
}

        @media (max-width: 768px) {
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

  ul.text-justify img.img-fisik {
  margin-top: 10px;
}
 
ul.text-justify img.img-pohonbunga {
  max-width: 80%;
  margin-bottom: 5px;
}

ul.text-justify img.img-otakhati {
    max-width: 80%;
    margin-bottom: 5px;
}

ul.text-justify img.img-ibu {
    max-width: 80%;
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
                            <h4 class="m-0 font-weight-bold text-primary">Jika Aku Menikah dan Kesiapanku</h4>
                        </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 18rem;"
                                        src="img/pria.png" alt="">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 18rem;"
                                        src="img/nikah.png" alt="">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 18rem;"
                                        src="img/wanita.png" alt="">
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
                    <button class="btn btn-secondary" onclick="showPage1()">Kembali</button>
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
                            <h4 class="card-title">Jika Aku Menikah dan Kesiapanku</h4>
                            <p class="text-justify">Pernikahan adalah langkah besar dalam kehidupan seseorang. Berikut adalah beberapa hal yang perlu dipertimbangkan:</p>

                            <div class="text-center mb-3">
                                <img src="img/menikah.webp" alt="Gambaran yang Harus Disiapkan Ketika Menikah" class="img-fluid" style="max-width: 50%; height: auto; border-radius: 5%;">
                            </div>

                            <p class="text-justify">Pasti masing-masing dari kita memiliki respon yang berbeda-beda mendengar kata 'pernikahan'. Ada yang senyum-senyum, ada yang melongo, ada yang bingung. Mungkin ada yang membayangkan pesta, honeymoon, tapi banyak juga yang berpikir rempong.</p>
                            <p class="text-justify">Pernikahan adalah ikatan lahir batin antara seorang pria dan wanita sebagai suami isteri dengan tujuan membentuk keluarga (rumah tangga) yang bahagia dan kekal berdasarkan KeTuhanan Yang Maha Esa. Karena itu, kamu harus tahu kewajiban masing-masing, kewajiban suami, kewajiban istri, dan kalau dianugerahi anak, kamu harus memenuhi hak anak. Maka kamu harus mempersiapkan lahir batin, rasa saling menghormati, menghargai, dan materi. Jadi kamu harus selesai sekolah dulu, punya pekerjaan yang baik, supaya siap untuk menikah.</p>
                            <p class="text-justify">Menikahlah di usia yang ideal (lebih dari 20 tahun) agar siap fisik, jiwa, sosial, dan ekonomi.</p>

                            <div class="full-text" style="display: none;">
                                <h4 class="card-title mt-4">Persiapan dan Tanggungjawab Sebelum Menikah</h4>
                                <p>Ini adalah hal-hal penting yang perlu disiapkan sebelum memasuki masa pernikahan:</p>
                                <ul class="text-justify">
                                    <li style="display: flex; align-items: flex-start; gap: 15px;">
                                        <img src="img/fisik.jpg" alt="Gambaran yang Harus Disiapkan Ketika Menikah" class="img-fluid img-fisik">
                                        <div>
                                            <strong>Siap Fisik:</strong>
                                            <p style="margin: 0;">
                                                Keadaan fisik yang paling baik untuk memiliki anak apabila pertumbuhan tubuh dan organ reproduksi telah sempurna. Perempuan idealnya berusia antara 20-35 tahun, dan laki-laki telah mencapai 25 tahun. Persiapan gizi perlu dimulai sejak remaja, walaupun pernikahan masih lama. Tidak ada salahnya mempersiapkan fisik yang baik agar tumbuh sehat dan optimal. Makanlah makanan bergizi dengan seimbang, terutama yang mengandung zat besi dan asam folat agar terhindar dari anemia. Pemeriksaan kesehatan perlu dilakukan untuk mengetahui status kesehatan umum, masalah pada organ reproduksi, kelainan bawaan, dan penyakit keturunan. Ini juga penting untuk mencegah penularan penyakit pada calon suami/istri bahkan penularan dari ibu ke janin.
                                            </p>
                                        </div>
                                    </li>
                                    
                                    <li style="display: flex; align-items: flex-start; gap: 15px;">
                                        <img src="img/bukukunci.jpg" alt="Gambaran yang Harus Disiapkan Ketika Menikah" class="img-fluid img-buku">
                                        <div>
                                            <strong>Siap Jiwa:</strong>
                                            <p style="margin: 0;">
                                                Pernikahan merupakan babak baru dari kehidupan seseorang. Pastinya membutuhkan persiapan psikologis, salah satunya kemampuan menyesuaikan diri dengan perubahan dalam kehidupan.
                                            </p>
                                        </div>
                                    </li>

                                    <li style="display: flex; align-items: flex-start; gap: 15px;">
                                        <img src="img/dompet.jpg" alt="Gambaran yang Harus Disiapkan Ketika Menikah" class="img-fluid img-dompet">
                                        <div>
                                            <strong>Siap Sosial Ekonomi:</strong>
                                            <p style="margin: 0;">
                                                Tidak hanya ikatan cinta dan kasih sayang saja yang diperlukan agar pernikahan bisa bertahan, tetapi diperlukan dukungan materi untuk memenuhi kebutuhan dasar seperti sandang, pangan, dan papan. Kebutuhan materi tentunya berbeda dari satu orang dengan yang lain. Bukan berarti matre, tapi kenyataannya begitu.
                                            </p>
                                        </div>
                                    </li>
                                </ul>

                                <h4 class="card-title mt-4">Menikah Sebelum Usia 20 Tahun?</h4>
                                <p class="text-justify">Pikir-pikir lagi deh, karena pada usia tersebut kita masih dalam proses pertumbuhan dan perkembangan baik fisik, psikis/jiwa maupun sosial. Isilah masa remaja untuk mengembangkan bakat, bersenang-senang dengan keluarga dan teman, juga belajar dengan giat untuk meraih cita-cita.</p>
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
                                <h6 class="font-weight-bold text-primary">Cek Seberapa Siapnya Dirimu!</h6>
                            </div>
                            <button class="btn btn-primary btn-lg mt-3" onclick="showPage5('laki-laki')" style="width: 100%; font-size: 17px;">
                                Kuisioner: Seberapa Siapkah Aku untuk Menjalani Peran Baruku?
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
                            <h4 class="card-title">Jika Aku Menikah dan Kesiapanku</h4>
                            <p class="text-justify">Pernikahan adalah langkah besar dalam kehidupan seseorang. Berikut adalah beberapa hal yang perlu dipertimbangkan:</p>

                            <div class="text-center mb-3">
                                <img src="img/menikah.webp" alt="Gambaran yang Harus Disiapkan Ketika Menikah" class="img-fluid" style="max-width: 50%; height: auto; border-radius: 5%;">
                            </div>

                            <p class="text-justify">Pasti masing-masing dari kita memiliki respon yang berbeda-beda mendengar kata 'pernikahan'. Ada yang senyum-senyum, ada yang melongo, ada yang bingung. Mungkin ada yang membayangkan pesta, honeymoon, tapi banyak juga yang berpikir rempong.</p>
                            <p class="text-justify">Pernikahan adalah ikatan lahir batin antara seorang pria dan wanita sebagai suami isteri dengan tujuan membentuk keluarga (rumah tangga) yang bahagia dan kekal berdasarkan KeTuhanan Yang Maha Esa. Karena itu, kamu harus tahu kewajiban masing-masing, kewajiban suami, kewajiban istri, dan kalau dianugerahi anak, kamu harus memenuhi hak anak. Maka kamu harus mempersiapkan lahir batin, rasa saling menghormati, menghargai, dan materi. Jadi kamu harus selesai sekolah dulu, punya pekerjaan yang baik, supaya siap untuk menikah.</p>
                            <p class="text-justify">Menikahlah di usia yang ideal (lebih dari 20 tahun) agar siap fisik, jiwa, sosial, dan ekonomi.</p>

                            <div class="full-text" style="display: none;">
                                <h4 class="card-title mt-4">Persiapan dan Tanggungjawab Sebelum Menikah</h4>
                                <p>Ini adalah hal-hal penting yang perlu disiapkan sebelum memasuki masa pernikahan:</p>
                                <ul class="text-justify">
                                    <li style="display: flex; align-items: flex-start; gap: 15px;">
                                        <img src="img/fisik.jpg" alt="Gambaran yang Harus Disiapkan Ketika Menikah" class="img-fluid img-fisik">
                                        <div>
                                            <strong>Siap Fisik:</strong>
                                            <p style="margin: 0;">
                                                Keadaan fisik yang paling baik untuk memiliki anak apabila pertumbuhan tubuh dan organ reproduksi telah sempurna. Perempuan idealnya berusia antara 20-35 tahun, dan laki-laki telah mencapai 25 tahun. Persiapan gizi perlu dimulai sejak remaja, walaupun pernikahan masih lama. Tidak ada salahnya mempersiapkan fisik yang baik agar tumbuh sehat dan optimal. Makanlah makanan bergizi dengan seimbang, terutama yang mengandung zat besi dan asam folat agar terhindar dari anemia. Pemeriksaan kesehatan perlu dilakukan untuk mengetahui status kesehatan umum, masalah pada organ reproduksi, kelainan bawaan, dan penyakit keturunan. Ini juga penting untuk mencegah penularan penyakit pada calon suami/istri bahkan penularan dari ibu ke janin.
                                            </p>
                                        </div>
                                    </li>
                                    
                                    <li style="display: flex; align-items: flex-start; gap: 15px;">
                                        <img src="img/bukukunci.jpg" alt="Gambaran yang Harus Disiapkan Ketika Menikah" class="img-fluid img-buku">
                                        <div>
                                            <strong>Siap Jiwa:</strong>
                                            <p style="margin: 0;">
                                                Pernikahan merupakan babak baru dari kehidupan seseorang. Pastinya membutuhkan persiapan psikologis, salah satunya kemampuan menyesuaikan diri dengan perubahan dalam kehidupan.
                                            </p>
                                        </div>
                                    </li>

                                    <li style="display: flex; align-items: flex-start; gap: 15px;">
                                        <img src="img/dompet.jpg" alt="Gambaran yang Harus Disiapkan Ketika Menikah" class="img-fluid img-dompet">
                                        <div>
                                            <strong>Siap Sosial Ekonomi:</strong>
                                            <p style="margin: 0;">
                                                Tidak hanya ikatan cinta dan kasih sayang saja yang diperlukan agar pernikahan bisa bertahan, tetapi diperlukan dukungan materi untuk memenuhi kebutuhan dasar seperti sandang, pangan, dan papan. Kebutuhan materi tentunya berbeda dari satu orang dengan yang lain. Bukan berarti matre, tapi kenyataannya begitu.
                                            </p>
                                        </div>
                                    </li>
                                </ul>

                                <h4 class="card-title mt-4">Keadaan yang Ideal untuk Hamil</h4>
                                <ul class="text-justify">
                                    <li style="display: flex; align-items: flex-start; gap: 15px;">
                                        <img src="img/pohonbunga.jpg" alt="Gambaran yang Harus Disiapkan Ketika Menikah" class="img-fluid img-pohonbunga">
                                        <div>
                                            <strong>Siap Fisik:</strong>
                                            <p style="margin: 0;">
                                                Pertumbuhan dan perkembangan fisik telah optimal, yaitu di usia lebih dari 20 tahun.
                                            </p>
                                        </div>
                                    </li>

                                    <li style="display: flex; align-items: flex-start; gap: 15px;">
                                        <img src="img/otakhati.jpg" alt="Gambaran yang Harus Disiapkan Ketika Menikah" class="img-fluid img-otakhati">
                                        <div>
                                            <strong>Siap Mental/Emosional:</strong>
                                            <p style="margin: 0;">
                                                Kondisi mental dan psikologis yang stabil untuk menjadi orang tua, biasanya pada usia lebih dari 20 tahun.
                                            </p>
                                        </div>
                                    </li>

                                    <li style="display: flex; align-items: flex-start; gap: 15px;">
                                        <img src="img/ibu.jpg" alt="Gambaran yang Harus Disiapkan Ketika Menikah" class="img-fluid img-ibu">
                                        <div>
                                            <strong>Siap Sosial Ekonomi:</strong>
                                            <p style="margin: 0;">
                                                Kemampuan untuk mandiri dan dapat membiayai kehidupan anak yang lahir secara berkesinambungan.
                                            </p>
                                        </div>
                                    </li>
                                </ul>

                                <h4 class="card-title mt-4">Menikah Sebelum Usia 20 Tahun?</h4>
                                <p class="text-justify">Pikir-pikir lagi deh, karena pada usia tersebut kita masih dalam proses pertumbuhan dan perkembangan baik fisik, psikis/jiwa maupun sosial. Isilah masa remaja untuk mengembangkan bakat, bersenang-senang dengan keluarga dan teman, juga belajar dengan giat untuk meraih cita-cita.</p>
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
                    <!-- Content for Page 3 (Laki-laki) -->
                    <div class="card shadow mb-4">
                        <div class="card-body text-center">
                            <div class="card-header py-3">
                                <h6 class="font-weight-bold text-primary">Cek Seberapa Siapnya Dirimu!</h6>
                            </div>
                            <button class="btn btn-primary btn-lg mt-3" onclick="showPage5('perempuan')" style="width: 100%; font-size: 17px;">
                                Kuisioner: Seberapa Siapkah Aku untuk Menjalani Peran Baruku?
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
                            <h4 class="card-title">Kuisioner: Seberapa Siapkah Aku untuk Menjalani Peran Baru?</h4>
                            <div id="questionnaire-male" class="hidden">
                                <form name="kuisionerForm1" action="submitkuisionermenikah.php" method="post" onsubmit="return validateForm1()">
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
                                    <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Pertanyaan</th>
                                                        <th>Tidak Siap</th>
                                                        <th>Ragu-ragu</th>
                                                        <th>Siap</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Jika aku menikah sekarang, aku harus menunda sekolah ku</td>
                                                        <td><input type="radio" name="q1" value="0"></td>
                                                        <td><input type="radio" name="q1" value="1"></td>
                                                        <td><input type="radio" name="q1" value="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jika aku menikah sekarang, aku menjadi seorang suami</td>
                                                        <td><input type="radio" name="q2" value="0"></td>
                                                        <td><input type="radio" name="q2" value="1"></td>
                                                        <td><input type="radio" name="q2" value="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jika aku menikah sekarang, aku harus menunda cita-citaku</td>
                                                        <td><input type="radio" name="q3" value="0"></td>
                                                        <td><input type="radio" name="q3" value="1"></td>
                                                        <td><input type="radio" name="q3" value="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jika aku menikah sekarang, aku bertanggung jawab kepada istriku</td>
                                                        <td><input type="radio" name="q4" value="0"></td>
                                                        <td><input type="radio" name="q4" value="1"></td>
                                                        <td><input type="radio" name="q4" value="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jika aku menikah sekarang, aku harus menjalankan kewajibanku sebagai seorang suami</td>
                                                        <td><input type="radio" name="q5" value="0"></td>
                                                        <td><input type="radio" name="q5" value="1"></td>
                                                        <td><input type="radio" name="q5" value="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jika aku menikah sekarang, aku akan menjadi seorang ayah</td>
                                                        <td><input type="radio" name="q6" value="0"></td>
                                                        <td><input type="radio" name="q6" value="1"></td>
                                                        <td><input type="radio" name="q6" value="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jika aku menikah sekarang, aku harus memenuhi kebutuhan keluargaku</td>
                                                        <td><input type="radio" name="q7" value="0"></td>
                                                        <td><input type="radio" name="q7" value="1"></td>
                                                        <td><input type="radio" name="q7" value="2"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="text-right mt-2 mb-2">
                                                <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                                            </div>
                                    </div>
                                </form>
                            </div>

                            <div id="questionnaire-female" class="hidden">
                            <form name="kuisionerForm2" action="submitkuisionermenikah.php" method="post" onsubmit="return validateForm2()">
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
                                <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Pertanyaan</th>
                                                    <th>Tidak Siap</th>
                                                    <th>Ragu-ragu</th>
                                                    <th>Siap</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Jika aku menikah sekarang, aku harus menunda sekolah ku</td>
                                                    <td><input type="radio" name="q1" value="0"></td>
                                                    <td><input type="radio" name="q1" value="1"></td>
                                                    <td><input type="radio" name="q1" value="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>Jika aku menikah sekarang, aku menjadi seorang istri</td>
                                                    <td><input type="radio" name="q2" value="0"></td>
                                                    <td><input type="radio" name="q2" value="1"></td>
                                                    <td><input type="radio" name="q2" value="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>Jika aku menikah sekarang, aku harus menunda cita-citaku</td>
                                                    <td><input type="radio" name="q3" value="0"></td>
                                                    <td><input type="radio" name="q3" value="1"></td>
                                                    <td><input type="radio" name="q3" value="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>Jika aku menikah sekarang, aku mengabdi kepada suamiku</td>
                                                    <td><input type="radio" name="q4" value="0"></td>
                                                    <td><input type="radio" name="q4" value="1"></td>
                                                    <td><input type="radio" name="q4" value="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>Jika aku menikah sekarang, aku harus menjalankan kewajibanku sebagai seorang istri</td>
                                                    <td><input type="radio" name="q5" value="0"></td>
                                                    <td><input type="radio" name="q5" value="1"></td>
                                                    <td><input type="radio" name="q5" value="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>Jika aku menikah sekarang, aku akan memiliki anak</td>
                                                    <td><input type="radio" name="q6" value="0"></td>
                                                    <td><input type="radio" name="q6" value="1"></td>
                                                    <td><input type="radio" name="q6" value="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>Jika aku menikah sekarang, aku akan menyusui anakku</td>
                                                    <td><input type="radio" name="q7" value="0"></td>
                                                    <td><input type="radio" name="q7" value="1"></td>
                                                    <td><input type="radio" name="q7" value="2"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-right mt-2 mb-2">
                                            <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                                        </div>
                                </div>
                            </form>
                        </div>
                            <button class="btn btn-secondary" id="backToGenderMaterial">Kembali ke Materi</button>
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
            for (let i = 1; i <= 7; i++) {
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
            for (let i = 1; i <= 7; i++) {
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
