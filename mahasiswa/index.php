<?php
session_start();
require '../src/db/functions.php';

checkRole('mahasiswa');
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
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="index.php#home" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              Home
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="index.php#about">About</a></li>
              <li>
                <a class="dropdown-item" href="index.php#kata-sambutan">Kata Sambutan</a>
              </li>
              <li>
                <a class="dropdown-item" href="index.php#alamat">Alamat dan Kontak</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="mata-kuliah.php">Mata Kuliah</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="dosen.php">Dosen</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="jadwal-kuliah.php">Jadwal Perkuliahan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="edit-profile.php">Profil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End of Navbar -->
</header>

<body id="home">
  <!-- Jumbotron -->
  <section class="jumbotron d-flex align-items-center"
    style="background-image: url(../src/images/mahasiswa-jbtrn.jpg);">
    <div class="container">
      <div class="row p-2">
        <h1>Selamat Datang</h1>
      </div>
      <div class="row p-2">
        <div class="col-md-8">
          <h2>
            Di Portal Web Learning Space Program Studi Administrasi
            Perkantoran Digital
          </h2>
        </div>
      </div>
      <div class="row p-2">
        <div class="col-md-8">
          <p>
            Kami senang bisa menyambut kamu di sini! Portal ini adalah tempat
            di mana kamu bisa menemukan segala hal yang kamu butuhkan untuk
            sukses dalam studi dan kehidupan kampus.
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- End of Jumbotron -->
  <!-- About -->
  <section id="about">
    <div class="container">
      <div class="row pb-4">
        <h1 class="text-center">Tentang Program Studi</h1>
      </div>
      <div class="row pb-4 align-items-center">
        <div class="col-md-6 text-start">
          <p>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit.
            Doloribus quis eligendi nobis numquam omnis tempora nulla,
            blanditiis animi illum sint quaerat consequatur aliquam hic minus
            nihil similique cupiditate maiores maxime! Lorem ipsum dolor sit
            amet consectetur adipisicing elit. Iste porro natus sequi
            praesentium eligendi necessitatibus cupiditate accusantium
            temporibus ducimus illo ut ex voluptatibus voluptas dignissimos,
            perspiciatis placeat tempore quidem cum?
          </p>
        </div>
        <div class="col-md-6 text-center">
          <img src="../src/images/foto kampus.jpg" class="img-fluid" alt="Foto Kampus" />
        </div>
      </div>
    </div>
  </section>
  <!-- End of About -->
  <!-- Sepatah Kata dari Kaprodi -->
  <section id="kata-sambutan">
    <div class="container">
      <div class="row text-center pb-3">
        <h1>Sambutan dari Ketua Program Studi</h1>
      </div>
      <div class="row align-items-center">
        <div class="col-md-6 text-center">
          <img src="../src/images/jk.jpg" class="img-fluid" alt="" />
        </div>
        <div class="col-md-6">
          <p>
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Libero
            illo debitis voluptatem et dignissimos sint fuga voluptates est
            sit itaque obcaecati, consequuntur deserunt facere incidunt
            aliquam, quod perferendis harum sunt recusandae aperiam.
            Explicabo, harum sint nisi, dolorem accusamus aliquid, doloremque
            inventore sunt omnis accusantium possimus doloribus nostrum iusto
            est amet!
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- End of Sepatah Kata dari Kaprodi -->
  <!-- Alamat -->
  <section id="alamat">
    <div class="container justify-content-center">
      <div class="row text-center pb-3">
        <h1>Alamat dan Kontak</h1>
      </div>
      <div class="row align-items-center">
        <div class="col-md-6">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63581.11650113188!2d119.39864003002323!3d-5.132706847633037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbefcca2887e13f%3A0xf5c059de86dd07!2sPNUP%20Politeknik%20Negeri%20Ujung%20Pandang!5e0!3m2!1sen!2sid!4v1712199819055!5m2!1sen!2sid"
            width="600" height="450" style="border: 0" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade" class="ratio ratio-1x1"></iframe>
        </div>
        <div class="col-md-6">
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
    <path fill="#c6ac8f" fill-opacity="1"
      d="M0,96L40,90.7C80,85,160,75,240,106.7C320,139,400,213,480,224C560,235,640,181,720,181.3C800,181,880,235,960,240C1040,245,1120,203,1200,181.3C1280,160,1360,160,1400,160L1440,160L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z">
    </path>
  </svg>
  <!-- End of Alamat -->
  <!-- Footer -->
  <footer class="text-center pb-1" style="background-color: #c6ac8f">
    <p>Created with <i class="bi bi-heart-fill"></i>, Aulia Kinanah</p>
  </footer>
  <!-- End of Footer-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>