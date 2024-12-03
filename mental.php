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
.text-center img {
  max-width: 50%; /* Ukuran gambar tetap kecil pada layar desktop */
  height: auto;   /* Pertahankan rasio aspek gambar */
  border-radius: 5%; /* Penambahan radius untuk sudut */
}

/* Style default untuk tampilan desktop */
ul.text-justify img {
  max-width: 20%; /* Ukuran gambar tetap kecil pada layar desktop */
  height: auto;   /* Pertahankan rasio aspek gambar */
  border-radius: 5%; /* Penambahan radius untuk sudut */
  margin-top: 20px;
  margin-right: 20px;
}

@media (max-width: 768px) {
  ul.text-justify li {
    flex-direction: column; /* Susunan vertikal pada layar kecil */
    align-items: center;
  }
  
  ul.text-justify img {
    max-width: 50%; /* Perbesar gambar di layar kecil, bisa diatur sesuai keinginan */
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
                            <h4 class="m-0 font-weight-bold text-primary">Aku dan Kesehatan Mentalku</h4>
                        </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 18rem;"
                                        src="img/mentallaki.png" alt="">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 18rem;"
                                        src="img/otak.png" alt="">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 18rem;"
                                        src="img/mentalperempuan.png" alt="">
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
                            <h4 class="card-title text-center">Aku dan Kesehatan Mentalku</h4>

                            <div class="text-center mb-3">
                                <img src="img/mental.webp" alt="Penerimaan Diri" class="img-fluid">
                            </div>

                            <h5 class="card-title mt-4">Menerima Diri dan Orang Lain</h5>
                            <p>Pada masa pubertas terjadi perubahan psikis/jiwa di mana emosi kita seringkali berubah dan kita juga sedang mencari jati diri. Nah, supaya kita dapat menghadapinya, tentunya kita harus mempunyai jiwa yang sehat. Apa sih yang harus kita lakukan supaya punya jiwa yang sehat?</p>
                            
                            <h5 class="card-title mt-4">Bisa Menerima Diri Apa Adanya</h5>
                            <p>Mengenal dan menerima diri sendiri merupakan langkah awal dalam membentuk harga diri yang positif. Terima diri apa adanya, kenali dan maksimalkan potensi/kekuatan, dan coba perbaiki kelemahan.</p>
                            <p>Jika kita bangga dan percaya pada diri sendiri, maka kita dapat dikatakan memiliki harga diri yang tinggi. Kita akan merasa lebih nyaman terhadap diri sendiri.</p>
                            
                            <h5 class="card-title mt-4">Bisa Menerima Orang Lain Apa Adanya</h5>
                            <ul class="text-justify">
                                <li style="display: flex; align-items: flex-start; gap: 15px;">
                                    <img src="img/tentram.jpg" alt="Penerimaan Diri" class="img-fluid">
                                    <div>
                                        <strong>Bisa Menerima Orang Lain Apa Adanya:</strong>
                                        <p style="margin: 0;">
                                            Ketika kita mampu mencintai dan menerima cinta orang lain serta mampu mempercayai orang lain, menghargai pendapat orang lain, merasa bahwa kita adalah bagian dari kelompok, dan tidak berbuat curang terhadap diri sendiri dan orang lain, maka kita adalah remaja yang bisa menerima orang lain apa adanya.
                                        </p>
                                    </div>
                                </li>
                            </ul>

                            <div class="full-text" style="display: none;">
                                <h5 class="card-title mt-4">Bisa Mengendalikan Emosi</h5>
                                    <p>Berikut beberapa langkah agar kita bisa mengendalikan emosi:</p>
                                    <ul>
                                        <li>Kenali perasaan apakah kita sedang marah, takut, sedih, iri, cemas, senang, dan lain-lain pada setiap situasi.</li>
                                        <li>Coba untuk mengerti apa yang menyebabkan perasaan tersebut.</li>
                                        <li>Perhatikan apa yang biasa kita lakukan terhadap orang lain dan diri sendiri ketika timbul perasaan tersebut. Ketahuilah kemampuan dan keterbatasan dalam menghadapi situasi tersebut.</li>
                                        <li>Kenali bagaimana cara kita ketika menghadapi masalah dan perasaan, apakah berhasil atau tidak.</li>
                                        <li>Cari cara positif untuk mengatasi masalah.</li>
                                        <li>Bila hasilnya tidak memuaskan, cari cara lain.</li>
                                    </ul>
                                    
                                <h5 class="card-title mt-4">Mampu Mengatasi Stres dan Menyelesaikan Masalah dengan Baik</h5>
                                    <p>Tips agar dapat menyelesaikan stres dengan baik:</p>
                                    <ul>
                                        <li>Jaga kesehatan.</li>
                                        <li>Rencanakan masa depan dengan baik.</li>
                                        <li>Hindari membuat keputusan besar sekaligus.</li>
                                        <li>Ubahlah sesuatu yang dapat diubah, terimalah sesuatu yang tidak dapat diubah.</li>
                                        <li>Berbuatlah sesuai dengan minat dan kemampuan.</li>
                                        <li>Berpikir positif.</li>
                                        <li>Bersantai dan menenangkan pikiran dengan melakukan relaksasi selama 10-15 menit.</li>
                                        <li>Jika kita stres, lakukan pekerjaan yang disenangi, atau curhat dengan orang yang kita percaya dan dianggap bisa membantu kita.</li>
                                    </ul>

                                <h5 class="card-title mt-4">Harga Diri</h5>
                                    <p>Dengan meningkatnya rasa hormat terhadap diri sendiri, maka secara keseluruhan akan meningkatkan rasa kebanggaan dalam diri.</p>

                                    <h5 class="card-title mt-4">Membangun Harga Diri</h5>
                                    <p>Dalam hidup ini, tentunya kita sering mengalami berbagai tantangan. Apalagi di masa remaja, ada tantangan di sekolah, tempat bermain, bahkan di rumah. Untuk mampu menghadapi tantangan hidup, kita harus mempunyai harga diri. Harga diri adalah cara kita menilai diri sendiri yang berkaitan dengan cara berpikir, merasakan, dan bertindak. Harga diri merupakan kombinasi dari percaya diri, menghargai diri sendiri, serta mampu mengatasi tantangan hidup.</p>

                                    <div class="text-center mb-3">
                                        <img src="img/bintang.jpg" alt="Ilustrasi Harga diri" class="img-fluid">
                                    </div>

                                    <p>Harga diri sangat diperlukan untuk membentuk jiwa yang sehat dan perilaku yang positif, sehingga kita dapat menghadapi tantangan hidup, termasuk menolak godaan untuk melakukan perilaku berisiko.</p>

                                <h5 class="card-title mt-4">Bagaimana Sih Membangun Harga Diri?</h5>
                                    <ul>
                                        <li>Mengenal diri sendiri: Ini perlu dilakukan untuk mengetahui apa kelebihan dan kekurangan kita. Untuk membantu, kita bisa membuat daftar kelebihan dan kekurangan kita di selembar kertas.</li>
                                        <li>Menerima diri kita: Setelah kita mengetahui kekurangan dan kelebihan kita, belajarlah untuk menerimanya. Apabila ada hal-hal yang bisa diperbaiki, perbaikilah. Tetapi apabila tidak mungkin diperbaiki, terimalah dengan ikhlas dan yakinlah bahwa kita masih memiliki banyak kelebihan.</li>
                                        <li>Kalau sudah menerima diri kita apa adanya, percayalah diri... tidak perlu minder untuk berteman dengan siapa saja dan ikut berbagai kegiatan positif karena kita yakin kita mampu, misalnya mengikuti paskibraka, band, kursus, bela diri, modeling.</li>
                                    </ul>

                                    <p>Kita Tidak Dapat Menyukai Orang Lain Jika Kita Tidak Menyukai Diri Kita Sendiri Terlebih Dahulu, dan Orang Lain Pun Tidak Akan Menyukai Kita.</p>
                                    <p>Mengenali dan Menerima Diri Sendiri Merupakan Kunci Dalam Membentuk Harga Diri yang Positif.</p>
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
                                <h6 class="font-weight-bold text-primary">Cek Seberapa Sehatnya Mentalmu!</h6>
                            </div>
                            <button class="btn btn-primary btn-lg mt-3" onclick="showPage5('laki-laki')" style="width: 100%; font-size: 17px;">
                                Kuisioner: Seberapa Sehatkah Mentalku?
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
                    <!-- Content for Page 3 (Perempuan) -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h4 class="card-title text-center">Aku dan Kesehatan Mentalku</h4>

                            <div class="text-center mb-3">
                                <img src="img/mental.webp" alt="Penerimaan Diri" class="img-fluid">
                            </div>

                            <h5 class="card-title mt-4">Menerima Diri dan Orang Lain</h5>
                            <p>Pada masa pubertas terjadi perubahan psikis/jiwa di mana emosi kita seringkali berubah dan kita juga sedang mencari jati diri. Nah, supaya kita dapat menghadapinya, tentunya kita harus mempunyai jiwa yang sehat. Apa sih yang harus kita lakukan supaya punya jiwa yang sehat?</p>
                            
                            <h5 class="card-title mt-4">Bisa Menerima Diri Apa Adanya</h5>
                            <p>Mengenal dan menerima diri sendiri merupakan langkah awal dalam membentuk harga diri yang positif. Terima diri apa adanya, kenali dan maksimalkan potensi/kekuatan, dan coba perbaiki kelemahan.</p>
                            <p>Jika kita bangga dan percaya pada diri sendiri, maka kita dapat dikatakan memiliki harga diri yang tinggi. Kita akan merasa lebih nyaman terhadap diri sendiri.</p>
                            
                            <h5 class="card-title mt-4">Bisa Menerima Orang Lain Apa Adanya</h5>
                            <ul class="text-justify">
                                <li style="display: flex; align-items: flex-start; gap: 15px;">
                                    <img src="img/tentram.jpg" alt="Penerimaan Diri" class="img-fluid">
                                    <div>
                                        <strong>Bisa Menerima Orang Lain Apa Adanya:</strong>
                                        <p style="margin: 0;">
                                            Ketika kita mampu mencintai dan menerima cinta orang lain serta mampu mempercayai orang lain, menghargai pendapat orang lain, merasa bahwa kita adalah bagian dari kelompok, dan tidak berbuat curang terhadap diri sendiri dan orang lain, maka kita adalah remaja yang bisa menerima orang lain apa adanya.
                                        </p>
                                    </div>
                                </li>
                            </ul>

                            <div class="full-text" style="display: none;">
                                <h5 class="card-title mt-4">Bisa Mengendalikan Emosi</h5>
                                    <p>Berikut beberapa langkah agar kita bisa mengendalikan emosi:</p>
                                    <ul>
                                        <li>Kenali perasaan apakah kita sedang marah, takut, sedih, iri, cemas, senang, dan lain-lain pada setiap situasi.</li>
                                        <li>Coba untuk mengerti apa yang menyebabkan perasaan tersebut.</li>
                                        <li>Perhatikan apa yang biasa kita lakukan terhadap orang lain dan diri sendiri ketika timbul perasaan tersebut. Ketahuilah kemampuan dan keterbatasan dalam menghadapi situasi tersebut.</li>
                                        <li>Kenali bagaimana cara kita ketika menghadapi masalah dan perasaan, apakah berhasil atau tidak.</li>
                                        <li>Cari cara positif untuk mengatasi masalah.</li>
                                        <li>Bila hasilnya tidak memuaskan, cari cara lain.</li>
                                    </ul>
                                    
                                <h5 class="card-title mt-4">Mampu Mengatasi Stres dan Menyelesaikan Masalah dengan Baik</h5>
                                    <p>Tips agar dapat menyelesaikan stres dengan baik:</p>
                                    <ul>
                                        <li>Jaga kesehatan.</li>
                                        <li>Rencanakan masa depan dengan baik.</li>
                                        <li>Hindari membuat keputusan besar sekaligus.</li>
                                        <li>Ubahlah sesuatu yang dapat diubah, terimalah sesuatu yang tidak dapat diubah.</li>
                                        <li>Berbuatlah sesuai dengan minat dan kemampuan.</li>
                                        <li>Berpikir positif.</li>
                                        <li>Bersantai dan menenangkan pikiran dengan melakukan relaksasi selama 10-15 menit.</li>
                                        <li>Jika kita stres, lakukan pekerjaan yang disenangi, atau curhat dengan orang yang kita percaya dan dianggap bisa membantu kita.</li>
                                    </ul>
                                    
                                <h5 class="card-title mt-4">Harga Diri</h5>
                                    <p>Dengan meningkatnya rasa hormat terhadap diri sendiri, maka secara keseluruhan akan meningkatkan rasa kebanggaan dalam diri.</p>

                                    <h5 class="card-title mt-4">Membangun Harga Diri</h5>
                                    <p>Dalam hidup ini, tentunya kita sering mengalami berbagai tantangan. Apalagi di masa remaja, ada tantangan di sekolah, tempat bermain, bahkan di rumah. Untuk mampu menghadapi tantangan hidup, kita harus mempunyai harga diri. Harga diri adalah cara kita menilai diri sendiri yang berkaitan dengan cara berpikir, merasakan, dan bertindak. Harga diri merupakan kombinasi dari percaya diri, menghargai diri sendiri, serta mampu mengatasi tantangan hidup.</p>

                                    <div class="text-center mb-3">
                                        <img src="img/bintang.jpg" alt="Ilustrasi Harga diri" class="img-fluid">
                                    </div>
                                    
                                    <p>Harga diri sangat diperlukan untuk membentuk jiwa yang sehat dan perilaku yang positif, sehingga kita dapat menghadapi tantangan hidup, termasuk menolak godaan untuk melakukan perilaku berisiko.</p>

                                <h5 class="card-title mt-4">Bagaimana Sih Membangun Harga Diri?</h5>
                                    <ul>
                                        <li>Mengenal diri sendiri: Ini perlu dilakukan untuk mengetahui apa kelebihan dan kekurangan kita. Untuk membantu, kita bisa membuat daftar kelebihan dan kekurangan kita di selembar kertas.</li>
                                        <li>Menerima diri kita: Setelah kita mengetahui kekurangan dan kelebihan kita, belajarlah untuk menerimanya. Apabila ada hal-hal yang bisa diperbaiki, perbaikilah. Tetapi apabila tidak mungkin diperbaiki, terimalah dengan ikhlas dan yakinlah bahwa kita masih memiliki banyak kelebihan.</li>
                                        <li>Kalau sudah menerima diri kita apa adanya, percayalah diri... tidak perlu minder untuk berteman dengan siapa saja dan ikut berbagai kegiatan positif karena kita yakin kita mampu, misalnya mengikuti paskibraka, band, kursus, bela diri, modeling.</li>
                                    </ul>

                                    <p>Kita Tidak Dapat Menyukai Orang Lain Jika Kita Tidak Menyukai Diri Kita Sendiri Terlebih Dahulu, dan Orang Lain Pun Tidak Akan Menyukai Kita.</p>
                                    <p>Mengenali dan Menerima Diri Sendiri Merupakan Kunci Dalam Membentuk Harga Diri yang Positif.</p>
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
                                <h6 class="font-weight-bold text-primary">Cek Seberapa Sehatnya Mentalmu!</h6>
                            </div>
                            <button class="btn btn-primary btn-lg mt-3" onclick="showPage5('perempuan')" style="width: 100%; font-size: 17px;">
                                Kuisioner: Seberapa Sehatkah Mentalku?
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
                            <h4 class="card-title">Kuisioner: Seberapa Sehatkah Mentalku?</h4>
                            <div id="questionnaire-male" class="hidden">
                                <p>Selama 2 minggu terakhir, seberapa sering kamu merasakan hal-hal di bawah ini?</p>
                                <form name="kuisionerForm1" action="submitkuisionermental.php" method="post" onsubmit="return validateForm1()">
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
                                                    <th>Tidak Pernah</th>
                                                    <th>Beberapa Hari</th>
                                                    <th>Hampir Setiap Hari</th>
                                                    <th>Setiap Hari</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Saya merasa malas melakukan aktivitas seperti biasanya</td>
                                                    <td><input type="radio" name="q1" value="0"></td>
                                                    <td><input type="radio" name="q1" value="1"></td>
                                                    <td><input type="radio" name="q1" value="2"></td>
                                                    <td><input type="radio" name="q1" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Merasa putus asa, menyerah dan kehilangan harapan</td>
                                                    <td><input type="radio" name="q2" value="0"></td>
                                                    <td><input type="radio" name="q2" value="1"></td>
                                                    <td><input type="radio" name="q2" value="2"></td>
                                                    <td><input type="radio" name="q2" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya merasa lelah atau sulit bangun</td>
                                                    <td><input type="radio" name="q3" value="0"></td>
                                                    <td><input type="radio" name="q3" value="1"></td>
                                                    <td><input type="radio" name="q3" value="2"></td>
                                                    <td><input type="radio" name="q3" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya merasa terlalu banyak tidur</td>
                                                    <td><input type="radio" name="q4" value="0"></td>
                                                    <td><input type="radio" name="q4" value="1"></td>
                                                    <td><input type="radio" name="q4" value="2"></td>
                                                    <td><input type="radio" name="q4" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya merasa lelah dan lemas</td>
                                                    <td><input type="radio" name="q5" value="0"></td>
                                                    <td><input type="radio" name="q5" value="1"></td>
                                                    <td><input type="radio" name="q5" value="2"></td>
                                                    <td><input type="radio" name="q5" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya kehilangan nafsu makan</td>
                                                    <td><input type="radio" name="q6" value="0"></td>
                                                    <td><input type="radio" name="q6" value="1"></td>
                                                    <td><input type="radio" name="q6" value="2"></td>
                                                    <td><input type="radio" name="q6" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya membenci diri saya sendiri</td>
                                                    <td><input type="radio" name="q7" value="0"></td>
                                                    <td><input type="radio" name="q7" value="1"></td>
                                                    <td><input type="radio" name="q7" value="2"></td>
                                                    <td><input type="radio" name="q7" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya merasa menjadi pribadi yang gagal</td>
                                                    <td><input type="radio" name="q8" value="0"></td>
                                                    <td><input type="radio" name="q8" value="1"></td>
                                                    <td><input type="radio" name="q8" value="2"></td>
                                                    <td><input type="radio" name="q8" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya merasa kesulitan untuk berkonsentrasi saat melakukan aktivitas</td>
                                                    <td><input type="radio" name="q9" value="0"></td>
                                                    <td><input type="radio" name="q9" value="1"></td>
                                                    <td><input type="radio" name="q9" value="2"></td>
                                                    <td><input type="radio" name="q9" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Teman-teman menganggap bicara saya terlalu lambat</td>
                                                    <td><input type="radio" name="q10" value="0"></td>
                                                    <td><input type="radio" name="q10" value="1"></td>
                                                    <td><input type="radio" name="q10" value="2"></td>
                                                    <td><input type="radio" name="q10" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Teman-teman menilai saya bergerak terlalu lambat</td>
                                                    <td><input type="radio" name="q11" value="0"></td>
                                                    <td><input type="radio" name="q11" value="1"></td>
                                                    <td><input type="radio" name="q11" value="2"></td>
                                                    <td><input type="radio" name="q11" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Teman-teman menganggap saya berbicara terlalu cepat</td>
                                                    <td><input type="radio" name="q12" value="0"></td>
                                                    <td><input type="radio" name="q12" value="1"></td>
                                                    <td><input type="radio" name="q12" value="2"></td>
                                                    <td><input type="radio" name="q12" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Teman-teman menilai saya sering bergerak spontan karena kaget</td>
                                                    <td><input type="radio" name="q13" value="0"></td>
                                                    <td><input type="radio" name="q13" value="1"></td>
                                                    <td><input type="radio" name="q13" value="2"></td>
                                                    <td><input type="radio" name="q13" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya merasa lebih lega saat menyakiti diri sendiri</td>
                                                    <td><input type="radio" name="q14" value="0"></td>
                                                    <td><input type="radio" name="q14" value="1"></td>
                                                    <td><input type="radio" name="q14" value="2"></td>
                                                    <td><input type="radio" name="q14" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya merasa lebih baik jika mati</td>
                                                    <td><input type="radio" name="q15" value="0"></td>
                                                    <td><input type="radio" name="q15" value="1"></td>
                                                    <td><input type="radio" name="q15" value="2"></td>
                                                    <td><input type="radio" name="q15" value="3"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>                                
                                    <div class="text-right mb-2 mt-2">
                                        <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                                    </div>
                                </form>
                            </div>
                            <div id="questionnaire-female" class="hidden">
                                <p>Selama 2 minggu terakhir, seberapa sering kamu merasakan hal-hal di bawah ini?</p>
                                <form name="kuisionerForm2" action="submitkuisionermental.php" method="post" onsubmit="return validateForm2()">
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
                                                    <th>Tidak Pernah</th>
                                                    <th>Beberapa Hari</th>
                                                    <th>Hampir Setiap Hari</th>
                                                    <th>Setiap Hari</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Saya merasa malas melakukan aktivitas seperti biasanya</td>
                                                    <td><input type="radio" name="q1" value="0"></td>
                                                    <td><input type="radio" name="q1" value="1"></td>
                                                    <td><input type="radio" name="q1" value="2"></td>
                                                    <td><input type="radio" name="q1" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Merasa putus asa, menyerah dan kehilangan harapan</td>
                                                    <td><input type="radio" name="q2" value="0"></td>
                                                    <td><input type="radio" name="q2" value="1"></td>
                                                    <td><input type="radio" name="q2" value="2"></td>
                                                    <td><input type="radio" name="q2" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya merasa lelah atau sulit bangun</td>
                                                    <td><input type="radio" name="q3" value="0"></td>
                                                    <td><input type="radio" name="q3" value="1"></td>
                                                    <td><input type="radio" name="q3" value="2"></td>
                                                    <td><input type="radio" name="q3" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya merasa terlalu banyak tidur</td>
                                                    <td><input type="radio" name="q4" value="0"></td>
                                                    <td><input type="radio" name="q4" value="1"></td>
                                                    <td><input type="radio" name="q4" value="2"></td>
                                                    <td><input type="radio" name="q4" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya merasa lelah dan lemas</td>
                                                    <td><input type="radio" name="q5" value="0"></td>
                                                    <td><input type="radio" name="q5" value="1"></td>
                                                    <td><input type="radio" name="q5" value="2"></td>
                                                    <td><input type="radio" name="q5" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya kehilangan nafsu makan</td>
                                                    <td><input type="radio" name="q6" value="0"></td>
                                                    <td><input type="radio" name="q6" value="1"></td>
                                                    <td><input type="radio" name="q6" value="2"></td>
                                                    <td><input type="radio" name="q6" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya membenci diri saya sendiri</td>
                                                    <td><input type="radio" name="q7" value="0"></td>
                                                    <td><input type="radio" name="q7" value="1"></td>
                                                    <td><input type="radio" name="q7" value="2"></td>
                                                    <td><input type="radio" name="q7" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya merasa menjadi pribadi yang gagal</td>
                                                    <td><input type="radio" name="q8" value="0"></td>
                                                    <td><input type="radio" name="q8" value="1"></td>
                                                    <td><input type="radio" name="q8" value="2"></td>
                                                    <td><input type="radio" name="q8" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya merasa kesulitan untuk berkonsentrasi saat melakukan aktivitas</td>
                                                    <td><input type="radio" name="q9" value="0"></td>
                                                    <td><input type="radio" name="q9" value="1"></td>
                                                    <td><input type="radio" name="q9" value="2"></td>
                                                    <td><input type="radio" name="q9" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Teman-teman menganggap bicara saya terlalu lambat</td>
                                                    <td><input type="radio" name="q10" value="0"></td>
                                                    <td><input type="radio" name="q10" value="1"></td>
                                                    <td><input type="radio" name="q10" value="2"></td>
                                                    <td><input type="radio" name="q10" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Teman-teman menilai saya bergerak terlalu lambat</td>
                                                    <td><input type="radio" name="q11" value="0"></td>
                                                    <td><input type="radio" name="q11" value="1"></td>
                                                    <td><input type="radio" name="q11" value="2"></td>
                                                    <td><input type="radio" name="q11" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Teman-teman menganggap saya berbicara terlalu cepat</td>
                                                    <td><input type="radio" name="q12" value="0"></td>
                                                    <td><input type="radio" name="q12" value="1"></td>
                                                    <td><input type="radio" name="q12" value="2"></td>
                                                    <td><input type="radio" name="q12" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Teman-teman menilai saya sering bergerak spontan karena kaget</td>
                                                    <td><input type="radio" name="q13" value="0"></td>
                                                    <td><input type="radio" name="q13" value="1"></td>
                                                    <td><input type="radio" name="q13" value="2"></td>
                                                    <td><input type="radio" name="q13" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya merasa lebih lega saat menyakiti diri sendiri</td>
                                                    <td><input type="radio" name="q14" value="0"></td>
                                                    <td><input type="radio" name="q14" value="1"></td>
                                                    <td><input type="radio" name="q14" value="2"></td>
                                                    <td><input type="radio" name="q14" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>Saya merasa lebih baik jika mati</td>
                                                    <td><input type="radio" name="q15" value="0"></td>
                                                    <td><input type="radio" name="q15" value="1"></td>
                                                    <td><input type="radio" name="q15" value="2"></td>
                                                    <td><input type="radio" name="q15" value="3"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>                                
                                    <div class="text-right mt-2 mb-2">
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
            for (let i = 1; i <= 15; i++) {
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
            for (let i = 1; i <= 15; i++) {
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
