<?php
session_start();
require '../src/db/functions.php';
checkRole('dosen');

$id = $_GET["id"];
$matkul = retrieve("SELECT * FROM mata_kuliah WHERE id = ?", [$id])[0];
$materi = retrieve("SELECT * FROM materi WHERE mata_kuliah_id = ? ORDER BY pertemuan", [$id]);

// Ambil nama dosen berdasarkan dosen_id_1 dan dosen_id_2
$dosen_1_id = $matkul['dosen_id_1'];
$dosen_2_id = $matkul['dosen_id_2'];

$dosen_1 = retrieve("SELECT nama FROM daftar_dosen WHERE id = ?", [$dosen_1_id])[0]['nama'];
$dosen_2 = $dosen_2_id ? retrieve("SELECT nama FROM daftar_dosen WHERE id = ?", [$dosen_2_id])[0]['nama'] : null;

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
  <?php include 'navbar.php'; ?>
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
      <div class="row">
        <p><?= htmlspecialchars($dosen_1); ?> &
          <?php if ($dosen_2): ?>
            <?= htmlspecialchars($dosen_2); ?>
          <?php endif; ?>
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col submit-button">
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
      if (confirm("Apakah anda yakin ingin keluar?"));
      window.location.href = "../logout.php";
    }
  </script>
</body>

</html>