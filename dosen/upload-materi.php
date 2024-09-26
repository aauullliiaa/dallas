<?php
session_start();
require '../src/db/functions.php';
checkRole('dosen');

$message = '';
$alert_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    list($message, $alert_type) = processMaterialUpload($db);
    if ($alert_type === 'success') {
        $mata_kuliah_id = $_POST['mata_kuliah_id'];
        $_SESSION['message'] = $message;
        $_SESSION['alert_type'] = $alert_type;
        header("Location: detail-matkul.php?id=$mata_kuliah_id");
        exit;
    }
}

$mata_kuliah_id = $_GET["id"];

// Ambil daftar pertemuan yang sudah terdaftar untuk mata kuliah tertentu
$existing_meetings = array_column(getAllMaterialsByMataKuliah($db, $mata_kuliah_id), 'pertemuan');

// Buat daftar pertemuan yang belum terdaftar
$available_meetings = array_diff(range(1, 16), $existing_meetings);

$db->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>APD Learning Space - Mata Kuliah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#home" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Dosen
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="dosen.php">Daftar Dosen</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="penelitian.php">Penelitian Dosen</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="jadwal-kuliah.php">Jadwal Perkuliahan</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#home" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Profil
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="profile.php">Edit Profil</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="form-upload-penelitian.php">Upload Penelitian</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="confirmLogout()">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section>
        <div class="row text-center">
            <h1>Upload Materi Perkuliahan</h1>
        </div>
    </section>
</header>

<body>
    <div class="container">
        <div class="card p-3">
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <?php if ($message != ''): ?>
                        <div class="alert alert-<?= $alert_type; ?>" role="alert">
                            <?= htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>
                    <input type="hidden" id="mata_kuliah_id" name="mata_kuliah_id"
                        value="<?= htmlspecialchars($mata_kuliah_id) ?>">
                    <div class="mb-3">
                        <label for="pertemuan" class="form-label">Pertemuan:</label>
                        <select class="form-control" id="pertemuan" name="pertemuan" required>
                            <?php foreach ($available_meetings as $meeting): ?>
                                <option value="<?= htmlspecialchars($meeting) ?>">
                                    <?= "Pertemuan " . htmlspecialchars($meeting) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Materi:</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="materi_file" class="form-label">File Materi Perkuliahan:</label>
                        <input type="file" class="form-control" id="materi_file" name="materi_file"
                            accept=".pdf,.doc,.docx,.ppt,.pptx" required>
                    </div>
                    <div class="row mb-2">
                        <div class="col submit-button">
                            <button type="submit" class="btn btn-light">Unggah Materi</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col submit-button">
                        <a href="detail-matkul.php?id=<?= htmlspecialchars($mata_kuliah_id) ?>"><button
                                class="btn">Kembali</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        function confirmLogout() {
            if (confirm("Apakah Anda yakin ingin keluar?")) {
                window.location.href = "../logout.php";
            }
        }
    </script>
</body>

</html>