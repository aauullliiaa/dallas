<?php
session_start();
require '../src/db/functions.php';
checkRole('admin');

$message = $_SESSION['message'] ?? '';
$alert_class = $_SESSION['alert_class'] ?? '';

$jadwal = null;
$kelas = $semester = $tahun = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['kelas']) && isset($_GET['semester']) && isset($_GET['tahun'])) {
    $kelas = htmlspecialchars($_GET['kelas']);
    $semester = htmlspecialchars($_GET['semester']);
    $tahun = htmlspecialchars($_GET['tahun']);

    $jadwal = get_schedule($kelas, $semester, $tahun);

    if ($jadwal) {
        // Simpan data jadwal dalam session
        $_SESSION['jadwal'] = $jadwal;
        $_SESSION['kelas'] = $kelas;
        $_SESSION['semester'] = $semester;
        $_SESSION['tahun'] = $tahun;
    } else {
        // Jadwal tidak ditemukan
        $_SESSION['message'] = "Belum ada jadwal yang dimasukkan untuk kelas $kelas, semester $semester, tahun $tahun.";
        $_SESSION['alert_class'] = 'alert-warning';
    }
    // Redirect ke halaman yang sama tanpa parameter
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kelas = htmlspecialchars($_POST['kelas']);
    $semester = htmlspecialchars($_POST['semester']);
    $tahun = htmlspecialchars($_POST['tahun']);

    if (isset($_FILES['file_jadwal']) && $_FILES['file_jadwal']['error'] == 0) {
        $file_tmp = $_FILES['file_jadwal']['tmp_name'];
        $file_type = $_FILES['file_jadwal']['type'];

        if (update_schedule($kelas, $semester, $tahun, $file_tmp, $file_type)) {
            $_SESSION['message'] = "Jadwal berhasil diperbarui";
            $_SESSION['alert_class'] = 'alert-success';
        } else {
            $_SESSION['message'] = "Jadwal gagal diperbarui, silakan coba lagi.";
            $_SESSION['alert_class'] = 'alert-danger';
        }
    } else {
        $_SESSION['message'] = "Tidak ada file yang diunggah atau terjadi kesalahan.";
        $_SESSION['alert_class'] = 'alert-warning';
    }
    header("Location: edit-jadwal.php");
    exit;
}

// Jika ada data jadwal dalam session, gunakan itu
if (isset($_SESSION['jadwal'])) {
    $jadwal = $_SESSION['jadwal'];
    $kelas = $_SESSION['kelas'];
    $semester = $_SESSION['semester'];
    $tahun = $_SESSION['tahun'];

    // Hapus data dari session setelah digunakan
    unset($_SESSION['jadwal']);
    unset($_SESSION['kelas']);
    unset($_SESSION['semester']);
    unset($_SESSION['tahun']);
}

unset($_SESSION['message']);
unset($_SESSION['alert_class']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>APD Learning Space - Update Jadwal Kuliah</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!-- CSS -->
    <link rel="stylesheet" href="../src/css/style.css" />
</head>

<body>
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
                            <a class="nav-link" href="data-users.php">Data Pengguna</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#home" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Perkuliahan
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="jadwal-kuliah.php">Jadwal Kuliah</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="mata-kuliah.php">Mata Kuliah</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="../logout.php" onclick="confirm('Apakah anda yakin ingin keluar?')">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <section class="hero-jadwal d-flex align-items-center justify-content-center">
            <h1>Update Jadwal Kuliah</h1>
        </section>
    </header>
    <div class="container mt-5">
        <div class="card p-3">
            <div class="card-body">
                <?php if ($message): ?>
                    <div class="alert <?= $alert_class ?> alert-dismissible fade show" role="alert">
                        <?= $message ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <form action="" method="get">
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <select name="kelas" id="kelas" class="form-select" required>
                            <option value="">Pilih Kelas</option>
                            <option value="1A" <?= $kelas == '1A' ? 'selected' : '' ?>>1A</option>
                            <option value="1B" <?= $kelas == '1B' ? 'selected' : '' ?>>1B</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <select name="semester" id="semester" class="form-select" required>
                            <option value="">Pilih Semester</option>
                            <option value="Ganjil" <?= $semester == 'Ganjil' ? 'selected' : '' ?>>Ganjil</option>
                            <option value="Genap" <?= $semester == 'Genap' ? 'selected' : '' ?>>Genap</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <select name="tahun" id="tahun" class="form-select" required>
                            <option value="">Pilih Tahun Ajaran</option>
                            <option value="2024/2025" <?= $tahun == '2024/2025' ? 'selected' : '' ?>>2024/2025</option>
                            <option value="2025/2026" <?= $tahun == '2025/2026' ? 'selected' : '' ?>>2025/2026</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col submit-button">
                            <button type="submit" class="btn btn-primary">Tampilkan Jadwal</button>
                        </div>
                    </div>
                </form>
                <?php if ($jadwal): ?>
                    <div class="mt-4">
                        <h4>Jadwal Saat Ini</h4>
                        <?php
                        $file_type = $jadwal['file_type'];
                        $file_path = $jadwal['file_jadwal'];
                        if (strpos($file_type, 'image') !== false) {
                            echo "<img src='$file_path' class='img-fluid' alt='Jadwal Perkuliahan'>";
                        } elseif ($file_type == 'application/pdf') {
                            echo "<embed src='$file_path' type='application/pdf' width='100%' height='600px' />";
                        } else {
                            echo "<p>Tipe file tidak didukung.</p>";
                        }
                        ?>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data" class="mt-4">
                        <input type="hidden" name="kelas" value="<?= $kelas ?>">
                        <input type="hidden" name="semester" value="<?= $semester ?>">
                        <input type="hidden" name="tahun" value="<?= $tahun ?>">
                        <div class="mb-3">
                            <label for="file_jadwal" class="form-label">Upload File Baru</label>
                            <input type="file" class="form-control" id="file_jadwal" name="file_jadwal" required>
                        </div>
                        <div class="row">
                            <div class="col submit-button">
                                <button type="submit" class="btn btn-primary">Update Jadwal</button>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>