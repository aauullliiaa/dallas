<?php
require '../src/db/functions.php';

// Fetch all requests
$sql = "SELECT r.id, r.dosen_id, d.nama AS dosen, r.mata_kuliah, r.tanggal_awal, r.jadwal_awal_mulai, r.jadwal_awal_selesai, r.tanggal_baru, r.jadwal_baru_mulai, r.jadwal_baru_selesai, r.alasan, r.status
        FROM requests r
        JOIN daftar_dosen d ON r.dosen_id = d.id
        ORDER BY r.id DESC";
$result = $db->query($sql);
$requests = $result->fetch_all(MYSQLI_ASSOC);

$db->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APD Learning Space - Daftar Request Pergantian Jadwal Kuliah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="../src/css/style.css">
</head>

<header>
    <nav class="navbar navbar-expand-lg shadow-sm fixed-top bg-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php#home">
                <img src="../src/images/logo kampus.png" alt="Logo" width="40px">
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
    <section>
        <div class="row text-center">
            <h1>Daftar Request Pergantian Jadwal Kuliah</h1>
        </div>
    </section>
</header>

<body>
    <div class="container mt-5 pt-5">
        <div class="row">
            <?php if ($message): ?>
                <div class="alert alert-<?= $alertType ?>">
                    <?= $alertMessage ?>
                </div>
            <?php endif; ?>
            <?php if (empty($requests)): ?>
                <div class="alert alert-info">Belum ada request pergantian.</div>
            <?php else: ?>
                <?php foreach ($requests as $request): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <?php $i = 1; ?>
                            <div class="card-body">
                                <h5 class="card-title">Request #<?php echo $i; ?></h5>
                                <p class="card-text">
                                    Dosen <strong><?php echo $request['dosen']; ?></strong> meminta pergantian jadwal dari
                                    <strong><?php echo $request['tanggal_awal']; ?></strong> pukul
                                    <strong><?php echo $request['jadwal_awal_mulai'] . " s/d " . $request['jadwal_awal_selesai']; ?></strong>
                                    ke tanggal
                                    <strong><?php echo $request['tanggal_baru']; ?></strong> pukul
                                    <strong><?php echo $request['jadwal_baru_mulai'] . " s/d " . $request['jadwal_baru_selesai']; ?></strong>.
                                </p>
                                <p class="card-text">
                                    <strong>Mata Kuliah:</strong> <?php echo $request['mata_kuliah']; ?><br>
                                    <strong>Alasan:</strong> <?php echo $request['alasan']; ?><br>
                                    <strong>Status:</strong> <?= $request['status']; ?>
                                </p>
                            </div>
                            <?php $i++; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col text-center submit-button">
                <a href="request-pergantian.php"><button class="btn btn-light">Request Pergantian</button></a>
                <a href="index.php" class="btn btn-light">Kembali</a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/6B7VOZtZpL4YNGG0KN5FjGz7+7iQp7X2g9rDft"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>

</html>