<?php
session_start();
require '../src/db/functions.php';
checkRole('admin');

$id = $_GET["id"];
$role = $_GET["role"];
$mahasiswa = retrieve("SELECT * FROM daftar_mahasiswa WHERE id = $id")[0];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>APD Learning Space - Informasi Detail Dosen</title>
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
                            <li><a class="dropdown-item" href="index.php#about">About</a></li>
                            <li>
                                <a class="dropdown-item" href="index.php#kata-sambutan">Kata Sambutan</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php#alamat">Alamat dan Kontak</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#home" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Data Pengguna
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="data-users.php">Data Pengguna</a></li>
                            <li>
                                <a class="dropdown-item" href="input-data-dosen.php">Input Data Dosen</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#home" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Perkuliahan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="jadwal-kuliah.php">Jadwal Kuliah</a></li>
                            <li><a class="dropdown-item" href="mata-kuliah.php">Mata Kuliah</a></li>
                            <li><a class="dropdown-item" href="tambah-matkul.php">Tambah Mata Kuliah</a></li>
                            <li><a class="dropdown-item" href="jadwal-pergantian.php">Pergantian</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End of Navbar -->
    <section class="d-flex align-items-center justify-content-center">
        <h1>Informasi Detail Mahasiswa</h1>
    </section>
</header>

<body>
    <div class="container">
        <div class="card p-3">
            <div class="card-body">
                <div class="row">
                    <img src="../src/images/<?= $mahasiswa["foto"] ?>" alt="" style="width: 80px; border-radius: 50%;">
                </div>
                <div class="row mt-3">
                    <h5>Nama</h5>
                    <p><?= $mahasiswa["nama"] ?></p>
                </div>
                <div class="row">
                    <h5>NIM</h5>
                    <p><?= $mahasiswa["nim"] ?></p>
                </div>
                <div class="row">
                    <h5>Kelas</h5>
                    <p><?= $mahasiswa["kelas"] ?></p>
                </div>
                <div class="row">
                    <h5>Alamat</h5>
                    <p><?= $mahasiswa["alamat"] ?></p>
                </div>
                <div class="row">
                    <h5>Tempat, Tanggal Lahir</h5>
                    <p><?= $mahasiswa["tempatlahir"] ?>, <?= $mahasiswa["tanggallahir"] ?></p>
                </div>
                <div class="row">
                    <h5>Telepon</h5>
                    <p><?= $mahasiswa["telepon"] ?></p>
                </div>
                <div class="row">
                    <h5>Email</h5>
                    <p><?= $mahasiswa["email"] ?></p>
                </div>
                <div class="row mt-3">
                    <div class="col submit-button text-center">
                        <a href="data-users.php?role=<?= $role ?>"><button class="btn">Kembali</button></a>
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