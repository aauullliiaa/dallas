<?php
session_start();
require '../src/db/functions.php';
checkRole('admin');
?>
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
  <link rel="stylesheet" href="../src/css/style.css" />
  <!-- Add AOS CSS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Add Font Awesome for icons -->
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
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="confirmLogout()">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End of Navbar -->
</header>

<body id="home">
  <!-- Jumbotron -->
  <section class="jumbotron admin d-flex align-items-center" data-aos="fade-up">
    <div class="container">
      <div class="row p-2" data-aos="fade-up" data-aos-delay="100">
        <h1>Selamat Datang, Admin!</h1>
      </div>
      <div class="row p-2" data-aos="fade-up" data-aos-delay="200">
        <div class="col-md-8">
          <h2>
            Di Portal Web Learning Space Program Studi Administrasi
            Perkantoran Digital
          </h2>
        </div>
      </div>
      <div class="row p-2" data-aos="fade-up" data-aos-delay="300">
        <div class="col-md-8">
          <p>
            Website ini hadir untuk membantu Anda mengatur jadwal perkuliahan
            dan mengedit mata kuliah dengan mudah. Buat dan kelola jadwal,
            serta atur informasi mata kuliah.
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- End of Jumbotron -->
  <section class="py-5">
    <div class="container">
      <div class="row text-center mb-5">
        <h1 class="display-4 fw-bold" data-aos="fade-down">Menu Administrasi Perkantoran Digital Learning Space</h1>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
          <div class="card h-100 shadow-sm hover-card p-3"
            style="border-radius: 15px; border: none; transition: all 0.3s;">
            <div class="card-body text-center">
              <div class="icon-circle mb-4 mx-auto d-flex align-items-center justify-content-center"
                style="width: 80px; height: 80px; background-color: #E6F3FF; border-radius: 50%;">
                <i class="bi bi-calendar-week text-primary" style="font-size: 2.5rem;"></i>
              </div>
              <h5 class="card-title mt-4 fw-bold">Jadwal Perkuliahan</h5>
              <p class="card-text">
                Akses jadwal kuliah Anda dengan mudah dan cepat. Pantau kelas dan waktu perkuliahan Anda di sini.
              </p>
            </div>
            <div class="card-footer bg-transparent border-0 text-end">
              <a href="jadwal-kuliah.php" class="btn btn-primary btn-sm rounded-pill">Lanjut <i
                  class="bi bi-arrow-right-short"></i></a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
          <div class="card h-100 shadow hover-card p-3"
            style="border-radius: 15px; border: none; transition: all 0.3s;">
            <div class="card-body text-center">
              <div class="icon-circle mb-4 mx-auto d-flex align-items-center justify-content-center"
                style="width: 80px; height: 80px; background-color: #E6FFE6; border-radius: 50%;">
                <i class="bi bi-book text-success" style="font-size: 2.5rem;"></i>
              </div>
              <h5 class="card-title mt-4 fw-bold">Mata Kuliah</h5>
              <p class="card-text">
                Jelajahi daftar mata kuliah yang tersedia. Temukan informasi tentang setiap mata kuliah di sini.
              </p>
            </div>
            <div class="card-footer bg-transparent border-0 text-end">
              <a href="mata-kuliah.php" class="btn btn-success btn-sm rounded-pill">Lanjut <i
                  class="bi bi-arrow-right-short"></i></a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
          <div class="card h-100 shadow hover-card p-3"
            style="border-radius: 15px; border: none; transition: all 0.3s;">
            <div class="card-body text-center">
              <div class="icon-circle mb-4 mx-auto d-flex align-items-center justify-content-center"
                style="width: 80px; height: 80px; background-color: #FFE6E6; border-radius: 50%;">
                <i class="bi bi-people text-danger" style="font-size: 2.5rem;"></i>
              </div>
              <h5 class="card-title mt-4 fw-bold">Data Pengguna</h5>
              <p class="card-text">
                Kelola informasi pengguna sistem. Akses dan perbarui data mahasiswa, dosen, dan staf di sini.
              </p>
            </div>
            <div class="card-footer bg-transparent border-0 text-end">
              <a href="data-users.php" class="btn btn-danger btn-sm rounded-pill">Lanjut <i
                  class="bi bi-arrow-right-short"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- About -->
  <section id="about" class="py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-right" data-aos-duration="1000">
          <div class="card shadow">
            <img src="../src/images/foto kampus.jpg" class="card-img-top" alt="Kampus" />
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
  <!-- End of About -->
  <section id="vision-mission" class="py-5">
    <div class="container">
      <div class="row mb-5">
        <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-up">
          <div class="card h-100 shadow p-3" style="background-color: #E6F3FF">
            <div class="card-body">
              <h3 class="card-title text-center mb-4">VISI</h3>
              <p class="card-text text-center" style="font-size: 1.2rem">
                Menjadi program studi yang menghasilkan sarjana terapan
                berwawasan global dan berdaya saing tinggi dibidang
                Administrasi Perkantoran Digital secara profesional dan
                berakhlak mulia.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="card h-100 shadow p-3" style="background-color: #E6F3FF">
            <div class="card-body">
              <h3 class="card-title text-center mb-4">MISI</h3>
              <ol class="card-text" style="font-size: 1.2rem">
                <li>
                  Menyelenggarakan tridarma perguruan tinggi untuk menyiapkan
                  tenaga kerja sarjana terapan dibidang Administrasi
                  Perkantoran Digital dengan penerapan metode pembelajaran
                  yang terpadu, berkualitas, selaras, dan berkesinambungan.
                </li><br>
                <li>
                  Menyelenggarakan penelitian terapan dan pengabdian
                  masyarakat untuk membantu pembangunan dan penyelesaian
                  masalah dalam bidang Administrasi Perkantoran Digital.
                </li><br>
                <li>
                  Mengembangkan kegiatan kerjasama yang saling menguntungkan
                  dengan pemerintah, institusi pendidikan, praktisi industri,
                  dan segenap stakeholder untuk pengembangan kompetensi
                  keilmuan dibidang Administrasi Perkantoran Digital.
                </li><br>
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

  <!-- Alamat -->
  <section id="alamat" class="py-5">
    <div class="container">
      <h2 class="text-center mb-5" data-aos="fade-up">Alamat dan Kontak</h2>
      <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-right" data-aos-delay="100">
          <div class="ratio ratio-16x9">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63581.11650113188!2d119.39864003002323!3d-5.132706847633037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbefcca2887e13f%3A0xf5c059de86dd07!2sPNUP%20Politeknik%20Negeri%20Ujung%20Pandang!5e0!3m2!1sen!2sid!4v1712199819055!5m2!1sen!2sid"
              allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
        <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
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
  <!-- End of Alamat -->
  <!-- Footer -->
  <footer class="py-4">
    <div class="container text-center">
      <small>&copy; APD Learning Space - 2024</small>
    </div>
  </footer>
  <!-- End of Footer-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      once: true
    });

    function confirmLogout() {
      if (confirm("Apakah anda yakin ingin keluar?")) {
        window.location.href = "../logout.php";
      }
    }
  </script>
</body>

</html>