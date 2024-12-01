<?php
session_start();
require '../src/db/functions.php';
checkRole('dosen');

// Initialize message and alert type
$message = '';
$alert_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save_research'])) {
        // Handle research submission
        $result = saveResearch($db); // Pastikan $db terhubung dengan database
        $_SESSION['message'] = $result['message'];
        $_SESSION['alert_type'] = $result['success'] ? 'success' : 'danger';

        // Redirect ke halaman yang menampilkan pesan
        header('Location: penelitian.php');
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APD Learning Space - Upload Penelitian</title>
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
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<header>
    <?php include 'navbar.php'; ?>
    <section>
        <div class="row">
            <h1 class="text-center">Upload Penelitian</h1>
        </div>
    </section>
</header>

<body>
    <div class="container mb-3 upload-penelitian">
        <div class="card p-3">
            <div class="card-body">
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?= htmlspecialchars($alert_type, ENT_QUOTES, 'UTF-8'); ?>" role="alert">
                        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="judul" class="form-label">Judul Penelitian</label>
                        <input type="text" name="judul" id="judul" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="tahun" class="form-label">Tahun Terbit</label>
                        <input type="number" name="tahun" id="tahun" class="form-control" min="1900" max="2099"
                            step="1">
                    </div>
                    <div class="form-group mb-3">
                        <label for="author1" class="form-label">Author</label>
                        <input type="text" name="author1" id="author1" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="author2" class="form-label">Author 2</label>
                        <input type="text" name="author2" id="author2" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="author3" class="form-label">Author 3</label>
                        <input type="text" name="author3" id="author3" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="author4" class="form-label">Author 4</label>
                        <input type="text" name="author4" id="author4" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="abstrak" class="form-label">Abstrak</label>
                        <textarea name="abstrak" id="abstrak" class="form-control"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="doi" class="form-label">DOI</label>
                        <input type="text" name="doi" id="doi" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="file" class="form-label">Upload File</label>
                        <input type="file" name="file" id="file" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col text-center submit-button">
                            <button class="btn btn-light" type="submit" name="save_research">Upload Penelitian</button>
                        </div>
                    </div>
                </form>
                <div class="row mt-2">
                    <div class="col text-center submit-button">
                        <a href="index.php"><button class="btn btn-light">Kembali</button></a>
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
        crossorigin="anonymous"></script>
    <script>
        function confirmLogout() {
            if (confirm("Apakah anda yakin ingin keluar?")) {
                window.location.href = "../logout.php";
            }
        }
    </script>
    <script>
        document.querySelector('input[name="tahun"]').addEventListener('input', function (e) {
            var num = parseInt(this.value);
            if (isNaN(num) || num < 1900 || num > 2099) {
                this.setCustomValidity('Masukkan tahun antara 1900 dan 2099');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>

</html>