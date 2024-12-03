<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check in tbuser table
    $sql = "SELECT iduser, role, pass, asalsekolah, status FROM tbuser WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['pass'];

        // Check if the account status is 'pending' or 'rejected'
        if ($row['status'] === 'pending') {
            echo "<script>alert('Akun Anda belum divalidasi oleh admin.');window.location.href='login.php';</script>";
            exit();
        } elseif ($row['status'] === 'rejected') {
            echo "<script>alert('Akun Anda ditolak.');window.location.href='login.php';</script>";
            exit();
        }

        if (password_verify($password, $hashed_password)) {
            // Password is bcrypt-hashed and correct
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];
            $_SESSION['iduser'] = $row['iduser'];

            if ($row['role'] == 'pengurus') {
                $_SESSION['asalsekolah'] = $row['asalsekolah'];
            }

            header("Location: index.php");
            exit();
        } elseif ($password === $hashed_password) {
            // Password is not bcrypt-hashed, but correct
            // Rehash the password using bcrypt
            $new_hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Update the database with the new hashed password
            $update_sql = "UPDATE tbuser SET pass = ? WHERE iduser = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("si", $new_hashed_password, $row['iduser']);
            $stmt->execute();

            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];
            $_SESSION['iduser'] = $row['iduser'];

            if ($row['role'] == 'pengurus') {
                $_SESSION['asalsekolah'] = $row['asalsekolah'];
            }

            header("Location: index.php");
            exit();
        } else {
            // Incorrect password
            echo "<script>alert('Username atau Password salah!');window.location.href='login.php';</script>";
        }
    } else {
        // If not found in tbuser, check in tbusersiswa
        $sql = "SELECT idusersiswa, idsiswa, pass, status FROM tbusersiswa WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['pass'];

            // Check if the account status is 'pending' or 'rejected'
            if ($row['status'] === 'pending') {
                echo "<script>alert('Akun Anda belum divalidasi oleh sistem.');window.location.href='login.php';</script>";
                exit();
            } elseif ($row['status'] === 'rejected') {
                echo "<script>alert('Akun Anda telah ditolak oleh sistem.');window.location.href='login.php';</script>";
                exit();
            }

            if (password_verify($password, $hashed_password)) {
                // Password is bcrypt-hashed and correct
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'siswa';
                $_SESSION['idusersiswa'] = $row['idusersiswa'];
                $_SESSION['idsiswa'] = $row['idsiswa'];

                // Retrieve jeniskelamin and asalsekolah from tbsiswa
                $idsiswa = $row['idsiswa'];
                $siswa_sql = "SELECT jeniskelamin, asalsekolah FROM tbsiswa WHERE idsiswa = '$idsiswa'";
                $siswa_result = $conn->query($siswa_sql);

                if ($siswa_result->num_rows > 0) {
                    $siswa_row = $siswa_result->fetch_assoc();
                    $_SESSION['jeniskelamin'] = $siswa_row['jeniskelamin'];
                    $_SESSION['asalsekolah'] = $siswa_row['asalsekolah'];
                }

                header("Location: index.php");
                exit();
            } elseif ($password === $hashed_password) {
                // Password is not bcrypt-hashed, but correct
                // Rehash the password using bcrypt
                $new_hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Update the database with the new hashed password
                $update_sql = "UPDATE tbusersiswa SET pass = ? WHERE idusersiswa = ?";
                $stmt = $conn->prepare($update_sql);
                $stmt->bind_param("si", $new_hashed_password, $row['idusersiswa']);
                $stmt->execute();

                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'siswa';
                $_SESSION['idusersiswa'] = $row['idusersiswa'];
                $_SESSION['idsiswa'] = $row['idsiswa'];

                // Retrieve jeniskelamin and asalsekolah from tbsiswa
                $idsiswa = $row['idsiswa'];
                $siswa_sql = "SELECT jeniskelamin, asalsekolah FROM tbsiswa WHERE idsiswa = '$idsiswa'";
                $siswa_result = $conn->query($siswa_sql);

                if ($siswa_result->num_rows > 0) {
                    $siswa_row = $siswa_result->fetch_assoc();
                    $_SESSION['jeniskelamin'] = $siswa_row['jeniskelamin'];
                    $_SESSION['asalsekolah'] = $siswa_row['asalsekolah'];
                }

                header("Location: index.php");
                exit();
            } else {
                // Incorrect password
                echo "<script>alert('Username atau Password salah!');window.location.href='login.php';</script>";
            }
        } else {
            // Username not found
            echo "<script>alert('Username atau Password salah!');window.location.href='login.php';</script>";
        }
    }
}

$conn->close();
?>
