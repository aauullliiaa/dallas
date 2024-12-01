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

// Pindahkan logika POST ke sini
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_tugas_id']) && isset($_POST['delete_pertemuan_id'])) {
  $tugas_id = $_POST['delete_tugas_id'];
  $pertemuan_id = $_POST['delete_pertemuan_id'];

  $task = retrieve("SELECT * FROM tugas_pertemuan WHERE id = ? AND dosen_id = ?", [$tugas_id, $dosen_id]);

  if (!empty($task)) {
    if (deletePertemuan($pertemuan_id)) {
      $_SESSION['message'] = "Tugas berhasil dihapus.";
      $_SESSION['alert_type'] = "success";
    } else {
      $_SESSION['message'] = "Gagal menghapus tugas, silakan coba lagi.";
      $_SESSION['alert_type'] = "danger";
    }
  } else {
    $_SESSION['message'] = "Anda tidak memiliki izin untuk menghapus tugas ini.";
    $_SESSION['alert_type'] = "danger";
  }

  header("Location: tugas-matkul.php?id=$matkul_id");
  exit;
}

// Ambil pesan dari session
$message = $_SESSION['message'] ?? '';
$alert_type = $_SESSION['alert_type'] ?? '';

// Hapus pesan dari session setelah diambil
unset($_SESSION['message']);
unset($_SESSION['alert_type']);
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
  <?php include 'navbar.php' ?>
  <section class="tugas-jumbotron d-flex align-items-center justify-content-center">
    <div class="row text-center">
      <h1>Tugas Kuliah</h1>
    </div>
  </section>
</header>

<body>
  <div class="container mt-5">
    <?php if ($message): ?>
      <div class="alert alert-<?= $alert_type; ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
      if (confirm("Apakah Anda yakin ingin keluar?")) {
        window.location.href = "../logout.php";
      }
    }
  </script>
</body>

</html>