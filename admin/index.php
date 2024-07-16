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
  <section class="jumbotron admin d-flex align-items-center">
    <div class="container">
      <div class="row p-2">
        <h1>Selamat Datang, Admin!</h1>
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
            Website ini hadir untuk membantu Anda mengatur jadwal perkuliahan
            dan mengedit mata kuliah dengan mudah. Buat dan kelola jadwal,
            serta atur informasi mata kuliah.
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- End of Jumbotron -->
  <section>
    <div class="container">
      <div class="row text-center mb-2">
        <h1>Menu Admin APD Learning Space</h1>
      </div>
      <div class="row justify-content-center">
        <div class="card m-1 p-3" style="width: 20rem">
          <img src="../src/images/eric-rothermel-FoKO4DpXamQ-unsplash.jpg" alt="" class="img-fluid rounded" />
          <div class="card-body">
            <h5 class="card-title text-center">Jadwal Perkuliahan</h5>
            <p class="card-text">
              Lorem ipsum dolor, sit amet consectetur adipisicing elit. Natus
              quasi culpa quos in harum quidem mollitia, repellat expedita hic
              voluptates!
            </p>
            <div class="card-footer text-end">
              <small>
                <a href="jadwal-kuliah.php">Lanjut<i class="bi bi-arrow-right-short"></i> </a></small>
            </div>
          </div>
        </div>
        <div class="card m-1 p-2" style="width: 20rem">
          <img src="../src/images/patrick-tomasso-Oaqk7qqNh_c-unsplash.jpg" alt="" />
          <div class="card-body">
            <h5 class="card-title text-center">Mata Kuliah</h5>
            <p class="card-text">
              Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iste,
              deleniti. Harum provident dolorem saepe beatae maiores veritatis
              alias esse debitis?
            </p>
            <div class="card-footer text-end">
              <small>
                <a href="mata-kuliah.php">Lanjut<i class="bi bi-arrow-right-short"></i></a>
              </small>
            </div>
          </div>
        </div>
        <div class="card m-1 p-2" style="width: 20rem">
          <img src="../src/images/hero-mah.jpg" alt="" />
          <div class="card-body">
            <h5 class="card-title text-center">Data Pengguna</h5>
            <p class="card-text">
              Lorem ipsum dolor, sit amet consectetur adipisicing elit. Natus
              quasi culpa quos in harum quidem mollitia, repellat expedita hic
              voluptates!
            </p>
            <div class="card-footer text-end">
              <small>
                <a href="data-users.php">Lanjut<i class="bi bi-arrow-right-short"></i>
                </a>
              </small>
            </div>
          </div>
        </div>
        <div class="card m-1 p-2" style="width: 20rem">
          <img src="../src/images/debby-hudson-TqKFiMR9O6s-unsplash.jpg" alt="" />
          <div class="card-body">
            <h5 class="card-title text-center">Request Pergantian Jadwal</h5>
            <p class="card-text">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum
              dignissimos sapiente qui! Saepe totam sequi rem, magni
              perferendis consequatur ex.
            </p>
            <div class="card-footer text-end">
              <small>
                <a href="list-request.php">Lanjut<i class="bi bi-arrow-right-short"></i></a>
              </small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
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
  <section>
    <div class="container">
      <div class="row text-center mb-3">
        <h1>Visi dan Misi Program Studi</h1>
      </div>
      <div class="row align-items-center justify-content-center">
        <div class="col-md-6">
          <div class="card p-3">
            <div class="card-body">
              <h5 class="card-title text-center">Visi</h5>
              <p class="card-text">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut
                quis accusamus quam dignissimos neque officia amet sequi
                voluptas error fuga explicabo libero labore laboriosam,
                consectetur velit? Animi asperiores corporis adipisci, nihil
                odio sequi nisi rem qui debitis quidem voluptatum iure ea, eum
                nesciunt dignissimos iste quam ipsam quo fugiat temporibus.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card p-3">
            <div class="card-body">
              <h5 class="card-title text-center">Misi</h5>
              <p class="card-text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem
                odit porro temporibus deserunt reprehenderit aliquid delectus,
                veritatis omnis nisi, praesentium itaque quae atque sed quos.
                Impedit amet doloremque fuga laudantium expedita laborum
                ducimus, molestias iure unde molestiae cumque quia nulla
                temporibus labore, similique harum culpa vitae quos illo qui
                tenetur.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End of About -->
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
  <footer class="text-center pb-1 pt-4" style="background-color: #c6ac8f">
    <p>Created with <i class="bi bi-heart-fill"></i>, Aulia Kinanah</p>
  </footer>
  <!-- End of Footer-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>