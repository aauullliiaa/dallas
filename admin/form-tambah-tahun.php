<?php
session_start(); // Tambahkan ini di awal untuk memulai session

require '../src/db/functions.php';

$message = "";
$alert_class = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tahun_mulai = trim($_POST['tahunmulai']);
    $tahun_selesai = trim($_POST['tahunselesai']);
    $kode = trim($_POST['kode']);
    $status = $_POST['status'];
    $tanggal_mulai = $_POST['tanggalmulai'];
    $tanggal_selesai = $_POST['tanggalselesai'];

    // Validasi input
    $errors = [];
    if (empty($tahun_mulai) || !is_numeric($tahun_mulai)) {
        $errors[] = "Tahun Mulai harus diisi dengan angka.";
    }
    if (empty($tahun_selesai) || !is_numeric($tahun_selesai)) {
        $errors[] = "Tahun Selesai harus diisi dengan angka.";
    }
    if (empty($kode)) {
        $errors[] = "Kode harus diisi.";
    }
    if (empty($status)) {
        $errors[] = "Status harus dipilih.";
    }
    if (empty($tanggal_mulai)) {
        $errors[] = "Tanggal Mulai harus diisi.";
    }
    if (empty($tanggal_selesai)) {
        $errors[] = "Tanggal Selesai harus diisi.";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO tahun_akademik (tahun_mulai, tahun_selesai, kode, status, tanggal_mulai, tanggal_selesai) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $result = retrieve($sql, [$tahun_mulai, $tahun_selesai, $kode, $status, $tanggal_mulai, $tanggal_selesai]);

        if ($result) {
            $_SESSION['message'] = "Tahun akademik berhasil ditambahkan.";
            $_SESSION['alert_class'] = "success";
        } else {
            $_SESSION['message'] = "Gagal menambahkan tahun akademik.";
            $_SESSION['alert_class'] = "danger";
        }
        header("Location: tahun-akademik.php");
        exit();
    } else {
        $_SESSION['message'] = implode("<br>", $errors);
        $_SESSION['alert_class'] = "danger";
    }
}

// Fetch all academic years
$tahun_akademik = retrieve("SELECT * FROM tahun_akademik ORDER BY tahun_mulai DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>APD Learning Space - Tambah Data Tahun Akademik</title>
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Data Program Studi</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="data-users.php">Data Pengguna</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="tahun-akademik.php">Tahun Akademik</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="data-ruangan.php">Data Ruang Kelas</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="data-semester.php">Data Semester</a>
                            </li>
                        </ul>
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
                        <a class="nav-link" href="../logout.php"
                            onclick="confirm('Apakah anda yakin ingin keluar?')">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section>
        <div class="row text-center">
            <h1>Tambah Data Tahun Akademik</h1>
        </div>
    </section>
</header>

<body>
    <div class="container">
        <div class="card p-3">
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="tahunmulai" class="form-label">Tahun Mulai</label>
                        <input type="number" class="form-control" name="tahunmulai" id="tahunmulai" required>
                    </div>
                    <div class="mb-3">
                        <label for="tahunselesai" class="form-label">Tahun Selesai</label>
                        <input type="number" class="form-control" name="tahunselesai" id="tahunselesai" required>
                    </div>
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode</label>
                        <input type="text" class="form-control" name="kode" id="kode" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="">Silakan Pilih Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggalmulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="tanggalmulai" id="tanggalmulai" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggalselesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" name="tanggalselesai" id="tanggalselesai" required>
                    </div>
                    <div class="row text-center mb-2">
                        <div class="col submit-button">
                            <button type="submit" class="btn btn-primary"
                                onclick="return confirm('Apakah Anda yakin ingin menyimpan data ini?')">Simpan
                                Data</button>
                        </div>
                    </div>
                </form>
                <div class="row text-center">
                    <div class="col submit-button">
                        <a href="tahun-akademik.php"><button class="btn btn-light">Kembali</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>