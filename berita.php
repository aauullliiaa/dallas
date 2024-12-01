<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Terkini || APD Learning Space</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../src/css/style.css" />
</head>

<body>
    <header>
        <?php include 'navbar.php'; ?>
        <section>
            <div class="section-title">
                <div class="row text-center">
                    <h2 class="display-4 mb-3">Berita Terkini</h2>
                    <p class="lead text-muted">Informasi terbaru seputar kampus dan kegiatan akademik</p>
                </div>
            </div>
        </section>
    </header>
    <section class="news-section">
        <div class="container">
            <div class="row g-4">
                <!-- Berita 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="news-card">
                        <div class="news-image">
                            <img src="src/images/achievement.jpg" alt="Berita 1">
                            <span class="news-badge">Akademik</span>
                        </div>
                        <div class="card-body">
                            <div class="news-meta">
                                <i class="far fa-calendar"></i> 24 November 2024
                                <span class="mx-2">|</span>
                                <i class="far fa-user"></i> Admin
                            </div>
                            <h5 class="card-title">Prestasi Mahasiswa dalam Kompetisi Nasional</h5>
                            <p class="card-text">
                                Mahasiswa program studi Administrasi Perkantoran Digital berhasil meraih juara dalam
                                kompetisi nasional. Pencapaian ini membuktikan kualitas pendidikan yang diterapkan dalam
                                program studi.
                            </p>
                            <div class="row submit-button">
                                <div class="col-md-8">
                                    <a href="#" class="btn btn-light rounded-pill">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Berita 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="news-card">
                        <div class="news-image">
                            <img src="src/images/digital-marketing.jpg" alt="Berita 2">
                            <span class="news-badge">Kegiatan</span>
                        </div>
                        <div class="card-body">
                            <div class="news-meta">
                                <i class="far fa-calendar"></i> 23 November 2024
                                <span class="mx-2">|</span>
                                <i class="far fa-user"></i> Admin
                            </div>
                            <h5 class="card-title">Workshop Digital Marketing untuk Mahasiswa</h5>
                            <p class="card-text">
                                Program studi mengadakan workshop digital marketing untuk meningkatkan kompetensi
                                mahasiswa dalam bidang pemasaran digital modern. Kegiatan ini menghadirkan praktisi
                                profesional.
                            </p>
                            <div class="row submit-button">
                                <div class="col-md-8">
                                    <a href="#" class="btn btn-light rounded-pill">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Berita 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="news-card">
                        <div class="news-image">
                            <img src="src/images/news-2.jpg" alt="Berita 3">
                            <span class="news-badge">Pengumuman</span>
                        </div>
                        <div class="card-body">
                            <div class="news-meta">
                                <i class="far fa-calendar"></i> 22 November 2024
                                <span class="mx-2">|</span>
                                <i class="far fa-user"></i> Admin
                            </div>
                            <h5 class="card-title">Pembukaan Pendaftaran Semester Baru</h5>
                            <p class="card-text">
                                Informasi terkait pembukaan pendaftaran mahasiswa baru untuk semester ganjil tahun
                                akademik 2024/2025 telah dibuka. Calon mahasiswa dapat mendaftar melalui website resmi
                                kampus.
                            </p>
                            <div class="row submit-button">
                                <div class="col-md-8">
                                    <a href="#" class="btn btn-light rounded-pill">Baca Selengkapnya</a>
                                </div>
                            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>