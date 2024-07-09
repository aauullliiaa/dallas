<?php
session_start();
require '../src/db/functions.php';
checkRole('dosen');

$matkul_id = $_GET['matkul_id'];
$message = '';
$alert_type = '';

// Retrieve mata kuliah detail
$matkul_detail = retrieve("SELECT nama FROM mata_kuliah WHERE id = ?", [$matkul_id])[0];

// Retrieve pertemuan with existing tugas
$existing_pertemuan = retrieve("SELECT pertemuan FROM tugas_pertemuan tp
                                JOIN pertemuan p ON tp.pertemuan_id = p.id
                                WHERE p.mata_kuliah_id = ?", [$matkul_id]);

// Create an array of existing pertemuan
$existing_pertemuan_array = array_column($existing_pertemuan, 'pertemuan');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pertemuan = $_POST['pertemuan'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_deadline = $_POST['tanggal_deadline'];
    $jam_deadline = $_POST['jam_deadline'];

    // Upload file
    $file_tugas = '';
    if (isset($_FILES['file_tugas'])) {
        $upload_result = uploadFileTugas($_FILES['file_tugas']);
        if (is_array($upload_result) && isset($upload_result['error'])) {
            $message = $upload_result['error'];
            $alert_type = "danger";
        } else {
            $file_tugas = $upload_result;
        }
    }

    if ($alert_type !== "danger") {
        // Insert pertemuan
        $pertemuan_data = [
            'mata_kuliah_id' => $matkul_id,
            'pertemuan' => $pertemuan,
            'deskripsi' => $deskripsi,
            'tanggal' => $tanggal_deadline
        ];
        $pertemuan_id = insertPertemuan($pertemuan_data);

        // Insert tugas
        if ($pertemuan_id) {
            $tugas_data = [
                'pertemuan_id' => $pertemuan_id,
                'judul' => $judul,
                'deskripsi' => $deskripsi,
                'tanggal_deadline' => $tanggal_deadline,
                'jam_deadline' => $jam_deadline,
                'file_tugas' => $file_tugas
            ];

            if (insertTugasPertemuan($tugas_data)) {
                $_SESSION['message'] = "Tugas berhasil diberikan.";
                $_SESSION['alert_type'] = "success";
            } else {
                $_SESSION['message'] = "Gagal memberikan tugas, silakan coba lagi.";
                $_SESSION['alert_type'] = "danger";
            }
        } else {
            $_SESSION['message'] = "Gagal menyimpan pertemuan, silakan coba lagi.";
            $_SESSION['alert_type'] = "danger";
        }

        // Redirect ke halaman tugas mata kuliah
        header("Location: tugas-matkul.php?id=$matkul_id");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>APD Learning Space - Tambah Tugas Kuliah</title>
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
                                <a class="dropdown-item" href="index.php#kata-sambutan">Kata Sambutan</a>
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
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="tugas-jumbotron d-flex align-items-center justify-content-center">
        <div class="row text-center">
            <h1>Tambah Tugas Kuliah</h1>
        </div>
    </section>
</header>

<body>
    <div class="container mt-5">
        <div class="card p-3 mb-3">
            <div class="card-body">
                <?php if ($message): ?>
                    <div class="alert alert-<?= $alert_type; ?>">
                        <?= $message; ?>
                    </div>
                <?php endif; ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama_mata_kuliah" class="form-label">Nama Mata Kuliah</label>
                        <input type="text" class="form-control" id="nama_mata_kuliah"
                            value="<?= htmlspecialchars($matkul_detail['nama']); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="pertemuan" class="form-label">Pertemuan</label>
                        <select class="form-select" id="pertemuan" name="pertemuan" required>
                            <?php
                            for ($i = 1; $i <= 16; $i++) {
                                if (!in_array($i, $existing_pertemuan_array)) {
                                    echo "<option value='$i'>Pertemuan $i</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Tugas</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Tugas</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_deadline" class="form-label">Tanggal Deadline</label>
                        <input type="date" class="form-control" id="tanggal_deadline" name="tanggal_deadline" required>
                    </div>
                    <div class="mb-3">
                        <label for="jam_deadline" class="form-label">Jam Deadline</label>
                        <input type="time" class="form-control" id="jam_deadline" name="jam_deadline" required>
                    </div>
                    <div class="mb-3">
                        <label for="file_tugas" class="form-label">Upload File (DOC, DOCX, PPTX, XLS, PDF)</label>
                        <input type="file" class="form-control" id="file_tugas" name="file_tugas">
                    </div>
                    <div class="mb-2">
                        <div class="col submit-button">
                            <button type="submit" class="btn btn-light" name="submit">Berikan Tugas</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col submit-button">
                        <a href="tugas-matkul.php?id=<?= $matkul_id; ?>"><button
                                class="btn btn-light">Kembali</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>