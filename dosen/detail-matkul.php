<?php
session_start();
require '../src/db/functions.php';
checkRole('dosen');

$id = $_GET["id"];
$matkul = retrieve("SELECT * FROM mata_kuliah WHERE id = ?", [$id])[0];
$materi = retrieve("SELECT * FROM materi WHERE mata_kuliah_id = ? ORDER BY pertemuan", [$id]);

// Ambil nama dosen berdasarkan dosen_id
$dosen_id = $matkul['dosen_id'];
$dosen = retrieve("SELECT nama FROM dosen_profiles WHERE user_id = ?", [$dosen_id])[0]['nama'];

$message = $_SESSION['message'] ?? '';
$alert_type = $_SESSION['alert_type'] ?? '';

unset($_SESSION['message']);
unset($_SESSION['alert_type']);

if (isset($_POST['delete_materi_id'])) {
  $delete_id = $_POST['delete_materi_id'];
  if (deleteMateri($delete_id)) {
    header("Location: detail-matkul.php?id=$id");
    exit();
  } else {
    echo "Error deleting record: " . $db->error;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>APD Learning Space - Detail Mata Kuliah</title>
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
  <section class="hero-matkul d-flex align-items-center justify-content-center">
    <h1>Detail Mata Kuliah</h1>
  </section>
</header>

<body>
  <div class="container detail-matkul">
    <?php if ($message != ''): ?>
      <div class="alert alert-<?= htmlspecialchars($alert_type); ?>" role="alert">
        <?= htmlspecialchars($message); ?>
      </div>
    <?php endif; ?>
    <div class="row desc-matkul">
      <h1 class="pb-2"><?= htmlspecialchars($matkul["nama"]) ?></h1>
      <h4>Kode Mata Kuliah</h4>
      <p><?= htmlspecialchars($matkul["kode"]) ?></p>
      <h4>Deskripsi</h4>
      <p>
        <?= nl2br(htmlspecialchars($matkul["deskripsi"])) ?>
      </p>
      <h4>Dosen Pengampu</h4>
      <p><?= htmlspecialchars($dosen); ?></p>
    </div>
    <div class="row">
      <div class="col submit-button">
        <a href="edit-matkul.php?id=<?= htmlspecialchars($matkul["id"]); ?>"><button
            class="btn btn-light">Edit</button></a>
        <a href="upload-materi.php?id=<?= htmlspecialchars($matkul["id"]); ?>"><button class="btn btn-light">Upload
            Materi</button></a>
        <a href="tugas-matkul.php?id=<?= htmlspecialchars($matkul["id"]); ?>"><button
            class="btn btn-light">Tugas</button></a>
        <a href="mata-kuliah.php"><button class="btn btn-light">Kembali</button></a>
      </div>
    </div>
    <div class="row list-materi pt-4">
      <h3>Materi</h3>
      <?php if (empty($materi)): ?>
        <p>Belum ada materi yang diberkan.</p>
      <?php else: ?>
        <?php foreach ($materi as $row): ?>
          <ul>
            <li>
              <div class="row justify-content-between">
                <div class="col-md-7">
                  <h5>Pertemuan Ke-<?= htmlspecialchars($row["pertemuan"]) ?></h5>
                  <p>
                    <?= nl2br(htmlspecialchars($row["deskripsi"])); ?>
                  </p>
                </div>
                <div class="col-md-2 submit-button">
                  <a href="<?= htmlspecialchars($row["file_path"]) ?>"><button
                      class="btn btn-light mb-1">Download</button></a>
                  <!-- Tombol Hapus Materi -->
                  <form method="post" style="display:inline;">
                    <input type="hidden" name="delete_materi_id" value="<?= htmlspecialchars($row['id']) ?>">
                    <button type="submit" class="btn btn-light mb-1"
                      onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">Hapus</button>
                  </form>
                </div>
              </div>
            </li>
          </ul>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>