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
$user_id = $_SESSION['user_id'];
$dosen_id = get_dosen_id_by_user_id($db, $user_id);

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
  if (isset($_POST['delete_schedule_permanently'])) {
    $hari = $_POST['hari'];
    $matkul = $_POST['matkul'];
    $dosen_id_1 = $_POST['dosen_id_1'];
    $dosen_id_2 = $_POST['dosen_id_2'];
    $kelas = $_POST['kelas'];

    $deleted_rows = delete_temp_schedule($hari, $matkul, $dosen_id_1, $dosen_id_2, $kelas);
    if ($deleted_rows > 0) {
      $_SESSION['message'] = "Berhasil menghapus $deleted_rows jadwal pergantian secara permanen.";
      $_SESSION['alert_class'] = "alert-success";
    } else {
      $_SESSION['message'] = "Tidak ada jadwal yang dihapus atau terjadi kesalahan.";
      $_SESSION['alert_class'] = "alert-warning";
    }
    header("Location: jadwal-pergantian.php");
    exit;
  } elseif (isset($_POST['delete_schedule_temporarily'])) {
    $hari = $_POST['hari'];
    $matkul = $_POST['matkul'];
    $dosen_id_1 = $_POST['dosen_id_1'];
    $dosen_id_2 = $_POST['dosen_id_2'];
    $kelas = $_POST['kelas'];

    $result = delete_schedule_temporarily($db, $hari, $matkul, $dosen_id_1, $dosen_id_2, $kelas);

    if ($result) {
      $_SESSION['message'] = "Berhasil menghapus jadwal sementara untuk pekan ini.";
      $_SESSION['alert_class'] = "alert-success";
    } else {
      $_SESSION['message'] = "Gagal menghapus jadwal sementara.";
      $_SESSION['alert_class'] = "alert-danger";
    }
    header("Location: jadwal-pergantian.php");
    exit;
  } elseif (isset($_POST['action']) && $_POST['action'] === 'cancel_delete') {
    $hari = $_POST['hari'];
    $matkul = $_POST['matkul'];
    $dosen_id_1 = $_POST['dosen_id_1'];
    $dosen_id_2 = $_POST['dosen_id_2'];
    $kelas = $_POST['kelas'];

    $affected_rows = cancel_temporary_delete($db, $hari, $matkul, $dosen_id_1, $dosen_id_2, $kelas);

    if ($affected_rows > 0) {
      $_SESSION['message'] = "Berhasil membatalkan penghapusan $affected_rows jadwal sementara.";
      $_SESSION['alert_class'] = "alert-success";
    } else {
      $_SESSION['message'] = "Tidak ada jadwal sementara yang perlu dibatalkan atau terjadi kesalahan.";
      $_SESSION['alert_class'] = "alert-danger";
    }
    header("Location: jadwal-pergantian.php");
    exit;
  } elseif (isset($_POST['hari'], $_POST['jam_mulai'], $_POST['jam_selesai'], $_POST['matkul'], $_POST['dosen_id_1'], $_POST['dosen_id_2'], $_POST['classroom'], $_POST['kelas'])) {
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $matkul = $_POST['matkul'];
    $dosen_id_1 = $_POST['dosen_id_1'];
    $dosen_id_2 = !empty($_POST['dosen_id_2']) ? $_POST['dosen_id_2'] : NULL;
    $classroom = $_POST['classroom'];
    $kelas = $_POST['kelas'];
    $is_temporary = isset($_POST['is_temporary']) ? 1 : 0;
    $end_date = $is_temporary ? date('Y-m-d', strtotime('next Sunday')) : NULL;

    if (checkRegularSchedule($db, $hari, $jam_mulai, $jam_selesai, $kelas)) {
      $_SESSION['message'] = "Tidak dapat menambahkan jadwal pergantian. Kelas $kelas sudah memiliki jadwal reguler pada waktu tersebut.";
      $_SESSION['alert_class'] = "alert-danger";
    } else {
      $start_index = array_search($jam_mulai, $time_slots_adding);
      $end_index = array_search($jam_selesai, $time_slots_adding);

      list($message, $alert_class) = insert_schedule($db, $hari, $matkul, $dosen_id_1, $dosen_id_2, $classroom, $kelas, $time_slots_adding, $start_index, $end_index, $is_temporary, $end_date);

      $_SESSION['message'] = $message;
      $_SESSION['alert_class'] = $alert_class;
    }
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
  <?php include 'navbar.php'; ?>
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
              $displayed_temporary_schedules = array();
              foreach ($time_slots_viewing as $slot):
                ?>
                <tr <?= in_array($slot, ["10.00 - 10.20", "12.00 - 13.00", "15.30 - 16.00", "17.40 - 18.40"]) ? 'class="table-secondary"' : ''; ?>>
                  <td><?= $slot; ?></td>
                  <?php foreach ($days as $day): ?>
                    <td>
                      <?php if (!empty($all_slots[$day][$slot])): ?>
                        <?php
                        $deleted_schedules = isset($_SESSION['deleted_schedules']) ? $_SESSION['deleted_schedules'] : [];
                        foreach ($all_slots[$day][$slot] as $index => $schedule):
                          $schedule_key = $day . '-' . $schedule['matkul'] . '-' . $schedule['dosen_id'] . '-' . $schedule['kelas'];
                          $is_deleted = in_array($schedule['id'], $deleted_schedules);
                          $show_buttons = !in_array($schedule_key, $displayed_schedules) && !$is_deleted;
                          ?>
                          <div><?= htmlspecialchars($schedule['matkul']); ?></div>
                          <div><small>Dosen 1: <?= htmlspecialchars($schedule['dosen_1']); ?></small></div>
                          <?php if ($schedule['dosen_2'] !== null): ?>
                            <div><small>Dosen 2: <?= htmlspecialchars($schedule['dosen_2']); ?></small></div>
                          <?php endif; ?>
                          <div><small>Kelas: <?= htmlspecialchars($schedule['kelas']); ?></small></div>
                          <div><small>Ruang: <?= htmlspecialchars($schedule['classroom']); ?></small></div>
                          <?php if ($schedule['is_temporary']): ?>
                            <span class="badge bg-warning">Jadwal Pergantian</span><br>
                            <?php
                            $temp_schedule_key = $schedule['matkul'] . '-' . $schedule['dosen_id_1'] . '-' . $schedule['kelas'];
                            if (!in_array($temp_schedule_key, $displayed_temporary_schedules)):
                              $displayed_temporary_schedules[] = $temp_schedule_key;
                              ?>
                              <button class="btn btn-sm btn-danger mt-2 delete-permanent-btn" data-hari="<?= $day; ?>"
                                data-matkul="<?= htmlspecialchars($schedule['matkul']); ?>"
                                data-dosen-id_1="<?= htmlspecialchars($schedule['dosen_id_1']); ?>"
                                data-dosen-id_2="<?= htmlspecialchars($schedule['dosen_id_2']); ?>"
                                data-kelas="<?= htmlspecialchars($schedule['kelas']); ?>" onclick="confirmDeletePermanent(this)">
                                Hapus Permanen
                              </button>
                            <?php endif; ?>
                          <?php endif; ?>
                          <?php if ($schedule['is_deleted_temporarily'] || $is_deleted): ?>
                            <span class="badge bg-danger">Jadwal Dikosongkan Sementara</span><br>
                            <?php if ($show_buttons): ?>
                              <button class="btn btn-sm btn-warning kosong-temporary-btn mt-2" data-bs-toggle="modal"
                                data-bs-target="#addScheduleModal" data-hari="<?= $day; ?>" data-jam="<?= $slot; ?>"
                                data-matkul="<?= htmlspecialchars($schedule['matkul']); ?>"
                                data-dosen="<?= htmlspecialchars($schedule['dosen_1']); ?>"
                                data-dosen-id_1="<?= htmlspecialchars($schedule['dosen_id_1']); ?>"
                                data-dosen-id_2="<?= htmlspecialchars($schedule['dosen_id_2']); ?>"
                                data-kelas="<?= htmlspecialchars($schedule['kelas']); ?>"
                                data-classroom="<?= htmlspecialchars($schedule['classroom']); ?>"
                                data-schedule-id="<?= $schedule['id']; ?>">
                                Kosong
                              </button>
                              <?php if ($schedule['dosen_id_1'] === $dosen_id || $schedule['dosen_id_2'] === $dosen_id): ?>
                                <form action="" method="post" class="d-inline">
                                  <input type="hidden" name="action" value="cancel_delete">
                                  <input type="hidden" name="hari" value="<?= $day; ?>">
                                  <input type="hidden" name="matkul" value="<?= htmlspecialchars($schedule['matkul']); ?>">
                                  <input type="hidden" name="dosen_id_1" value="<?= htmlspecialchars($schedule['dosen_id_1']); ?>">
                                  <input type="hidden" name="dosen_id_2" value="<?= htmlspecialchars($schedule['dosen_id_2']); ?>">
                                  <input type="hidden" name="kelas" value="<?= htmlspecialchars($schedule['kelas']); ?>">
                                  <button type="button" class="btn btn-sm btn-success mt-2 cancel-delete-btn"
                                    onclick="cancelDeleteSchedule(this)">
                                    Batal Kosongkan
                                  </button>
                                </form>
                              <?php endif; ?>
                            <?php endif; ?>
                          <?php endif; ?>
                          <?php if (!$schedule['is_temporary'] && !$schedule['is_deleted_temporarily'] && !$is_deleted && $show_buttons): ?>
                            <?php if ($schedule['dosen_id_1'] === $dosen_id || $schedule['dosen_id_2'] === $dosen_id): ?>
                              <form action="" method="post" class="d-inline delete-schedule-form">
                                <input type="hidden" name="schedule_id" value="<?= $schedule['id']; ?>">
                                <input type="hidden" name="hari" value="<?= $day; ?>">
                                <input type="hidden" name="matkul" value="<?= htmlspecialchars($schedule['matkul']); ?>">
                                <input type="hidden" name="dosen_id_1" value="<?= htmlspecialchars($schedule['dosen_id_1']); ?>">
                                <input type="hidden" name="dosen_id_2" value="<?= htmlspecialchars($schedule['dosen_id_2']); ?>">
                                <input type="hidden" name="kelas" value="<?= htmlspecialchars($schedule['kelas']); ?>">
                                <input type="hidden" name="jam" value="<?= $slot; ?>">
                                <button type="button" class="btn btn-sm btn-danger mt-2 delete-schedule-btn"
                                  onclick="confirmDeleteSchedule(this, false)">
                                  Hapus Sementara
                                </button>
                              </form>
                            <?php endif; ?>
                          <?php endif; ?>
                          <?php $displayed_schedules[] = $schedule_key; ?>
                          <hr>
                        <?php endforeach; ?>
                      <?php elseif (in_array($slot, ["10.00 - 10.20", "12.00 - 13.00", "15.30 - 16.00", "17.40 - 18.40"])): ?>
                        Istirahat
                      <?php else: ?>
                        <button class="btn btn-sm btn-success kosong-btn" data-bs-toggle="modal"
                          data-bs-target="#addScheduleModal" data-hari="<?= $day; ?>" data-jam="<?= $slot; ?>" data-kelas="">
                          Kosong
                        </button>
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
                $sql = "SELECT mata_kuliah.nama AS matkul_nama, 
                               dosen1.nama AS dosen1_nama, dosen2.nama AS dosen2_nama, 
                               dosen1.id AS dosen1_id, dosen2.id AS dosen2_id
                        FROM mata_kuliah 
                        LEFT JOIN daftar_dosen dosen1 ON mata_kuliah.dosen_id_1 = dosen1.id
                        LEFT JOIN daftar_dosen dosen2 ON mata_kuliah.dosen_id_2 = dosen2.id";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['matkul_nama'] . "' data-dosen1='" . $row['dosen1_nama'] . "' data-dosen1-id='" . $row['dosen1_id'] . "' data-dosen2='" . $row['dosen2_nama'] . "' data-dosen2-id='" . $row['dosen2_id'] . "'>" . $row['matkul_nama'] . "</option>";
                  }
                } else {
                  echo "<option value=''>Tidak ada mata kuliah tersedia</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="dosen1" class="form-label">Dosen Pengampu 1:</label>
              <input type="text" id="dosen1" name="dosen1" class="form-control" readonly>
              <input type="hidden" id="dosen_id_1" name="dosen_id_1">
            </div>
            <div class="mb-3">
              <label for="dosen2" class="form-label">Dosen Pengampu 2:</label>
              <input type="text" id="dosen2" name="dosen2" class="form-control" readonly>
              <input type="hidden" id="dosen_id_2" name="dosen_id_2">
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
      // Inisialisasi
      restoreHiddenButtons();
      initializeModalHandlers();
      initializeFormHandlers();
      loadSubmittedData();
      loadHiddenButtonsFromStorage();
      initializeCancelButtons();
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

      // Event listener untuk tombol "Batal" pada modal
      document.querySelector('#addScheduleModal .btn-secondary').addEventListener('click', function () {
        restoreHiddenButtons();
      });
    }

    function initializeFormHandlers() {
      document.getElementById('matkul').addEventListener('change', function () {
        var selectedOption = this.options[this.selectedIndex];
        var dosen1 = selectedOption.getAttribute('data-dosen1');
        var dosen1Id = selectedOption.getAttribute('data-dosen1-id');
        var dosen2 = selectedOption.getAttribute('data-dosen2') || '';
        var dosen2Id = selectedOption.getAttribute('data-dosen2-id') || '';
        document.getElementById('dosen1').value = dosen1;
        document.getElementById('dosen_id_1').value = dosen1Id;
        document.getElementById('dosen2').value = dosen2;
        document.getElementById('dosen_id_2').value = dosen2Id;
      });

      document.getElementById('addScheduleForm').addEventListener('submit', function (event) {
        var hari = document.getElementById('hari').value;
        var jamMulai = document.getElementById('jam_mulai').value;
        var matkul = document.getElementById('matkul').value;
        var dosen1Id = document.getElementById('dosen_id_1').value;
        var kelas = document.getElementById('kelas').value;

        hideAllMatchingButtons(hari, jamMulai, matkul, dosen1Id, kelas);
      });
    }

    function initializeCancelButtons() {
      var cancelButtons = document.querySelectorAll('.cancel-delete-btn').forEach(function (button) {
        button.removeEventListener('click', cancelDeleteSchedule); // Hapus listener yang mungkin sudah ada
        button.addEventListener('click', cancelDeleteSchedule);
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
      var dosenId_1 = form.querySelector('input[name="dosen_id_1"]').value;
      var dosenId_2 = form.querySelector('input[name="dosen_id_2"]').value;
      var kelas = form.querySelector('input[name="kelas"]').value;

      var message = isPermanent ?
        "Apakah Anda yakin ingin menghapus semua jadwal yang sama secara permanen?" :
        "Apakah Anda yakin ingin menghapus semua jadwal yang sama sementara untuk pekan ini?";

      if (confirm(message)) {
        if (!isPermanent) {
          // Menyembunyikan tombol "Hapus Sementara"
          button.style.display = 'none';

          // Menampilkan tombol "Batal Kosong"
          var cancelButton = button.parentElement.nextElementSibling;
          if (cancelButton && cancelButton.classList.contains('cancel-delete-btn')) {
            cancelButton.style.display = 'inline-block';
          } else {
            // Jika tombol "Batal Kosong" belum ada, kita buat baru
            cancelButton = document.createElement('button');
            cancelButton.type = 'button';
            cancelButton.className = 'btn btn-sm btn-success mt-2 cancel-delete-btn';
            cancelButton.textContent = 'Batal Kosong';
            cancelButton.onclick = function () { cancelDeleteSchedule(this); };
            button.parentElement.parentElement.insertBefore(cancelButton, button.parentElement.nextSibling);
          }

          // Menambahkan badge "Jadwal Dikosongkan Sementara"
          var badge = document.createElement('span');
          badge.className = 'badge bg-danger';
          badge.textContent = 'Jadwal Dikosongkan Sementara';
          button.parentElement.parentElement.insertBefore(badge, button.parentElement);
        }

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

        var dosenId_1Input = document.createElement('input');
        dosenId_1Input.type = 'hidden';
        dosenId_1Input.name = 'dosen_id_1';
        dosenId_1Input.value = dosenId_1;
        submitForm.appendChild(dosenId_1Input);

        var dosenId_2Input = document.createElement('input');
        dosenId_2Input.type = 'hidden';
        dosenId_2Input.name = 'dosen_id_2';
        dosenId_2Input.value = dosenId_2;
        submitForm.appendChild(dosenId_2Input);

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

    function confirmDeletePermanent(button) {
      var hari = button.getAttribute('data-hari');
      var matkul = button.getAttribute('data-matkul');
      var dosenId_1 = button.getAttribute('data-dosen-id_1');
      var dosenId_2 = button.getAttribute('data-dosen-id_2') || '';
      var kelas = button.getAttribute('data-kelas');

      var message = "Apakah Anda yakin ingin menghapus semua jadwal pergantian yang sama secara permanen?";

      if (confirm(message)) {
        var submitForm = document.createElement('form');
        submitForm.method = 'post';
        submitForm.style.display = 'none';

        var inputs = [
          { name: 'hari', value: hari },
          { name: 'matkul', value: matkul },
          { name: 'dosen_id_1', value: dosenId_1 },
          { name: 'dosen_id_2', value: dosenId_2 },
          { name: 'kelas', value: kelas },
          { name: 'delete_schedule_permanently', value: 'true' }
        ];

        inputs.forEach(function (input) {
          var inputElement = document.createElement('input');
          inputElement.type = 'hidden';
          inputElement.name = input.name;
          inputElement.value = input.value;
          submitForm.appendChild(inputElement);
        });

        document.body.appendChild(submitForm);

        // Hapus data dari localStorage
        removeAllMatchingFromStorage(hari, matkul, dosenId_1, dosenId_2, kelas);

        // Update UI
        updateUIAfterPermanentDelete(hari, matkul, dosenId_1, dosenId_2, kelas);

        submitForm.submit();
      }
    }

    function cancelDeleteSchedule(event) {
      event.preventDefault(); // Mencegah form submit otomatis
      var button = event.currentTarget;
      var form = button.closest('form');
      if (confirm('Apakah Anda yakin ingin membatalkan pengosongan semua jadwal yang sama?')) {
        var hari = form.querySelector('input[name="hari"]').value;
        var matkul = form.querySelector('input[name="matkul"]').value;
        var dosenId_1 = form.querySelector('input[name="dosen_id_1"]').value;
        var dosenId_2 = form.querySelector('input[name="dosen_id_2"]').value;
        var kelas = form.querySelector('input[name="kelas"]').value;

        // Hapus semua data yang cocok dari localStorage
        removeAllMatchingFromStorage(hari, matkul, dosenId_1, dosenId_2, kelas);

        form.submit();
      }
    }

    function removeAllMatchingFromStorage(hari, matkul, dosenId_1, dosenId_2, kelas) {
      var hiddenButtons = JSON.parse(localStorage.getItem('hiddenKosongTemporaryButtons') || '[]');
      hiddenButtons = hiddenButtons.filter(function (item) {
        return !(item.hari === hari && item.matkul === matkul &&
          item.dosenId === dosenId_1 && item.kelas === kelas &&
          (dosenId_2 ? item.dosenId_2 === dosenId_2 : !item.dosenId_2 || item.dosenId_2 === ''));
      });
      localStorage.setItem('hiddenKosongTemporaryButtons', JSON.stringify(hiddenButtons));
    }

    function updateUIAfterPermanentDelete(hari, matkul, dosenId_1, dosenId_2, kelas) {
      var selector = `[data-hari="${hari}"][data-matkul="${matkul}"][data-dosen-id_1="${dosenId_1}"][data-kelas="${kelas}"]`;
      if (dosenId_2) {
        selector += `[data-dosen-id_2="${dosenId_2}"]`;
      } else {
        selector += ':not([data-dosen-id_2]), [data-dosen-id_2=""]';
      }
      var allScheduleElements = document.querySelectorAll(selector);
      allScheduleElements.forEach(function (element) {
        element.remove();
      });
    }

    function removeHiddenButtonFromStorage(hari, jam, matkul, dosenId_1, dosenId_2, kelas) {
      var hiddenButtons = JSON.parse(localStorage.getItem('hiddenKosongTemporaryButtons') || '[]');
      hiddenButtons = hiddenButtons.filter(function (item) {
        return !(item.hari === hari && item.jam === jam && item.matkul === matkul &&
          item.dosenId_1 === dosenId_1 && item.dosenId_2 === dosenId_2 && item.kelas === kelas);
      });
      localStorage.setItem('hiddenKosongTemporaryButtons', JSON.stringify(hiddenButtons));
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>