<?php
session_start();
require '../src/db/functions.php';
checkRole('admin');

// Handle deletion
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  if (deleteMataKuliah($db, $id)) {
    $_SESSION['message'] = "Mata kuliah berhasil dihapus.";
    $_SESSION['alert_type'] = "success";
  } else {
    $_SESSION['message'] = "Gagal menghapus mata kuliah. Silakan coba lagi.";
    $_SESSION['alert_type'] = "danger";
  }
  header('Location: mata-kuliah.php');
  exit;
}

$mata_kuliah = getAllMataKuliah($db);
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
  <script>
    function confirmDeletion(event, url) {
      event.preventDefault();
      if (confirm("Apakah anda yakin ingin menghapus mata kuliah ini?")) {
        window.location.href = url;
      }
    }
  </script>
</head>

<header>
  <?php include 'navbar.php'; ?>
  <section class="hero-matkul d-flex align-items-center justify-content-center">
    <h1>Daftar Mata Kuliah</h1>
  </section>
</header>

<body>
  <div class="container mt-5 mb-5">
    <?php if (isset($_SESSION['message'])): ?>
      <div class="alert alert-<?= $_SESSION['alert_type']; ?>" role="alert">
        <?= $_SESSION['message']; ?>
        <?php unset($_SESSION['message']); ?>
      </div>
    <?php endif; ?>
    <div class="card p-3">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead style="vertical-align: middle; text-align: center;">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Kode</th>
                <th scope="col">Nama Mata Kuliah</th>
                <th scope="col">Deskripsi</th>
                <th scope="col">Dosen Pengampu 1</th>
                <th scope="col">Dosen Pengampu 2</th>
                <th scope="col">Semester</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              <?php foreach ($mata_kuliah as $mata_kuliah_item): ?>
                <tr class="text-center">
                  <td><?= $i; ?></td>
                  <td><?= htmlspecialchars($mata_kuliah_item['kode']); ?></td>
                  <td><?= htmlspecialchars($mata_kuliah_item['nama']); ?></td>
                  <td><?= htmlspecialchars($mata_kuliah_item['deskripsi']); ?></td>
                  <td><?= htmlspecialchars($mata_kuliah_item['dosen_1']); ?></td>
                  <td><?= htmlspecialchars($mata_kuliah_item['dosen_2']); ?></td>
                  <td>Semester <?= $mata_kuliah_item['nomor_semester'] ?></td>
                  <td>
                    <a href="mata-kuliah.php?delete=<?= $mata_kuliah_item['id']; ?>" class="btn btn-danger btn-sm"
                      onclick="confirmDeletion(event, this.href)">Hapus</a>
                  </td>
                </tr>
                <?php $i++; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="row text-center">
          <div class="col submit-button">
            <a href="tambah-matkul.php"><button class="btn btn-light">Tambah Mata Kuliah</button></a>
          </div>
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
</body>

</html>