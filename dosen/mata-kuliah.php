<?php
session_start();
require '../src/db/functions.php';
checkRole('dosen');

$message = $_SESSION['message'] ?? '';
$alert_type = $_SESSION['alert_type'] ?? '';

unset($_SESSION['message']);
unset($_SESSION['alert_type']);

$user_id = $_SESSION['user_id'] ?? null;

// Ambil dosen_id dari tabel daftar_dosen berdasarkan user_id
$dosen_id = null;
if ($user_id !== null) {
  $result = retrieve("SELECT id FROM daftar_dosen WHERE user_id = $user_id");
  if (!empty($result)) {
    $dosen_id = $result[0]['id'];
  }
}

$courses = [];
if ($dosen_id !== null) {
  $courses = retrieve("SELECT * FROM mata_kuliah WHERE dosen_id_1 = $dosen_id OR dosen_id_2 = $dosen_id");
}
?>

<!DOCTYPE html>
<html lang="en">

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
<header>
  <?php include 'navbar.php'; ?>
  <section class="hero-matkul d-flex align-items-center justify-content-center">
    <h1>Mata Kuliah</h1>
  </section>
</header>

<body>
  <div class="container">
    <?php if ($message != ''): ?>
      <div class="alert alert-<?= htmlspecialchars($alert_type); ?>" role="alert">
        <?= htmlspecialchars($message); ?>
      </div>
    <?php endif; ?>

    <div class="row daftar-matkul mt-4">
      <h5>Daftar Mata Kuliah</h5>
      <ul>
        <?php if (empty($courses)): ?>
          <li>Belum ada mata kuliah yang terdaftar.</li>
        <?php else: ?>
          <?php foreach ($courses as $course): ?>
            <li>
              <a href="detail-matkul.php?id=<?= $course["id"]; ?>"><?= $course["nama"] ?> -
                <?= $course["kode"] ?></a>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>
  </div>
  <footer class="py-4">
    <div class="container text-center">
      <small>&copy; APD Learning Space - 2024</small>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
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