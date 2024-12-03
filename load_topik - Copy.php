<?php
include 'init.php'; // Include file koneksi database dan session


if (isset($_GET['kategori']) && isset($_GET['gender'])) {
    $kategori = isset($_GET['kategori']) ? urlencode($_GET['kategori']) : '';
    $gender = isset($_GET['gender']) ? urlencode($_GET['gender']) : '';
} elseif (isset($_GET['kategoriperempuan']) && isset($_GET['gender'])) {
    $kategori = isset($_GET['kategoriperempuan']) ? urlencode($_GET['kategoriperempuan']) : '';
    $gender = isset($_GET['gender']) ? urlencode($_GET['gender']) : '';
} else {
    echo "Kategori atau gender tidak valid.";
    exit;
}

    
if ($gender === 'laki-laki') {
    $stmt = $conn->prepare("SELECT t.idtopik, t.isitopik, t.tanggal, 
        CASE 
            WHEN t.iduser IS NOT NULL THEN u.username 
            WHEN t.idusersiswa IS NOT NULL THEN s.username 
        END as username,
        t.iduser,
        t.idusersiswa,
        si.asalsekolah, -- Assuming si is the alias for tbsiswa
        sc.namasekolah, -- Assuming tbsekolah has a column named namasekolah
        (SELECT COUNT(*) FROM komentar WHERE idtopik = t.idtopik) AS jumlah_komentar
    FROM topik t
    LEFT JOIN tbuser u ON t.iduser = u.iduser
    LEFT JOIN tbusersiswa s ON t.idusersiswa = s.idusersiswa
    LEFT JOIN tbsiswa si ON s.idusersiswa = si.idsiswa -- Join tbsiswa to get asalsekolah
    LEFT JOIN tbsekolah sc ON si.asalsekolah = sc.idsekolah -- Join tbsekolah to get namasekolah
    WHERE t.kategori = ?
    ORDER BY t.tanggal DESC");
} else {
    $stmt = $conn->prepare("SELECT tp.idtopikperempuan, tp.isitopikperempuan, tp.tanggal, 
        CASE 
            WHEN tp.iduser IS NOT NULL THEN u.username 
            WHEN tp.idusersiswa IS NOT NULL THEN s.username 
        END as username,
        tp.iduser,
        tp.idusersiswa,
        si.asalsekolah,
        sc.namasekolah,
        (SELECT COUNT(*) FROM komentarperempuan WHERE idtopikperempuan = tp.idtopikperempuan) AS jumlah_komentar
    FROM topikperempuan tp
    LEFT JOIN tbuser u ON tp.iduser = u.iduser
    LEFT JOIN tbusersiswa s ON tp.idusersiswa = s.idusersiswa
    LEFT JOIN tbsiswa si ON s.idusersiswa = si.idsiswa -- Join tbsiswa to get asalsekolah
    LEFT JOIN tbsekolah sc ON si.asalsekolah = sc.idsekolah -- Join tbsekolah to get namasekolah
    WHERE tp.kategoriperempuan = ?
    ORDER BY tp.tanggal DESC");
}
    $stmt->bind_param("s", $kategori);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Kode untuk menampilkan topik
if ($gender === 'laki-laki') {
    // Menampilkan topik laki-laki
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $isitopik = nl2br(htmlspecialchars($row['isitopik'], ENT_QUOTES, 'UTF-8'));
            $idtopik = htmlspecialchars($row['idtopik'], ENT_QUOTES, 'UTF-8');
            $jumlah_komentar = $row['jumlah_komentar'];
            $username = htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8');
            $tanggal = htmlspecialchars($row['tanggal'], ENT_QUOTES, 'UTF-8');
            $namasekolah = htmlspecialchars($row['namasekolah'], ENT_QUOTES, 'UTF-8'); // Add this line
        
            echo "<div class='col-lg-6 mb-4'>";
            echo "<div class='card h-100'>";
            echo "<div class='card-body'>";
            echo "<div class='d-flex justify-content-between align-items-center'>";
            echo "<div class='d-flex flex-column'>";
            echo "<h5 class='card-title'>$username</h5>";
            echo "<h6 class='card-subtitle text-muted'>$namasekolah</h6>"; // Display school name
            echo "</div>";
            echo "<div class='d-flex align-items-center'>";
            echo "<h6 class='card-subtitle text-muted mb-0 mr-3'>$tanggal</h6>";
    
            // Check if the user is the owner or admin
            $isOwner = $_SESSION['role'] == 'admin' || 
            (isset($_SESSION['iduser']) && $_SESSION['iduser'] == $row['iduser']) || 
            (isset($_SESSION['idusersiswa']) && $_SESSION['idusersiswa'] == $row['idusersiswa']);
    
            if ($isOwner) {
                echo '<div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="hapustopik.php?idtopik=' . $idtopik . '&kategori=' . $kategori . '&gender=' . $gender . '" 
                            onclick="return confirm(\'Apakah Anda yakin ingin menghapus topik ini?\')">Hapus</a>
                    </div>
                </div>';
            }
    
            echo "</div>";
            echo "</div>";
    
            // Add topic content
            echo "<p class='card-text mt-3'>$isitopik</p>";
    
            // Create a container for comments and button
            echo "<div class='d-flex justify-content-between align-items-center mt-3'>";
            
            if ($jumlah_komentar > 0) {
                echo "<span class='badge badge-info'>Komentar ($jumlah_komentar)</span>";
            }
            
            echo "<button class='btn btn-success' onclick=\"window.location.href='jawab.php?idtopik=$idtopik&kategori=$kategori&gender=$gender'\">Jawab</button>";
    
            echo "</div>"; // Close container
    
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<div class='col-lg-12'><p>Belum ada topik yang dikirim.</p></div>";
    }
    } else {
        // Menampilkan topik perempuan
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $isitopikperempuan = nl2br(htmlspecialchars($row['isitopikperempuan'], ENT_QUOTES, 'UTF-8'));
                $idtopikperempuan = htmlspecialchars($row['idtopikperempuan'], ENT_QUOTES, 'UTF-8');
                $jumlah_komentar = isset($row['jumlah_komentar']) ? $row['jumlah_komentar'] : 0;
                $username = htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8');
                $tanggal = htmlspecialchars($row['tanggal'], ENT_QUOTES, 'UTF-8');
                $namasekolah = htmlspecialchars($row['namasekolah'], ENT_QUOTES, 'UTF-8'); // Add this line
        
                echo "<div class='col-lg-6 mb-4'>";
                echo "<div class='card h-100'>";
                echo "<div class='card-body'>";
                echo "<div class='d-flex justify-content-between align-items-center'>";
                echo "<div class='d-flex flex-column'>";
                echo "<h5 class='card-title'>$username</h5>";
                echo "<h6 class='card-subtitle text-muted'>$namasekolah</h6>"; // Display school name
                echo "</div>";
                echo "<div class='d-flex align-items-center'>";
                echo "<h6 class='card-subtitle text-muted mb-0 mr-3'>$tanggal</h6>";
        
                // Cek apakah pengguna adalah admin atau pemilik topik
                $isOwner = $_SESSION['role'] == 'admin' || 
                (isset($_SESSION['iduser']) && $_SESSION['iduser'] == $row['iduser']) || 
                (isset($_SESSION['idusersiswa']) && $_SESSION['idusersiswa'] == $row['idusersiswa']);
        
                if ($isOwner) {
                    echo '<div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="hapustopik.php?idtopikperempuan=' . $idtopikperempuan . '&kategori=' . $kategori . '&gender=' . $gender . '"  
                                onclick="return confirm(\'Apakah Anda yakin ingin menghapus topik ini?\')">Hapus</a>
                        </div>
                    </div>';
                }
        
                echo "</div>";
                echo "</div>";
        
                // Tambahkan isi topik
                echo "<p class='card-text mt-3'>$isitopikperempuan</p>";
        
                // Buat div container untuk komentar dan tombol
                echo "<div class='d-flex justify-content-between align-items-center mt-3'>";
                
                if ($jumlah_komentar > 0) {
                    echo "<span class='badge badge-info'>Komentar ($jumlah_komentar)</span>";
                }
                
                echo "<button class='btn btn-success' onclick=\"window.location.href='jawab.php?idtopikperempuan=$idtopikperempuan&kategoriperempuan=$kategori&gender=$gender'\">Jawab</button>";

                echo "</div>"; // Tutup container
        
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='col-lg-12'><p>Belum ada topik yang dikirim.</p></div>";
        }        
    }
?>
