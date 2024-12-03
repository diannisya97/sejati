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

include('sidebar.php'); 
include('topbar.php'); 
?>


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
    </style>

<style>
.calendar-container {
    display: flex;
    flex-direction: column;
    align-items: center; /* Pusatkan kalender */
    margin-top: 30px;
    margin-bottom: 30px;
}
.calendar-title {
    font-size: 1.5em;
    margin-bottom: 20px;
    text-align: center; /* Pusatkan judul */
}
.calendar-instructions {
    margin-bottom: 10px;
    font-size: 0.9em; /* Ubah ukuran teks lebih kecil */
}
.calendar {
    background-color: #007bff;
    color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px; /* Ukuran padding tetap */
    width: 100%;
    max-width: 350px; /* Ukuran kalender tetap */
    text-align: center; /* Pusatkan kalender */
    margin-bottom: 20px;
}
.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.calendar-header h2 {
    margin: 0;
    font-size: 1.2em; /* Ukuran judul tetap */
}
.calendar-header button {
    background: none;
    border: none;
    color: #fff;
    font-size: 1.2rem; /* Ukuran tombol tetap */
    cursor: pointer;
}
.calendar-body {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 5px; /* Jarak antar kotak kalender tetap */
    margin-top: 10px;
}
.calendar-body div {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 35px; /* Tinggi kotak kalender tetap */
    border-radius: 5px;
    background-color: #e3f2fd;
    color: #007bff;
    cursor: pointer;
}
.calendar-body .day-header {
    font-weight: bold;
    background-color: #007bff;
    color: #fff;
}
.calendar-body .today {
    background-color: #ffcc00;
    color: #fff;
}
.info {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 100%;
    max-width: 400px; /* Ukuran box tetap */
    text-align: center;
    margin-bottom: 20px;
}
.result-container {
    display: flex;
    justify-content: space-between;
    width: 100%;
    max-width: 400px; /* Ukuran box tetap */
}
.result-box {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 48%; /* Lebar box */
    text-align: center;
}

/* Style default untuk tampilan desktop */
.text-center img {
  max-width: 50%; /* Ukuran gambar tetap kecil pada layar desktop */
  height: auto;   /* Pertahankan rasio aspek gambar */
  border-radius: 5%; /* Penambahan radius untuk sudut */
}

/* Style default untuk tampilan desktop */
ul.text-justify img {
  max-width: 40%; /* Ukuran gambar tetap kecil pada layar desktop */
  height: auto;   /* Pertahankan rasio aspek gambar */
  border-radius: 5%; /* Penambahan radius untuk sudut */
  margin-top: 60px;
  margin-right: 20px;
}

.text-center img.img-pikiran {
  margin-bottom: 10px;
  margin-top: -20px;
  max-width: 35%;
}

.text-center img.img-haid {
  margin-bottom: 10px;
  margin-top: -20px;
  max-width: 35%;
}


@media (max-width: 768px) {
  ul.text-justify li {
    flex-direction: column; /* Susunan vertikal pada layar kecil */
    align-items: center;
  }
  
  ul.text-justify img {
    max-width: 60%; /* Perbesar gambar di layar kecil, bisa diatur sesuai keinginan */
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
                            <h4 class="m-0 font-weight-bold text-primary">Memahami Perubahan Diriku</h4>
                        </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 18rem;"
                                        src="img/kaget2.png" alt="">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 18rem;"
                                        src="img/kaget.png" alt="">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 18rem;"
                                        src="img/kaget3.png" alt="">
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
                            <h4 class="card-title text-center">Memahami Perubahan Diriku</h4>
                            <p class="mb-4 text-justify">
                                Ketika memasuki usia remaja (10-19 tahun), kita akan mengalami usia yang disebut masa pubertas atau masa perubahan/transisi dari masa anak-anak menuju dewasa. 
                                Masa pubertas banyak melibatkan perubahan, khususnya menyangkut fisik, psikis, jiwa, dan pematangan fungsi organ reproduksi. </br>
                                </br>
                                Masa pubertas dimulai pada umur yang berbeda-beda, biasanya pada umur 10-12 tahun, tetapi ada juga yang dimulai pada usia lebih tua dari usia tersebut. 
                                Biasanya, pubertas pada anak perempuan lebih awal 1 atau 2 tahun dari anak laki-laki.
                            </p>
                            <h5 class="card-subtitle mb-3">Yuk kita kenali tanda-tanda pubertas</h5>

                            <div class="text-center">
                                <img src="img/puberlaki.png" alt="Perubahan Fisik pada Laki-laki" class="img-fluid">
                            </div>

                            <h6>Perubahan fisik yang kita alami:</h6>
                            <ul>
                                <li>Tumbuh jakun dan suara menjadi berat</li>
                                <li>Tumbuh kumis, jambang, janggut dan rambut ketiak dan sekitar kelamin, bisa juga tumbuh rambut di dada</li>
                                <li>Badan bertambah tinggi dan besar, otot dada dan bahu melebar</li>
                                <li>Perubahan pada kulit yang bisa menjadi lebih berminyak dan berjerawat.</li>
                                <li>Mimpi basah</li>
                            </ul>
                            <div class="full-text" style="display: none;">

                                <h6>Perubahan psikis yang kita alami:</h6>
                                <ul class="text-justify">
                                    <li style="display: flex; align-items: flex-start; gap: 15px;">
                                        <img src="img/pikiran.jpg" alt="Perubahan Psikis pada Laki-laki" class="img-fluid">
                                        <div>
                                            <strong>Perubahan Psikis pada Laki-laki:</strong>
                                            <p style="margin: 0;">
                                                Remaja tidak hanya berubah fisiknya saja, tetapi keadaan jiwanya juga mengalami perubahan yang dapat mempengaruhi perilaku remaja.
                                                Di satu sisi, kita mungkin merasa lebih bersemangat, kreatif, dan senang berpetualang. Namun, kadang-kadang kita juga bisa mudah marah, bosan, atau tidak peduli (cuek).
                                                Pada masa ini, kita lebih suka berkumpul dengan teman-teman daripada keluarga, ingin diakui oleh kelompok sebaya, memiliki rasa ingin tahu yang besar, 
                                                suka mencoba hal baru, dan mungkin mulai naksir atau jatuh cinta dengan lawan jenis. Semua hal ini wajar dialami, yang penting adalah memiliki jiwa yang sehat.
                                            </p>
                                        </div>
                                    </li>
                                </ul>

                                <h6>Jerawat:</h6>
                                <p class="mb-4 text-justify">
                                    Kenapa kita berjerawat? Selama pubertas, hampir semua remaja mengalami yang namanya jerawat. Jerawat adalah peradangan kronis dari kelenjar minyak yang 
                                    bisa muncul di wajah, leher, dada, punggung, dan lengan atas. Munculnya jerawat ini sangat lazim di masa pubertas karena adanya peningkatan hormon androgen 
                                    yang dapat meningkatkan produksi minyak di kulit, sehingga menyumbat pori-pori dan menimbulkan jerawat.
                                </p>

                                <div class="text-center">
                                    <img src="img/jerawat2.png" alt="Perubahan Fisik pada Perempuan" class="img-fluid img-pikiran">
                                </div>
                                
                                <h6>Perlu ke dokter nggak sih?</h6>
                                <p class="mb-4 text-justify">
                                    Jika jerawatmu meradang dan sangat mengganggu penampilanmu, sebaiknya berobat ke dokter. Selain itu, selalu bersihkan kulit wajah setelah bepergian dan sebelum tidur 
                                    untuk menjaga kebersihan kulit.
                                </p>
                                <h6>Mimpi Basah:</h6>
                                <p class="mb-4 text-justify">
                                    Apa yang perlu kita ketahui tentang mimpi basah? Mimpi basah adalah peristiwa keluarnya sperma (ejakulasi) saat tidur, sering kali terjadi ketika bermimpi tentang hubungan seksual. 
                                    Mimpi basah merupakan cara alami tubuh mengeluarkan timbunan sperma yang terbentuk terus menerus dan merupakan pengalaman yang normal. 
                                    Ketika kamu mulai mengalami mimpi basah, itu menandakan bahwa alat reproduksi kamu sudah berfungsi seperti orang dewasa dan bisa menyebabkan kehamilan pada perempuan, 
                                    bahkan jika hanya melakukan hubungan seksual satu kali.
                                </p>

                                <div class="text-center">
                                    <img src="img/mimpibasah.jpg" alt="Perubahan Fisik pada Laki-laki" class="img-fluid" style="margin-bottom: 20px;">
                                </div>

                                <p class="mb-4 text-justify">
                                    Remaja perempuan yang sudah menstruasi berisiko hamil jika melakukan hubungan seksual, dan remaja laki-laki yang telah mengalami mimpi basah sudah bisa menyebabkan 
                                    kehamilan jika melakukan hubungan seksual.
                                </p>
                            </div>
                            <button class="btn btn-link show-more">Lihat Selengkapnya</button>
                            <div class="text-center mt-4">
                                <button id="backToPrevious" class="btn btn-secondary me-2" onclick="showPage2()">Kembali</button>
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
                                <h6 class="font-weight-bold text-primary">Cek Apa Saja yang Berubah dari Dirimu!</h6>
                            </div>
                            <button class="btn btn-primary btn-lg mt-3" onclick="showPage5('laki-laki')" style="width: 100%; font-size: 17px;">
                                Kuisioner: Perubahan Diri Saya
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Halaman Keempat (Perempuan) -->
        <div id="page4" class="hidden">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <!-- Content for Page 4 (Perempuan) -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h4 class="card-title text-center">Memahami Perubahan Diriku</h4>
                            <p class="mb-4 text-justify">
                                Ketika memasuki usia remaja (10-19 tahun), kita akan mengalami usia yang disebut masa pubertas atau masa perubahan/transisi dari masa anak-anak menuju dewasa. 
                                Masa pubertas banyak melibatkan perubahan, khususnya menyangkut fisik, psikis, jiwa, dan pematangan fungsi organ reproduksi. </br>
                                </br>
                                Masa pubertas dimulai pada umur yang berbeda-beda, biasanya pada umur 10-12 tahun, tetapi ada juga yang dimulai pada usia lebih tua dari usia tersebut. 
                                Biasanya, pubertas pada anak perempuan lebih awal 1 atau 2 tahun dari anak laki-laki.
                            </p>
                            <h5 class="card-subtitle mb-3">Yuk kita kenali tanda-tanda pubertas</h5>
                            <h6>Perubahan fisik yang kita alami:</h6>

                            <div class="text-center">
                                <img src="img/puberperempuan.png" alt="Perubahan Fisik pada Perempuan" class="img-fluid">
                            </div>

                            <ul>
                                <li>Badan bertambah tinggi dan besar, pinggul melebar.</li>
                                <li>Payudara mulai membesar.</li>
                                <li>Tumbuh rambut pada ketiak dan sekitar kelamin.</li>
                                <li>Mulai berjerawat.</li>
                                <li>Mulai menstruasi.</li>
                            </ul>
                            <div class="full-text" style="display: none;">

                                <h6>Perubahan psikis yang kita alami:</h6>
                                <p class="mb-4 text-justify">
                                    Remaja tidak hanya berubah fisiknya saja, tetapi keadaan jiwanya juga mengalami perubahan yang dapat mempengaruhi perilaku remaja. 
                                    Di satu sisi, kita mungkin merasa lebih bersemangat, kreatif, dan senang berpetualang. Namun, kadang-kadang kita juga bisa mudah marah, bosan, atau tidak peduli (cuek).
                                </p>

                                <div class="text-center">
                                    <img src="img/pikiran.jpg" alt="Perubahan Fisik pada Perempuan" class="img-fluid img-pikiran">
                                </div>

                                <p class="mb-4 text-justify">
                                    Pada masa ini, kita lebih suka berkumpul dengan teman-teman daripada keluarga, ingin diakui oleh kelompok sebaya, memiliki rasa ingin tahu yang besar, 
                                    suka mencoba hal baru, dan mungkin mulai naksir atau jatuh cinta dengan lawan jenis. Semua hal ini wajar dialami, yang penting adalah memiliki jiwa yang sehat.
                                </p>

                                <h6>Jerawat:</h6>
                                <p class="mb-4 text-justify">
                                    Kenapa kita berjerawat? Selama pubertas, hampir semua remaja mengalami yang namanya jerawat. Jerawat adalah peradangan kronis dari kelenjar minyak yang 
                                    bisa muncul di wajah, leher, dada, punggung, dan lengan atas. Munculnya jerawat ini sangat lazim di masa pubertas karena adanya peningkatan hormon androgen 
                                    yang dapat meningkatkan produksi minyak di kulit, sehingga menyumbat pori-pori dan menimbulkan jerawat.
                                </p>

                                <div class="text-center">
                                    <img src="img/jerawat1.png" alt="Perubahan Fisik pada Perempuan" class="img-fluid img-pikiran">
                                </div>
                                
                                <h6>Perlu ke dokter nggak sih?</h6>
                                <p class="mb-4 text-justify">
                                    Jika jerawatmu meradang dan sangat mengganggu penampilanmu, sebaiknya berobat ke dokter. Selain itu, selalu bersihkan kulit wajah setelah bepergian dan sebelum tidur 
                                    untuk menjaga kebersihan kulit.
                                </p>
                                <h6>Menstruasi:</h6>
                                    <p class="mb-4 text-justify">Menstruasi atau haid yang pertama (menarche) adalah tanda pubertas. Menstruasi merupakan peluruhan lapisan dalam dinding rahim (endometrium) yang mengandung banyak pembuluh darah. Peristiwa ini terjadi setiap bulan, berlangsung selama 5 hingga 7 hari. Siklus menstruasi yang normal rata-rata berlangsung selama 28 hari (21-35 hari). Jika siklus menstruasi kamu tidak normal, sebaiknya tanyakan kepada tenaga kesehatan. Menstruasi umumnya akan berlangsung hingga usia 50 tahun, dan masa setelah menstruasi berhenti disebut menopause.</p>

                                    <div class="text-center">
                                        <img src="img/haid.jpg" alt="Perubahan Fisik pada Laki-laki" class="img-fluid img-haid" style="margin-bottom: 20px;">
                                    </div>

                                    <p class="mb-4 text-justify">
                                        Beberapa perempuan akan merasakan kram atau sakit selama menstruasi, yang disebut dismenore. 
                                        Untuk mengurangi rasa nyeri, kamu bisa memberikan kompres hangat pada area yang sakit, istirahat yang cukup, dan berolahraga ringan seperti berjalan. 
                                        Jika rasa nyeri sangat mengganggu, segera periksakan ke Puskesmas atau fasilitas kesehatan terdekat. Kebutuhan zat besi akan meningkat karena mengalami menstruasi. 
                                        Oleh karena itu untuk mencegah terjadinya anemia gizi besi, kamu perlu mengkonsumsi 1 tablet tambah darah/ TTD (zat besi dan asam folat) setiap hari selama menstruasi dan sekali seminggu saat tidak mienstruasi.
                                        </p>
                                    </p>
                                    <p class="mb-4 text-justify">
                                        Konsumsilah 1 tablet tambah darah setlap hari selama menstruosi dan 1 X seminggu saat tidak menstruasi
                                    </p>
                            </div>
                            <button class="btn btn-link show-more">Lihat Selengkapnya</button>                                    
                            <div class="text-center mt-4">
                                <button id="backToPreviousW" class="btn btn-secondary me-2" onclick="showPage2()">Kembali</button>
                                <button id="backToStartW" class="btn btn-secondary" onclick="showPage1()">Kembali ke Awal</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-body text-center">
                                <div class="card-header py-3">
                                    <h6 class="font-weight-bold text-primary">Cek Apa Saja yang Berubah dari Dirimu!</h6>
                                </div>
                                <button class="btn btn-primary btn-lg mt-3" onclick="showPage5('perempuan')" style="width: 100%; font-size: 17px;">
                                    Kuisioner: Perubahan Diri Saya
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <!-- Content for Page 4 (Perempuan) -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <!-- Kalender Elektronik -->
                            <div class="calendar-container">
                                <h4 class="calendar-title">Kalender Menstruasi</h4>
                                <div class="info">
                                    <label for="cycleLength">
                                        Pilih Panjang Siklus Haid (28-45 hari):
                                    </label>
                                    <select id="cycleLength" onchange="calculateCycle()">
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                        <option value="32">32</option>
                                        <option value="33">33</option>
                                        <option value="34">34</option>
                                        <option value="35">35</option>
                                        <option value="36">36</option>
                                        <option value="37">37</option>
                                        <option value="38">38</option>
                                        <option value="39">39</option>
                                        <option value="40">40</option>
                                        <option value="41">41</option>
                                        <option value="42">42</option>
                                        <option value="43">43</option>
                                        <option value="44">44</option>
                                        <option value="45">45</option>
                                    </select>
                                    </br>
                                    Klik pada tanggal di kalender untuk melihat periode menstruasi dan masa ovulasi.
                                </div>
                                <div class="calendar">
                                    <div class="calendar-header">
                                        <button onclick="prevMonth()">&#9664;</button>
                                        <h2 id="monthYear"></h2>
                                        <button onclick="nextMonth()">&#9654;</button>
                                    </div>
                                    <div class="calendar-body" id="calendar">
                                        <!-- Calendar will be dynamically generated here -->
                                    </div>
                                </div>
                                <div class="result-container">
                                    <div class="result-box">
                                        <p>Menstruasi Berikutnya</p>
                                        <p id="periodInfo"></p>
                                    </div>
                                    <div class="result-box">
                                        <p>Perkiraan Masa Ovulasi Berikutnya</p>
                                        <p id="ovulationInfo"></p>
                                    </div>
                                </div>
                            </div>
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
                            <h4 class="card-title">Kuisioner: Perubahan Diri Saya</h4>
                            <div id="questionnaire-male" class="hidden">
                                <p>Kuisioner untuk laki-laki:</p>
                                <form name="kuisionerForm1" action="submitkuisionerperubahanlaki.php" method="POST" onsubmit="return validateForm1()">
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
                                            <thead>
                                                <tr>
                                                    <th>Pertanyaan</th>
                                                    <th>Ya</th>
                                                    <th>Tidak</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Saya merasa adanya perubahan pada badan saya saat ini</td>
                                                    <td><input type="radio" name="q1" value="1"></td>
                                                    <td><input type="radio" name="q1" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>Berat badan saya bertambah setiap bulan</td>
                                                    <td><input type="radio" name="q2" value="1"></td>
                                                    <td><input type="radio" name="q2" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>Tinggi badan saya bertambah setiap bulan</td>
                                                    <td><input type="radio" name="q3" value="1"></td>
                                                    <td><input type="radio" name="q3" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>Keinginan saya untuk makan bertambah</td>
                                                    <td><input type="radio" name="q4" value="1"></td>
                                                    <td><input type="radio" name="q4" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>Jakun saya mulai tumbuh</td>
                                                    <td><input type="radio" name="q5" value="1"></td>
                                                    <td><input type="radio" name="q5" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>Tumbuh rambut di ketiak saya</td>
                                                    <td><input type="radio" name="q6" value="1"></td>
                                                    <td><input type="radio" name="q6" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>Tumbuh rambut di sekitar kemaluan</td>
                                                    <td><input type="radio" name="q7" value="1"></td>
                                                    <td><input type="radio" name="q7" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>Tumbuh rambut di kaki dan tangan</td>
                                                    <td><input type="radio" name="q8" value="1"></td>
                                                    <td><input type="radio" name="q8" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>Suara saya menjadi besar dan berat</td>
                                                    <td><input type="radio" name="q9" value="1"></td>
                                                    <td><input type="radio" name="q9" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya mengalami mimpi yang menyebabkan keluarnya cairan mani</td>
                                                    <td><input type="radio" name="q10" value="1"></td>
                                                    <td><input type="radio" name="q10" value="0"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                                    </div>
                                </form>
                            </div>
                            <div id="questionnaire-female" class="hidden">
                                <p>Kuisioner untuk perempuan:</p>
                                <form name="kuisionerForm2" action="submitkuisionerperubahanperempuan.php" method="POST" onsubmit="return validateForm2()">
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
                                            <thead>
                                                <tr>
                                                    <th>Pertanyaan</th>
                                                    <th>Ya</th>
                                                    <th>Tidak</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Saya merasa adanya perubahan pada badan saya saat ini</td>
                                                    <td><input type="radio" name="q1" value="1"></td>
                                                    <td><input type="radio" name="q1" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>Berat badan saya bertambah setiap bulan</td>
                                                    <td><input type="radio" name="q2" value="1"></td>
                                                    <td><input type="radio" name="q2" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>Tinggi badan saya bertambah setiap bulan</td>
                                                    <td><input type="radio" name="q3" value="1"></td>
                                                    <td><input type="radio" name="q3" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>Keinginan saya untuk makan bertambah</td>
                                                    <td><input type="radio" name="q4" value="1"></td>
                                                    <td><input type="radio" name="q4" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>Payudara saya mulai membesar</td>
                                                    <td><input type="radio" name="q5" value="1"></td>
                                                    <td><input type="radio" name="q5" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>Tumbuh rambut di ketiak saya</td>
                                                    <td><input type="radio" name="q6" value="1"></td>
                                                    <td><input type="radio" name="q6" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>Tumbuh rambut di sekitar kemaluan</td>
                                                    <td><input type="radio" name="q7" value="1"></td>
                                                    <td><input type="radio" name="q7" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>Suara saya menjadi lebih halus</td>
                                                    <td><input type="radio" name="q8" value="1"></td>
                                                    <td><input type="radio" name="q8" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya sudah menstruasi/haid</td>
                                                    <td><input type="radio" name="q9" value="1"></td>
                                                    <td><input type="radio" name="q9" value="0"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
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
            const form = document.forms["kuisionerForm2"];
            for (let i = 1; i <= 9; i++) {
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
        const calendar = document.getElementById('calendar');
        const monthYear = document.getElementById('monthYear');
        const periodInfo = document.getElementById('periodInfo');
        const ovulationInfo = document.getElementById('ovulationInfo');
        const cycleLengthSelect = document.getElementById('cycleLength');

        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();

        const months = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        function generateCalendar(month, year) {
            calendar.innerHTML = '';
            monthYear.innerText = `${months[month]} ${year}`;

            const daysOfWeek = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
            daysOfWeek.forEach(day => {
                const dayHeader = document.createElement('div');
                dayHeader.classList.add('day-header');
                dayHeader.innerText = day;
                calendar.appendChild(dayHeader);
            });

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            for (let i = 0; i < firstDay; i++) {
                const emptyCell = document.createElement('div');
                calendar.appendChild(emptyCell);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dayCell = document.createElement('div');
                dayCell.innerText = day;
                dayCell.onclick = () => selectDate(day, month, year);
                if (day === new Date().getDate() && month === new Date().getMonth() && year === new Date().getFullYear()) {
                    dayCell.classList.add('today');
                }
                calendar.appendChild(dayCell);
            }
        }

        function prevMonth() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            generateCalendar(currentMonth, currentYear);
        }

        function nextMonth() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            generateCalendar(currentMonth, currentYear);
        }

        function selectDate(day, month, year) {
            const cycleLength = parseInt(cycleLengthSelect.value);
            const startDate = new Date(year, month, day);
            const ovulationDate = new Date(startDate);
            ovulationDate.setDate(startDate.getDate() + cycleLength - 14);
            const nextPeriodDate = new Date(startDate);
            nextPeriodDate.setDate(startDate.getDate() + cycleLength);

            periodInfo.innerText = formatDate(nextPeriodDate);
            ovulationInfo.innerText = formatDate(ovulationDate);
        }

        function formatDate(date) {
            const day = date.getDate();
            const month = months[date.getMonth()];
            const year = date.getFullYear();
            return `${day} ${month} ${year}`;
        }

        document.addEventListener('DOMContentLoaded', () => {
            generateCalendar(currentMonth, currentYear);
        });
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
