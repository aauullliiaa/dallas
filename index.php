<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>APD Learning Space - Home</title>
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
  <link rel="stylesheet" href="src/css/style.css" />
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<header>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg shadow-sm fixed-top bg-navbar">
    <div class="container">
      <a class="navbar-brand" href="index.php#home">
        <img src="src/images/logo kampus.png" alt="Logo" width="40px" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item dropdown"></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              About
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="#about">Tentang Program Studi</a>
              </li>
              <li><a class="dropdown-item" href="visimisi.html">Visi dan Misi</a></li>
              <li>
                <a class="dropdown-item" href="#">Sarana dan Prasarana</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End of Navbar -->
</header>

<body id="home">
  <!-- Carousel -->
  <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="src/images/mahasiswa-jbtrn.jpg" class="d-block w-100" alt="Slide 1" />
        <div class="carousel-caption d-md-block">
          <h5>Selamat Datang</h5>
          <p>
            Di Website Program Studi Sarjana Terapan Administrasi Perkantoran
            Digital
          </p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="src/images/eric-rothermel-FoKO4DpXamQ-unsplash.jpg" class="d-block w-100" alt="Slide 2" />
        <div class="carousel-caption d-md-block">
          <h5>Profil Program Studi</h5>
          <p>
            Program Studi ini merupakan Program Studi Terbaru di Jurusan
            Administrasi Niaga Politeknik Negeri Ujung pandang
          </p>
          <button class="btn">More</button>
        </div>
      </div>
      <div class="carousel-item">
        <img src="src/images/inaki-del-olmo-NIJuEQw0RKg-unsplash.jpg" class="d-block w-100" alt="Slide 3" />
        <div class="carousel-caption d-md-block">
          <h5>Kegiatan Program Studi</h5>
          <p>Be part of a vibrant learning environment.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="src/images/inaki-del-olmo-NIJuEQw0RKg-unsplash.jpg" class="d-block w-100" alt="Slide 4" />
        <div class="carousel-caption d-md-block">
          <h5>Promosi Program Studi</h5>
          <p>Be part of a vibrant learning environment.</p>
        </div>
      </div>
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
  <!-- End of Carousel -->
  <!-- Tentang Program Studi -->
  <section id="about">
    <div class="container">
      <div class="row justify-content-between align-items-center">
        <div class="col-md-6" data-aos="fade-right" data-aos-duration="1000">
          <div class="card p-2">
            <div class="card-body">
              <img src="src/images/foto kampus.jpg" class="img-fluid rounded" alt="..." width="600px" />
            </div>
          </div>
        </div>
        <div class="col-md-6 text-center" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
          <div class="row mb-3 mt-3">
            <h3>Tentang Program Studi</h3>
          </div>
          <div class="row about-paragraph">
            <p> Program Studi Sarjana Terapan Administrasi Perkantoran Digital
              memiliki tujuan dan keunggulan. Tujuan Program Studi ini adalah
              untuk membekali lulusan dengan pengetahuan, keterampilan, dan
              sikap dalam menyelesaikan pekerjaan-pekerjaan kantor baik
              organisasi swasta maupun organisasi pemerintah, membantu dan
              menangani pekerjaan tugas-tugas pimpinan. Sejalan dengan tuntutan
              pekerjaan administrasi organisasi di era digital.
              Keunggulan Program Studi Sarjana Terapan Administrasi Perkantoran Digital yakni kemampuan lulusan untuk
              menyelesaikan pekerjaan kantor dengan menggunakan teknologi digital berbasis ergonomi yang mengacu pada
              pendidikan vokasi yang terintegrasi dengan Dunia Industri dan Dunia Kerja (DUDIKA) untuk menghasilkan
              sumber daya manusia unggul.</p>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
  <!-- End of Tentang Program Studi -->
  <section>

  </section>
  <!-- Alamat -->
  <section id="alamat">
    <div class="container justify-content-center">
      <div class="row text-center pb-3">
        <h1 data-aos="fade-up" data-aos-duration="800">Alamat dan Kontak</h1>
      </div>
      <div class="row align-items-center">
        <div class="col-md-6" data-aos="zoom-in" data-aos-duration="1000">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63581.11650113188!2d119.39864003002323!3d-5.132706847633037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbefcca2887e13f%3A0xf5c059de86dd07!2sPNUP%20Politeknik%20Negeri%20Ujung%20Pandang!5e0!3m2!1sen!2sid!4v1712199819055!5m2!1sen!2sid"
            width="600" height="450" style="border: 0" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade" class="ratio ratio-1x1"></iframe>
        </div>
        <div class="col-md-6" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
          <h3 class="pb-2">Alamat</h3>
          <table class="alamat mb-3">
            <tr>
              <th>Kampus 1</th>
              <td>
                Jl. Perintis Kemerdekaan KM. 10, Tamalanrea, Kota Makassar,
                Sulawesi Selatan
              </td>
            </tr>
            <tr>
              <th>Kampus 2</th>
              <td>
                Jl. Tamalanrea Raya, Tamalanrea, Kabupaten Maros, Sulawesi
                Selatan
              </td>
            </tr>
          </table>
          <h3 class="pb-2">Kontak</h3>
          <table class="kontak">
            <tr>
              <th>Nomor Telp.</th>
              <td>+62813456789</td>
            </tr>
            <tr>
              <th>Email</th>
              <td>lorem@loremipsum.com</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </section>
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#638ECB" fill-opacity="1"
      d="M0,64L24,74.7C48,85,96,107,144,144C192,181,240,235,288,229.3C336,224,384,160,432,144C480,128,528,160,576,149.3C624,139,672,85,720,58.7C768,32,816,32,864,64C912,96,960,160,1008,197.3C1056,235,1104,245,1152,250.7C1200,256,1248,256,1296,234.7C1344,213,1392,171,1416,149.3L1440,128L1440,320L1416,320C1392,320,1344,320,1296,320C1248,320,1200,320,1152,320C1104,320,1056,320,1008,320C960,320,912,320,864,320C816,320,768,320,720,320C672,320,624,320,576,320C528,320,480,320,432,320C384,320,336,320,288,320C240,320,192,320,144,320C96,320,48,320,24,320L0,320Z">
    </path>
  </svg>
  <!-- End of Alamat -->
  <!-- Footer -->
  <footer>

  </footer>
  <!-- End of Footer-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    // Initialize AOS
    AOS.init({
      duration: 800,
      once: true,
    });

    // Set carousel interval to 5 seconds
    document.addEventListener("DOMContentLoaded", function () {
      var myCarousel = document.querySelector("#homeCarousel");
      var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 5000,
      });
    });
  </script>
</body>

</html>