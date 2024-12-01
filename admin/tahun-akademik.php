<?php
session_start(); // Pastikan session dimulai di bagian paling atas
require '../src/db/functions.php';

// Fetch all academic years
$query = retrieve("SELECT * FROM tahun_akademik ORDER BY tahun_mulai DESC");

// Check for alert messages in the session
$message = "";
$alert_class = "";
if (isset($_SESSION['message']) && isset($_SESSION['alert_class'])) {
    $message = $_SESSION['message'];
    $alert_class = $_SESSION['alert_class'];
    // Clear the session variables
    unset($_SESSION['message']);
    unset($_SESSION['alert_class']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>APD Learning Space - Tahun Akademik</title>
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
    <?php include 'navbar.php'; ?>
    <section class="hero-matkul d-flex align-items-center justify-content-center">
        <h1>Data Tahun Akademik</h1>
    </section>
</header>

<body>
    <div class="container mb-5">
        <div class="row mb-3">
            <div class="col submit-button">
                <a href="form-tambah-tahun.php"><button class="btn btn-light">Tambah tahun akademik</button></a>
            </div>
        </div>
        <div class="card p-3">
            <div class="card-body">
                <!-- Tampilkan pesan alert -->
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?php echo $alert_class; ?>" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr class="align-middle text-center">
                                <th>No</th>
                                <th>Tahun Mulai</th>
                                <th>Tahun Selesai</th>
                                <th>Kode</th>
                                <th>Status</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($query as $data): ?>
                                <tr class="align-middle text-center">
                                    <td><?= $i++; ?></td>
                                    <td><?= $data['tahun_mulai'] ?></td>
                                    <td><?= $data['tahun_selesai'] ?></td>
                                    <td><?= $data['kode'] ?></td>
                                    <td><?= $data['status'] ?></td>
                                    <td><?= $data['tanggal_mulai'] ?></td>
                                    <td><?= $data['tanggal_selesai'] ?></td>
                                    <td><button></button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>