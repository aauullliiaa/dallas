<?php
session_start();
require '../src/db/functions.php';
checkRole('admin');

$time_slots = get_time_slots_for_adding();
$occupied_slots = [];
$kelas = $_GET['kelas'] ?? $_POST['kelas'] ?? '';

if (isset($_GET['hari']) && !empty($kelas)) {
    $hari = $_GET['hari'];
    $occupied_slots = get_occupied_slots($db, $hari, $kelas);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_form'])) {
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $matkul_id = $_POST['matkul'];
    $dosen_id_1 = $_POST['dosen_id_1'];
    $dosen_id_2 = !empty($_POST['dosen_id_2']) ? $_POST['dosen_id_2'] : NULL;
    $classroom = htmlspecialchars($_POST['classroom']);
    $kelas = $_POST['kelas'];

    $course = get_course_name($db, $matkul_id);

    $start_index = array_search($jam_mulai, $time_slots);
    $end_index = array_search($jam_selesai, $time_slots);

    list($message, $alert_class) = insert_schedule($db, $hari, $course, $dosen_id_1, $dosen_id_2, $classroom, $kelas, $time_slots, $start_index, $end_index);

    if ($alert_class == "alert-success") {
        $_SESSION['message'] = $message;
        $_SESSION['alert_class'] = $alert_class;
        header("Location: jadwal-kuliah.php?kelas={$kelas}");
        exit();
    }
}

$dosen_name_1 = '';
$dosen_name_2 = '';
if (isset($_POST['matkul'])) {
    $dosen_id_1 = $_POST['dosen_id_1'];
    $dosen_id_2 = $_POST['dosen_id_2'] ?? NULL;
    $dosen_name_1 = getDosenName($db, $dosen_id_1);
    $dosen_name_2 = $dosen_id_2 ? getDosenName($db, $dosen_id_2) : '';
}

unset($_SESSION['message']);
unset($_SESSION['alert_type']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APD Learning Space - Tambah Jadwal Perkuliahan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>
    <!-- End of Navbar -->
    <section class="hero-jadwal d-flex align-items-center justify-content-center">
        <h1>Tambah Jadwal Perkuliahan</h1>
    </section>
</header>

<body>
    <div class="container mb-5">
        <div class="card p-3 mb-2">
            <div class="card-body">
                <?php if (isset($message))
                    echo "<div class='alert {$alert_class} alert-dismissible fade show' role='alert'>{$message}<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>"; ?>

                <form action="" method="get" id="dayForm">
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas:</label>
                        <select id="kelas" name="kelas" class="form-select" required onchange="this.form.submit();">
                            <option value="">--Pilih Kelas--</option>
                            <option value="1A" <?php if ($kelas == '1A')
                                echo 'selected'; ?>>1A</option>
                            <option value="1B" <?php if ($kelas == '1B')
                                echo 'selected'; ?>>1B</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="hari" class="form-label">Hari:</label>
                        <select id="hari" name="hari" class="form-select" required onchange="this.form.submit();">
                            <option value="">--Pilih Hari--</option>
                            <option value="Senin" <?php if (isset($hari) && $hari == 'Senin')
                                echo 'selected'; ?>>Senin
                            </option>
                            <option value="Selasa" <?php if (isset($hari) && $hari == 'Selasa')
                                echo 'selected'; ?>>Selasa
                            </option>
                            <option value="Rabu" <?php if (isset($hari) && $hari == 'Rabu')
                                echo 'selected'; ?>>Rabu
                            </option>
                            <option value="Kamis" <?php if (isset($hari) && $hari == 'Kamis')
                                echo 'selected'; ?>>Kamis
                            </option>
                            <option value="Jumat" <?php if (isset($hari) && $hari == 'Jumat')
                                echo 'selected'; ?>>Jumat
                            </option>
                        </select>
                    </div>
                </form>

                <form action="" method="post" id="scheduleForm">
                    <input type="hidden" name="hari" value="<?= htmlspecialchars($hari); ?>">
                    <input type="hidden" name="kelas" value="<?= htmlspecialchars($kelas); ?>">
                    <div class="mb-3">
                        <label for="matkul" class="form-label">Mata Kuliah:</label>
                        <select id="matkul" name="matkul" class="form-select" required>
                            <option value="">--Pilih Mata Kuliah--</option>
                            <?php
                            $sql = "SELECT id, nama, dosen_id_1, dosen_id_2 FROM mata_kuliah";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "' data-dosen-id-1='" . $row['dosen_id_1'] . "' data-dosen-id-2='" . $row['dosen_id_2'] . "'>" . $row['nama'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>Tidak ada mata kuliah tersedia</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="dosen_1" class="form-label">Dosen Pengampu 1:</label>
                        <input type="text" id="dosen_1" name="dosen_1" class="form-control"
                            value="<?= htmlspecialchars($dosen_name_1); ?>" readonly required>
                        <input type="hidden" id="dosen_id_1" name="dosen_id_1">
                    </div>
                    <div class="mb-3">
                        <label for="dosen_2" class="form-label">Dosen Pengampu 2:</label>
                        <input type="text" id="dosen_2" name="dosen_2" class="form-control"
                            value="<?= htmlspecialchars($dosen_name_2); ?>" readonly>
                        <input type="hidden" id="dosen_id_2" name="dosen_id_2">
                    </div>
                    <div class="mb-3">
                        <label for="classroom" class="form-label">Ruang Kelas:</label>
                        <input type="text" id="classroom" name="classroom" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="jam_mulai" class="form-label">Jam Mulai:</label>
                        <select id="jam_mulai" name="jam_mulai" class="form-select" required>
                            <option value="">--Pilih Jam Mulai--</option>
                            <?php
                            foreach ($time_slots as $slot) {
                                if (!in_array($slot, $occupied_slots)) {
                                    echo "<option value='$slot'>$slot</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jam_selesai" class="form-label">Jam Selesai:</label>
                        <select id="jam_selesai" name="jam_selesai" class="form-select" required>
                            <?php
                            foreach ($time_slots as $slot) {
                                if (!in_array($slot, $occupied_slots)) {
                                    echo "<option value='$slot'>$slot</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="hari" value="<?= htmlspecialchars($hari); ?>">
                    <input type="hidden" name="submit_form" value="1">
                    <div class="row mb-2">
                        <div class="col submit-button">
                            <button type="submit" class="btn btn-light">Tambah Jadwal</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col submit-button">
                        <a href="jadwal-kuliah.php"><button class="btn btn-light">Kembali</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('matkul').addEventListener('change', function () {
            var selectedOption = this.options[this.selectedIndex];
            var dosenId1 = selectedOption.getAttribute('data-dosen-id-1');
            var dosenId2 = selectedOption.getAttribute('data-dosen-id-2');
            document.getElementById('dosen_id_1').value = dosenId1;
            document.getElementById('dosen_id_2').value = dosenId2 ? dosenId2 : '';

            // Find the selected dosen names from the options
            var dosenName1 = '';
            var dosenName2 = '';
            <?php
            $sql = "SELECT id, nama FROM daftar_dosen";
            $result = $db->query($sql);
            $dosen_list = [];
            while ($row = $result->fetch_assoc()) {
                $dosen_list[$row['id']] = $row['nama'];
            }
            ?>
            var dosenList = <?= json_encode($dosen_list); ?>;
            if (dosenId1 in dosenList) {
                dosenName1 = dosenList[dosenId1];
            }
            if (dosenId2 && dosenId2 in dosenList) {
                dosenName2 = dosenList[dosenId2];
            }
            document.getElementById('dosen_1').value = dosenName1;
            document.getElementById('dosen_2').value = dosenName2;
        });

        // Filter jam_selesai options based on jam_mulai selection
        var timeSlots = <?= json_encode($time_slots); ?>;
        document.getElementById('jam_mulai').addEventListener('change', function () {
            var jamMulai = this.value;
            var jamMulaiIndex = timeSlots.indexOf(jamMulai);
            var jamSelesaiSelect = document.getElementById('jam_selesai');
            jamSelesaiSelect.innerHTML = '';

            for (var i = jamMulaiIndex + 1; i < timeSlots.length; i++) {
                var option = document.createElement('option');
                option.value = timeSlots[i];
                option.textContent = timeSlots[i];
                jamSelesaiSelect.appendChild(option);
            }
        });
    </script>
</body>

</html>