<?php
session_start();
require '../src/db/functions.php';
checkRole('mahasiswa');

$matkul_id = $_GET["id"];
$detailmk = retrieve("SELECT * FROM mata_kuliah WHERE id =?", [$matkul_id]);
if (empty($detailmk)) {
  die("Mata kuliah tidak ditemukan.");
}
$detailmk = $detailmk[0];

$tugasList = retrieve("SELECT tp.*, p.pertemuan as pertemuan_ke, d.nama as nama_dosen 
                       FROM tugas_pertemuan tp 
                       JOIN pertemuan p ON tp.pertemuan_id = p.id 
                       JOIN daftar_dosen d ON p.dosen_id = d.id
                       WHERE p.mata_kuliah_id = ?
                       ORDER BY p.pertemuan",
  [$matkul_id]
);

$user_id = $_SESSION['user_id']; // assuming you have the user ID stored in the session
$mahasiswa = retrieve("SELECT id FROM daftar_mahasiswa WHERE user_id = ?", [$user_id]);
if (empty($mahasiswa)) {
  die("Mahasiswa tidak ditemukan.");
}
$mahasiswa_id = $mahasiswa[0]['id'];

// Dosen ID and name retrieval
$pertemuan = retrieve("SELECT dosen_id FROM pertemuan WHERE mata_kuliah_id = ? LIMIT 1", [$matkul_id]);
if (!empty($pertemuan)) {
  $dosen_id = $pertemuan[0]['dosen_id'];
  $nama_dosen = retrieve("SELECT nama FROM daftar_dosen WHERE id = ?", [$dosen_id])[0]['nama'];
} else {
  $dosen_id = null;
  $nama_dosen = "Tidak ditemukan";
}

$tugas_kumpul = retrieve("SELECT * FROM tugas_kumpul WHERE mahasiswa_id =? AND tugas_id IN (SELECT id FROM tugas_pertemuan WHERE pertemuan_id IN (SELECT id FROM pertemuan WHERE mata_kuliah_id =?))", [$mahasiswa_id, $matkul_id]);

$dosen_pengampu = retrieve("SELECT DISTINCT d.nama 
                            FROM pertemuan p 
                            JOIN daftar_dosen d ON p.dosen_id = d.id
                            WHERE p.mata_kuliah_id = ?",
  [$matkul_id]
);
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
  <?php include 'navbar.php'; ?>
  <section class="tugas-jumbotron d-flex align-items-center justify-content-center">
    <div class="row text-center">
      <h1>Tugas Kuliah</h1>
    </div>
  </section>
</header>

<body>
  <div class="container mt-5 mb-5">
    <div class="row mb-3">
      <div class="row">
        <h4>Mata Kuliah</h4>
        <p><?= htmlspecialchars($detailmk['nama']); ?></p>
      </div>
      <div class="col submit-button mb-2">
        <a href="detail-matkul.php?id=<?= $matkul_id; ?>"><button class="btn">Kembali</button></a>
      </div>
    </div>
    <div class="row list-tugas">
      <?php if (empty($tugasList)): ?>
        <p>Belum ada tugas yang diberikan oleh dosen.</p>
      <?php else: ?>
        <hr>
        <ul>
          <?php foreach ($tugasList as $tugas): ?>
            <li>
              <h5>Pertemuan ke-<?= htmlspecialchars($tugas['pertemuan_ke']); ?></h5>
              <div class="row">
                <h6><?= htmlspecialchars($tugas['judul']); ?></h6>
                <p><?= nl2br(htmlspecialchars($tugas['deskripsi'])); ?></p>
                <small>Diberikan oleh: <?= htmlspecialchars($tugas['nama_dosen']) ?></small>
                <small>Tenggat: <?= htmlspecialchars($tugas['tanggal_deadline']) ?>,
                  <?= htmlspecialchars(date('H:i', strtotime($tugas['jam_deadline']))) ?></small>
                </p>
                <?php if (!empty($tugas['file_tugas'])): ?>
                  <p><a href="../src/files/assignment/<?= htmlspecialchars($tugas['file_tugas']); ?>" target="_blank">Lihat
                      Tugas</a></p>
                <?php else: ?>
                  <p><span class="badge rounded-pill text-bg-danger">File tugas tidak tersedia</span></p>
                <?php endif; ?>
                <div class="col">
                  <?php
                  $deadline = strtotime($tugas['tanggal_deadline'] . ' ' . $tugas['jam_deadline']);
                  $current_time = time();

                  $isSubmitted = false;
                  $submission_time = null;
                  foreach ($tugas_kumpul as $kumpul) {
                    if ($kumpul['tugas_id'] == $tugas['id']) {
                      $isSubmitted = true;
                      $submission_time = strtotime($kumpul['tanggal_kumpul'] . ' ' . $kumpul['jam_kumpul']);
                      break;
                    }
                  }

                  if ($isSubmitted): ?>
                    <span class="badge rounded-pill text-bg-success">Tugas telah dikumpulkan</span>
                    <?php if ($submission_time > $deadline): ?>
                      <span class="badge rounded-pill text-bg-danger">Terlambat</span>
                    <?php endif; ?>
                  <?php else: ?>
                    <?php if ($deadline < $current_time): ?>
                      <span class="badge rounded-pill text-bg-danger">Tenggat telah lewat</span>
                    <?php elseif ($deadline - $current_time < 259200): // 3 days in seconds ?>
                      <span class="badge rounded-pill text-bg-warning">Tenggat akan segera berakhir</span>
                    <?php elseif (date('Y-m-d', $deadline) == date('Y-m-d', $current_time)): ?>
                      <span class="badge rounded-pill text-bg-warning">Tenggat hari ini</span>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col submit-button">
                  <a
                    href="upload-tugas.php?tugas_id=<?= $tugas['id']; ?>&matkul_id=<?= $matkul_id; ?>&pertemuan_id=<?= $tugas['pertemuan_id']; ?>"><button
                      class="btn">Upload Tugas</button></a>
                </div>
              </div>
              <hr />
            </li>
          <?php endforeach; ?>
        </ul>
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
      if (confirm("Apakah anda yakin ingin keluar?")) {
        window.location.href = "../logout.php"
      }
    }
  </script>
</body>

</html>