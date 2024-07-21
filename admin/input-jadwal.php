<?php
session_start();
require '../src/db/functions.php';
checkRole('admin');

$message = $_SESSION['message'] ?? '';
$alert_class = $_SESSION['alert_class'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $kelas = htmlspecialchars($_POST['kelas']);
  $semester = htmlspecialchars($_POST['semester']);
  $tahun = htmlspecialchars($_POST['tahun']);
  $file_jadwal = $_FILES['file_jadwal']['tmp_name']; // Mengakses file yang diunggah
  $file_type = $_FILES['file_jadwal']['type']; // Mengakses tipe file yang diunggah

  if (is_uploaded_file($file_jadwal)) {
    add_schedule($kelas, $semester, $tahun, $file_jadwal, $file_type);
    $_SESSION['message'] = "Jadwal berhasil ditambahkan";
    $_SESSION['alert_class'] = 'alert-success';
  } else {
    $_SESSION['message'] = "Jadwal gagal ditambahkan, silakan coba lagi.";
    $_SESSION['alert_class'] = 'alert-danger';
  }
  header("Location: input-jadwal.php");
  exit;
}

unset($_SESSION['message']);
unset($_SESSION['alert_class']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>APD Learning Space - Input Jadwal Kuliah</title>
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
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
            <a class="nav-link dropdown-toggle" href="#home" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Home
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="index.php#about">About</a>
              </li>
              <li>
                <a class="dropdown-item" href="index.php#kata-sambutan">Kata Sambutan</a>
              </li>
              <li>
                <a class="dropdown-item" href="index.php#alamat">Alamat dan Kontak</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="data-users.php">Data Pengguna</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#home" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Perkuliahan
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="jadwal-kuliah.php">Jadwal Kuliah</a>
              </li>
              <li>
                <a class="dropdown-item" href="mata-kuliah.php">Mata Kuliah</a>
              </li>
              <li>
                <a class="dropdown-item" href="list-request.php">Request Pergantian</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <section class="hero-jadwal d-flex align-items-center justify-content-center">
    <h1>Input Jadwal Kuliah</h1>
  </section>
</header>

<body>
  <div class="container">
    <div class="card p-3">
      <div class="card-body">
        <?php if ($message): ?>
          <div class="alert <?= $alert_class ?> alert-dismissible fade show" role="alert">
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="row mb-3">
            <label for="kelas" class="form-label">Kelas</label>
            <select name="kelas" id="kelas" class="form-select">
              <option value="">Pilih Kelas</option>
              <option value="1A">1A</option>
              <option value="1B">1B</option>
            </select>
          </div>
          <div class="row mb-3">
            <label for="semester" class="form-label">Semester</label>
            <select name="semester" id="semester" class="form-select">
              <option value="">Pilih Semester</option>
              <option value="Ganjil">Ganjil</option>
              <option value="Genap">Genap</option>
            </select>
          </div>
          <div class="row mb-3">
            <label for="tahun" class="form-label">Tahun</label>
            <select name="tahun" id="tahun" class="form-select">
              <option value="">Pilih Tahun Ajaran</option>
              <option value="2024/2025">2024/2025</option>
              <option value="2025/2026">2025/2026</option>
            </select>
          </div>
          <div class="row mb-3">
            <label for="file_jadwal" class="form-label">Upload File</label>
            <input type="file" class="form-control" id="file_jadwal" name="file_jadwal" required />
          </div>
          <div class="row text-center">
            <div class="col submit-button">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
        <div class="row mt-2 text-center">
          <div class="col submit-button">
            <a href="jadwal-kuliah.php"><button class="btn btn-secondary">Kembali</button></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>