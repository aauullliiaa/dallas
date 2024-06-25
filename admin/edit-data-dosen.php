<?php
session_start();
require '../src/db/functions.php';
checkRole('admin');

$message = '';
$alert_type = '';

// Mengambil id dari data;
$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

// Mengambil data dosen dari id dengan prepared statement
$stmt = $db->prepare("SELECT * FROM dosen_profiles WHERE user_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$dsn = $result->fetch_assoc();
$stmt->close();

// Cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {
  // Memastikan data POST telah disanitasi
  $data = [
    'id' => intval($_POST['id']),
    'nama' => htmlspecialchars($_POST['nama']),
    'nip' => htmlspecialchars($_POST['nip']),
    'email' => htmlspecialchars($_POST['email']),
    'alamat' => htmlspecialchars($_POST['alamat']),
    'telepon' => htmlspecialchars($_POST['telepon']),
  ];

  // Cek apakah data berhasil diedit atau gagal diedit
  if (ubah($data) > 0) {
    $message = "Data berhasil di update!";
    $alert_type = "success";
  } else {
    $message = "Data gagal diedit, silakan coba lagi";
    $alert_type = "error";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Data Dosen</title>
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
              <li><a class="dropdown-item" href="data-dosen.php">Data Dosen</a></li>
              <li><a class="dropdown-item" href="data-mahasiswa.php">Data Mahasiswa</a></li>
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
  <!-- End of Navbar -->
  <section class="mhs-hero d-flex align-items-center justify-content-center">
    <h1>Edit Data Dosen</h1>
  </section>
</header>

<body>
  <div class="container">
    <div class="card p-4 mb-3">
      <div class="card-body">
        <?php if ($message != ''): ?>
          <div class="alert alert-<?= htmlspecialchars($alert_type); ?>">
            <?= htmlspecialchars($message); ?>
          </div>
        <?php endif; ?>
        <form action="" method="post">
          <input type="hidden" name="id" value="<?= htmlspecialchars($dsn["user_id"]); ?>">
          <div class="row">
            <img src="../src/images/<?= htmlspecialchars($dsn["foto"]); ?>"
              style="width: 90px; margin-left: 0px; border-radius: 50%;">
          </div>
          <div class="row mt-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama"
              value="<?= htmlspecialchars($dsn["nama"]); ?>" />
          </div>
          <div class="row mt-2">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" class="form-control" id="nip" name="nip" value="<?= htmlspecialchars($dsn["nip"]); ?>" />
          </div>
          <div class="row mt-2">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email"
              value="<?= htmlspecialchars($dsn["email"]); ?>" />
          </div>
          <div class="row mt-2">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat"
              value="<?= htmlspecialchars($dsn["alamat"]); ?>" />
          </div>
          <div class="row mt-2">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="text" class="form-control" id="telepon" name="telepon"
              value="<?= htmlspecialchars($dsn["telepon"]); ?>" />
          </div>
          <div class="row mt-4">
            <div class="col submit-button">
              <button type="submit" name="submit" class="btn">Simpan</button> |
              <a href="../admin/data-dosen.php" class="btn">Kembali</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>