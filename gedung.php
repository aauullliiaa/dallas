<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas Gedung || APD Learning Space</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../src/css/style.css" />

    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        .building-card {
            transition: transform 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .building-card:hover {
            transform: translateY(-10px);
        }

        .building-image {
            position: relative;
            overflow: hidden;
            height: 250px;
        }

        .building-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .stats-number {
            font-size: 3rem;
            font-weight: bold;
            color: #0d6efd;
        }

        .room-list {
            list-style: none;
            padding: 0;
        }

        .room-list li {
            padding: 10px 15px;
            margin-bottom: 8px;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
        }

        .room-list li i {
            color: #0d6efd;
            margin-right: 10px;
        }

        .room-badge {
            background: #e7f1ff;
            color: #0d6efd;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            margin: 0.2rem;
        }

        .facility-icon {
            width: 40px;
            height: 40px;
            background: #e7f1ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: #0d6efd;
        }

        .tab-building {
            cursor: pointer;
            padding: 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .tab-building:hover,
        .tab-building.active {
            background: #e7f1ff;
        }
    </style>
</head>

<body>
    <header>
        <?php include 'navbar.php'; ?>
        <section>
            <div class="text-center mb-5">
                <h1 class="display-5 mb-3">Fasilitas Gedung</h1>
                <h2 class="h4 text-secondary">Program Studi Sarjana Terapan Administrasi Perkantoran Digital</h2>
            </div>
        </section>
    </header>
    <div class="container-fluid py-5">
        <!-- Header Section -->
        <div class="container mb-5">
            <div class="row text-center mb-5">
                <div class="col-md-4 mb-4">
                    <div class="p-4 rounded-3 shadow-sm bg-white" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-building mb-3 text-primary" style="font-size: 2.5rem;"></i>
                        <div class="stats-number">3</div>
                        <p class="text-muted mb-0">Total Gedung</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="p-4 rounded-3 shadow-sm bg-white" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-door-open mb-3 text-primary" style="font-size: 2.5rem;"></i>
                        <div class="stats-number">35</div>
                        <p class="text-muted mb-0">Total Ruang Kelas</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="p-4 rounded-3 shadow-sm bg-white" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-users mb-3 text-primary" style="font-size: 2.5rem;"></i>
                        <div class="stats-number">500+</div>
                        <p class="text-muted mb-0">Kapasitas Mahasiswa</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container">
            <div class="row">
                <!-- Building Cards -->
                <div class="col-lg-8">
                    <div class="row">
                        <!-- Gedung Seminar -->
                        <div class="col-md-12 mb-4" data-aos="fade-right" data-aos-delay="400">
                            <div class="card building-card">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <div class="building-image h-100">
                                            <img src="/api/placeholder/400/300" alt="Gedung Seminar">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h3 class="card-title">Gedung Seminar</h3>
                                            <p class="card-text">
                                                Gedung modern yang dilengkapi dengan fasilitas pembelajaran terkini
                                                untuk mendukung
                                                kegiatan perkuliahan dan seminar.
                                            </p>
                                            <div class="mb-3">
                                                <span class="room-badge">
                                                    <i class="fas fa-door-open me-2"></i>5 Ruang Kelas
                                                </span>
                                                <span class="room-badge">
                                                    <i class="fas fa-users me-2"></i>Kapasitas 25 Mahasiswa/Ruang
                                                </span>
                                            </div>
                                            <div class="mt-3">
                                                <h6 class="mb-3">Fasilitas Ruangan:</h6>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <div class="facility-icon">
                                                            <i class="fas fa-tv"></i>
                                                        </div>
                                                        <span>Smart TV</span>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="facility-icon">
                                                            <i class="fas fa-wind"></i>
                                                        </div>
                                                        <span>AC</span>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="facility-icon">
                                                            <i class="fas fa-wifi"></i>
                                                        </div>
                                                        <span>WiFi</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gedung Program Studi -->
                        <div class="col-md-12 mb-4" data-aos="fade-right" data-aos-delay="400">
                            <div class="card building-card">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <div class="building-image h-100">
                                            <img src="/api/placeholder/400/300" alt="Gedung Program Studi">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h3 class="card-title">Gedung Program Studi</h3>
                                            <p class="card-text">
                                                Pusat kegiatan akademik program studi yang dilengkapi dengan ruang kelas
                                                modern
                                                dan area diskusi mahasiswa.
                                            </p>
                                            <div class="mb-3">
                                                <span class="room-badge">
                                                    <i class="fas fa-door-open me-2"></i>10 Ruang Kelas
                                                </span>
                                                <span class="room-badge">
                                                    <i class="fas fa-users me-2"></i>Kapasitas 25 Mahasiswa/Ruang
                                                </span>
                                            </div>
                                            <div class="mt-3">
                                                <h6 class="mb-3">Fasilitas Ruangan:</h6>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <div class="facility-icon">
                                                            <i class="fas fa-desktop"></i>
                                                        </div>
                                                        <span>Komputer</span>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="facility-icon">
                                                            <i class="fas fa-wind"></i>
                                                        </div>
                                                        <span>AC</span>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="facility-icon">
                                                            <i class="fas fa-wifi"></i>
                                                        </div>
                                                        <span>WiFi</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gedung Sekolah -->
                        <div class="col-md-12 mb-4" data-aos="fade-right" data-aos-delay="500">
                            <div class="card building-card">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <div class="building-image h-100">
                                            <img src="/api/placeholder/400/300" alt="Gedung Sekolah">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h3 class="card-title">Gedung Sekolah</h3>
                                            <p class="card-text">
                                                Gedung perkuliahan bersama yang dilengkapi dengan berbagai fasilitas
                                                pendukung
                                                untuk kegiatan akademik.
                                            </p>
                                            <div class="mb-3">
                                                <span class="room-badge">
                                                    <i class="fas fa-door-open me-2"></i>20 Ruang Kelas
                                                </span>
                                                <span class="room-badge">
                                                    <i class="fas fa-users me-2"></i>Kapasitas 25 Mahasiswa/Ruang
                                                </span>
                                            </div>
                                            <div class="mt-3">
                                                <h6 class="mb-3">Fasilitas Ruangan:</h6>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <div class="facility-icon">
                                                            <i class="fas fa-projector"></i>
                                                        </div>
                                                        <span>Proyektor</span>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="facility-icon">
                                                            <i class="fas fa-wind"></i>
                                                        </div>
                                                        <span>AC</span>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="facility-icon">
                                                            <i class="fas fa-wifi"></i>
                                                        </div>
                                                        <span>WiFi</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar with Additional Info -->
                <div class="col-lg-4">
                    <div class="card shadow-sm mb-4" data-aos="fade-left" data-aos-delay="300">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Informasi Tambahan</h5>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    Jam Operasional: 07.00 - 17.00
                                </li>
                                <li class="mb-3">
                                    <i class="fas fa-calendar text-primary me-2"></i>
                                    Senin - Jumat
                                </li>
                                <li class="mb-3">
                                    <i class="fas fa-wheelchair text-primary me-2"></i>
                                    Aksesibilitas Difabel
                                </li>
                                <li class="mb-3">
                                    <i class="fas fa-parking text-primary me-2"></i>
                                    Area Parkir Tersedia
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card shadow-sm" data-aos="fade-left" data-aos-delay="400">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Kontak Pengelola Gedung</h5>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    (021) 1234567
                                </li>
                                <li class="mb-3">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    fasilitas@kampus.ac.id
                                </li>
                                <li class="mb-3">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    Gedung Administrasi Lt. 1
                                </li>
                            </ul>
                        </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
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