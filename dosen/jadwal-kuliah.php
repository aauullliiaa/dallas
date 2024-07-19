<?php
session_start();
require '../src/db/functions.php';
checkRole('dosen');

$class = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$schedules = !empty($class) ? fetch_schedules($db, $class) : [];

$days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
$time_slots = get_time_slots_for_viewing();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>APD Learning Space - Jadwal Kuliah</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
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
  <!-- End of Navbar -->
  <section class="hero-jadwal d-flex align-items-center justify-content-center">
    <div class="row">
      <h1>Jadwal Perkuliahan</h1>
    </div>
  </section>
</header>

<body>
  <div class="container">
    <form action="" method="get" class="mb-2">
      <div class="mb-3">
        <label for="kelas" class="form-label">Pilih Kelas:</label>
        <div class="row">
          <div class="col-sm-3">
            <select id="kelas" name="kelas" class="form-select" required>
              <option value="">Pilih Kelas</option>
              <option value="1A" <?= ($class == '1A') ? 'selected' : ''; ?>>1A</option>
              <option value="1B" <?= ($class == '1B') ? 'selected' : ''; ?>>1B</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col submit-button">
          <button type="submit" class="btn">Lihat Jadwal</button>
        </div>
      </div>
    </form>
    <div class="row mb-2">
      <div class="col submit-button">
        <a href="jadwal-mengajar.php"><button class="btn">Jadwal Mengajar</button></a>
      </div>
    </div>
    <div class="card p-3">
      <div class="card-body">
        <?php if (isset($message)): ?>
          <div class='alert <?= $alert_class; ?> alert-dismissible fade show' role='alert'>
            <?= $message; ?>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>
        <?php endif; ?>
        <?php if (!empty($class)): ?>
          <div class="row mb-2">
            <h3>Jadwal Kelas <?= htmlspecialchars($class); ?></h3>
          </div>
          <?php if (empty($schedules)): ?>
            <div class="alert alert-info">Tidak ada jadwal untuk kelas ini.</div>
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
                  <?php foreach ($time_slots as $slot): ?>
                    <tr <?= in_array($slot, ["10.00 - 10.20", "12.00 - 13.00", "15.30 - 16.00", "17.40 - 18.40"]) ? 'class="table-secondary"' : ''; ?>>
                      <td><?= $slot; ?></td>
                      <?php foreach ($days as $day): ?>
                        <td>
                          <?php if (isset($schedules[$day][$slot])): ?>
                            <?php foreach ($schedules[$day][$slot] as $schedule): ?>
                              <?= htmlspecialchars($schedule['matkul']); ?><br>
                              <small><?= htmlspecialchars($schedule['dosen1']); ?></small>
                              <?php if (!empty($schedule['dosen2'])): ?>
                                & <small><?= htmlspecialchars($schedule['dosen2']); ?></small>
                              <?php endif; ?>
                              <br>
                              <small><?= htmlspecialchars($schedule['classroom']); ?></small><br>
                              <?php if ($schedule['is_temporary']): ?>
                                <span class="badge bg-warning">Jadwal Pergantian</span><br>
                              <?php elseif ($schedule['is_deleted_temporarily']): ?>
                                <span class="badge bg-danger">Jadwal Dikosongkan untuk Pekan ini</span>
                              <?php endif; ?>
                              <hr>
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
        <?php endif; ?>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>