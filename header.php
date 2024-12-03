<?php
include 'init.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Mengakses data sesi
$username = $_SESSION['username'];
$role = $_SESSION['role'];

// Query untuk mendapatkan nama sekolah berdasarkan peran pengguna
if ($role == 'admin' || $role == 'pengurus') {
    $sql = "SELECT tbsekolah.namasekolah 
            FROM tbuser 
            JOIN tbsekolah ON tbuser.asalsekolah = tbsekolah.idsekolah 
            WHERE tbuser.username = ?";
} elseif ($role == 'siswa') {
    $sql = "SELECT tbsekolah.namasekolah 
            FROM tbusersiswa 
            JOIN tbsiswa ON tbusersiswa.idsiswa = tbsiswa.idsiswa 
            JOIN tbsekolah ON tbsiswa.asalsekolah = tbsekolah.idsekolah 
            WHERE tbusersiswa.username = ?";
}

// Siapkan pernyataan
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Ambil data
if ($row = $result->fetch_assoc()) {
    $namasekolah = $row['namasekolah'];
} else {
    $namasekolah = 'Not available';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SEJATI</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src='fullcalendar/dist/index.global.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<style>
    /* Mengatasi overflow */
.container {
  overflow-x: hidden; /* Sembunyikan overflow horizontal */
}

.table-responsive {
  overflow-x: auto; /* Tambahkan scroll horizontal jika diperlukan */
}

    /* Ukuran font tabel untuk perangkat mobile */
@media (max-width: 768px) {
  .table {
    font-size: 0.875rem; /* Sesuaikan ukuran font sesuai kebutuhan */
    width: 100%;
  }
  .table th, .table td {
    padding: 0.5rem; /* Sesuaikan padding agar tabel tidak melebihi container */
  }

  .table th, .table td {
    word-wrap: break-word; /* Memastikan teks dalam sel tabel tidak melampaui batas */
  }
  /* Pastikan margin dan padding cukup untuk menyesuaikan dengan sidebar */
  .main-content {
    margin-left: 0; /* Atur margin untuk tampilan mobile */
  }
  .card-body .text-center img {
    width: 10rem; /* Sesuaikan ukuran gambar pada tampilan mobile */
  }
}

/* Ukuran font tabel yang lebih kecil untuk perangkat dengan lebar layar hingga 375px (termasuk iPhone SE) */
@media (max-width: 375px) {
  .table {
    font-size: 0.75rem; /* Ukuran font lebih kecil */
    width: 100%;
  }
  .table th, .table td {
    padding: 0.3rem; /* Padding lebih kecil untuk mengurangi ukuran tabel */
  }

  .table th, .table td {
    word-wrap: break-word; /* Memastikan teks dalam sel tabel tidak melampaui batas */
  }
  
  .main-content {
    margin-left: 0; /* Margin untuk menyesuaikan tampilan mobile */
  }

  /* Sesuaikan ukuran font umum untuk seluruh halaman */
  body {
    font-size: 0.875rem; /* Ukuran font umum lebih kecil */
  }

  /* Sesuaikan ukuran heading jika diperlukan */
  h1, h2, h3, h4, h5, h6 {
    font-size: 90%; /* Kurangi ukuran font heading */
  }

  /* Sesuaikan margin dan padding dari elemen lain jika diperlukan */
  .container, .content {
    padding: 0.5rem; /* Padding lebih kecil untuk container */
  }

  /* Ukuran font dan padding pada tombol */
  button, .btn {
    font-size: 0.75rem !important; /* Ukuran font tombol lebih kecil */
    padding: 0.4rem 0.8rem; /* Padding tombol lebih kecil */
  }

  button.btn.gender-box {
    font-size: 0.75rem !important; /* Ukuran font tombol lebih kecil */
    padding: 0.4rem 0.8rem !important; /* Padding tombol lebih kecil */
  }

  /* Mengatur ukuran font pada elemen label, select, dan option */
  label, select, select option {
    font-size: 0.75rem; /* Ukuran font lebih kecil */
  }

  /* Jika diperlukan, kurangi padding dan margin */
  .form-control {
    padding: 0.3rem 0.6rem; /* Padding lebih kecil pada elemen form-control */
    margin-bottom: 0.5rem;  /* Margin bawah lebih kecil */
  }

  /* Nonaktifkan gaya bawaan di iOS */
  select {
    -webkit-appearance: none; /* Menonaktifkan gaya bawaan */
    appearance: none;
  }

  /* Atur ukuran font secara lebih eksplisit */
  select {
    font-size: 0.75rem !important; /* Gunakan !important jika perlu */
  }
}

</style>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
