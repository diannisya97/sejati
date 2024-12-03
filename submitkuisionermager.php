<?php
include 'header.php';

// Ambil idusersiswa dari POST (admin/pengurus) atau session (siswa)
$idusersiswa = intval($_POST['idusersiswa']);
$aktivitasberat = isset($_POST['aktivitasberat']) ? $_POST['aktivitasberat'] : '';
$hariberat = isset($_POST['hariberat']) ? intval($_POST['hariberat']) : 0;
$jamberat = isset($_POST['jamberat']) ? intval($_POST['jamberat']) : 0;
$menitberat = isset($_POST['menitberat']) ? intval($_POST['menitberat']) : 0;

$aktivitassedang = isset($_POST['aktivitassedang']) ? $_POST['aktivitassedang'] : '';
$harisedang = isset($_POST['harisedang']) ? intval($_POST['harisedang']) : 0;
$jamsedang = isset($_POST['jamsedang']) ? intval($_POST['jamsedang']) : 0;
$menitsedang = isset($_POST['menitsedang']) ? intval($_POST['menitsedang']) : 0;

$jalansepeda = isset($_POST['jalansepeda']) ? $_POST['jalansepeda'] : '';
$hariberjalan = isset($_POST['hariberjalan']) ? intval($_POST['hariberjalan']) : 0;
$jamberjalan = isset($_POST['jamberjalan']) ? intval($_POST['jamberjalan']) : 0;
$menitberjalan = isset($_POST['menitberjalan']) ? intval($_POST['menitberjalan']) : 0;

$olahragaberat = isset($_POST['olahragaberat']) ? $_POST['olahragaberat'] : '';
$hariberatolahraga = isset($_POST['hariberatolahraga']) ? intval($_POST['hariberatolahraga']) : 0;
$jamberatolahraga = isset($_POST['jamberatolahraga']) ? intval($_POST['jamberatolahraga']) : 0;
$menitberatolahraga = isset($_POST['menitberatolahraga']) ? intval($_POST['menitberatolahraga']) : 0;

$olahragasedang = isset($_POST['olahragasedang']) ? $_POST['olahragasedang'] : '';
$harisedangolahraga = isset($_POST['harisedangolahraga']) ? intval($_POST['harisedangolahraga']) : 0;
$jamsedangolahraga = isset($_POST['jamsedangolahraga']) ? intval($_POST['jamsedangolahraga']) : 0;
$menitsedangolahraga = isset($_POST['menitsedangolahraga']) ? intval($_POST['menitsedangolahraga']) : 0;

$waktududuk = isset($_POST['waktududuk']) ? intval($_POST['waktududuk']) : 0;
$menitduduk = isset($_POST['menitduduk']) ? intval($_POST['menitduduk']) : 0;

// Query untuk memasukkan data ke dalam tabel kuisionermager
$sql = "INSERT INTO kuisionermager (idusersiswa, aktivitasberat, hariberat, jamberat, menitberat, aktivitassedang, 
harisedang, jamsedang, menitsedang, jalansepeda, hariberjalan, jamberjalan, menitberjalan, olahragaberat, hariberatolahraga, 
jamberatolahraga, menitberatolahraga, olahragasedang, harisedangolahraga, jamsedangolahraga, menitsedangolahraga, waktududuk, menitduduk) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

// Periksa jika prepare() gagal
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Perbaiki tipe data dalam bind_param
$stmt->bind_param("isiiisiiisiiisiiisiiiii", $idusersiswa, $aktivitasberat, $hariberat, $jamberat, $menitberat, $aktivitassedang, 
                 $harisedang, $jamsedang, $menitsedang, $jalansepeda, $hariberjalan, $jamberjalan, $menitberjalan, $olahragaberat, 
                 $hariberatolahraga, $jamberatolahraga, $menitberatolahraga, $olahragasedang, $harisedangolahraga, $jamsedangolahraga, 
                 $menitsedangolahraga, $waktududuk, $menitduduk);

// Eksekusi query dan cek keberhasilan
if ($stmt->execute()) {
    echo "<script>alert('Data berhasil disimpan.'); window.location.href='olahraga.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


// Tutup koneksi
$stmt->close();
$conn->close();
?>
