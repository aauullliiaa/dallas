<?php
session_start();
require '../src/db/functions.php';

// Check if the user has the required role
checkRole('dosen');

// Initialize message and alert type
$message = '';
$alert_type = '';

// Fetch user ID and email from the session
$user_id = $_SESSION['user_id'];

// Fetch user profile data based on the user role
$profile = getUserProfile($user_id, $_SESSION['role']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Handle file upload within updateProfile function
  $result = updateProfile($user_id, $_SESSION['role'], $data);
  $message = $result['message'];
  $alert_type = $result['alert_type'];
  $profile = $result['profile'];
}
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>APD Learning Space - Mata Kuliah</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
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
              <a class="nav-link" href="#" onclick="confirmLogout()">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <section>
    <div class="row text-center">
      <h1>Edit Profile</h1>
    </div>
  </section>

  <div class="container edit-profile">
    <div class="card p-3">
      <div class="card-body">
        <div class="row mb-3 text-center">
          <img src="../src/images/<?= htmlspecialchars($profile['foto'], ENT_QUOTES, 'UTF-8'); ?>"
            style="border-radius: 50%; width: 100px;">
        </div>
        <?php if (!empty($message)): ?>
          <div class="alert alert-<?= htmlspecialchars($alert_type, ENT_QUOTES, 'UTF-8'); ?>" role="alert">
            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
          </div>
        <?php endif; ?>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-group mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control"
              value="<?= htmlspecialchars($profile['email'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
          </div>
          <div class="form-group mb-3">
            <label for="nama">Nama:</label>
            <input type="text" name="nama" class="form-control"
              value="<?= htmlspecialchars($profile['nama'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
          </div>
          <div class="form-group mb-3">
            <label for="nip" class="form-label">NIP:</label>
            <input type="text" name="nip" class="form-control"
              value="<?= htmlspecialchars($profile['nip'], ENT_QUOTES, 'UTF-8'); ?>" readonly disabled>
          </div>
          <div class="form-group mb-3">
            <label for="telepon">Telepon:</label>
            <input type="text" name="telepon" class="form-control"
              value="<?= htmlspecialchars($profile['telepon'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
          </div>
          <div class="form-group mb-3">
            <label for="tempatlahir" class="form-label">Tempat Lahir:</label>
            <input type="text" name="tempatlahir" class="form-control"
              value="<?= htmlspecialchars($profile['tempatlahir'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
          </div>
          <div class="form-group mb-3">
            <label for="tanggallahir" class="form-label">Tanggal Lahir:</label>
            <input type="date" name="tanggallahir" class="form-control"
              value="<?= htmlspecialchars($profile['tanggallahir'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
          </div>
          <div class="form-group mb-3">
            <label for="alamat" class="form-label">Alamat:</label>
            <textarea name="alamat"
              class="form-control"><?= htmlspecialchars($profile['alamat'], ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
          <div class="form-group mb-3">
            <label for="foto" class="form-label">Foto:</label>
            <input type="file" name="foto" class="form-control">
          </div>
          <div class="row mb-1">
            <div class="col text-center submit-button">
              <button type="submit" name="submit" class="btn btn-light">Update Profil</button>
            </div>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
  <script>
    function confirmLogout() {
      if (confirm("Apakah anda yakin ingin keluar?")) {
        window.location.href = "../logout.php";
      }
    }
  </script>
</body>

</html>