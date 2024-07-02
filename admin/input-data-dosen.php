<?php
session_start();
require '../src/db/functions.php';
checkRole('admin');

$message = '';
$alert_type = '';

if (isset($_POST['submit'])) {
  $nama = htmlspecialchars($_POST["nama"]);
  $nip = htmlspecialchars($_POST["nip"]);

  if (!empty($nama) && !empty($nip)) {
    $data = [
      'nama' => $nama,
      'nip' => $nip
    ];
    $result = input_dosen($data);
    if ($result === true) {
      $alert_type = 'success';
      $message = 'Data berhasil ditambahkan';
    } else {
      $alert_type = 'danger';
      $message = 'Data gagal ditambahkan: ' . $result;
    }
  } else {
    $alert_type = 'danger';
    $message = 'Data tidak boleh kosong';
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>APD Learning Space - Input NIP Dosen</title>
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
              <li><a class="dropdown-item" href="index.php#about">About</a></li>
              <li>
                <a class="dropdown-item" href="index.php#kata-sambutan">Kata Sambutan</a>
              </li>
              <li>
                <a class="dropdown-item" href="index.php#alamat">Alamat dan Kontak</a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#home" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Data Pengguna
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="data-users.php">Data Pengguna</a></li>
              <li>
                <a class="dropdown-item" href="input-data-dosen.php">Input Data Dosen</a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#home" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Perkuliahan
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="jadwal-kuliah.php">Jadwal Kuliah</a></li>
              <li><a class="dropdown-item" href="mata-kuliah.php">Mata Kuliah</a></li>
              <li><a class="dropdown-item" href="tambah-matkul.php">Tambah Mata Kuliah</a></li>
              <li><a class="dropdown-item" href="jadwal-pergantian.php">Pergantian</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <section>
    <div class="row text-center">
      <h1>Input Data Dosen</h1>
    </div>
  </section>
</header>

<body>
  <div class="container">
    <div class="card p-3">
      <div class="card-body">
        <?php if ($message): ?>
          <div class="alert alert-<?= $alert_type; ?>" role="alert">
            <?= $message; ?>
          </div>
        <?php endif; ?>
        <form action="" method="post">
          <div class="mb-3">
            <label for="nama" class="form-label">Nama Dosen</label>
            <input type="text" class="form-control" name="nama" id="nama" required />
          </div>
          <div class="mb-3">
            <label for="nip" class="form-label">Nomor Induk Pegawai</label>
            <input type="text" class="form-control" name="nip" id="nip" maxlength="18" required />
          </div>
          <div class="mt-3 text-center">
            <div class="col submit-button">
              <button type="submit" class="btn btn-light" name="submit">
                Submit
              </button>
            </div>
          </div>
        </form>
        <div class="row mt-2 text-center">
          <div class="col submit-button">
            <a href="index.php" class="btn btn-light">Kembali</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>