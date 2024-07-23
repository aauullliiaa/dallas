<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>APD Learning Space - Home</title>

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

<body id="home">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-navbar fixed-top shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="index.php#home">
        <img src="src/images/logo kampus.png" alt="Logo" width="40" height="45" class="d-inline-block align-text-top" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
          <li class="nav-item">
            <a class="nav-link" href="dosen.php">Dosen</a>
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
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Login
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="login-pegawai.php">Login Pegawai</a>
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

  <!-- Hero Carousel -->
  <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active" data-bs-interval="10000">
        <img src="src/images/gedung-ad-carousel.jpg" class="d-block w-100" alt="Slide 1" />
        <div class="carousel-caption d-md-block">
          <h2 class="display-4 fw-bold">Selamat Datang!</h2>
          <p>Di Website Program Studi Sarjana Terapan Administrasi Perkantoran Digital</p>
        </div>
      </div>
      <div class="carousel-item" data-bs-interval="10000">
        <img src="src/images/promosi-3-carousel.jpeg" class="d-block w-100" alt="Slide 2" />
        <div class="carousel-caption d-md-block">
          <h2 class="display-4 fw-bold">Promosi Program Studi</h2>
          <p>Informasi terkait dengan Program Studi Sarjana Terapan Administrasi Perkantoran Digital
          </p>
          <div class="row">
            <div class="col submit-button">
              <a href="promotion.php" class="btn btn-light">Selengkapnya</a>
            </div>
          </div>
        </div>
      </div>
      <!-- Add more carousel items here if needed -->
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- Etalase -->
  <section id="showcase" class="py-5">
    <div class="container">
      <h2 class="text-center mb-5">Etalase Program Studi</h2>
      <div class="row g-4">
        <!-- Showcase items -->
        <div class="col-md-4" data-aos="fade-up">
          <div class="card h-100 shadow-sm d-flex flex-column">
            <div class="card-body text-center flex-grow-1">
              <i class="bi bi-book display-1 text-dark mb-3"></i>
              <h5 class="card-title">Kurikulum yang Terbaru</h5>
              <p class="card-text">
                Kurikulum terkini yang disesuaikan dengan kebutuhan industri dan perkembangan teknologi.
              </p>
              <div class="card-footer bg-transparent border-0 submit-button mt-auto">
                <a href=""><button class="btn btn-light">Selengkapnya</button></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="card h-100 shadow-sm d-flex flex-column">
            <div class="card-body text-center flex-grow-1">
              <i class="bi bi-laptop display-1 text-dark mb-3"></i>
              <h5 class="card-title">Fasilitas Modern</h5>
              <p class="card-text">
                Nikmati fasilitas belajar terkini yang mendukung pembelajaran digital.
              </p>
              <div class="card-footer bg-transparent border-0 submit-button mt-auto">
                <a href="facility.php"><button class="btn btn-light">Selengkapnya</button></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="card h-100 shadow-sm d-flex flex-column">
            <div class="card-body text-center flex-grow-1">
              <i class="bi bi-people display-1 text-dark mb-3"></i>
              <h5 class="card-title">Kegiatan di Program Studi</h5>
              <p class="card-text">
                Berbagai kegiatan menarik untuk mengembangkan soft skills dan hard skills mahasiswa.
              </p>
              <div class="card-footer bg-transparent border-0 submit-button mt-auto">
                <a href="activity.php"><button class="btn btn-light">Selengkapnya</button></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-right" data-aos-duration="1000">
          <div class="card shadow">
            <img src="src/images/foto kampus.jpg" class="card-img-top" alt="Kampus" />
          </div>
        </div>
        <div class="col-md-6" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
          <h2 class="mb-4">Tentang Program Studi</h2>
          <p class="lead">
            Program Studi Sarjana Terapan Administrasi Perkantoran Digital
            memiliki tujuan dan keunggulan. Tujuan Program Studi ini adalah
            untuk membekali lulusan dengan pengetahuan, keterampilan, dan
            sikap dalam menyelesaikan pekerjaan-pekerjaan kantor baik
            organisasi swasta maupun organisasi pemerintah, membantu dan
            menangani pekerjaan tugas-tugas pimpinan. Sejalan dengan tuntutan
            pekerjaan administrasi organisasi di era digital.
          </p>
          <p>
            Keunggulan Program Studi Sarjana Terapan Administrasi Perkantoran
            Digital yakni kemampuan lulusan untuk menyelesaikan pekerjaan
            kantor dengan menggunakan teknologi digital berbasis ergonomi yang
            mengacu pada pendidikan vokasi yang terintegrasi dengan Dunia
            Industri dan Dunia Kerja (DUDIKA) untuk menghasilkan sumber daya
            manusia unggul.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Vision and Mission Section -->
  <section id="vision-mission" class="py-5">
    <div class="container">
      <div class="row mb-5">
        <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-up">
          <div class="card h-100 shadow p-3">
            <div class="card-body ">
              <h3 class="card-title text-center mb-4">Visi</h3>
              <p class="card-text">
                Menjadi program studi yang menghasilkan sarjana terapan
                berwawasan global dan berdaya saing tinggi dibidang
                Administrasi Perkantoran Digital secara profesional dan
                berakhlak mulia.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="card h-100 shadow p-3">
            <div class="card-body">
              <h3 class="card-title text-center mb-4">Misi</h3>
              <ol class="card-text">
                <li>
                  Menyelenggarakan tridarma perguruan tinggi untuk menyiapkan
                  tenaga kerja sarjana terapan dibidang Administrasi
                  Perkantoran Digital dengan penerapan metode pembelajaran
                  yang terpadu, berkualitas, selaras, dan berkesinambungan.
                </li>
                <li>
                  Menyelenggarakan penelitian terapan dan pengabdian
                  masyarakat untuk membantu pembangunan dan penyelesaian
                  masalah dalam bidang Administrasi Perkantoran Digital.
                </li>
                <li>
                  Mengembangkan kegiatan kerjasama yang saling menguntungkan
                  dengan pemerintah, institusi pendidikan, praktisi industri,
                  dan segenap stakeholder untuk pengembangan kompetensi
                  keilmuan dibidang Administrasi Perkantoran Digital.
                </li>
                <li>
                  Menghasilkan lulusan sarjana terapan yang unggul,
                  profesional, berintegrasi tinggi, dan siap diserap di dunia
                  kerja.
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Peminat -->
  <section id="stats-section" class="py-5 text-dark">
    <div class="container">
      <h2 class="text-center mb-5">Data Peminat Program Studi</h2>
      <div class="row text-center">
        <div class="col-md-4 mb-4" data-aos="fade-up">
          <h3 class="display-4 fw-bold"><span id="total-pendaftar" class="counter">1500</span>+</h3>
          <p class="lead">Total Pendaftar</p>
        </div>
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
          <h3 class="display-4 fw-bold"><span id="total-peminat" class="counter">205</span></h3>
          <p class="lead">Total Peminat</p>
        </div>
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
          <h3 class="display-4 fw-bold"><span id="daya-tampung" class="counter">50</span></h3>
          <p class="lead">Daya Tampung</p>
        </div>
      </div>
    </div>
  </section>


  <!-- Mitra -->
  <section id="mitra" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center mb-5">Mitra Kami</h2>
      <div class="logo-slider" data-aos="fade-up">
        <div class="logo-item">
          <img src="src/images/logo-antam.png" alt="Logo 1" />
        </div>
        <div class="logo-item">
          <img src="src/images/logo-angkasa-pura.png" alt="Logo 2" />
        </div>
        <div class="logo-item">
          <img src="src/images/logo-bsi.png" alt="Logo 3" />
        </div>
        <div class="logo-item">
          <img src="src/images/logo-cni.png" alt="Logo 4" />
        </div>
        <div class="logo-item">
          <img src="src/images/logo-markija.png" alt="Logo 5" />
        </div>
        <div class="logo-item">
          <img src="src/images/logo-PT-KIMA.jpg" alt="Logo 5" />
        </div>
        <div class="logo-item">
          <img src="src/images/logo-rekind-daya-mamuju.jpeg" alt="Logo 5" />
        </div>
        <div class="logo-item">
          <img src="src/images/Logo-BRI-Bank-Rakyat-Indonesia-PNG-Terbaru.webp" alt="Logo 5" />
        </div>
        <div class="logo-item">
          <img src="src/images/Logo_bank_mega_syariah_new.png" alt="Logo 5" />
        </div>
        <div class="logo-item">
          <img src="src/images/Logo_PLN.png" alt="Logo 5" />
        </div>
        <div class="logo-item">
          <img src="src/images/Vale_logo.svg.png" alt="Logo 5" />
        </div>
        <div class="logo-item">
          <img src="src/images/charoen-logo.webp" alt="Logo 5" />
        </div>
        <div class="logo-item">
          <img src="src/images/trakindo-logo.jpg" alt="Logo 5" />
        </div>
        <div class="logo-item">
          <img src="src/images/huayou-indo-logo.fd7af3e5.svg" alt="Logo 5" />
        </div>
        <div class="logo-item">
          <img src="src/images/Semen_Tonasa_logo.png" alt="Logo 5" />
        </div>
        <div class="logo-item">
          <img src="src/images/bank-tabungan-negara-logo-png_seeklogo-524115.png" alt="Logo 5" />
        </div>
        <div class="logo-item">
          <img src="src/images/BankNegaraIndonesia46-logo.svg.png" alt="Logo 5" />
        </div>
        <div class="logo-item">
          <img src="src/images/Singapore_Polytechnic_logo.png" alt="Logo 5" />
        </div>
      </div>
  </section>

  <!-- Alamat -->
  <section id="alamat" class="py-5">
    <div class="container">
      <h2 class="text-center mb-5">Alamat dan Kontak</h2>
      <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
          <div class="ratio ratio-16x9">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63581.11650113188!2d119.39864003002323!3d-5.132706847633037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbefcca2887e13f%3A0xf5c059de86dd07!2sPNUP%20Politeknik%20Negeri%20Ujung%20Pandang!5e0!3m2!1sen!2sid!4v1712199819055!5m2!1sen!2sid"
              allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
        <div class="col-md-6">
          <h3 class="mb-3">Alamat</h3>
          <address>
            <strong>Kampus 1:</strong><br />
            Jl. Perintis Kemerdekaan KM. 10, Tamalanrea, Kota Makassar,
            Sulawesi Selatan<br /><br />
            <strong>Kampus 2:</strong><br />
            Jl. Tamalanrea Raya, Tamalanrea, Kabupaten Maros, Sulawesi Selatan
          </address>
          <h3 class="mt-4 mb-3">Kontak</h3>
          <p>
            <strong>Telp:</strong> +6281242930330 (Hirman)<br />
            +6282193655502 (Imasita)
          </p>
          <p>
            <strong>Email:</strong>
            <a href="mailto:adm_perkantoran_digital@poliupg.ac.id">adm_perkantoran_digital@poliupg.ac.id</a>
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="py-4">
    <div class="container text-center">
      <small>&copy; APD Learning Space - 2024</small>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 800,
      once: true,
      offset: 100,
    });

    document.addEventListener("DOMContentLoaded", function () {
      var myCarousel = document.querySelector("#homeCarousel");
      var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 5000,
      });
    });

    $(document).ready(function () {
      $(".logo-slider").slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: true,
        dots: false,
        pauseOnHover: false,
        responsive: [
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 4,
            },
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 3,
            },
          },
          {
            breakpoint: 576,
            settings: {
              slidesToShow: 2,
            },
          },
        ],
      });
    });
  </script>
  <script>
    function animateCounter(elementId, end, duration) {
      let start = 0;
      const element = document.getElementById(elementId);
      const range = end - start;
      const increment = end > start ? 1 : 1;
      const stepTime = Math.abs(Math.floor(duration / range));

      let current = start;
      const timer = setInterval(() => {
        current += increment;
        element.textContent = current;
        if (current === end) {
          clearInterval(timer);
        }
      }, stepTime);
    }

    // Memulai animasi saat elemen masuk ke viewport
    function startCountersWhenVisible() {
      const counters = document.querySelectorAll('.counter');
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const element = entry.target;
            const end = parseInt(element.textContent);
            element.textContent = '0';
            animateCounter(element.id, end, 2000); // Durasi 2 detik
            observer.unobserve(element);
          }
        });
      }, { threshold: 0.5 });

      counters.forEach(counter => {
        observer.observe(counter);
      });
    }

    // Jalankan fungsi saat dokumen selesai dimuat
    document.addEventListener('DOMContentLoaded', startCountersWhenVisible);

  </script>
</body>

</html>