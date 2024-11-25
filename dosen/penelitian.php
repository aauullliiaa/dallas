<?php session_start();
require '../src/db/functions.php';
checkRole('dosen');

// Cek apakah ada pesan di session
$message = '';
$alert_type = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $alert_type = $_SESSION['alert_type']; // Hapus pesan setelah ditampilkan unset($_SESSION['message']);
    unset($_SESSION['alert_type']);
}
$penelitian = retrieve("SELECT * FROM penelitian");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APD Learning Space - Penelitian Dosen</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!-- CSS -->
    <link rel="stylesheet" href="../src/css/style.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<header>
    <!-- Navbar -->
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
    <!-- End of Navbar -->
    <section class="penelitian-hero d-flex justify-content-center align-items-center">
        <h1 style="font-weight: 600;">PENELITIAN DOSEN</h1>
    </section>
</header>

<body>
    <div class="container">
        <?php if (!empty($message)): ?>
            <div class="container mt-4">
                <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show" role="alert">
                    <?= $message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        <?php foreach ($penelitian as $row): ?>
            <div class="card shadow-sm mb-3 p-2">
                <div class="card-body">
                    <h3 class="card-subtitle text-muted mb-2"><?= $row["judul"] ?></h3>

                    <?php
                    // Ambil semua penulis dari array row
                    $authors = array_filter([$row["author1"], $row["author2"], $row["author3"], $row["author4"]]);
                    $authorCount = count($authors);

                    // Tampilkan penulis dengan format yang benar
                    if ($authorCount === 1) {
                        echo '<small class="text-secondary mb-4"><i class="bi bi-people me-2"></i>' . $authors[0] . '</small>';
                    } else {
                        echo '<small class="text-secondary mb-4"><i class="bi bi-people me-2"></i>' . implode(', ', $authors) . '</small>';
                    }
                    ?>

                    <br>
                    <small class="text-secondary mb-4"><i
                            class="bi bi-calendar me-2"></i><?= $row["tahun_terbit"] ?></small>
                    <div class="row mt-1 mb-2">
                        <strong>DOI: <?= $row["doi"] ?></strong>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-10">
                            <p><?= $row["abstrak"] ?></p>
                        </div>
                    </div>
                    <div class="row submit-button">
                        <div class="col-lg-6">
                            <a href="<?= $row["file_path"] ?>" target="_blank" class="btn btn-light me-2 mb-2">
                                <i class="bi bi-eye me-2"></i>Preview
                            </a>
                            <a href="<?= $row["file_path"] ?>" download class="btn btn-light mb-2">
                                <i class="bi bi-download me-2"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <footer class="py-4">
        <div class="container text-center">
            <small>&copy; APD Learning Space - 2024</small>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script>
        function confirmLogout() {
            if (confirm("Apakah anda yakin ingin keluar?")) {
                window.location.href = "../logout.php";
            }
        }
    </script>
</body>

</html>