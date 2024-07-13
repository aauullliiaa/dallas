<?php
session_start();
require '../src/db/functions.php';
checkRole('admin');

delete_expired_temporary_schedules($db);
restore_temporary_deleted_schedules($db);

$all_slots = fetch_all_slots($db);

$days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
$time_slots_viewing = get_time_slots_for_viewing();
$time_slots_adding = get_time_slots_for_adding();

$message = '';
$alert_class = '';
$deleted_schedules = [];

// Ambil pesan dari session jika ada
if (isset($_SESSION['message']) && isset($_SESSION['alert_class'])) {
  $message = $_SESSION['message'];
  $alert_class = $_SESSION['alert_class'];

  // Hapus pesan dari session setelah ditampilkan
  unset($_SESSION['message']);
  unset($_SESSION['alert_class']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['delete_schedule_permanently']) || isset($_POST['delete_schedule_temporarily'])) {
    $is_permanent = isset($_POST['delete_schedule_permanently']);
    $hari = $_POST['hari'];
    $matkul = $_POST['matkul'];
    $dosen_id = $_POST['dosen_id'];
    $kelas = $_POST['kelas'];

    if ($is_permanent) {
      $result = delete_schedule_permanently($db, $schedule_id);
    } else {
      $result = delete_schedule_temporarily($db, $hari, $matkul, $dosen_id, $kelas);
    }

    if ($result) {
      $_SESSION['message'] = $is_permanent ?
        "Berhasil menghapus jadwal secara permanen." :
        "Berhasil menghapus jadwal sementara untuk pekan ini.";
      $_SESSION['alert_class'] = "alert-success";
    } else {
      $_SESSION['message'] = $is_permanent ?
        "Gagal menghapus jadwal secara permanen." :
        "Gagal menghapus jadwal sementara.";
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
    $_SESSION['submitted_hari'] = $hari;
    $_SESSION['submitted_jam_mulai'] = $jam_mulai;
    $_SESSION['submitted_matkul'] = $matkul;
    $_SESSION['submitted_dosen_id'] = $dosen_id;
    $_SESSION['submitted_kelas'] = $kelas;
  }
  header("Location: jadwal-pergantian.php");
  exit;
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
              $displayed_schedules = array();
              foreach ($time_slots_viewing as $slot):
                ?>
                <tr <?= in_array($slot, ["10.00 - 10.20", "12.00 - 13.00", "15.30 - 16.00", "17.40 - 18.40"]) ? 'class="table-secondary"' : ''; ?>>
                  <td><?= $slot; ?></td>
                  <?php foreach ($days as $day): ?>
                    <td>
                      <?php if (!empty($all_slots[$day][$slot])): ?>
                        <?php
                        $deleted_schedules = isset($_SESSION['deleted_schedules']) ? $_SESSION['deleted_schedules'] : [];
                        foreach ($all_slots[$day][$slot] as $schedule):
                          $schedule_key = $day . '-' . $schedule['matkul'] . '-' . $schedule['dosen_id'] . '-' . $schedule['kelas'];
                          $is_deleted = in_array($schedule['id'], $deleted_schedules);
                          $show_buttons = !in_array($schedule_key, $displayed_schedules) && !$is_deleted;
                          ?>
                          <div><?= htmlspecialchars($schedule['matkul']); ?></div>
                          <div><small>Dosen: <?= htmlspecialchars($schedule['dosen']); ?></small></div>
                          <div><small>Kelas: <?= htmlspecialchars($schedule['kelas']); ?></small></div>
                          <div><small>Ruang: <?= htmlspecialchars($schedule['classroom']); ?></small></div>
                          <?php if ($schedule['is_temporary']): ?>
                            <span class="badge bg-warning">Jadwal Pergantian</span><br>
                          <?php endif; ?>
                          <?php if ($schedule['is_deleted_temporarily'] || $is_deleted): ?>
                            <span class="badge bg-danger">Jadwal Dikosongkan Sementara</span><br>
                            <?php if ($show_buttons): ?>
                              <button class="btn btn-sm btn-warning kosong-temporary-btn mt-1" data-bs-toggle="modal"
                                data-bs-target="#addScheduleModal" data-hari="<?= $day; ?>" data-jam="<?= $slot; ?>"
                                data-matkul="<?= htmlspecialchars($schedule['matkul']); ?>"
                                data-dosen="<?= htmlspecialchars($schedule['dosen']); ?>"
                                data-dosen-id="<?= htmlspecialchars($schedule['dosen_id']); ?>"
                                data-kelas="<?= htmlspecialchars($schedule['kelas']); ?>"
                                data-classroom="<?= htmlspecialchars($schedule['classroom']); ?>"
                                data-schedule-id="<?= $schedule['id']; ?>">Kosong</button>
                              <?php $displayed_schedules[] = $schedule_key; ?>
                            <?php endif; ?>
                          <?php endif; ?>
                          <?php if (!$schedule['is_temporary'] && !$schedule['is_deleted_temporarily'] && !$is_deleted && $show_buttons): ?>
                            <form action="" method="post" class="d-inline delete-schedule-form">
                              <input type="hidden" name="schedule_id" value="<?= $schedule['id']; ?>">
                              <input type="hidden" name="hari" value="<?= $day; ?>">
                              <input type="hidden" name="matkul" value="<?= htmlspecialchars($schedule['matkul']); ?>">
                              <input type="hidden" name="dosen_id" value="<?= htmlspecialchars($schedule['dosen_id']); ?>">
                              <input type="hidden" name="kelas" value="<?= htmlspecialchars($schedule['kelas']); ?>">
                              <input type="hidden" name="jam" value="<?= $slot; ?>">
                              <button type="button" class="btn btn-sm btn-danger mt-2 delete-schedule-btn"
                                onclick="confirmDeleteSchedule(this, false)">
                                Hapus Sementara
                              </button>
                            </form>
                            <?php $displayed_schedules[] = $schedule_key; ?>
                          <?php endif; ?>
                          <hr>
                        <?php endforeach; ?>
                      <?php elseif (in_array($slot, ["10.00 - 10.20", "12.00 - 13.00", "15.30 - 16.00", "17.40 - 18.40"])): ?>
                        Istirahat
                      <?php else: ?>
                        <button class="btn btn-sm btn-success kosong-btn" data-bs-toggle="modal"
                          data-bs-target="#addScheduleModal" data-hari="<?= $day; ?>" data-jam="<?= $slot; ?>"
                          data-kelas="">Kosong</button>
                      <?php endif; ?>
                    </td>
                  <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="row text-center">
          <div class="col submit-button">
            <a href="jadwal-kuliah.php"><button class="btn btn-light">Kembali</button></a>
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
                <option value="">--Pilih Kelas--</option>
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
              <button type="submit" class="btn btn-primary" id="submitScheduleButton">Tambah Mata Kuliah</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      restoreHiddenButtons();
      initializeModalHandlers();
      initializeFormHandlers();
      loadSubmittedData();
      loadHiddenButtonsFromStorage();
    });

    function initializeModalHandlers() {
      var addScheduleModal = document.getElementById('addScheduleModal');
      addScheduleModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var hari = button.getAttribute('data-hari');
        var jamMulai = button.getAttribute('data-jam');
        var kelas = button.getAttribute('data-kelas');
        var isTemporary = button.classList.contains('kosong-temporary-btn');
        var classroom = button.getAttribute('data-classroom');

        var modalTitle = addScheduleModal.querySelector('.modal-title');
        var hariInput = addScheduleModal.querySelector('#hari');
        var jamMulaiInput = addScheduleModal.querySelector('#jam_mulai');
        var jamSelesaiSelect = addScheduleModal.querySelector('#jam_selesai');
        var kelasInput = addScheduleModal.querySelector('#kelas');
        var isTemporaryInput = addScheduleModal.querySelector('#is_temporary');
        var classroomInput = addScheduleModal.querySelector('#classroom');

        modalTitle.textContent = 'Tambah Mata Kuliah untuk ' + hari;
        hariInput.value = hari;
        jamMulaiInput.value = jamMulai;
        kelasInput.value = kelas;
        isTemporaryInput.checked = isTemporary;
        classroomInput.value = classroom || '';

        populateJamSelesaiOptions(jamMulaiInput.value, jamSelesaiSelect);
      });

      document.querySelector('#addScheduleModal .btn-secondary').addEventListener('click', function () {
        restoreHiddenButtons();
      });
    }
    function initializeFormHandlers() {
      document.getElementById('matkul').addEventListener('change', function () {
        var selectedOption = this.options[this.selectedIndex];
        var dosen = selectedOption.getAttribute('data-dosen');
        var dosenId = selectedOption.getAttribute('data-dosen-id');
        document.getElementById('dosen').value = dosen;
        document.getElementById('dosen_id').value = dosenId;
      });

      document.getElementById('addScheduleForm').addEventListener('submit', function (event) {
        event.preventDefault();

        var hari = document.getElementById('hari').value;
        var jamMulai = document.getElementById('jam_mulai').value;
        var matkul = document.getElementById('matkul').value;
        var dosenId = document.getElementById('dosen_id').value;
        var kelas = document.getElementById('kelas').value;

        hideAllMatchingButtons(hari, jamMulai, matkul, dosenId, kelas);

        // Hide the specific "Kosong Sementara" button that was clicked
        var clickedButton = document.querySelector(`.kosong-temporary-btn[data-hari="${hari}"][data-jam="${jamMulai}"][data-matkul="${matkul}"][data-dosen-id="${dosenId}"][data-kelas="${kelas}"]`);
        if (clickedButton) {
          clickedButton.style.display = 'none';
        }

        this.submit();
      });
    }

    function populateJamSelesaiOptions(jamMulai, jamSelesaiSelect) {
      var timeSlotsAdding = ['07.30 - 08.20', '08.20 - 09.10', '09.10 - 10.00', '10.20 - 11.10', '11.10 - 12.00', '13.00 - 13.50', '13.50 - 14.40', '14.40 - 15.30', '16.00 - 16.50', '16.50 - 17.40'];

      jamSelesaiSelect.innerHTML = '';
      var startIndex = timeSlotsAdding.indexOf(jamMulai);
      for (var i = startIndex + 1; i < timeSlotsAdding.length; i++) {
        var option = document.createElement('option');
        option.value = timeSlotsAdding[i];
        option.text = timeSlotsAdding[i];
        jamSelesaiSelect.appendChild(option);
      }
    }

    function loadSubmittedData() {
      var submittedHari = '<?= isset($_SESSION['submitted_hari']) ? $_SESSION['submitted_hari'] : '' ?>';
      var submittedJamMulai = '<?= isset($_SESSION['submitted_jam_mulai']) ? $_SESSION['submitted_jam_mulai'] : '' ?>';
      var submittedMatkul = '<?= isset($_SESSION['submitted_matkul']) ? $_SESSION['submitted_matkul'] : '' ?>';
      var submittedDosenId = '<?= isset($_SESSION['submitted_dosen_id']) ? $_SESSION['submitted_dosen_id'] : '' ?>';
      var submittedKelas = '<?= isset($_SESSION['submitted_kelas']) ? $_SESSION['submitted_kelas'] : '' ?>';

      if (submittedHari && submittedJamMulai && submittedMatkul && submittedDosenId && submittedKelas) {
        hideAllMatchingButtons(submittedHari, submittedJamMulai, submittedMatkul, submittedDosenId, submittedKelas);

        // Hide the specific "Kosong Sementara" button that was submitted
        var submittedButton = document.querySelector(`.kosong-temporary-btn[data-hari="${submittedHari}"][data-jam="${submittedJamMulai}"][data-matkul="${submittedMatkul}"][data-dosen-id="${submittedDosenId}"][data-kelas="${submittedKelas}"]`);
        if (submittedButton) {
          submittedButton.style.display = 'none';
        }
      }
    }

    function loadHiddenButtonsFromStorage() {
      var hiddenButtons = JSON.parse(localStorage.getItem('hiddenKosongTemporaryButtons') || '[]');
      hiddenButtons.forEach(function (buttonData) {
        hideAllMatchingButtons(buttonData.hari, buttonData.jam, buttonData.matkul, buttonData.dosenId, buttonData.kelas);
      });
    }

    function hideAllMatchingButtons(hari, jam, matkul, dosenId, kelas) {
      var allButtons = document.querySelectorAll('.kosong-temporary-btn, .kosong-btn');
      allButtons.forEach(function (button) {
        if (button.getAttribute('data-hari') === hari &&
          button.getAttribute('data-jam') === jam &&
          (button.getAttribute('data-matkul') === matkul || button.getAttribute('data-matkul') === null) &&
          (button.getAttribute('data-dosen-id') === dosenId || button.getAttribute('data-dosen-id') === null) &&
          (button.getAttribute('data-kelas') === kelas || button.getAttribute('data-kelas') === '')) {
          button.style.display = 'none';

          var hiddenButtons = JSON.parse(localStorage.getItem('hiddenKosongTemporaryButtons') || '[]');
          var buttonData = { hari: hari, jam: jam, matkul: matkul, dosenId: dosenId, kelas: kelas };
          if (!hiddenButtons.some(item =>
            item.hari === buttonData.hari &&
            item.jam === buttonData.jam &&
            item.matkul === buttonData.matkul &&
            item.dosenId === buttonData.dosenId &&
            item.kelas === buttonData.kelas
          )) {
            hiddenButtons.push(buttonData);
            localStorage.setItem('hiddenKosongTemporaryButtons', JSON.stringify(hiddenButtons));
          }
        }
      });
    }

    function restoreHiddenButtons() {
      var hiddenButtons = JSON.parse(localStorage.getItem('hiddenKosongTemporaryButtons') || '[]');
      hiddenButtons.forEach(function (buttonData) {
        var button = document.querySelector(`.kosong-temporary-btn[data-hari="${buttonData.hari}"][data-jam="${buttonData.jam}"][data-matkul="${buttonData.matkul}"][data-dosen-id="${buttonData.dosenId}"][data-kelas="${buttonData.kelas}"]`);
        if (button) {
          button.style.display = 'block';
        }
      });
      localStorage.removeItem('hiddenKosongTemporaryButtons');
    }

    function confirmDeleteSchedule(button, isPermanent) {
      var form = button.closest('form');
      var hari = form.querySelector('input[name="hari"]').value;
      var matkul = form.querySelector('input[name="matkul"]').value;
      var dosenId = form.querySelector('input[name="dosen_id"]').value;
      var kelas = form.querySelector('input[name="kelas"]').value;

      var message = isPermanent ?
        "Apakah Anda yakin ingin menghapus semua jadwal yang sama secara permanen?" :
        "Apakah Anda yakin ingin menghapus semua jadwal yang sama sementara untuk pekan ini?";

      if (confirm(message)) {
        var submitForm = document.createElement('form');
        submitForm.method = 'post';
        submitForm.style.display = 'none';

        var hariInput = document.createElement('input');
        hariInput.type = 'hidden';
        hariInput.name = 'hari';
        hariInput.value = hari;
        submitForm.appendChild(hariInput);

        var matkulInput = document.createElement('input');
        matkulInput.type = 'hidden';
        matkulInput.name = 'matkul';
        matkulInput.value = matkul;
        submitForm.appendChild(matkulInput);

        var dosenIdInput = document.createElement('input');
        dosenIdInput.type = 'hidden';
        dosenIdInput.name = 'dosen_id';
        dosenIdInput.value = dosenId;
        submitForm.appendChild(dosenIdInput);

        var kelasInput = document.createElement('input');
        kelasInput.type = 'hidden';
        kelasInput.name = 'kelas';
        kelasInput.value = kelas;
        submitForm.appendChild(kelasInput);

        var actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = isPermanent ? 'delete_schedule_permanently' : 'delete_schedule_temporarily';
        actionInput.value = 'true';
        submitForm.appendChild(actionInput);

        document.body.appendChild(submitForm);
        submitForm.submit();
      }
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>