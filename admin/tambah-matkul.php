<?php
session_start();
require '../src/db/functions.php';
checkRole('admin');

// Ambil daftar nama dosen dari tabel dosen_profiles
$dosenList = [];
$query = "SELECT user_id, nama FROM dosen_profiles";
$result = $db->query($query);
if ($result) {
  while ($row = $result->fetch_assoc()) {
    $dosenList[] = $row;
  }
}

// Proses form mata kuliah
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  list($message, $alert_type) = processCourseFormByAdmin($db);
}

// Menutup koneksi
$db->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>APD Learning Space - Tambah Mata Kuliah</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
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
              aria-expanded="false">Home</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="index.php#about">About</a></li>
              <li><a class="dropdown-item" href="index.php#kata-sambutan">Kata Sambutan</a></li>
              <li><a class="dropdown-item" href="index.php#alamat">Alamat dan Kontak</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#home" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">Data Pengguna</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="data-dosen.php">Data Dosen</a></li>
              <li><a class="dropdown-item" href="data-mahasiswa.php">Data Mahasiswa</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#home" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">Perkuliahan</a>
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
  <section class="hero-matkul d-flex align-items-center justify-content-center">
    <h1>Tambah Mata Kuliah</h1>
  </section>
</header>

<body>
  <div class="container mt-5">
    <div class="card p-3">
      <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
          <?php if (isset($message)): ?>
            <div class="alert alert-<?= $alert_type; ?>" role="alert">
              <?= $message; ?>
            </div>
          <?php endif; ?>
          <div class="mb-3">
            <label for="kode" class="form-label">Kode Mata Kuliah:</label>
            <input type="text" class="form-control" id="kode" name="kode" required>
          </div>
          <div class="mb-3">
            <label for="nama" class="form-label">Nama Mata Kuliah:</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
          </div>
          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Mata Kuliah:</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label for="dosen_id" class="form-label">Dosen Pengampu:</label>
            <select class="form-control" id="dosen_id" name="dosen_id" required>
              <option value="">Pilih Dosen Pengampu</option>
              <?php foreach ($dosenList as $dosen): ?>
                <option value="<?= htmlspecialchars($dosen['user_id']); ?>"><?= htmlspecialchars($dosen['nama']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="row mb-2">
            <div class="col submit-button">
              <button type="submit" class="btn">Tambah Mata Kuliah</button>
            </div>
          </div>
        </form>
        <div class="row submit-button">
          <a href="mata-kuliah.php"><button class="btn">Kembali</button></a>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>