<?php
session_start();
require '../src/db/functions.php';
checkRole('dosen');

delete_expired_temporary_schedules($db);
restore_temporary_deleted_schedules($db);

$all_slots = fetch_all_slots($db);

$days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
$time_slots_viewing = get_time_slots_for_viewing();
$time_slots_adding = get_time_slots_for_adding();

$message = '';
$alert_class = '';

// Ambil pesan dari session jika ada
if (isset($_SESSION['message']) && isset($_SESSION['alert_class'])) {
  $message = $_SESSION['message'];
  $alert_class = $_SESSION['alert_class'];

  // Hapus pesan dari session setelah ditampilkan
  unset($_SESSION['message']);
  unset($_SESSION['alert_class']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['delete_schedule_permanently'])) {
    $schedule_id = $_POST['schedule_id'];
    if (delete_schedule_permanently($db, $schedule_id)) {
      $_SESSION['message'] = "Jadwal berhasil dihapus.";
      $_SESSION['alert_class'] = "alert-success";
    } else {
      $_SESSION['message'] = "Error: Gagal menghapus jadwal.";
      $_SESSION['alert_class'] = "alert-danger";
    }
    header("Location: jadwal-pergantian.php");
    exit;
  } elseif (isset($_POST['hari'], $_POST['jam_mulai'], $_POST['jam_selesai'], $_POST['matkul'], $_POST['dosen_id'], $_POST['classroom'], $_POST['kelas'])) {
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $matkul = $_POST['matkul'];
    $dosen_id = $_POST['dosen_id'];
    $classroom = $_POST['classroom'];
    $kelas = $_POST['kelas'];
    $is_temporary = isset($_POST['is_temporary']) ? 1 : 0;
    $end_date = $is_temporary ? date('Y-m-d', strtotime('next Sunday')) : NULL;

    $start_index = array_search($jam_mulai, $time_slots_adding);
    $end_index = array_search($jam_selesai, $time_slots_adding);

    list($message, $alert_class) = insert_schedule($db, $hari, $matkul, $dosen_id, $classroom, $kelas, $time_slots_adding, $start_index, $end_index, $is_temporary, $end_date);

    $_SESSION['message'] = $message;
    $_SESSION['alert_class'] = $alert_class;
    header("Location: jadwal-pergantian.php");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>APD Learning Space - Jadwal Pergantian</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <h1>Jadwal Pergantian</h1>
  </section>
</header>

<body>
  <div class="container mt-5">
    <div class="card p-3">
      <div class="card-body">
        <?php if ($message): ?>
          <div class="alert <?= $alert_class; ?> alert-dismissible fade show" role="alert">
            <?= $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        <div class="row mb-2">
          <h5>Silakan pilih jadwal yang kosong untuk mengganti jadwal perkuliahan Anda.</h5>
        </div>
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
            <?php foreach ($time_slots_viewing as $slot): ?>
              <tr <?= in_array($slot, ["10.00 - 10.20", "12.00 - 13.00", "15.30 - 16.00", "17.40 - 18.40"]) ? 'class="table-secondary"' : ''; ?>>
                <td><?= $slot; ?></td>
                <?php foreach ($days as $day): ?>
                  <td>
                    <?php if (!empty($all_slots[$day][$slot])): ?>
                      <?php foreach ($all_slots[$day][$slot] as $schedule): ?>
                        <div><?= htmlspecialchars($schedule['matkul']); ?></div>
                        <div><small>Dosen: <?= htmlspecialchars($schedule['dosen']); ?></small></div>
                        <div><small>Kelas: <?= htmlspecialchars($schedule['kelas']); ?></small></div>
                        <div><small>Ruang: <?= htmlspecialchars($schedule['classroom']); ?></small></div>
                        <?php if ($schedule['is_temporary']): ?>
                          <span class="badge bg-warning">Jadwal Pergantian</span><br>
                          <hr>
                        <?php endif; ?>
                        <?php if ($schedule['is_deleted_temporarily']): ?>
                          <span class="badge bg-danger">Jadwal Dihapus Sementara</span><br>
                          <button class="btn btn-sm btn-success kosong-btn mt-1" data-bs-toggle="modal"
                            data-bs-target="#addScheduleModal" data-hari="<?= $day; ?>" data-jam="<?= $slot; ?>"
                            data-kelas="<?= htmlspecialchars($schedule['kelas']); ?>" style="display: block;">Kosong</button>
                          <hr>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    <?php elseif (in_array($slot, ["10.00 - 10.20", "12.00 - 13.00", "15.30 - 16.00", "17.40 - 18.40"])): ?>
                      Istirahat
                    <?php else: ?>
                      <button class="btn btn-sm btn-success kosong-btn" data-bs-toggle="modal"
                        data-bs-target="#addScheduleModal" data-hari="<?= $day; ?>" data-jam="<?= $slot; ?>" data-kelas=""
                        style="display: block;">Kosong</button>
                    <?php endif; ?>
                  </td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="row text-center">
          <div class="col submit-button">
            <a href="jadwal-mengajar.php"><button class="btn btn-light">Kembali</button></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Tambah Jadwal -->
  <div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addScheduleModalLabel">Tambah Mata Kuliah</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="addScheduleForm">
            <div class="mb-3">
              <label for="hari" class="form-label">Hari:</label>
              <input type="text" id="hari" name="hari" class="form-control" readonly>
            </div>
            <div class="mb-3">
              <label for="jam_mulai" class="form-label">Jam Mulai:</label>
              <input type="text" id="jam_mulai" name="jam_mulai" class="form-control" readonly>
            </div>
            <div class="mb-3">
              <label for="jam_selesai" class="form-label">Jam Selesai:</label>
              <select id="jam_selesai" name="jam_selesai" class="form-select" required>
                <!-- Opsi akan diisi dengan JavaScript -->
              </select>
            </div>
            <div class="mb-3">
              <label for="matkul" class="form-label">Mata Kuliah:</label>
              <select id="matkul" name="matkul" class="form-select" required>
                <option value="">--Pilih Mata Kuliah--</option>
                <?php
                $sql = "SELECT mata_kuliah.nama AS matkul_nama, daftar_dosen.nama AS dosen_nama, daftar_dosen.id AS dosen_id 
                                        FROM mata_kuliah 
                                        JOIN daftar_dosen ON mata_kuliah.dosen_id = daftar_dosen.id";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['matkul_nama'] . "' data-dosen='" . $row['dosen_nama'] . "' data-dosen-id='" . $row['dosen_id'] . "'>" . $row['matkul_nama'] . "</option>";
                  }
                } else {
                  echo "<option value=''>Tidak ada mata kuliah tersedia</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="dosen" class="form-label">Dosen Pengampu:</label>
              <input type="text" id="dosen" name="dosen" class="form-control" readonly>
              <input type="hidden" id="dosen_id" name="dosen_id">
            </div>
            <div class="mb-3">
              <label for="classroom" class="form-label">Ruang Kelas:</label>
              <input type="text" id="classroom" name="classroom" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="kelas" class="form-label">Kelas:</label>
              <select id="kelas" name="kelas" class="form-select" required>
                <option value="1A">1A</option>
                <option value="1B">1B</option>
                <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
              </select>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_temporary" name="is_temporary" required>
                <label class="form-check-label" for="is_temporary">Jadwal Sementara (Hanya Pekan Ini)</label>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Tambah Mata Kuliah</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('matkul').addEventListener('change', function () {
      var selectedOption = this.options[this.selectedIndex];
      var dosen = selectedOption.getAttribute('data-dosen');
      var dosenId = selectedOption.getAttribute('data-dosen-id');
      document.getElementById('dosen').value = dosen;
      document.getElementById('dosen_id').value = dosenId;
    });

    var addScheduleModal = document.getElementById('addScheduleModal');
    addScheduleModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var hari = button.getAttribute('data-hari');
      var jamMulai = button.getAttribute('data-jam');

      var modalTitle = addScheduleModal.querySelector('.modal-title');
      var hariInput = addScheduleModal.querySelector('#hari');
      var jamMulaiInput = addScheduleModal.querySelector('#jam_mulai');
      var jamSelesaiSelect = addScheduleModal.querySelector('#jam_selesai');

      modalTitle.textContent = 'Tambah Mata Kuliah untuk ' + hari;
      hariInput.value = hari;
      jamMulaiInput.value = jamMulai;

      // Isi opsi jam selesai
      jamSelesaiSelect.innerHTML = '';
      <?php
      $time_slots_adding_js = json_encode($time_slots_adding);
      echo "var timeSlotsAdding = $time_slots_adding_js;\n";
      ?>

      var startIndex = timeSlotsAdding.indexOf(jamMulai);
      for (var i = startIndex + 1; i < timeSlotsAdding.length; i++) {
        var option = document.createElement('option');
        option.value = timeSlotsAdding[i];
        option.text = timeSlotsAdding[i];
        jamSelesaiSelect.appendChild(option);
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>