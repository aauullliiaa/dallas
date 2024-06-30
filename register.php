<?php
require 'src/db/functions.php';

$message = "";
$alert_type = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Periksa apakah email sudah terdaftar
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = 'Email sudah terdaftar, silakan gunakan email lain.';
        $alert_type = 'danger';
    } else {
        if ($role == 'dosen') {
            $nip = htmlspecialchars($_POST['nip']);

            // Verifikasi NIP dosen
            $stmt = $db->prepare("SELECT * FROM daftar_dosen WHERE nip = ?");
            $stmt->bind_param("s", $nip);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                $message = 'NIP tidak ditemukan, anda tidak terdaftar sebagai dosen program studi ini.';
                $alert_type = 'danger';
            } else {
                // Registrasi user jika NIP valid
                $user_id = registerUser($email, $password, $role, $nama);
                if ($user_id !== false) {
                    registerDosenProfile($user_id, $email, $nama, $nip);
                    $message = 'Registrasi anda berhasil, silakan gunakan kredensial anda untuk masuk.';
                    $alert_type = 'success';
                } else {
                    $message = 'Gagal mendaftarkan pengguna';
                    $alert_type = 'danger';
                }
            }
        } else {
            // Registrasi untuk role mahasiswa
            $user_id = registerUser($email, $password, $role, $nama);
            if ($user_id !== false) {
                $nim = htmlspecialchars($_POST['nim']);
                registerMahasiswaProfile($user_id, $email, $nama, $nim);
                $message = 'Registrasi anda berhasil, silakan gunakan kredensial anda untuk masuk.';
                $alert_type = 'success';
            } else {
                $message = 'Gagal mendaftarkan pengguna';
                $alert_type = 'danger';
            }
        }
    }
}

if ($alert_type === 'success') {
    $_SESSION['message'] = $message;
    $_SESSION['alert_type'] = $alert_type;
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>APD Learning Space - Register</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <!-- CSS -->
    <link rel="stylesheet" href="src/css/style.css" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="register d-flex align-items-center justify-content-center">
    <div class="container" style="max-width: 600px;">
        <div class="card p-3">
            <div class="card-body">
                <div class="row text-center mb-2">
                    <h3>Register</h3>
                </div>
                <?php if ($message != ""): ?>
                    <div class="alert alert-<?= $alert_type; ?>">
                        <?= $message; ?>
                    </div>
                <?php endif; ?>
                <form action="" method="post" id="roleForm">
                    <div class="mb-3">
                        <label for="role" class="form-label">Pilih Role:</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="">--Pilih Role--</option>
                            <option value="mahasiswa" <?php if (isset($_POST['role']) && $_POST['role'] == 'mahasiswa')
                                echo 'selected'; ?>>Mahasiswa</option>
                            <option value="dosen" <?php if (isset($_POST['role']) && $_POST['role'] == 'dosen')
                                echo 'selected'; ?>>Dosen</option>
                        </select>
                    </div>
                    <div id="formContainer">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama:</label>
                            <input type="text" id="nama" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3" id="nimField" style="display: none;">
                            <label for="nim" class="form-label">NIM:</label>
                            <input type="text" id="nim" name="nim" class="form-control" required>

                        </div>
                        <div class="mb-3" id="nipField" style="display: none;">
                            <label for="nip" class="form-label">NIP:</label>
                            <input type="text" id="nip" name="nip" class="form-control" maxlength="18" required>
                            <small id="nipError" style="color: red; display: none;">NIP harus 18 digit</small>
                        </div>
                    </div>
                    <div class="row mb-3 text-center justify-content-center">
                        <div class="col-md-3 submit-button">
                            <button type="submit" name="register" class="btn btn-light">Register</button>
                        </div>
                    </div>
                    <div class="row text-center">
                        <small>Sudah memiliki akun? Silahkan <a href="index.php">login</a> disini </small>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#role').change(function () {
                var role = $(this).val();
                if (role == 'ahasiswa') {
                    $('#nimField').show();
                    $('#nipField').hide();
                    $('#nim').attr('required', true);
                    $('#nip').removeAttr('required');
                } else if (role == 'dosen') {
                    $('#nimField').hide();
                    $('#nipField').show();
                    $('#nip').attr('required', true);
                    $('#nim').removeAttr('required');
                } else {
                    $('#nimField').hide();
                    $('#nipField').hide();
                    $('#nim').removeAttr('required');
                    $('#nip').removeAttr('required');
                }
            });

            $('#nip').on('input', function () {
                var nip = $(this).val();
                if (nip.length != 18) {
                    $('#nipError').show();
                    $(this).addClass('is-invalid');
                } else {
                    $('#nipError').hide();
                    $(this).removeClass('is-invalid');
                }
            });

            // Trigger change event on page load to ensure correct fields are shown
            $('#role').trigger('change');
        });
    </script>
</body>

</html>