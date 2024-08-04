<?php
session_start();
require 'src/db/functions.php';

$message = "";
$alert_type = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $role = htmlspecialchars($_POST['role']);
    $nip = htmlspecialchars($_POST['nip']);
    $nim = htmlspecialchars($_POST['nim']);

    // Validasi NIP dan NIM
    $valid = true;

    if (!empty($nip)) {
        // Verifikasi NIP di semua tabel dan cek apakah sudah digunakan
        $stmt = $db->prepare("SELECT 'admin' as role, user_id FROM daftar_admin WHERE nip = ? UNION ALL SELECT 'dosen' as role, user_id FROM daftar_dosen WHERE nip = ?");
        $stmt->bind_param("ss", $nip, $nip);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $role = $row['role'];
            if (!is_null($row['user_id'])) {
                $message = 'NIP sudah terdaftar. Anda tidak dapat menggunakan NIP ini untuk registrasi, silakan hubungi administrator jika terdapat kendala.';
                $alert_type = 'danger';
                $valid = false;
            }
        } else {
            $message = 'NIP tidak ditemukan, Anda tidak terdaftar sebagai dosen atau admin program studi ini.';
            $alert_type = 'danger';
            $valid = false;
        }
    } elseif (!empty($nim)) {
        // Verifikasi NIM di tabel mahasiswa dan cek apakah sudah digunakan
        $stmt = $db->prepare("SELECT 'mahasiswa' as role, user_id FROM daftar_mahasiswa WHERE nim = ?");
        $stmt->bind_param("s", $nim);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $role = $row['role'];
            if (!is_null($row['user_id'])) {
                $message = 'NIM sudah terdaftar. Anda tidak dapat menggunakan NIM ini untuk registrasi, silakan hubungi administrator jika terdapat kendala.';
                $alert_type = 'danger';
                $valid = false;
            }
        } else {
            $message = 'NIM tidak ditemukan, Anda tidak terdaftar sebagai mahasiswa program studi ini.';
            $alert_type = 'danger';
            $valid = false;
        }
    }

    if ($role && $valid) {
        // Registrasi user baru
        $user_id = registerUser($email, $password, $role);
        if ($user_id !== false) {
            if ($role == 'admin') {
                // Update profil admin
                if (updateAdminProfile($user_id, $email, $password, $nip)) {
                    $message = 'Registrasi Anda berhasil, silakan gunakan kredensial Anda untuk masuk.';
                    $alert_type = 'success';
                } else {
                    $message = 'Gagal memperbarui data admin.';
                    $alert_type = 'danger';
                    error_log("Error in updating admin profile for user_id $user_id, email $email, nip $nip");
                }
            } elseif ($role == 'dosen') {
                // Update profil dosen
                if (updateDosenProfile($user_id, $email, $password, $nip)) {
                    $message = 'Registrasi Anda berhasil, silakan gunakan kredensial Anda untuk masuk.';
                    $alert_type = 'success';
                } else {
                    $message = 'Gagal memperbarui data dosen.';
                    $alert_type = 'danger';
                    error_log("Error in updating dosen profile for user_id $user_id, email $email, nip $nip");
                }
            } elseif ($role == 'mahasiswa') {
                // Update profil mahasiswa
                if (updateMahasiswaProfile($user_id, $email, $password, $nim)) {
                    $message = 'Registrasi Anda berhasil, silakan gunakan kredensial Anda untuk masuk.';
                    $alert_type = 'success';
                } else {
                    $message = 'Gagal memperbarui data mahasiswa.';
                    $alert_type = 'danger';
                    error_log("Error in updating mahasiswa profile for user_id $user_id, email $email, nim $nim");
                }
            }
        } else {
            $message = 'Gagal mendaftarkan pengguna.';
            $alert_type = 'danger';
        }
    }
}

if ($alert_type === 'success') {
    $_SESSION['message'] = $message;
    $_SESSION['alert_type'] = $alert_type;

    switch ($role) {
        case 'dosen':
        case 'admin':
            header("Location: login-pegawai.php");
            break;
        case 'mahasiswa':
            header("Location: login-mahasiswa.php");
            break;
        default:
            header("Location: index.php");
            break;
    }
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
                    <div id="formContainer">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role:</label>
                            <select id="role" name="role" class="form-select" required>
                                <option value="">Pilih Role</option>
                                <option value="mahasiswa">Mahasiswa</option>
                                <option value="dosen">Dosen</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div id="nimField" class="mb-3" style="display: none;">
                            <label for="nim" class="form-label">NIM:</label>
                            <input type="text" id="nim" name="nim" class="form-control" maxlength="8">
                            <small id="nipError" style="color: red; display: none;">NIM harus 8 digit</small>
                        </div>
                        <div id="nipField" class="mb-3" style="display: none;">
                            <label for="nip" class="form-label">NIP:</label>
                            <input type="text" id="nip" name="nip" class="form-control" maxlength="18">
                            <small id="nipError" style="color: red; display: none;">NIP harus 18 digit</small>
                        </div>
                    </div>
                    <div class="row mb-2 text-center justify-content-center">
                        <div class="col-md-3 submit-button">
                            <button type="submit" name="register" class="btn btn-light">Register</button>
                        </div>
                    </div>
                </form>
                <div class="row text-center">
                    <div class="col submit-button">
                        <a href="index.php"><button class="btn btn-light">Kembali</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#role').on('change', function () {
                var selectedRole = $(this).val();
                if (selectedRole === 'mahasiswa') {
                    $('#nimField').show();
                    $('#nipField').hide();
                } else if (selectedRole === 'dosen' || selectedRole === 'admin') {
                    $('#nipField').show();
                    $('#nimField').hide();
                } else {
                    $('#nimField').hide();
                    $('#nipField').hide();
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
        });

    </script>
</body>

</html>