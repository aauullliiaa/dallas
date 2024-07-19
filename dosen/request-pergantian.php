<?php
session_start();
require '../src/db/functions.php';
checkRole('dosen');

$user_id = $_SESSION['user_id'];
$dosen_id = get_dosen_id_by_user_id($db, $user_id);

$time_slots = get_time_slots_for_adding();
$jadwal_kuliah = get_jadwal_kuliah_for_dosen($db, $dosen_id);

$alertMessage = "";
$alertType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $jadwal_ids = $_POST['jadwal_id'];
  $tanggal_awal = $_POST['tanggalAwal'];
  $tanggal_baru = $_POST['tanggalBaru'];
  $jadwal_baru_mulai = $_POST['jadwalBaruMulai'];
  $jadwal_baru_selesai = $_POST['jadwalBaruSelesai'];
  $alasan = $_POST['alasan'];
  header("Location: list-request.php");
  exit;

  list($alertType, $alertMessage) = process_request($db, $jadwal_ids, $tanggal_awal, $tanggal_baru, $jadwal_baru_mulai, $jadwal_baru_selesai, $alasan);

  $db->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>APD Learning Space - Request Pergantian Jadwal Kuliah</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
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
      <h1>Request Jadwal Pergantian Kuliah</h1>
    </div>
  </section>
</header>

<body>
  <div class="container">
    <div class="card p-3">
      <div class="card-body">
        <?php if (!empty($alertMessage)): ?>
          <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
            <?php echo $alertMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        <form action="" method="post">
          <div class="mb-3">
            <label for="jadwal" class="form-label">Pilih Jadwal:</label>
            <select class="form-select" id="jadwal" name="jadwal_id" required>
              <option value="">Pilih Jadwal</option>
              <?php
              foreach ($jadwal_kuliah as $jadwal) {
                $jadwal_info = "{$jadwal['hari']} - ({$jadwal['jam_awal']}) - ({$jadwal['jam_akhir']}) - {$jadwal['matkul']} - {$jadwal['dosen1']} & {$jadwal['dosen2']} - Kelas: {$jadwal['kelas']}, Ruang: {$jadwal['classroom']}";
                echo "<option value='{$jadwal['id_list']}'>{$jadwal_info}</option>";
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="tanggalAwal" class="form-label">Tanggal Awal:</label>
            <input type="date" class="form-control" id="tanggalAwal" name="tanggalAwal" required>
          </div>
          <div class="mb-3">
            <label for="tanggalBaru" class="form-label">Tanggal Baru:</label>
            <input type="date" class="form-control" id="tanggalBaru" name="tanggalBaru" required>
          </div>
          <div class="mb-3">
            <label for="jadwalBaruMulai" class="form-label">Waktu Mulai Baru:</label>
            <select class="form-select" id="jadwalBaruMulai" name="jadwalBaruMulai" required>
              <option value="">Pilih Waktu Mulai untuk Jadwal Pergantian</option>
              <?php
              foreach ($time_slots as $slot) {
                echo "<option value='{$slot}'>{$slot}</option>";
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="jadwalBaruSelesai" class="form-label">Waktu Selesai Baru:</label>
            <select class="form-select" id="jadwalBaruSelesai" name="jadwalBaruSelesai" required>
              <option value="">Pilih Waktu Selesai untuk Jadwal Pergantian</option>
              <?php
              foreach ($time_slots as $slot) {
                echo "<option value='{$slot}'>{$slot}</option>";
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="alasan" class="form-label">Alasan Pergantian:</label>
            <textarea class="form-control" id="alasan" name="alasan" rows="4" required></textarea>
          </div>
          <div class="row mb-2">
            <div class="col submit-button">
              <button type="submit" class="btn btn-light">Submit Request</button>
            </div>
          </div>
        </form>
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
  <script>
    $(document).ready(function () {
      $('#jadwal').change(function () {
        var selectedOption = $(this).find('option:selected');
        var jam = selectedOption.data('jam');
        var additionalInfo = selectedOption.data('additional-info');
        $('#jadwalAwal').val(jam);
        $('#additionalInfo').val(additionalInfo);
      });

      function updateTimeSlots(startSelect, endSelect) {
        var selectedStart = startSelect.val();
        endSelect.html('<option value="">Pilih Waktu Selesai</option>');
        var foundSelected = false;
        startSelect.find('option').each(function () {
          if (foundSelected && $(this).val() !== '') {
            endSelect.append($('<option></option>').attr('value', $(this).val()).text($(this).text()));
          }
          if ($(this).val() === selectedStart) {
            foundSelected = true;
          }
        });
      }

      function updateTimeSlots(select, options) {
        select.html('<option value="">Pilih Waktu Selesai</option>');
        options.forEach(function (slot) {
          var option = $('<option></option>').attr('value', slot).text(slot);
          select.append(option);
        });
      }

      $('#jadwalBaruMulai').change(function () {
        var selectedIndex = $(this).prop('selectedIndex');
        var options = $(this).find('option').slice(selectedIndex + 1);
        var values = options.map(function () { return $(this).val(); }).get();
        updateTimeSlots($('#jadwalBaruSelesai'), values);
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
</body>


</html>