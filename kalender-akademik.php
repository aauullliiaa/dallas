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
    <?php include 'navbar.php'; ?>
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
            <a href="src/files/kalender/Kalender Akademik 2024_2025.pdf" class="btn btn-primary" download>
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
              <iframe src="src/files/kalender/Kalender Akademik 2024_2025.pdf" class="pdf-viewer" id="pdfViewer"
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