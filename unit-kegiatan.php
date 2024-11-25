<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Unit Kegiatan Mahasiswa</title>
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="src/css/style.css" />
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- AOS Animation -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    .hero-section {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      padding: 100px 0;
      margin-bottom: 2rem;
    }

    .ukm-card {
      border: none;
      border-radius: 15px;
      transition: all 0.3s ease;
      height: 100%;
      background-color: var(--white-color);
    }

    .ukm-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 20px rgba(198, 172, 143, 0.2);
    }

    .ukm-icon {
      font-size: 2.5rem;
      margin-bottom: 1.5rem;
      background: var(--secondary-color);
      width: 80px;
      height: 80px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      margin: 0 auto 1.5rem;
    }

    .card-body {
      text-align: center;
      padding: 2rem;
    }

    .section-title {
      position: relative;
      margin-bottom: 3rem;
      padding-bottom: 1rem;
      color: var(--text-color);
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 50px;
      height: 3px;
      background-color: var(--primary-color);
    }

    .nav-pills .nav-link.active {
      background-color: var(--primary-color);
      color: var(--white-color);
    }

    .nav-pills .nav-link {
      color: var(--text-color);
      margin: 0 5px;
    }

    .nav-pills .nav-link:hover {
      background-color: var(--secondary-color);
      color: var(--text-color);
    }

    .btn-outline-primary {
      color: var(--primary-color);
      border-color: var(--primary-color);
    }

    .btn-outline-primary:hover {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      color: var(--white-color);
    }

    .card-title {
      color: var(--primary-color) !important;
    }

    .text-muted {
      color: var(--text-color) !important;
      opacity: 0.8;
    }

    /* Hero text color */
    .hero-section h1,
    .hero-section p {
      color: var(--text-color);
    }

    /* Hero button styling */
    .hero-section .btn-light {
      background-color: var(--white-color);
      color: var(--primary-color);
      border: none;
      transition: all 0.3s ease;
    }

    .hero-section .btn-light:hover {
      background-color: var(--secondary-color);
      color: var(--text-color);
      transform: translateY(-3px);
    }

    /* Card shadow on hover */
    .ukm-card:hover {
      box-shadow: 0 10px 20px rgba(198, 172, 143, 0.2);
    }
  </style>
</head>

<body>
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
                Informasi Program Studi
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="#about">Tentang Prodi</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#vision-mission">Visi dan Misi Prodi</a>
                </li>
                <li>
                  <a class="dropdown-item" href="dosen.php">Dosen Pengajar</a>
                </li>
                <li>
                  <a class="dropdown-item" href="kurikulum.php">Kurikulum</a>
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
                  <a class="dropdown-item" href="fasilitas/laboratorium.php">Laboratorium</a>
                </li>
                <li>
                  <a class="dropdown-item" href="fasilitas/kelas.php">Gedung</a>
                </li>
                <li>
                  <a class="dropdown-item" href="fasilitas/pusat-studi.php">Pusat Studi</a>
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
                  <a class="dropdown-item" href="unit-kegiatan.php">Unit Kegiatan</a>
                </li>
                <li>
                  <a class="dropdown-item" href="https://hmanpnup.or.id/">Himpunan Mahasiswa Jurusan</a>
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
  </header>
  <!-- Hero Section -->
  <section class="hero-section text-center">
    <div class="container">
      <h1 class="display-4 mb-4" data-aos="fade-down">Unit Kegiatan Mahasiswa (UKM)</h1>
      <p class="lead mb-4" data-aos="fade-up">Mengembangkan Bakat dan Minat Mahasiswa untuk Masa Depan yang Lebih Baik
      </p>
    </div>
  </section>

  <!-- Main Content -->
  <div class="container" id="ukm-section">
    <h2 class="text-center section-title">Pilihan UKM</h2>

    <div class="row g-4">
      <!-- MAPALA -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up">
        <div class="card ukm-card">
          <div class="card-body">
            <div class="ukm-icon">🏔️</div>
            <h3 class="card-title h4">UKM Pecinta Alam (MAPALA)</h3>
            <p class="card-text text-muted">Wadah bagi mahasiswa yang memiliki minat dalam kegiatan alam bebas dan
              pelestarian lingkungan.</p>
            <a href="#" class="btn btn-outline-primary mt-3">Selengkapnya</a>
          </div>
        </div>
      </div>

      <!-- Seni -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card ukm-card">
          <div class="card-body">
            <div class="ukm-icon">🎨</div>
            <h3 class="card-title h4">UKM Seni dan Olahraga</h3>
            <p class="card-text text-muted">Mengembangkan bakat mahasiswa dalam bidang seni dan olahraga melalui
              berbagai kegiatan kreatif.</p>
            <a href="#" class="btn btn-outline-primary mt-3">Selengkapnya</a>
          </div>
        </div>
      </div>

      <!-- Taekwondo -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card ukm-card">
          <div class="card-body">
            <div class="ukm-icon">🥋</div>
            <h3 class="card-title h4">UKM Taekwondo</h3>
            <p class="card-text text-muted">Mewadahi minat mahasiswa dalam seni bela diri Taekwondo dan pengembangan
              prestasi.</p>
            <a href="#" class="btn btn-outline-primary mt-3">Selengkapnya</a>
          </div>
        </div>
      </div>

      <!-- Humaniora -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up">
        <div class="card ukm-card">
          <div class="card-body">
            <div class="ukm-icon">📚</div>
            <h3 class="card-title h4">UKM Humaniora</h3>
            <p class="card-text text-muted">Fokus pada pengembangan ilmu-ilmu humaniora dan kajian sosial
              kemasyarakatan.</p>
            <a href="#" class="btn btn-outline-primary mt-3">Selengkapnya</a>
          </div>
        </div>
      </div>

      <!-- Sepak Bola -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card ukm-card">
          <div class="card-body">
            <div class="ukm-icon">⚽</div>
            <h3 class="card-title h4">UKM Bola</h3>
            <p class="card-text text-muted">Mengembangkan bakat dan prestasi mahasiswa dalam bidang sepak bola melalui
              latihan rutin.</p>
            <a href="#" class="btn btn-outline-primary mt-3">Selengkapnya</a>
          </div>
        </div>
      </div>

      <!-- Pers -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card ukm-card">
          <div class="card-body">
            <div class="ukm-icon">📰</div>
            <h3 class="card-title h4">UKM Pers</h3>
            <p class="card-text text-muted">Wadah kreativitas mahasiswa dalam bidang jurnalistik dan pengembangan media
              kampus.</p>
            <a href="#" class="btn btn-outline-primary mt-3">Selengkapnya</a>
          </div>
        </div>
      </div>

      <!-- Bahasa -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up">
        <div class="card ukm-card">
          <div class="card-body">
            <div class="ukm-icon">🗣️</div>
            <h3 class="card-title h4">UKM Bahasa</h3>
            <p class="card-text text-muted">Mengembangkan kemampuan berbahasa asing mahasiswa melalui program
              pembelajaran intensif.</p>
            <a href="#" class="btn btn-outline-primary mt-3">Selengkapnya</a>
          </div>
        </div>
      </div>

      <!-- KSR-PMI -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card ukm-card">
          <div class="card-body">
            <div class="ukm-icon">🏥</div>
            <h3 class="card-title h4">UKM KSR-PMI</h3>
            <p class="card-text text-muted">Unit Korps Sukarela Palang Merah Indonesia untuk kegiatan sosial dan
              kesehatan masyarakat.</p>
            <a href="#" class="btn btn-outline-primary mt-3">Selengkapnya</a>
          </div>
        </div>
      </div>

      <!-- Wirausaha -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card ukm-card">
          <div class="card-body">
            <div class="ukm-icon">💼</div>
            <h3 class="card-title h4">UKM Wirausaha</h3>
            <p class="card-text text-muted">Mengembangkan jiwa kewirausahaan mahasiswa melalui pelatihan dan praktik
              bisnis.</p>
            <a href="#" class="btn btn-outline-primary mt-3">Selengkapnya</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="py-4">
    <div class="container text-center">
      <small>&copy; APD Learning Space - 2024</small>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- AOS Animation -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    // Initialize AOS
    AOS.init({
      duration: 800,
      once: true
    });
  </script>
</body>

</html>