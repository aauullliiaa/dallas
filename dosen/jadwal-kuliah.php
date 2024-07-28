<?php
session_start();
require '../src/db/functions.php';
checkRole('dosen');

$jadwalHtml = '';
$kelas = '';
$semester = '';
$tahun = '';
$fileType = '';
$fileData = '';
$fileOrientation = 'portrait'; // Default orientation
$message = '';
$alert_class = '';

if (isset($_GET['kelas']) && isset($_GET['semester']) && isset($_GET['tahun'])) {
  $kelas = htmlspecialchars($_GET['kelas']);
  $semester = htmlspecialchars($_GET['semester']);
  $tahun = htmlspecialchars($_GET['tahun']);

  $stmt = $db->prepare('SELECT file_jadwal, file_type FROM jadwal_perkuliahan WHERE kelas = ? AND semester = ? AND tahun = ?');
  $stmt->bind_param('sss', $kelas, $semester, $tahun);
  $stmt->execute();
  $result = $stmt->get_result();
  $jadwal = $result->fetch_assoc();

  if ($jadwal) {
    $filePath = $jadwal['file_jadwal'];
    $fileType = $jadwal['file_type'];
    if (strpos($fileType, 'image') !== false) {
      list($width, $height) = getimagesize($filePath);
      $fileOrientation = $width > $height ? 'landscape' : 'portrait';
      $jadwalHtml = '<img src="' . $filePath . '" class="img-fluid" alt="Jadwal Perkuliahan">';
    } elseif ($fileType == 'application/pdf') {
      $fileOrientation = 'landscape';
      $jadwalHtml = '<embed src="' . $filePath . '" type="application/pdf" width="100%" height="600px" />';
    }
  } else {
    $_SESSION['message'] = "Jadwal tidak ditemukan, silakan melapor ke admin untuk menambahkan jadwal terlebih dahulu.";
    $_SESSION['alert_class'] = "alert-warning";
  }
}
$message = $_SESSION['message'] ?? '';
$alert_class = $_SESSION['alert_class'] ?? '';
unset($_SESSION['message']);
unset($_SESSION['alert_class']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>APD Learning Space - Jadwal Perkuliahan</title>
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
  <style>
    @media print {
      body * {
        visibility: hidden;
      }

      #jadwalContainer,
      #jadwalContainer * {
        visibility: visible;
      }

      .no-print {
        display: none;
      }

      #jadwalContainer {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
      }

      #jadwalContainer img,
      #jadwalContainer embed {
        width: 100%;
        height: 100%;
        object-fit: contain;
        page-break-inside: avoid;
      }

      @page {
        size:
          <?= $fileOrientation ?>
        ;
        margin: 0;
      }

      html,
      body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
      }

      .container {
        width: 100%;
        height: 100%;
        padding: 0;
        margin: 0;
      }

      .card-body {
        padding: 0;
        margin: 0;
      }
    }
  </style>
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
            <a class="nav-link" href="#" onclick="confirmLogout()">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End of Navbar -->
  <section class="hero-jadwal d-flex align-items-center justify-content-center">
    <h1>Jadwal Perkuliahan</h1>
  </section>
</header>

<body>
  <div class="container">
    <div class="card p-3">
      <div class="card-body">
        <?php if ($message): ?>
          <div class="alert <?= $alert_class ?> alert-dismissible fade show" role="alert">
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        <form action="jadwal-kuliah.php" method="GET">
          <div class="row mb-3">
            <label for="kelas" class="form-label">Kelas</label>
            <select name="kelas" id="kelas" class="form-select">
              <option value="">Pilih Kelas</option>
              <option value="1A">1A</option>
              <option value="1B">1B</option>
            </select>
          </div>
          <div class="row mb-3">
            <label for="semester" class="form-label">Semester</label>
            <select name="semester" id="semester" class="form-select">
              <option value="">Pilih Semester</option>
              <option value="Ganjil">Ganjil</option>
              <option value="Genap">Genap</option>
            </select>
          </div>
          <div class="row mb-3">
            <label for="tahun" class="form-label">Tahun</label>
            <select name="tahun" id="tahun" class="form-select">
              <option value="">Pilih Tahun</option>
              <option value="2024/2025">2024/2025</option>
              <option value="2025/2026">2025/2026</option>
            </select>
          </div>
          <div class="row mb-2 text-center">
            <div class="col submit-button">
              <button type="submit" class="btn">Tampilkan Jadwal</button>
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col submit-button text-center">
            <a href="index.php"><button class="btn">Kembali</button></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container mt-3 mb-5" id="jadwalContainer">
    <div class="card p-1">
      <div class="card-body">
        <?php if ($jadwalHtml): ?>
          <div class="d-flex justify-content-end mb-3 no-print">
            <button class="btn btn-secondary me-2 no-print"
              onclick="downloadJadwal('<?= $kelas ?>', '<?= $semester ?>', '<?= $tahun ?>', '<?= $fileType ?>')">Download</button>
            <button class="btn btn-secondary no-print" onclick="printJadwal()">Print</button>
          </div>
          <script>
            // Menghapus parameter GET dari URL setelah hasil ditampilkan
            if (window.history.replaceState) {
              const url = window.location.origin + window.location.pathname;
              window.history.replaceState({ path: url }, '', url);
            }
          </script>
        <?php endif; ?>
        <?php echo $jadwalHtml; ?>
      </div>
    </div>
  </div>
  <script>
    function downloadJadwal(kelas, semester, tahun, fileType) {
      const filePath = document.querySelector('#jadwalContainer img, #jadwalContainer embed').src;
      const link = document.createElement('a');
      link.href = filePath;
      link.download = `jadwal_${kelas}_${semester}_${tahun}.${fileType.split('/')[1]}`;
      link.click();
    }

    function printJadwal() {
      const content = document.querySelector('#jadwalContainer img, #jadwalContainer embed');
      const win = window.open('', '_blank');
      win.document.write('<html><head><title>Print</title>');
      win.document.write('<style>');
      win.document.write(`
    @page { size: ${content.naturalWidth > content.naturalHeight ? 'landscape' : 'portrait'}; margin: 0; }
    html, body { margin: 0; padding: 0; width: 100%; height: 100%; }
    img, embed { width: 100%; height: 100%; object-fit: contain; }
  `);
      win.document.write('</style></head><body>');
      win.document.write(content.outerHTML);
      win.document.close();
      win.onload = function () {
        win.focus();
        win.print();
        win.close();
      };
    }
  </script>
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