<?php
session_start();
require '../src/db/functions.php';
checkRole('dosen');

$tugas_id = $_GET['tugas_id'] ?? null;
$matkul_id = $_GET['matkul_id'] ?? null;
$pertemuan_id = $_GET['pertemuan_id'] ?? null;

if (!$tugas_id || !$matkul_id || !$pertemuan_id) {
    die("ID tugas, mata kuliah, atau pertemuan tidak ditemukan.");
}

$tugasDetail = retrieve("SELECT tp.*, p.pertemuan, p.tanggal, mk.nama as mata_kuliah, mp.nama as mahasiswa, mp.nim, mp.kelas, 
                         DATE_FORMAT(tp.tanggal_kumpul, '%Y-%m-%d') as tanggal_kumpul, 
                         DATE_FORMAT(tp.jam_kumpul, '%H:%i') as jam_kumpul 
                         FROM tugas_kumpul tp 
                         JOIN tugas_pertemuan t ON tp.tugas_id = t.id 
                         JOIN pertemuan p ON t.pertemuan_id = p.id 
                         JOIN mata_kuliah mk ON p.mata_kuliah_id = mk.id 
                         JOIN mahasiswa_profiles mp ON tp.mahasiswa_id = mp.user_id 
                         WHERE tp.tugas_id =? AND p.mata_kuliah_id =? AND p.id =?",
    [$tugas_id, $matkul_id, $pertemuan_id]
)[0];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>APD Learning Space - Pengumpulan Tugas</title>
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
                        <a class="nav-link" href="edit-profile.php">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="d-flex align-items-center justify-content-center">
        <div class="row">
            <h2>Daftar Mahasiswa yang Mengumpulkan Tugas</h2>
        </div>
    </section>
</header>

<body>
    <div class="container mt-5">
        <div class="col submit-button mb-2">
            <a href="tugas-matkul.php?id=<?= $matkul_id; ?>" class="btn btn-light">Kembali</a>
        </div>
        <?php if (empty($tugasDetail)): ?>
            <div class="alert alert-danger">
                Belum ada yang mengumpulkan tugas.
            </div>
        <?php else: ?>
            <div class="card p-3">
                <div class="card-header">
                    <h4>Detail Tugas Pertemuan ke-<?= htmlspecialchars($tugasDetail['pertemuan']); ?></h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Kelas</th>
                            <th>Tanggal diserahkan</th>
                            <th>Waktu diserahkan</th>
                            <th>File</th>
                        </tr>
                        <tr>
                            <td><?= htmlspecialchars($tugasDetail['mahasiswa']); ?></td>
                            <td><?= htmlspecialchars($tugasDetail['nim']); ?></td>
                            <td><?= htmlspecialchars($tugasDetail['kelas']); ?></td>
                            <td><?= htmlspecialchars($tugasDetail['tanggal_kumpul']); ?></td>
                            <td><?= htmlspecialchars($tugasDetail['jam_kumpul']); ?></td>
                            <td><a href="<?= htmlspecialchars($tugasDetail['file_path']); ?>" target="_blank">Lihat File</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>