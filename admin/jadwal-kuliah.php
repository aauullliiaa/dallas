<?php
session_start();
require '../src/db/functions.php';
checkRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_schedule'])) {
  $schedule_id = $_POST['schedule_id'];
  if (delete_schedule_permanently($db, $schedule_id)) {
    $message = "Jadwal berhasil dihapus.";
    $alert_class = "alert-success";
  } else {
    $message = "Error: Gagal menghapus jadwal.";
    $alert_class = "alert-danger";
  }
}

// Ambil semua jadwal
$schedules = fetch_all_schedules($db);

$days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
$time_slots = get_time_slots_for_viewing();

$message = $_SESSION['message'] ?? '';
$alert_class = $_SESSION['alert_class'] ?? '';

unset($_SESSION['message']);
unset($_SESSION['alert_class']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>APD Learning Space - Jadwal Perkuliahan</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
    rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
  <section class="hero-jadwal d-flex align-items-center justify-content-center">
    <h1>Jadwal Perkuliahan</h1>
  </section>
</header>

<body>
  <div class="container">
    <div class="row mb-3">
      <div class="col-md-5 submit-button">
        <a href="tambah-jadwal.php"><button class="btn mb-2">Tambah Jadwal</button></a>
        <a href="jadwal-pergantian.php"><button class="btn mb-2">Tambah Pergantian Kuliah</button></a>
      </div>
    </div>
    <div class="card p-3">
      <div class="card-body">
        <?php if ($message): ?>
          <div class="alert <?= $alert_class ?> alert-dismissible fade show" role="alert">
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        <div class="row mb-2">
          <h3>Jadwal Perkuliahan</h3>
        </div>
        <?php if (empty($schedules)): ?>
          <div class="alert alert-info">Tidak ada jadwal tersedia.</div>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Jam</th>
                  <?php foreach ($days as $day): ?>
                    <th><?= $day; ?></th>
                  <?php endforeach; ?>
                </tr>
              </thead>
              <tbody>
                <?php
                $displayed_courses = array();
                foreach ($time_slots as $slot):
                  ?>
                  <tr <?= in_array($slot, ["10.00 - 10.20", "12.00 - 13.00", "15.30 - 16.00", "17.40 - 18.40"]) ? 'class="table-secondary"' : ''; ?>>
                    <td><?= $slot; ?></td>
                    <?php foreach ($days as $day): ?>
                      <td>
                        <?php if (isset($schedules[$day][$slot])): ?>
                          <?php foreach ($schedules[$day][$slot] as $schedule):
                            $course_key = $day . '-' . $schedule['matkul'] . '-' . $schedule['kelas'];
                            $show_edit = !in_array($course_key, $displayed_courses);
                            if ($show_edit) {
                              $displayed_courses[] = $course_key;
                            }
                            ?>
                            <strong>Kelas <?= htmlspecialchars($schedule['kelas']); ?></strong><br>
                            <?= htmlspecialchars($schedule['matkul']); ?><br>
                            <small><?= htmlspecialchars($schedule['dosen']); ?></small> -
                            <small><?= htmlspecialchars($schedule['classroom']); ?></small>
                            <br>
                            <?php if ($schedule['is_temporary']): ?>
                              <span class="badge bg-warning">Jadwal Pergantian</span><br>
                            <?php elseif ($schedule['is_deleted_temporarily']): ?>
                              <span class="badge bg-danger">Jadwal Dikosongkan untuk Pekan ini</span>
                            <?php endif; ?>
                            <?php if ($show_edit): ?>
                              <a href="edit-jadwal.php?id=<?= $schedule['id']; ?>" class="btn btn-sm btn-warning mt-2">Edit</a>
                            <?php endif; ?>
                            <br><br>
                          <?php endforeach; ?>
                        <?php elseif (in_array($slot, ["10.00 - 10.20", "12.00 - 13.00", "15.30 - 16.00", "17.40 - 18.40"])): ?>
                          Istirahat
                        <?php endif; ?>
                      </td>
                    <?php endforeach; ?>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>