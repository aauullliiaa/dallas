<?php
require '../src/db/functions.php';
$semesters = retrieve("SELECT * FROM semester");

$message = "";
$alert_type = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $semester_id = $_POST['semester_id'];
    $nomor_kelas = $_POST['nomor_kelas'];
    $huruf_kelas = $_POST['huruf_kelas'];

    // Validate inputs
    if (empty($semester_id) || empty($nomor_kelas) || empty($huruf_kelas)) {
        $message = "Semua field harus diisi.";
        $alert_type = "danger";
    } else {
        $sql = "INSERT INTO kelas (semester_id, nomor_kelas, huruf_kelas) VALUES (?, ?, ?)";

        $stmt = $db->prepare($sql);
        $stmt->bind_param("iss", $semester_id, $nomor_kelas, $huruf_kelas);

        if ($stmt->execute()) {
            $message = "Data kelas berhasil disimpan.";
            $alert_type = "success";
        } else {
            $message = "Error: " . $stmt->error;
            $alert_type = "danger";
        }
    }
}

// Retrieve existing classes
$existing_classes = retrieve("SELECT k.*, s.jenis_semester, s.nomor_semester, ta.kode as tahun_akademik 
                             FROM kelas k 
                             JOIN semester s ON k.semester_id = s.id
                             JOIN tahun_akademik ta ON s.tahun_akademik_id = ta.id
                             ORDER BY ta.kode, s.jenis_semester, s.nomor_semester, k.nomor_kelas, k.huruf_kelas");
?>
<!DOCTYPE html>
<html lang="en">

<head>
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
    <title>APD Learning Space - Manajemen Data Kelas</title>
</head>
<header>
    <?php include 'navbar.php'; ?>
    <section>
        <div class="row text-center">
            <h1>Data Kelas</h1>
        </div>
    </section>
</header>

<body>
    <div class="container form-kelas mb-3">
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?= $alert_type; ?>" role="alert">
                <?= $message; ?>
            </div>
        <?php endif; ?>
        <div class="card p-3">
            <div class="card-body">
                <h2 class="card-title mb-2">Tambah Data Kelas</h2>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="semester_id" class="form-label">Semester</label>
                        <select name="semester_id" id="semester_id" class="form-select" required>
                            <option value="">Pilih Semester</option>
                            <?php foreach ($semesters as $semester): ?>
                                <option value="<?= htmlspecialchars($semester["id"]) ?>">
                                    <?= htmlspecialchars($semester["jenis_semester"] . " - Semester " . $semester["nomor_semester"]) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_kelas" class="form-label">Nomor Kelas:</label>
                        <select id="nomor_kelas" class="form-select" name="nomor_kelas" required>
                            <option value="">Pilih Nomor Kelas</option>
                            <option value="1">Kelas 1</option>
                            <option value="2">Kelas 2</option>
                            <option value="3">Kelas 3</option>
                            <option value="4">Kelas 4</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="huruf_kelas" class="form-label">Huruf Kelas:</label>
                        <select id="huruf_kelas" class="form-select" name="huruf_kelas" required>
                            <option value="">Pilih Huruf Kelas</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </div>
                    <div class="row text-center mb-2">
                        <div class="col submit-button">
                            <button type="submit" class="btn btn-primary">Simpan Data Kelas</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4 p-3">
            <div class="card-body">
                <h2 class="card-title mb-2">Daftar Kelas</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tahun Akademik</th>
                            <th>Semester</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($existing_classes as $class): ?>
                            <tr>
                                <td><?= htmlspecialchars($class['tahun_akademik']) ?></td>
                                <td><?= htmlspecialchars($class['jenis_semester'] . ' - Semester ' . $class['nomor_semester']) ?>
                                </td>
                                <td><?= htmlspecialchars($class['nomor_kelas'] . $class['huruf_kelas']) ?></td>
                                <td>
                                    <a href="hapus-kelas.php?id=<?= $class['id'] ?>" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row text-center mt-3 mb-3">
            <div class="col">
                <a href="index.php" class="btn btn-secondary">Kembali ke Beranda</a>
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