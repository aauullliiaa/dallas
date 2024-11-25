<?php
require '../src/db/functions.php';
$tahunakademik = retrieve("SELECT * FROM tahun_akademik");

$message = "";
$alert_type = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tahun_akademik_id = $_POST['tahun_akademik'];
    $jenis_semester = $_POST['jenis_semester'];
    $nomor_semester = $_POST['nomor_semester'];

    // Validate inputs
    if (empty($tahun_akademik_id) || empty($jenis_semester) || empty($nomor_semester)) {
        $message = "Semua field harus diisi.";
        $alert_type = "danger";
    } else {
        $sql = "INSERT INTO semester (tahun_akademik_id, jenis_semester, nomor_semester) VALUES (?, ?, ?)";

        $stmt = $db->prepare($sql);
        $stmt->bind_param("iss", $tahun_akademik_id, $jenis_semester, $nomor_semester);

        if ($stmt->execute()) {
            $message = "Data semester berhasil disimpan.";
            $alert_type = "success";
        } else {
            $message = "Error: " . $stmt->error;
            $alert_type = "danger";
        }
    }
}
$semesterData = retrieve("SELECT s.id, t.kode as tahun_akademik, s.jenis_semester, s.nomor_semester 
                          FROM semester s 
                          JOIN tahun_akademik t ON s.tahun_akademik_id = t.id 
                          ORDER BY t.kode DESC, s.jenis_semester, s.nomor_semester");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>APD Learning Space - Form Data Semester</title>
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
    <script>
        function updateSemesterOptions() {
            const semesterSelect = document.getElementById('nomor_semester');
            const selectedType = document.querySelector('input[name="jenis_semester"]:checked').value;

            semesterSelect.innerHTML = '<option value="">Pilih Nomor Semester</option>';

            const options = selectedType === 'ganjil' ? [1, 3, 5, 7] : [2, 4, 6, 8];
            options.forEach(function (semester) {
                const option = document.createElement('option');
                option.value = semester;
                option.text = `Semester ${semester}`;
                semesterSelect.add(option);
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const radioButtons = document.querySelectorAll('input[name="jenis_semester"]');
            radioButtons.forEach(function (radio) {
                radio.addEventListener('change', updateSemesterOptions);
            });
        });
    </script>
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
                                <a class="dropdown-item" href="index.php#vision-mission">Visi dan Misi</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php#alamat">Alamat dan Kontak</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Data Program Studi</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="data-users.php">Data Pengguna</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="tahun-akademik.php">Tahun Akademik</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="data-ruangan.php">Data Ruang Kelas</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="data-semester.php">Data Semester</a>
                            </li>
                            <li><a class="dropdown-item" href="data-kelas.php">Data Kelas</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#home" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Perkuliahan
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="jadwal-kuliah.php">Jadwal Kuliah</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="mata-kuliah.php">Mata Kuliah</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php"
                            onclick="confirm('Apakah anda yakin ingin keluar?')">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section>
        <div class="row text-center">
            <h1>Tambah Data Semester</h1>
        </div>
    </section>
</header>

<body>
    <div class="container form-semester">
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $alert_type; ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <div class="card p-3">
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="tahun_akademik" class="form-label">Tahun Akademik</label>
                        <select name="tahun_akademik" id="tahun_akademik" class="form-select" required>
                            <option value="">Silakan Pilih Tahun Akademik</option>
                            <?php foreach ($tahunakademik as $row): ?>
                                <option value="<?= htmlspecialchars($row["id"]) ?>"><?= htmlspecialchars($row["kode"]) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Semester:</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_semester" id="ganjil"
                                value="ganjil" required>
                            <label class="form-check-label" for="ganjil">Ganjil</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_semester" id="genap" value="genap"
                                required>
                            <label class="form-check-label" for="genap">Genap</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_semester" class="form-label">Nomor Semester:</label>
                        <select id="nomor_semester" class="form-select" name="nomor_semester" required>
                            <option value="">Pilih Nomor Semester</option>
                        </select>
                    </div>
                    <div class="row text-center mb-2">
                        <div class="col submit-button">
                            <button type="submit" class="btn btn-light">Simpan Data</button>
                        </div>
                    </div>
                </form>
                <div class="row text-center mb-1">
                    <div class="col submit-button">
                        <a href="index.php" class="btn btn-light">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="card p-3">
            <div class="card-body">
                <h2 class="mb-4">Data Semester</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tahun Akademik</th>
                                <th>Jenis Semester</th>
                                <th>Nomor Semester</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($semesterData as $index => $row): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($row['tahun_akademik']) ?></td>
                                    <td><?= ucfirst(htmlspecialchars($row['jenis_semester'])) ?></td>
                                    <td><?= htmlspecialchars($row['nomor_semester']) ?></td>
                                    <td>
                                        <a href="delete-semester.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this semester?')">Delete</a>
                                    </td>
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