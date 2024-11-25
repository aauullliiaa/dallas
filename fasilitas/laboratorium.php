<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratorium || APD Learning Space</title>
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
    <style>
        .lab-card {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.6s ease-out;
        }

        .lab-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .card:hover {
            transform: translateY(-10px);
            transition: transform 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Tambahkan CSS untuk mengatur ukuran gambar */
        .card-img-top {
            width: 100%;
            height: 200px;
            /* Atur tinggi gambar yang diinginkan */
            object-fit: cover;
            /* Pastikan gambar menutupi seluruh area */
        }
    </style>
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
                                    <a class="dropdown-item" href="https://hmanpnup.or.id/">Himpunan Mahasiswa
                                        Jurusan</a>
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
        <section class="lab-hero d-flex align-items-center justify-content-center">
            <div class="row text-center">
                <h1>Laboratorium</h1>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <p class="fs-4 text-center">
                            Program studi Sarjana Terapan Administrasi Perkantoran Digital dilengkapi dengan berbagai
                            fasilitas laboratorium modern yang
                            komprehensif untuk menunjang kegiatan pembelajaran di bidang administrasi perkantoran
                            digital. Berikut adalah laboratorium-laboratorium unggulan yang kami miliki:
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </header>
    <!-- Labs Section -->
    <div class="container pb-4">
        <div class="row g-3">
            <!-- Lab 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 lab-card">
                    <img src="../src/images/lab-komputer-kp2.jpeg" class="card-img-top" alt="Lab Multimedia">
                    <div class="card-body">
                        <h5 class="card-title">Laboratorium Multimedia</h5>
                        <p class="card-text">Dilengkapi dengan perangkat dan software terkini untuk pengembangan konten
                            digital, editing video, desain grafis, dan produksi multimedia profesional.</p>
                    </div>
                </div>
            </div>

            <!-- Lab 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 lab-card">
                    <img src="../src/images/lab-typing-kp2.jpeg" class="card-img-top" alt="Lab Typing Speed">
                    <div class="card-body">
                        <h5 class="card-title">Laboratorium Typing Speed</h5>
                        <p class="card-text">Ruang praktik khusus untuk meningkatkan kecepatan dan akurasi mengetik
                            dengan sistem monitoring kecepatan dan progress tracking.</p>
                    </div>
                </div>
            </div>


            <!-- Lab 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 lab-card">
                    <img src="../src/images/lab-typing-kp1.jpg" class="card-img-top" alt="Lab Typing Tutor">
                    <div class="card-body">
                        <h5 class="card-title">Laboratorium Typing Tutor</h5>
                        <p class="card-text">Fasilitas pembelajaran mengetik dengan sistem tutorial interaktif dan
                            perangkat lunak pembelajaran yang komprehensif.</p>
                    </div>
                </div>
            </div>

            <!-- Lab 4 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 lab-card">
                    <img src="../src/images/studio-bahasa.jpeg" class="card-img-top" alt="Studio Bahasa">
                    <div class="card-body">
                        <h5 class="card-title">Studio Bahasa</h5>
                        <p class="card-text">Studio modern untuk pembelajaran bahasa dengan sistem audio-visual
                            interaktif dan perangkat komunikasi profesional.</p>
                    </div>
                </div>
            </div>

            <!-- Lab 5 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 lab-card">
                    <img src="../src/images/lab-perkantoran-kp1.jpg" class="card-img-top" alt="Lab Simulasi Bisnis">
                    <div class="card-body">
                        <h5 class="card-title">Laboratorium Otomatisasi dan Simulasi Bisnis</h5>
                        <p class="card-text">Lingkungan simulasi bisnis yang realistis untuk praktik manajemen,
                            administrasi, dan operasional perkantoran modern.</p>
                    </div>
                </div>
            </div>

            <!-- Lab 6 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 lab-card">
                    <img src="../src/images/lab-perkantoran-kp2.jpeg" class="card-img-top" alt="Lab Simulasi Bisnis">
                    <div class="card-body">
                        <h5 class="card-title">Laboratorium Perkantoran</h5>
                        <p class="card-text">Lingkungan simulasi bisnis yang realistis untuk praktik manajemen,
                            administrasi, dan operasional perkantoran modern.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-4">
        <div class="container text-center">
            <small>&copy; APD Learning Space - 2024</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Intersection Observer untuk animasi scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1
        });

        // Mengamati semua kartu lab
        document.querySelectorAll('.lab-card').forEach((card) => {
            observer.observe(card);
        });
    </script>
</body>

</html>