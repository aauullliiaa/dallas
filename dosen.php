<?php
require 'src/db/functions.php';

$dosen = retrieve("SELECT * FROM daftar_dosen");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>APD Learning Space - Dosen</title>
    <!-- Fonts -->
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
    <link rel="stylesheet" href="src/css/style.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        .dosen-card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            border-radius: 10px;
            overflow: hidden;
            border: none;
            max-width: 300px;
            margin: 0 auto;
        }

        .dosen-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .dosen-img-container {
            position: relative;
            padding-top: 75%;
            /* 4:3 Aspect Ratio */
            overflow: hidden;
        }

        .dosen-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }

        .dosen-card:hover .dosen-img {
            transform: scale(1.05);
        }

        .dosen-info {
            padding: 15px;
            background-color: #fff;
        }

        .dosen-name {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .dosen-detail {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 3px;
        }

        .dosen-contact {
            background-color: #f8f9fa;
            padding: 10px 15px;
            font-size: 0.8rem;
        }

        .contact-icon {
            width: 15px;
            text-align: center;
            margin-right: 5px;
            color: #007bff;
        }

        .dosen-row {
            margin-bottom: 30px;
        }
    </style>
</head>
<header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-navbar fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php#home">
                <img src="src/images/logo kampus.png" alt="Logo" width="40" height="45"
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
                            Profil
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#about">Tentang Prodi</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#vision-mission">Visi dan Misi Prodi</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Kurikulum
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#">Seluruh Mata Kuliah</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Mata Kuliah Kampus Merdeka</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dosen.php">Dosen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="facility.php">Fasilitas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#mitra">Mitra</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#alamat">Kontak</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Login
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="login-pegawai.php">Login Pegawai</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="login-mahasiswa.php">Login Mahasiswa</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End of Navbar -->
    <section class="dosen-hero d-flex align-items-center justify-content-center">
        <h1 data-aos="fade-up" style="font-weight: 600;">DAFTAR DOSEN</h1>
    </section>
</header>

<body>
    <div class="container mt-5 pt-5">
        <?php
        $totalDosen = count($dosen);
        $dosenPerRow = 4;
        $totalRows = ceil($totalDosen / $dosenPerRow);

        for ($i = 0; $i < $totalRows; $i++) {
            $startIndex = $i * $dosenPerRow;
            $endIndex = min(($i + 1) * $dosenPerRow, $totalDosen);
            ?>
            <div class="row dosen-row" data-aos="fade-up" data-aos-delay="<?= $i * 200 ?>">
                <?php for ($j = $startIndex; $j < $endIndex; $j++) {
                    $row = $dosen[$j];
                    ?>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card dosen-card h-100">
                            <div class="dosen-img-container">
                                <img src="src/images/<?= $row["foto"] ?>" class="dosen-img" alt="<?= $row["nama"] ?>">
                            </div>
                            <div class="dosen-info">
                                <h5 class="dosen-name"><?= $row["nama"] ?></h5>
                                <p class="dosen-detail mb-0"><strong>NIP:</strong> <?= $row["nip"] ?></p>
                            </div>
                            <div class="dosen-contact">
                                <p class="mb-1">
                                    <span class="contact-icon"><i class="bi bi-envelope-fill"></i></span>
                                    <?= $row["email"] ?>
                                </p>
                                <p class="mb-0">
                                    <span class="contact-icon"><i class="bi bi-telephone-fill"></i></span>
                                    <?= $row["telepon"] ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
        });

        function confirmLogout() {
            if (confirm("Apakah anda yakin ingin keluar?"));
            window.location.href = "../logout.php";
        }
    </script>
</body>

</html>