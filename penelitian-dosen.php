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
                                <a class="dropdown-item" href="#about">Tentang Prodi</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#vision-mission">Visi dan Misi Prodi</a>
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
                        <a class="nav-link" href="#mitra">Mitra</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#alamat">Kontak</a>
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
        <div class="card shadow-sm p-3">
            <div class="card-body">
                <h3 class="card-subtitle text-muted mb-4">Pengelolaan Pembelajaran Berbasis Website pada Program Studi
                    Sarjana Terapan Administrasi Perkantoran Digital
                </h3>
                <p class="text-secondary mb-4"><i class="bi bi-people me-2"></i>Imasita, Nahiruddin, Dewi Sartika Z,
                    Aulia Kinanah</p>
                <div class="row mb-4">
                    <div class="col-md-9">
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nulla eligendi autem
                            atque rem quam a eveniet id expedita fugit aperiam. Saepe architecto nostrum nisi fugiat
                            odit totam consequatur quis asperiores?</p>
                    </div>
                </div>
                <div class="row submit-button">
                    <div class="col-lg-6">
                        <a href="#" class="btn btn-light me-2 mb-2">
                            <i class="bi bi-eye me-2"></i>View
                        </a>
                        <a href="#" class="btn btn-light mb-2">
                            <i class="bi bi-download me-2"></i>Download
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>