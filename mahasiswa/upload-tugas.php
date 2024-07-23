<?php
session_start();
require '../src/db/functions.php';
checkRole('mahasiswa');

$tugas_id = $_GET['tugas_id'] ?? null;
$matkul_id = $_GET['matkul_id'] ?? null;
$pertemuan_id = $_GET['pertemuan_id'] ?? null;
$user_id = $_SESSION['user_id'];

if (!$tugas_id || !$matkul_id || !$pertemuan_id) {
    die("ID tugas, mata kuliah, atau pertemuan tidak ditemukan.");
}

// Retrieve mahasiswa data
$mahasiswa = retrieve("SELECT id, nim FROM daftar_mahasiswa WHERE user_id = ?", [$user_id])[0];
$mahasiswa_id = $mahasiswa['id'];
$mahasiswa_nim = $mahasiswa['nim'];

// Retrieve pertemuan detail
$pertemuanDetail = getPertemuanDetail($pertemuan_id);
$pertemuan_ke = $pertemuanDetail['pertemuan'];

$uploadMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadMessage = uploadTugas($tugas_id, $matkul_id, $pertemuan_id, $mahasiswa_id, $mahasiswa_nim, $pertemuan_ke, $_FILES["file_tugas"]);
}

// Retrieve tugas detail
$tugasDetail = getTugasDetail($tugas_id, $mahasiswa_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Upload Tugas</title>
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
            <a class="navbar-brand" href="../mahasiswa/index.php#home">
                <img src="../src/images/logo kampus.png" alt="Logo" width="40px" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="index.php#home" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Home
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php#about">About</a></li>
                            <li>
                                <a class="dropdown-item" href="index.php#vision-mission">Visi dan Misi</a>
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
                        <a class="nav-link" href="profile.php">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="d-flex align-items-center justify-content-center">
        <div class="row">
            <h2>Upload Tugas</h2>
        </div>
    </section>
</header>

<body>
    <div class="container mt-5">
        <?php if ($uploadMessage): ?>
            <div class="alert alert-info"><?= $uploadMessage; ?></div>
        <?php endif; ?>
        <div class="card p-3">
            <div class="card-header">
                <h4>Upload Tugas Pertemuan ke-<?= $pertemuan_ke; ?></h4>
            </div>
            <div class="card-body">
                <?php if ($tugasDetail): ?>
                    <div class="alert alert-warning">
                        Anda sudah mengumpulkan tugas. Anda dapat mengganti file yang telah diupload jika diperlukan.
                    </div>
                <?php endif; ?>
                <form
                    action="upload-tugas.php?tugas_id=<?= $tugas_id ?>&matkul_id=<?= $matkul_id ?>&pertemuan_id=<?= $pertemuan_id ?>"
                    method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="file_tugas" class="form-label">File Tugas (pdf, doc, docx, pptx, xls, jpg, png,
                            jpeg):</label>
                        <input class="form-control" type="file" name="file_tugas" id="file_tugas" required>
                    </div>
                    <div class="row">
                        <div class="col submit-button">
                            <?php if ($tugasDetail): ?>
                                <button type="submit" class="btn btn-light mb-1">Ganti File</button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-light mb-1">Upload Tugas</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
                <?php if ($tugasDetail): ?>
                    <div class="mt-3">
                        <h5>File yang telah diunggah:</h5>
                        <p><a href="<?= htmlspecialchars($tugasDetail['file_path']); ?>" target="_blank">Lihat File</a></p>
                    </div>
                <?php endif; ?>
                <div class="col submit-button mb-2">
                    <a href="tugas-matkul.php?id=<?= $matkul_id; ?>" class="btn btn-light">Kembali</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>