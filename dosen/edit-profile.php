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
$email = $_SESSION['email'];

// Fetch user profile data based on the user role
$profile = getUserProfile($user_id, $_SESSION['role']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Gather form data
  $data['nama'] = $_POST['nama'];
  $data['nip'] = $_POST['nip'];
  $data['telepon'] = $_POST['telepon'];
  $data['tempatlahir'] = $_POST['tempatlahir'];
  $data['tanggallahir'] = $_POST['tanggallahir'];
  $data['penghargaan'] = $_POST['penghargaan'];
  $data['pengabdian'] = $_POST['pengabdian'];
  $data['alamat'] = $_POST['alamat'];
  $data['foto'] = '';

  // Handle file upload
  if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $target_dir = "../src/images/";
    $target_file = $target_dir . basename($_FILES["foto"]["name"]);
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
      $data['foto'] = $_FILES['foto']['name'];
    } else {
      $message = "Maaf, terjadi kesalahan saat mengunggah foto Anda.";
      $alert_type = "danger";
    }
  } else {
    $data['foto'] = $profile['foto'];
  }

  if (empty($message)) {
    if (updateUserProfile($user_id, $_SESSION['role'], $data)) {
      $message = "Profil berhasil diperbarui";
      $alert_type = 'success';
      // Refresh profile data
      $profile = getUserProfile($user_id, $_SESSION['role']);
    } else {
      $message = "Terjadi kesalahan saat memperbarui profil.";
      $alert_type = 'danger';
    }
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>APD Learning Space - Edit Profile</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
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
              <a class="nav-link" href="edit-profile.php">Profil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../logout.php">Logout</a>
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
        <form method="post" enctype="multipart/form-data">
          <div class="form-group mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control"
              value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" disabled>
          </div>
          <div class="form-group mb-3">
            <label for="nama">Nama:</label>
            <input type="text" name="nama" class="form-control"
              value="<?= htmlspecialchars($profile['nama'], ENT_QUOTES, 'UTF-8'); ?>" required>
          </div>
          <div class="form-group mb-3">
            <label for="nip" class="form-label">NIP:</label>
            <input type="text" name="nip" class="form-control"
              value="<?= htmlspecialchars($profile['nip'], ENT_QUOTES, 'UTF-8'); ?>" required>
          </div>
          <div class="form-group mb-3">
            <label for="telepon">Telepon:</label>
            <input type="text" name="telepon" class="form-control"
              value="<?= htmlspecialchars($profile['telepon'], ENT_QUOTES, 'UTF-8'); ?>" required>
          </div>
          <div class="form-group mb-3">
            <label for="tempatlahir" class="form-label">Tempat Lahir:</label>
            <input type="text" name="tempatlahir" class="form-control"
              value="<?= htmlspecialchars($profile['tempatlahir'], ENT_QUOTES, 'UTF-8'); ?>" required>
          </div>
          <div class="form-group mb-3">
            <label for="tanggallahir" class="form-label">Tanggal Lahir:</label>
            <input type="date" name="tanggallahir" class="form-control"
              value="<?= htmlspecialchars($profile['tanggallahir'], ENT_QUOTES, 'UTF-8'); ?>" required>
          </div>
          <div class="form-group mb-3">
            <label for="foto" class="form-label">Foto:</label>
            <input type="file" name="foto" class="form-control">
          </div>
          <div class="form-group mb-3">
            <label for="penghargaan" class="form-label">Penghargaan:</label>
            <textarea name="penghargaan"
              class="form-control"><?= htmlspecialchars($profile['penghargaan'], ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
          <div class="form-group mb-3">
            <label for="pengabdian" class="form-label">Pengabdian:</label>
            <textarea name="pengabdian"
              class="form-control"><?= htmlspecialchars($profile['pengabdian'], ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
          <div class="form-group mb-3">
            <label for="alamat" class="form-label">Alamat:</label>
            <textarea name="alamat"
              class="form-control"><?= htmlspecialchars($profile['alamat'], ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
          <div class="row mb-1">
            <div class="col text-center submit-button">
              <button type="submit" class="btn btn-light">Update Profile</button>
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
</body>

</html>