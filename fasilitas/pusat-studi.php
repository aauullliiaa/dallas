<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pusat Studi || APD Learning Space</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../src/css/style.css" />

    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-navbar fixed-top shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="../index.php#home">
                    <img src="../src/images/logo kampus.png" alt="Logo" width="40" height="45"
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
                                Informasi Program Studi
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="../index.php#about">Tentang Prodi</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="../dosen.php">Dosen Pengajar</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="../kurikulum.php">Kurikulum</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Fasilitas
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="laboratorium.php">Laboratorium</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="gedung.php">Gedung</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="pusat-studi.php">Pusat Studi</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Kemahasiswaan
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="../unit-kegiatan.php">Unit Kegiatan</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="../himpunan-jurusan.php">Himpunan Mahasiswa</a>
                                </li>
                            </ul>
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
        <section class="ps-hero d-flex align-items-center justify-content-center text-center">
            <div class="container">
                <h1 class="ps-hero-title" data-aos="fade-up">Pusat Studi</h1>
                <p class="ps-hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                    Tempat di mana inovasi dan pembelajaran bertemu, menciptakan lingkungan yang ideal untuk
                    pengembangan akademik dan penelitian.
                </p>
            </div>
        </section>
        <!-- Statistics Section -->
        <section class="ps-stats-section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row text-center">
                    <div class="col-md-3 mb-4" data-aos="fade-up">
                        <div class="stats-item">
                            <i class="bi bi-building fs-1 mb-3"></i>
                            <h2 class="counter">2</h2>
                            <p>Lokasi Kampus</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="stats-item">
                            <i class="bi bi-book fs-1 mb-3"></i>
                            <h2 class="counter">10000+</h2>
                            <p>Koleksi Digital</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="stats-item">
                            <i class="bi bi-people fs-1 mb-3"></i>
                            <h2 class="counter">250+</h2>
                            <p>Kapasitas Ruang Studi</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="stats-item">
                            <i class="bi bi-laptop fs-1 mb-3"></i>
                            <h2 class="counter">50+</h2>
                            <p>Komputer Penelitian</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="ps-features-section" id="facilities">
            <div class="container">
                <h2 class="text-center mb-5" data-aos="fade-up">Fasilitas Unggulan</h2>
                <div class="row">
                    <div class="col-md-4" data-aos="fade-up">
                        <div class="feature-item shadow-sm">
                            <i class="bi bi-book feature-icon"></i>
                            <h4>Perpustakaan Digital</h4>
                            <p>Akses ke ribuan sumber pembelajaran digital dan jurnal akademik internasional.</p>
                            <ul class="mt-3 text-start">
                                <li>Akses 24/7 ke e-journal</li>
                                <li>Katalog online terintegrasi</li>
                                <li>Area baca yang nyaman</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="feature-item shadow-sm">
                            <i class="bi bi-laptop feature-icon"></i>
                            <h4>Fasilitas Modern</h4>
                            <p>Dilengkapi dengan teknologi terkini untuk mendukung pembelajaran dan penelitian.</p>
                            <ul class="mt-3 text-start">
                                <li>Laboratorium komputer</li>
                                <li>Ruang multimedia</li>
                                <li>Koneksi internet cepat</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                        <div class="feature-item shadow-sm">
                            <i class="bi bi-people feature-icon"></i>
                            <h4>Kolaborasi</h4>
                            <p>Ruang diskusi dan area kerja sama untuk proyek kelompok dan penelitian bersama.</p>
                            <ul class="mt-3 text-start">
                                <li>Ruang diskusi kelompok</li>
                                <li>Area co-working</li>
                                <li>Ruang seminar</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Location Section -->
        <section class="container py-5" id="location">
            <h2 class="text-center mb-5" data-aos="fade-up">Lokasi Kampus</h2>
            <div class="row">
                <div class="col-md-6 mb-4" data-aos="fade-right">
                    <div class="card center-study-card shadow-sm h-100">
                        <div class="campus-image">
                            <img src="../src/images/gedung-jurusan-kp1.jpeg" class="card-img-top" alt="Kampus 1">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Kampus 1 Tamalanrea</h5>
                            <p class="card-text">
                                Pusat studi utama dengan fasilitas lengkap termasuk perpustakaan digital,
                                laboratorium penelitian, dan ruang diskusi modern.
                            </p>
                            <div class="location-details mt-4">
                                <p><i class="bi bi-geo-alt-fill me-2"></i>Jl. Perintis Kemerdekaan KM.10, Tamalanrea</p>
                                <p><i class="bi bi-telephone-fill me-2"></i>+62 411-123456</p>
                                <p><i class="bi bi-clock-fill me-2"></i>Senin - Jumat: 08.00 - 16.00 WITA</p>
                            </div>
                            <div class="mt-4">
                                <a href="https://maps.app.goo.gl/15GEugC1jf8r25Jd7" class="btn btn-primary">
                                    <i class="bi bi-geo-alt-fill me-2"></i>Google Maps
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4" data-aos="fade-left">
                    <div class="card center-study-card shadow-sm h-100">
                        <div class="campus-image">
                            <img src="../src/images/gedung-jurusan-kp2.jpeg" class="card-img-top" alt="Kampus 2">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Kampus 2 Bumi Tamalanrea Permai</h5>
                            <p class="card-text">
                                Pusat studi modern dengan fokus pada penelitian terapan dan pengembangan teknologi.
                            </p>
                            <div class="location-details mt-4">
                                <p><i class="bi bi-geo-alt-fill me-2"></i>Jl. BTP Blok M, Tamalanrea</p>
                                <p><i class="bi bi-telephone-fill me-2"></i>+62 411-234567</p>
                                <p><i class="bi bi-clock-fill me-2"></i>Senin - Jumat: 08.00 - 16.00 WITA</p>
                            </div>
                            <div class="mt-4">
                                <a href="https://maps.app.goo.gl/Xgmgk6j2ffVzDiwV6" class="btn btn-primary">
                                    <i class="bi bi-geo-alt-fill me-2"></i>Google Maps
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="py-4">
            <div class="container text-center">
                <small>&copy; APD Learning Space - 2024</small>
            </div>
        </footer>
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init({
                duration: 800,
                once: true,
                offset: 100,
            });
        </script>
</body>

</html>