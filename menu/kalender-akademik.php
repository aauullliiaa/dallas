<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>APD Learning Space - Kalender Akademik</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css"
    rel="stylesheet">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../src/css/style.css" />
  <style>
    .pdf-container {
      height: 80vh;
      min-height: 500px;
    }

    .pdf-viewer {
      width: 100%;
      height: 100%;
      border: none;
      border-radius: 8px;
    }
  </style>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-navbar fixed-top shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="../index.php#home">
          <img src="../src/images/logo kampus.png" alt="Logo" width="40" height="45"
            class="d-inline-block align-text-top" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Informasi Program Studi
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="../index.php#about">Tentang Prodi</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../index.php#vision-mission">Visi dan Misi Prodi</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../dosen.php">Dosen Pengajar</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../kurikulum.php">Kurikulum</a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Fasilitas
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="">Laboratorium</a>
                </li>
                <li>
                  <a class="dropdown-item" href="">Gedung</a>
                </li>
                <li>
                  <a class="dropdown-item" href="">Pusat Studi</a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Kemahasiswaan
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="">Unit Kegiatan</a>
                </li>
                <li>
                  <a class="dropdown-item" href="">Himpunan Mahasiswa</a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Login
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="../login-pegawai.php">Login Dosen/Admin</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../login-mahasiswa.php">Login Mahasiswa</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <section>
    <div class="row text-center">
      <h1>Kalender Akademik</h1>
    </div>
  </section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <!-- Header -->
        <div class="text-center mb-4">
          <div class="d-flex justify-content-center gap-2 mb-3">
            <a href="../src/files/kalender/Kalender Akademik 2024_2025.pdf" class="btn btn-primary" download>
              <i class="bi bi-download me-2"></i>Download PDF
            </a>
            <button class="btn btn-outline-primary" onclick="toggleFullscreen()">
              <i class="bi bi-fullscreen me-2"></i>Fullscreen
            </button>
          </div>
        </div>

        <!-- PDF Viewer -->
        <div class="card shadow">
          <div class="card-body p-2">
            <div class="pdf-container" id="pdfContainer">
              <iframe src="../src/files/kalender/Kalender Akademik 2024_2025.pdf" class="pdf-viewer" id="pdfViewer"
                title="Kalender Akademik PDF">
              </iframe>
            </div>
          </div>
        </div>

        <!-- Footer Info -->
        <div class="text-center text-muted m-3">
          <small>Klik tombol download untuk menyimpan PDF atau fullscreen untuk tampilan layar penuh</small>
        </div>
      </div>
    </div>
  </div>
  <footer class="py-4">
    <div class="container text-center">
      <small>&copy; APD Learning Space - 2024</small>
    </div>
  </footer>
  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

  <script>
    // Fungsi untuk toggle fullscreen
    function toggleFullscreen() {
      const container = document.getElementById('pdfContainer');

      if (!document.fullscreenElement) {
        if (container.requestFullscreen) {
          container.requestFullscreen();
        } else if (container.webkitRequestFullscreen) {
          container.webkitRequestFullscreen();
        } else if (container.msRequestFullscreen) {
          container.msRequestFullscreen();
        }
      } else {
        if (document.exitFullscreen) {
          document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
          document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        }
      }
    }

    // Event listener untuk perubahan status fullscreen
    document.addEventListener('fullscreenchange', updateFullscreenButton);
    document.addEventListener('webkitfullscreenchange', updateFullscreenButton);
    document.addEventListener('msfullscreenchange', updateFullscreenButton);

    function updateFullscreenButton() {
      const button = document.querySelector('[onclick="toggleFullscreen()"]');
      const icon = button.querySelector('i');

      if (document.fullscreenElement) {
        icon.classList.remove('bi-fullscreen');
        icon.classList.add('bi-fullscreen-exit');
      } else {
        icon.classList.remove('bi-fullscreen-exit');
        icon.classList.add('bi-fullscreen');
      }
    }
  </script>
</body>

</html>