<?php
require 'src/db/functions.php';
$penelitian = retrieve("SELECT * FROM penelitian");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>APD Learning Space - Penelitian Dosen</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="src/css/style.css" />

    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-navbar fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php#home">
                <img src="src/images/logo kampus.png" alt="Logo" width="40" height="45"
                    class="d-inline-block align-text-top" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Profil
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="index.php#about">Tentang Prodi</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php#vision-mission">Visi dan Misi Prodi</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Kurikulum
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#">Seluruh Mata Kuliah</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Mata Kuliah Kampus Merdeka</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Dosen
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="dosen.php">Daftar Dosen</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="penelitian-dosen.php">Penelitian Dosen</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="facility.php">Fasilitas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#mitra">Mitra</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#alamat">Kontak</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Login
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="login-pegawai.php">Login Dosen/Admin</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="login-mahasiswa.php">Login Mahasiswa</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="penelitian-hero d-flex justify-content-center align-items-center">
        <h1 style="font-weight: 600;">PENELITIAN DOSEN</h1>
    </section>
</header>

<body>
    <div class="container">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>