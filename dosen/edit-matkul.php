<?php
session_start();
require '../src/db/functions.php';
checkRole('dosen');

$message = '';
$alert_type = '';

// Menggunakan parameterized query untuk mencegah SQL Injection
$id = $_GET["id"];
$matkul = retrieve("SELECT * FROM mata_kuliah WHERE id =?", [$id])[0];
$dosen_id = $matkul["dosen_id"]; // Get the dosen ID from the mata kuliah data
$dosen_data = retrieve("SELECT * FROM dosen_profiles WHERE user_id =?", [$dosen_id])[0]; // Retrieve the dosen data
$dosen_nama = $dosen_data["nama"]; // Get the dosen's name

if (isset($_POST["submit"])) {
  $data = [
    "id" => $id,
    "nama" => htmlspecialchars($_POST["nama"]),
    "kode" => htmlspecialchars($_POST["kode"]),
    "dosen_id" => $dosen_id, // Pass the dosen ID instead of the dosen name
    "deskripsi" => htmlspecialchars($_POST["deskripsi"])
  ];

  if (editmk($data) > 0) {
    $message = "Detail mata kuliah berhasil diupdate!";
    $alert_type = "success";
  } else {
    $message = "Detail mata kuliah gagal diupdate, silakan coba lagi.";
    $alert_type = "error";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>APD Learning Space - Edit Mata Kuliah</title>
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
  <!-- End of Navbar -->
  <section class="edit-hero d-flex align-items-center justify-content-center">
    <h1>Edit Mata Kuliah</h1>
  </section>
</header>

<body>
  <div class="container">
    <div class="card p-3">
      <div class="card-body">
        <form action="" method="post">
          <?php if ($message != ''): ?>
            <div class="alert alert-<?= $alert_type; ?>">
              <?= $message; ?>
            </div>
          <?php endif; ?>
          <input type="hidden" name="id" value="<?= htmlspecialchars($matkul["id"]) ?>">
          <div class="row mb-3">
            <label for="nama" class="form-label">Nama Mata Kuliah</label>
            <input type="text" class="form-control" id="nama" name="nama"
              value="<?= htmlspecialchars($matkul["nama"]) ?>" required />
          </div>
          <div class="row mb-3">
            <label for="kode" class="form-label">Kode Mata Kuliah</label>
            <input type="text" class="form-control" id="kode" name="kode"
              value="<?= htmlspecialchars($matkul["kode"]) ?>" required />
          </div>
          <div class="row mb-3">
            <label for="dosen" class="form-label">Dosen Pengampu</label>
            <input type="text" class="form-control" id="dosen" name="dosen" value="<?= htmlspecialchars($dosen_nama) ?>"
              readonly>
          </div>
          <div class="row mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Mata Kuliah</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control"
              rows="5"><?= htmlspecialchars($matkul["deskripsi"]) ?></textarea>
          </div>
          <div class="row">
            <div class="col submit-button">
              <button class="btn btn-light mb-2" name="submit" id="submit">Simpan</button>
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col submit-button">
            <a href="detail-matkul.php?id=<?= htmlspecialchars($matkul["id"]) ?>"><button
                class="btn btn-light mb-1">Kembali</button></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLeSaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</body>

</html>