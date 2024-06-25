<?php
session_start();
require '../src/db/functions.php';
checkRole('admin');

$time_slots = get_time_slots_for_adding();
$courses = get_all_courses($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['delete_schedule'])) {
    $schedule_id = $_POST['schedule_id'];
    if (delete_schedule($db, $schedule_id)) {
      $message = "Jadwal berhasil dihapus.";
      $alert_class = "alert-success";
    } else {
      $message = "Error: Gagal menghapus jadwal.";
      $alert_class = "alert-danger";
    }
  } else {
    $hari = $_POST['hari'];
    $matkul = $_POST['matkul'];
    $dosen_id = $_POST['dosen_id'];
    $classroom = htmlspecialchars($_POST['classroom']);
    $kelas = $_POST['kelas'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $old_hari = $_POST['old_hari'] ?? null;
    $old_jam_mulai = $_POST['old_jam_mulai'] ?? null;
    $old_jam_selesai = $_POST['old_jam_selesai'] ?? null;

    list($message, $alert_class) = update_or_insert_schedule($db, $hari, $matkul, $dosen_id, $classroom, $kelas, $jam_mulai, $jam_selesai, $time_slots, 0, NULL, $old_hari, $old_jam_mulai, $old_jam_selesai);
  }
} elseif (isset($_GET['id'])) {
  $schedule_id = $_GET['id'];
  $schedule = fetch_schedule_by_id($db, $schedule_id);
  $hari = $schedule['hari'];
  $matkul = $schedule['matkul'];
  $dosen_id = $schedule['dosen_id'];
  $classroom = $schedule['classroom'];
  $kelas = $schedule['kelas'];
  $jam_mulai = $schedule['jam'];
  $jam_selesai = end(fetch_schedules_by_details($db, $hari, $matkul, $kelas))['jam'];
  $dosen_name = getDosenName($dosen_id);  // Get the name of the lecturer
} else {
  die("ID jadwal tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APD Learning Space - Edit Jadwal Perkuliahan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="../src/css/style.css">
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
                            <li><a class="dropdown-item" href="data-dosen.php">Data Dosen</a></li>
                            <li><a class="dropdown-item" href="data-mahasiswa.php">Data Mahasiswa</a></li>
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
    <section class="hero-jadwal d-flex align-items-center justify-content-center">
        <h1>Edit Jadwal Perkuliahan</h1>
    </section>
</header>

<body>
    <div class="container">
        <div class="card p-3 m-2">
            <div class="card-body">
                <?php if (isset($message)) {
                    echo "<div class='alert {$alert_class} alert-dismissible fade show' role='alert'>{$message}<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                } ?>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="hari" class="form-label">Hari:</label>
                        <select id="hari" name="hari" class="form-select" required>
                            <option value="Senin" <?php if (isset($hari) && $hari == 'Senin') echo 'selected'; ?>>Senin</option>
                            <option value="Selasa" <?php if (isset($hari) && $hari == 'Selasa') echo 'selected'; ?>>Selasa</option>
                            <option value="Rabu" <?php if (isset($hari) && $hari == 'Rabu') echo 'selected'; ?>>Rabu</option>
                            <option value="Kamis" <?php if (isset($hari) && $hari == 'Kamis') echo 'selected'; ?>>Kamis</option>
                            <option value="Jumat" <?php if (isset($hari) && $hari == 'Jumat') echo 'selected'; ?>>Jumat</option>
                        </select>
                    </div>
                    <input type="hidden" name="old_hari" value="<?= htmlspecialchars($hari); ?>">

                    <div class="mb-3">
                        <label for="matkul" class="form-label">Mata Kuliah:</label>
                        <select id="matkul" name="matkul" class="form-select" required>
                            <?php foreach ($courses as $course): ?>
                                <option value="<?= htmlspecialchars($course['nama']); ?>" data-dosen-id="<?= htmlspecialchars($course['id']); ?>" <?= ($course['nama'] == $matkul) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($course['nama']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="dosen_name" class="form-label">Nama Dosen:</label>
                        <input type="text" id="dosen_name" name="dosen_name" class="form-control" value="<?= htmlspecialchars($dosen_name); ?>" readonly>
                        <input type="hidden" id="dosen_id" name="dosen_id" class="form-control" value="<?= htmlspecialchars($dosen_id); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="classroom" class="form-label">Ruang Kelas:</label>
                        <input type="text" id="classroom" name="classroom" class="form-control" value="<?= htmlspecialchars($classroom); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas:</label>
                        <input type="text" id="kelas" name="kelas" class="form-control" value="<?= htmlspecialchars($kelas); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="jam_mulai" class="form-label">Jam Mulai:</label>
                        <select id="jam_mulai" name="jam_mulai" class="form-select" required>
                            <?php
                            foreach ($time_slots as $slot) {
                                echo "<option value='$slot' " . (isset($jam_mulai) && $slot == $jam_mulai ? 'selected' : '') . ">$slot</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jam_selesai" class="form-label">Jam Selesai:</label>
                        <select id="jam_selesai" name="jam_selesai" class="form-select" required>
                            <?php
                            foreach ($time_slots as $slot) {
                                echo "<option value='$slot' " . (isset($jam_selesai) && $slot == $jam_selesai ? 'selected' : '') . ">$slot</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <input type="hidden" name="old_jam_mulai" value="<?= htmlspecialchars($jam_mulai); ?>">
                    <input type="hidden" name="old_jam_selesai" value="<?= htmlspecialchars($jam_selesai); ?>">
                    <input type="hidden" name="submit_form" value="1">
                    <div class="row">
                        <div class="col submit-button">
                            <button type="submit" class="btn btn-primary">Perbarui Jadwal</button>
                            <button type="submit" name="delete_schedule" value="1" class="btn btn-danger">Hapus Jadwal</button>
                        </div>
                    </div>
                </form>
                <div class="row mt-2">
                    <div class="col submit-button">
                        <a href="jadwal-kuliah.php?kelas=<?= htmlspecialchars($kelas) ?>"><button class="btn btn-secondary">Kembali</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('matkul').addEventListener('change', function () {
            var selectedOption = this.options[this.selectedIndex];
            var dosenId = selectedOption.getAttribute('data-dosen-id');
            document.getElementById('dosen_id').value = dosenId;

            // Mengambil nama dosen dari PHP tanpa AJAX
            <?php
            if (isset($_POST['dosen_id'])) {
                $dosen_id = $_POST['dosen_id'];
                $dosen_name = getDosenName($dosen_id);
                echo "document.getElementById('dosen_name').value = '{$dosen_name}';";
            }
            ?>
        });
    </script>
</body>

</html>