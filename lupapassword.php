<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script>
        function updateFormAction() {
            var role = document.getElementById("role").value;
            var form = document.getElementById("forgotPasswordForm");

            if (role === "pengurus") {
                form.action = "lupapassword_pengurus.php";
            } else if (role === "siswa") {
                form.action = "lupapassword_siswa.php";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Pilih Jenis Akun</h1>
                        </div>
                        <form id="forgotPasswordForm" method="POST" action="lupapassword_siswa.php">
                            <div class="form-group">
                                <select class="form-control" id="role" name="role" required onchange="updateFormAction()">
                                    <option value="">Pilih Jenis Akun</option>
                                    <option value="pengurus">Pengurus</option>
                                    <option value="siswa">Siswa</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">Lanjut</button>
                        </form>
                        <div class="mt-2">
                            <a href="login.php" class="btn btn-secondary btn-user btn-block">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
