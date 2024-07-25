<?php
session_start();
require '../src/db/functions.php';
checkRole('dosen');

$user_id = $_SESSION['user_id'];
$dosen_id = get_dosen_id_by_user_id($db, $user_id);

$matkul_id = $_GET["id"];
$detailmk = retrieve("SELECT nama FROM mata_kuliah WHERE id = ?", [$matkul_id])[0];
$tugasList = retrieve("SELECT tp.*, p.pertemuan as pertemuan_ke 
                       FROM tugas_pertemuan tp 
                       JOIN pertemuan p ON tp.pertemuan_id = p.id 
                       WHERE p.mata_kuliah_id = ? AND tp.dosen_id = ?",
  [$matkul_id, $dosen_id]
);

$message = $_SESSION['message'] ?? '';
$alert_type = $_SESSION['alert_type'] ?? '';

// Hapus pesan dari sesi setelah ditampilkan
unset($_SESSION['message']);
unset($_SESSION['alert_type']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_tugas_id']) && isset($_POST['delete_pertemuan_id'])) {
  $tugas_id = $_POST['delete_tugas_id'];
  $pertemuan_id = $_POST['delete_pertemuan_id'];

  $task = retrieve("SELECT * FROM tugas_pertemuan WHERE id = ? AND dosen_id = ?", [$tugas_id, $dosen_id]);

  if (!empty($task)) {
    if (deletePertemuan($pertemuan_id)) {
      $message = "Tugas berhasil dihapus.";
      $alert_type = "success";
    } else {
      $message = "Gagal menghapus tugas, silakan coba lagi.";
      $alert_type = "danger";
    }
  } else {
    $message = "Anda tidak memiliki izin untuk menghapus tugas ini.";
    $alert_type = "danger";
  }

  header("Location: tugas-matkul.php?id=$matkul_id&message=$message&alert_type=$alert_type");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>APD Learning Space - Tugas Kuliah</title>
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
                <a class="dropdown-item" href="index.php#vision-mission">Visi dan Misi</a>
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
            <a class="nav-link" href="../logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <section class="tugas-jumbotron d-flex align-items-center justify-content-center">
    <div class="row text-center">
      <h1>Tugas Kuliah</h1>
    </div>
  </section>
</header>

<body>
  <div class="container mt-5">
    <?php if ($message): ?>
      <div class="alert alert-<?= $alert_type; ?>">
        <?= htmlspecialchars($message); ?>
      </div>
    <?php endif; ?>
    <div class="row mb-3">
      <div class="row">
        <h4>Mata Kuliah</h4>
        <p><?= htmlspecialchars($detailmk['nama']); ?></p>
      </div>
      <div class="col submit-button mb-2">
        <a href="tambah-tugas.php?matkul_id=<?= $matkul_id; ?>"><button class="btn">Berikan Tugas</button></a>
        <a href="detail-matkul.php?id=<?= $matkul_id; ?>"><button class="btn">Kembali</button></a>
      </div>
    </div>
    <div class="card p-3">
      <div class="card-body">
        <div class="row list-tugas">
          <ul>
            <?php if (empty($tugasList)): ?>
              <li>
                <p>Belum ada tugas yang diberikan.</p>
              </li>
            <?php else: ?>
              <?php foreach ($tugasList as $tugas): ?>
                <li>
                  <div class="row justify-content-between">
                    <div class="col-md-6">
                      <h5>
                        Pertemuan ke-<?= htmlspecialchars($tugas['pertemuan_ke']); ?>
                      </h5>
                      <h6><?= htmlspecialchars($tugas['judul']); ?></h6>
                      <p><?= nl2br(htmlspecialchars($tugas['deskripsi'])); ?></p>
                      <?php if (!empty($tugas['file_tugas'])): ?>
                        <p><a href="../src/files/assignment/<?= htmlspecialchars($tugas['file_tugas']); ?>">Lihat Tugas</a>
                        </p>
                      <?php endif; ?>
                    </div>
                    <div class="row">
                      <div class="col-md-2 submit-button">
                        <a
                          href="lihat-tugas.php?tugas_id=<?= $tugas['id']; ?>&matkul_id=<?= $matkul_id; ?>&pertemuan_id=<?= $tugas['pertemuan_id']; ?>"><button
                            class="btn btn-light mb-1">Lihat</button></a>
                        <form action="" method="post"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');">
                          <input type="hidden" name="delete_tugas_id" value="<?= $tugas['id']; ?>" />
                          <input type="hidden" name="delete_pertemuan_id" value="<?= $tugas['pertemuan_id']; ?>" />
                          <button type="submit" class="btn btn-light">Hapus</button>
                        </form>
                      </div>
                    </div>
                  </div>
                  <hr />
                </li>
              <?php endforeach; ?>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>