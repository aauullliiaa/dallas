<?php
session_start();
require '../src/db/functions.php';
checkRole('mahasiswa');

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Data profil yang diambil dari input pengguna
  $data = [
    'email' => $_POST['email'],
    'nama' => $_POST['nama'],
    'telepon' => $_POST['telepon'],
    'tempatlahir' => $_POST['tempatlahir'],
    'tanggallahir' => $_POST['tanggallahir'],
    'kelas' => $_POST['kelas'],
    'alamat' => $_POST['alamat'],
  ];

  // Panggil fungsi updateProfile
  $result = updateProfile($user_id, $role, $data);

  // Ambil hasil dari fungsi updateProfile
  $profile = $result['profile'];
  $message = $result['message'];
  $alert_type = $result['alert_type'];
} else {
  // Jika bukan POST, maka ambil data profil pengguna dari database
  $profile = getUserProfile($user_id, $role);
  $message = '';
  $alert_type = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>APD Learning Space - Edit Profil</title>
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

<body>
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
              <a class="nav-link dropdown-toggle" href="index.php#home" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Home
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="index.php#about">About</a></li>
                <li><a class="dropdown-item" href="index.php#kata-sambutan">Kata Sambutan</a></li>
                <li><a class="dropdown-item" href="index.php#alamat">Alamat dan Kontak</a></li>
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
              <a class="nav-link" href="profile.php">Profil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End of Navbar -->
    <section class="d-flex align-items-center justify-content-center">
      <h1>Edit Profil</h1>
    </section>
  </header>

  <div class="container edit-profile">
    <div class="card p-3">
      <div class="card-body">
        <div class="row mb-3 ">
          <img src="../src/images/<?= htmlspecialchars($profile["foto"]); ?>"
            style="width: 100px; margin: 0; border-radius: 50%;">
        </div>
        <?php if ($message != ""): ?>
          <div class="alert alert-<?= htmlspecialchars($alert_type); ?>" role="alert">
            <?= htmlspecialchars($message); ?>
          </div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($profile["email"]); ?>" class="form-control"
              readonly>
          </div>
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($profile["nama"]); ?>"
              class="form-control readonly" readonly>
          </div>
          <div class="mb-4">
            <label for="nim">NIM</label>
            <input type="text" name="nim" value="<?= htmlspecialchars($profile["nim"]); ?>" class="form-control"
              disabled readonly>
          </div>
          <div class="mb-4">
            <label for="telepon">Telepon</label>
            <input type="text" name="telepon" value="<?= htmlspecialchars($profile["telepon"]); ?>" class="form-control"
              maxlength="13" readonly>
          </div>
          <div class="mb-4">
            <label for="tempatlahir">Tempat Lahir</label>
            <input type="text" name="tempatlahir" value="<?= htmlspecialchars($profile["tempatlahir"]); ?>"
              class="form-control" readonly>
          </div>
          <div class="mb-4">
            <label for="tanggallahir">Tanggal Lahir</label>
            <input type="date" name="tanggallahir" value="<?= htmlspecialchars($profile["tanggallahir"]); ?>"
              class="form-control" readonly>
          </div>
          <div class="form-group mb-3">
            <label for="kelas" class="form-label">Kelas</label>
            <input type="text" name="kelas" class="form-control" value="<?= htmlspecialchars($profile["kelas"]); ?>"
              readonly>
          </div>
          <div class="mb-4">
            <label for="alamat">Alamat</label> <!-- Menambahkan field alamat -->
            <input type="text" name="alamat" class="form-control" value="<?= htmlspecialchars($profile["alamat"]); ?>"
              readonly>
          </div>
        </form>
        <div class="row">
          <div class="col submit-button text-center">
            <a href="index.php"><button class="btn btn-light">Kembali</button></a>
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