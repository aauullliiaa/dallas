<?php
session_start();
require '../src/db/functions.php';
checkRole('mahasiswa');


$matkul_id = $_GET['matkul_id'] ?? null;
$pertemuan_id = $_GET['pertemuan_id'] ?? null;
$tugas_id = $_GET['tugas_id'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;

if (!$matkul_id || !$pertemuan_id || !$tugas_id || !$user_id) {
    die("Parameter tidak lengkap.");
}

$message = '';
$alert_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "../src/files/tugas/";
    $file_name = basename($_FILES["file"]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        $message = "File already exists.";
        $alert_type = "danger";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["file"]["size"] > 5000000) {
        $message = "Sorry, your file is too large.";
        $alert_type = "danger";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
        $message = "Sorry, only PDF, DOC & DOCX files are allowed.";
        $alert_type = "danger";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $message = "Sorry, your file was not uploaded.";
        $alert_type = "danger";
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $data = [
                'tugas_id' => $tugas_id,
                'mahasiswa_id' => $user_id,
                'file_path' => $target_file,
                'tanggal_kumpul' => date('Y-m-d H:i:s')
            ];

            if (insertTugasKumpul($data)) {
                $message = "Tugas berhasil diunggah.";
                $alert_type = "success";
            } else {
                $message = "Gagal mengunggah tugas, silakan coba lagi.";
                $alert_type = "danger";
            }
        } else {
            $message = "Sorry, there was an error uploading your file.";
            $alert_type = "danger";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>APD Learning Space - Tugas Kuliah</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!-- CSS -->
    <link rel="stylesheet" href="../src/css/style.css" />
</head>
<header>
    <nav class="navbar navbar-expand-lg shadow-sm fixed-top bg-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php#home">
                <img src="../src/images/logo kampus.png" alt="Logo" width="40px" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#home" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Home
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="index.php#about">About</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php#kata-sambutan">Kata Sambutan</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php#alamat">Alamat dan Kontak</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mata-kuliah.php">Mata Kuliah</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dosen.php">Dosen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="jadwal-kuliah.php">Jadwal Perkuliahan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="edit-profile.php">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="tugas-jumbotron d-flex align-items-center justify-content-center">
        <div class="row text-center">
            <h1>Upload Tugas Kuliah</h1>
        </div>
    </section>
</header>

<body>
    <div class="container mt-5">
        <div class="card p-3">
            <div class="card-body">
                <?php if ($message): ?>
                    <div class="alert alert-<?= $alert_type; ?>">
                        <?= $message; ?>
                    </div>
                <?php endif; ?>
                <div class="card-title mb-4">
                    <h5>Silahkan upload tugas anda disini.</h5>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="file" class="form-label">Pilih File Tugas (PDF, DOC, DOCX):</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                    <div class="row">
                        <div class="col submit-button">
                            <button type="submit" class="btn btn-light">Unggah Tugas</button>
                        </div>
                    </div>
                </form>
                <div class="row mt-2">
                    <div class="col submit-button">
                        <a href="tugas-matkul.php?id=<?= $matkul_id; ?>"><button
                                class="btn btn-light">Kembali</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
?>