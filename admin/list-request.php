<?php
session_start();
require '../src/db/functions.php';
checkRole('admin');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $request_id = $_POST['request_id'];

    if ($action == 'accept') {
        $sql = "UPDATE requests SET status = 'Diterima' WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $request_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Permintaan berhasil diterima.";
            $_SESSION['alert_type'] = "success";
        } else {
            $_SESSION['message'] = "Gagal memperbarui status permintaan.";
            $_SESSION['alert_type'] = "danger";
        }
    } elseif ($action == 'reject') {
        $sql = "UPDATE requests SET status = 'Ditolak' WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $request_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Permintaan berhasil ditolak.";
            $_SESSION['alert_type'] = "warning";
        } else {
            $_SESSION['message'] = "Gagal memperbarui status permintaan.";
            $_SESSION['alert_type'] = "danger";
        }
    }

    header("Location: list-request.php");
    exit();
}

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
    <section>
        <div class="row text-center">
            <h1>Daftar Request Pergantian Jadwal Kuliah</h1>
        </div>
    </section>
</header>

<body>
    <div class="container mt-5 pt-5">
        <div class="card p-3">
            <?php
            if (isset($_SESSION['message'])) {
                $alertType = $_SESSION['alert_type'];
                echo "<div class='alert alert-{$alertType} alert-dismissible fade show' role='alert'>
                {$_SESSION['message']}
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
                unset($_SESSION['message']);
                unset($_SESSION['alert_type']);
            }
            ?>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="align-top">
                                <th scope="col">No</th>
                                <th scope="col">Dosen</th>
                                <th scope="col">Mata Kuliah</th>
                                <th scope="col">Tanggal Awal</th>
                                <th scope="col">Jadwal Awal</th>
                                <th scope="col">Tanggal Baru</th>
                                <th scope="col">Jadwal Baru</th>
                                <th scope="col">Alasan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($requests as $request): ?>
                                <?php $i = 1; ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $request['dosen']; ?></td>
                                    <td><?= $request['mata_kuliah']; ?></td>
                                    <td><?= $request['tanggal_awal']; ?></td>
                                    <td><?= $request['jadwal_awal_mulai'] . " - " . $request['jadwal_awal_selesai']; ?></td>
                                    <td><?= $request['tanggal_baru']; ?></td>
                                    <td><?= $request['jadwal_baru_mulai'] . " - " . $request['jadwal_baru_selesai']; ?></td>
                                    <td><?= $request['alasan']; ?></td>
                                    <td><?= ucfirst($request['status']); ?></td>
                                    <td>
                                        <?php if ($request['status'] == 'pending'): ?>
                                            <form method="post" style="display:inline;"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menerima permintaan ini?');">
                                                <input type="hidden" name="request_id" value="<?= $request['id']; ?>">
                                                <input type="hidden" name="action" value="accept">
                                                <button type="submit" class="btn btn-success btn-sm mb-1">Terima</button>
                                            </form>
                                            <form method="post" style="display:inline;"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menolak permintaan ini?');">
                                                <input type="hidden" name="request_id" value="<?= $request['id']; ?>">
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                            </form>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?= ucfirst($request['status']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col submit-button">
                        <a href="index.php"><button class="btn btn-light">Kembali</button></a>
                    </div>
                </div>
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