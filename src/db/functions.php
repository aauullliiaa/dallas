<?php
session_start();
// koneksi ke database
$db = mysqli_connect("localhost", "root", "", "db_learning_space");

// query fetch data
function retrieve($query, $params = [])
{
    global $db;

    $stmt = $db->prepare($query);
    if ($params) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $stmt->close();
    return $rows;
}

function checkRole($role)
{
    if (!isset($_SESSION["role"])) {
        header("Location: ../index.php");
        exit;
    }
    $currentRole = $_SESSION["role"];
    if ($currentRole != $role) {
        // Set error message in session
        $_SESSION['error_message'] = 'Mohon maaf, Anda tidak memiliki akses ke halaman ini.';
        // Redirect back to the previous page
        echo '<script type="text/javascript">
            alert("Mohon maaf, Anda tidak memiliki akses ke halaman ini.");
            window.history.back();
        </script>';
        exit;
    }
}

// fungsi halaman register
function registerUser($email, $password, $role, $nama)
{
    global $db;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO users (email, password, role, nama) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $email, $hashed_password, $role, $nama);
    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;  // Get the ID of the newly inserted user
        $stmt->close();
        return $user_id;
    } else {
        $stmt->close();
        return false;
    }
}

function registerMahasiswaProfile($user_id, $email, $nama, $nim)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO mahasiswa_profiles (user_id, email, nama, nim) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $email, $nama, $nim);
    $stmt->execute();
    $stmt->close();
}

function registerDosenProfile($user_id, $email, $nama, $nip)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO dosen_profiles (user_id, email, nama, nip) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $email, $nama, $nip);
    $stmt->execute();
    $stmt->close();
}
function isNIP($id)
{
    // Periksa apakah ID adalah NIP (Anda dapat menyesuaikan logika ini berdasarkan format NIP Anda)
    return preg_match('/^[0-9]{18}$/', $id); // Contoh: NIP memiliki 8 hingga 10 digit
}

function isNIM($id)
{
    // Periksa apakah ID adalah NIM (Anda dapat menyesuaikan logika ini berdasarkan format NIM Anda)
    return preg_match('/^[0-9]{5,12}$/', $id); // Contoh: NIM memiliki 5 hingga 12 digit
}
function loginUser($emailOrId, $password)
{
    global $db;

    // Identifikasi apakah input adalah email, NIP, atau NIM
    if (filter_var($emailOrId, FILTER_VALIDATE_EMAIL)) {
        $query = "SELECT id, password, role, nama FROM users WHERE email = ?";
        $role = 'admin'; // default role if checking by email
    } elseif (isNIP($emailOrId)) {
        $query = "SELECT u.id, u.password, 'dosen' as role, dp.nama FROM users u JOIN dosen_profiles dp ON u.id = dp.user_id WHERE dp.nip = ?";
        $role = 'dosen';
    } elseif (isNIM($emailOrId)) {
        $query = "SELECT u.id, u.password, 'mahasiswa' as role, mp.nama FROM users u JOIN mahasiswa_profiles mp ON u.id = mp.user_id WHERE mp.nim = ?";
        $role = 'mahasiswa';
    } else {
        return false;
    }

    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $emailOrId);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password, $role, $nama);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $hashed_password)) {
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['emailOrId'] = $emailOrId;
        $_SESSION['role'] = $role;
        $_SESSION['nama'] = $nama;

        return true;
    } else {
        return false;
    }
}

// end of halaman login functions

// halaman edit profil mahasiswa functions
function updateProfile($user_id, $role, $data)
{
    $message = "";
    $alert_type = "";

    // Fetch user profile to use existing photo if no new photo is uploaded
    $profile = getUserProfile($user_id, $role);

    // Handle file upload
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "../src/images/";
        $imageFileType = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $newFileName = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $newFileName;
        $uploadOk = 1;

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $message = "File yang diunggah bukan gambar.";
            $alert_type = "danger";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["foto"]["size"] > 500000) {
            $message = "Maaf, ukuran file terlalu besar.";
            $alert_type = "danger";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $message = "Maaf, hanya file JPG, JPEG, & PNG yang diizinkan.";
            $alert_type = "danger";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $message = "Maaf, foto Anda tidak diunggah.";
            $alert_type = "danger";
        } else {
            // Remove old photo if it exists
            if (!empty($profile['foto']) && file_exists($target_dir . $profile['foto'])) {
                unlink($target_dir . $profile['foto']);
            }

            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                $message = "Foto berhasil diunggah.";
                $alert_type = "success";
                $data['foto'] = $newFileName;
                error_log("New file name set: " . $newFileName); // Logging the new file name
            } else {
                $message = "Maaf, terjadi kesalahan saat mengunggah foto Anda.";
                $alert_type = "danger";
            }
        }
    }

    if (updateUserProfile($user_id, $role, $data)) {
        $message = "Profil berhasil diperbarui.";
        $alert_type = "success";
        // Fetch updated profile
        $profile = getUserProfile($user_id, $role);
    } else {
        $message = "Terjadi kesalahan saat memperbarui profil.";
        $alert_type = "danger";
    }

    return [
        'profile' => $profile,
        'message' => $message,
        'alert_type' => $alert_type
    ];
}
// fungsi untuk mendapatkan data user untuk di halaman profil masing-masing profil
function getUserProfile($user_id, $role)
{
    global $db;

    switch ($role) {
        case 'admin':
            $stmt = $db->prepare("SELECT nama, foto FROM admin_profiles WHERE user_id = ?");
            break;
        case 'mahasiswa':
            $stmt = $db->prepare("SELECT nama, nim, telepon, tempatlahir, tanggallahir, foto, kelas, alamat FROM mahasiswa_profiles WHERE user_id = ?");
            break;
        case 'dosen':
            $stmt = $db->prepare("SELECT nama, nip, telepon, tempatlahir, tanggallahir, foto, penghargaan, pengabdian, alamat FROM dosen_profiles WHERE user_id = ?");
            break;
        default:
            return null;
    }

    if (!$stmt) {
        echo "Error: " . $db->error;
        return null;
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $result;
}

// fungsi untuk mengupdate data user di database
function updateUserProfile($user_id, $role, $data)
{
    global $db;

    switch ($role) {
        case 'admin':
            $stmt = $db->prepare("UPDATE admin_profiles SET nama = ?, foto = ? WHERE user_id = ?");
            $stmt->bind_param("ssi", $data['nama'], $data['foto'], $user_id);
            break;
        case 'mahasiswa':
            $stmt = $db->prepare("UPDATE mahasiswa_profiles SET nama = ?, nim = ?, telepon = ?, tempatlahir = ?, tanggallahir = ?, foto = ?, kelas = ?, alamat = ? WHERE user_id = ?");
            $stmt->bind_param("ssssssssi", $data['nama'], $data['nim'], $data['telepon'], $data['tempatlahir'], $data['tanggallahir'], $data['foto'], $data['kelas'], $data['alamat'], $user_id);
            break;
        case 'dosen':
            $stmt = $db->prepare("UPDATE dosen_profiles SET nama = ?, nip = ?, telepon = ?, tempatlahir = ?, tanggallahir = ?, foto = ?, penghargaan = ?, pengabdian = ?, alamat = ? WHERE user_id = ?");
            $stmt->bind_param("sssssssssi", $data['nama'], $data['nip'], $data['telepon'], $data['tempatlahir'], $data['tanggallahir'], $data['foto'], $data['penghargaan'], $data['pengabdian'], $data['alamat'], $user_id);
            break;
        default:
            return false;
    }

    if (!$stmt) {
        echo "Error: " . $db->error;
        return false;
    }

    $stmt->execute();
    $result = $stmt->affected_rows > 0;
    $stmt->close();

    return $result;
}


// function edit data dosen (admin)
function ubah($data)
{
    global $db;

    $id = $data["id"];
    $nama = $data["nama"];
    $nip = $data["nip"];
    $email = $data["email"];
    $alamat = $data["alamat"];
    $telepon = $data["telepon"];

    // Prepare statement to prevent SQL Injection
    $stmt = $db->prepare("UPDATE dosen_profiles SET nama = ?, nip = ?, email = ?, alamat = ?, telepon = ? WHERE user_id = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($db->error));
    }

    // Bind parameters
    $bind = $stmt->bind_param('sssssi', $nama, $nip, $email, $alamat, $telepon, $id);
    if ($bind === false) {
        die('Bind param failed: ' . htmlspecialchars($stmt->error));
    }

    // Execute the statement
    $exec = $stmt->execute();
    if ($exec === false) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    // Return the number of affected rows
    $affected_rows = $stmt->affected_rows;

    // Close the statement
    $stmt->close();

    return $affected_rows;
}
// function edit data mahasiswa (admin)
function edit($data)
{
    global $db;

    $id = $data["id"];
    $nama = $data["nama"];
    $nim = $data["nim"];
    $telepon = $data["telepon"];
    $kelas = $data["kelas"];
    $alamat = $data["alamat"];

    // Prepare statement to prevent SQL Injection
    $stmt = $db->prepare("UPDATE mahasiswa_profiles SET nama = ?, nim = ?, telepon = ?, kelas = ?, alamat = ? WHERE user_id = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($db->error));
    }

    // Bind parameters
    $bind = $stmt->bind_param('sssssi', $nama, $nim, $telepon, $kelas, $alamat, $id);
    if ($bind === false) {
        die('Bind param failed: ' . htmlspecialchars($stmt->error));
    }

    // Execute the statement
    $exec = $stmt->execute();
    if ($exec === false) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    // Return the number of affected rows
    $affected_rows = $stmt->affected_rows;

    // Close the statement
    $stmt->close();

    return $affected_rows;
}
// end of function edit data (admin)

// fungsi untuk menyimpan data mata kuliah saat pertama kali ditambahkan
function processCourseFormByDosen($db)
{
    $message = '';
    $alert_type = '';

    if (isset($_POST['kode'], $_POST['nama'], $_POST['deskripsi'], $_POST['dosen_id'])) {
        // Escape special characters to prevent XSS
        $kode = htmlspecialchars($_POST['kode']);
        $nama = htmlspecialchars($_POST['nama']);
        $deskripsi = htmlspecialchars($_POST['deskripsi']);
        $dosen_id = intval($_POST['dosen_id']); // Convert to integer for safety

        // Prepare SQL statement with email_dosen field
        $sql = "INSERT INTO mata_kuliah (kode, nama, deskripsi, status, dosen_id) VALUES (?, ?, ?, 'Pending', ?)";
        $stmt = $db->prepare($sql);

        if ($stmt === false) {
            $message = "Terjadi kesalahan dalam persiapan statement SQL.";
            $alert_type = "danger";
            return [$message, $alert_type];
        }

        $stmt->bind_param("sssi", $kode, $nama, $deskripsi, $dosen_id);

        if ($stmt->execute()) {
            $message = "Mata Kuliah berhasil ditambahkan. Mohon hubungi administrator untuk proses persetujuan lebih lanjut.";
            $alert_type = "success";
        } else {
            $message = "Mata kuliah gagal ditambahkan, silakan coba lagi.";
            $alert_type = "danger";
        }
        $stmt->close();
    }
    return [$message, $alert_type];
}
// Akhir kode untuk menyimpan data detail mata kuliah

// fungsi untuk mengupload data berupa materi pembelajaran
function processMaterialUpload($db)
{
    $message = '';
    $alert_type = '';

    if (isset($_POST['mata_kuliah_id'], $_POST['pertemuan'], $_POST['deskripsi'], $_FILES['materi_file'])) {
        $mata_kuliah_id = $_POST['mata_kuliah_id'];
        $pertemuan = $_POST['pertemuan'];
        $deskripsi = htmlspecialchars($_POST['deskripsi']);

        // Check if the meeting number is valid
        if (!is_numeric($pertemuan) || $pertemuan < 1 || $pertemuan > 16) {
            $message = "Nomor pertemuan tidak valid.";
            $alert_type = "danger";
            return [$message, $alert_type];
        }

        if ($_FILES['materi_file']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../src/files/materi/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $materi_file_path = $upload_dir . basename($_FILES['materi_file']['name']);
            $file_extension = strtolower(pathinfo($materi_file_path, PATHINFO_EXTENSION));

            if (in_array($file_extension, ['pdf', 'doc', 'docx', 'ppt', 'pptx'])) {
                if (move_uploaded_file($_FILES['materi_file']['tmp_name'], $materi_file_path)) {
                    $sql = "INSERT INTO materi (mata_kuliah_id, pertemuan, deskripsi, file_path) VALUES (?, ?, ?, ?)";
                    $stmt = $db->prepare($sql);
                    if ($stmt === false) {
                        $message = "Gagal mempersiapkan query: " . $db->error;
                        $alert_type = "danger";
                        return [$message, $alert_type];
                    }
                    $stmt->bind_param("iiss", $mata_kuliah_id, $pertemuan, $deskripsi, $materi_file_path);

                    if ($stmt->execute()) {
                        $message = "Materi berhasil diunggah.";
                        $alert_type = "success";
                    } else {
                        $message = "Materi gagal diunggah, silakan coba lagi. Error: " . $stmt->error;
                        $alert_type = "danger";
                    }
                    $stmt->close();
                } else {
                    $message = "Gagal mengunggah file materi, silakan coba lagi.";
                    $alert_type = "danger";
                }
            } else {
                $message = "File materi tidak valid, silakan unggah file dengan ekstensi PDF, DOC, DOCX, PPT, atau PPTX.";
                $alert_type = "danger";
            }
        } else {
            $message = "Gagal mengunggah file materi, silakan coba lagi.";
            $alert_type = "danger";
        }
    }

    return [$message, $alert_type];
}
// Akhir kode untuk fungsi pada halaman upload materi

// Mengambil semua data materi perkuliahan untuk di halaman detail mata kuliah
function getAllMaterialsByMataKuliah($db, $mata_kuliah_id)
{
    $sql = "SELECT * FROM materi WHERE mata_kuliah_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $mata_kuliah_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $materials = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $materials;
}
// Akhir kode untuk mengambil semua data materi perkuliahan

// Mengedit data mata kuliah (dosen)
function editmk($matkul)
{
    global $db;

    $query = "UPDATE mata_kuliah SET nama =?, kode =?, dosen_id =?, deskripsi =? WHERE id =?";

    $stmt = $db->prepare($query);
    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("ssisi", $matkul["nama"], $matkul["kode"], $matkul["dosen_id"], $matkul["deskripsi"], $matkul["id"]);
    $stmt->execute();

    $affected_rows = $stmt->affected_rows;
    $stmt->close();

    return $affected_rows;
}
// Akhir kode untuk fungsi edit data MK

// Fungsi untuk menambah jadwal kuliah pada halaman tambah jadwal dan menampilkan jadwal sesuai dengan kelas yang ada pada dropdown
function get_time_slots_for_adding()
{
    return [
        "07.30 - 08.20",
        "08.20 - 09.10",
        "09.10 - 10.00",
        "10.20 - 11.10",
        "11.10 - 12.00",
        "13.00 - 13.50",
        "13.50 - 14.40",
        "14.40 - 15.30",
        "16.00 - 16.50",
        "16.50 - 17.40",
        "18.40 - 19.30"
    ];
}
// Mengambil data untuk jam yang sudah terisi maka tidak akan ditampilkan di halaman tambah jadwal
function get_occupied_slots($db, $hari, $kelas)
{
    $occupied_slots = [];
    $sql = "SELECT jam FROM jadwal_kuliah WHERE hari = ? AND kelas = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ss", $hari, $kelas);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $occupied_slots[] = $row['jam'];
    }

    $stmt->close();
    return $occupied_slots;
}


// Mengambil data nama mata kuliah untuk ditampilkan dalam halaman tambah jadwal dan lihat jadwal
function get_course_name($db, $matkul_id)
{
    $sql = "SELECT nama FROM mata_kuliah WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $matkul_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc()['nama'];
    $stmt->close();
    return $course;
}

// Menyimpan data yang disubmit dari halaman tambah jadwal
function insert_schedule($db, $hari, $matkul, $dosen_id, $classroom, $kelas, $time_slots, $start_index, $end_index, $is_temporary = 0, $end_date = NULL)
{
    $message = "";
    $alert_class = "";

    // Validate required parameters
    if (empty($hari) || empty($matkul) || empty($dosen_id) || empty($classroom) || empty($kelas) || $start_index === false || $end_index === false || $start_index > $end_index) {
        return ["Error: Invalid input data", "alert-danger"];
    }

    // Validate dosen_id exists in dosen_profiles
    $stmt = $db->prepare("SELECT 1 FROM dosen_profiles WHERE user_id = ?");
    $stmt->bind_param("i", $dosen_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $stmt->close();
        return ["Error: Invalid dosen_id", "alert-danger"];
    }
    $stmt->close();

    // Validate matkul exists in mata_kuliah and is assigned to dosen_id
    $stmt = $db->prepare("SELECT 1 FROM mata_kuliah WHERE nama = ? AND dosen_id = ?");
    $stmt->bind_param("si", $matkul, $dosen_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $stmt->close();
        return ["Error: Invalid matkul or matkul not assigned to dosen_id", "alert-danger"];
    }
    $stmt->close();

    // Prepare the SQL statement
    $stmt = $db->prepare("INSERT INTO jadwal_kuliah (hari, matkul, dosen_id, classroom, kelas, jam, is_temporary, end_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        return ["Error: " . $db->error, "alert-danger"];
    }

    // Start a transaction
    $db->begin_transaction();

    try {
        for ($i = $start_index; $i <= $end_index; $i++) {
            $current_time = $time_slots[$i];
            $stmt->bind_param("ssisssis", $hari, $matkul, $dosen_id, $classroom, $kelas, $current_time, $is_temporary, $end_date);

            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
        }

        // Commit the transaction if all inserts were successful
        $db->commit();
        $message = "Jadwal berhasil ditambahkan";
        $alert_class = "alert-success";
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $db->rollback();
        $message = "Error: " . $e->getMessage();
        $alert_class = "alert-danger";
    }

    // Close the statement
    $stmt->close();

    // Return the result message and alert class
    return [$message, $alert_class];
}

// Akhir kode untuk fungsi tambah jadwal

// Fungsi untuk menampilkan keseluruhan jadwal
function get_time_slots_for_viewing()
{
    return [
        "07.30 - 08.20",
        "08.20 - 09.10",
        "09.10 - 10.00",
        "10.00 - 10.20", // Break
        "10.20 - 11.10",
        "11.10 - 12.00",
        "12.00 - 13.00", // Break
        "13.00 - 13.50",
        "13.50 - 14.40",
        "14.40 - 15.30",
        "15.30 - 16.00", // Break
        "16.00 - 16.50",
        "16.50 - 17.40",
        "17.40 - 18.40", // Break
        "18.40 - 19.30"
    ];
}
// Akhir kode untuk fungsi menampilkan keseluruhan jadwal

// Fungsi untuk menghapus jadwal
function delete_schedule($db, $schedule_id)
{
    $sql = "DELETE FROM jadwal_kuliah WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $schedule_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}
// Akhir kode untuk menghapus jadwal

// Fungsi untuk menampilkan jadwal sesuai dengan kelas
function fetch_schedules($db, $kelas)
{
    $sql = "SELECT jk.*, dp.nama as dosen FROM jadwal_kuliah jk 
            JOIN dosen_profiles dp ON jk.dosen_id = dp.user_id
            WHERE jk.kelas = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $kelas);
    $stmt->execute();
    $result = $stmt->get_result();
    $schedules = [];
    while ($row = $result->fetch_assoc()) {
        $schedules[$row['hari']][$row['jam']][] = $row;
    }
    $stmt->close();
    return $schedules;
}

// Akhir kode untuk fungsi halaman jadwal perkuliahan

// Fungsi untuk halaman edit jadwal
// Mengambil data jadwal sesuai dengan id
function fetch_schedule_by_id($db, $schedule_id)
{
    $sql = "SELECT * FROM jadwal_kuliah WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $schedule_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $schedule = $result->fetch_assoc();
    $stmt->close();
    return $schedule;
}
// Mengambil data jadwal berdasarkan dengan detail (Hari)
function fetch_schedules_by_details($db, $hari, $matkul, $kelas)
{
    $sql = "SELECT * FROM jadwal_kuliah WHERE hari = ? AND matkul = ? AND kelas = ?";
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $db->error);
    }
    $stmt->bind_param("sss", $hari, $matkul, $kelas);
    $stmt->execute();
    $result = $stmt->get_result();
    $schedules = [];
    while ($row = $result->fetch_assoc()) {
        $schedules[] = $row;
    }
    $stmt->close();
    return $schedules;
}

// Fungsi untuk mengupdate atau memasukkan jadwal apabila belum ditambahkan
function update_or_insert_schedule($db, $hari, $matkul, $dosen_id, $classroom, $kelas, $jam_mulai, $jam_selesai, $time_slots, $is_temporary = 0, $end_date = NULL, $old_hari = NULL, $old_jam_mulai = NULL, $old_jam_selesai = NULL)
{
    $message = "";
    $alert_class = "";

    $start_index = array_search($jam_mulai, $time_slots);
    $end_index = array_search($jam_selesai, $time_slots);

    if ($start_index === false || $end_index === false || $start_index > $end_index) {
        return ["Error: Invalid input data", "alert-danger"];
    }

    // Handle old schedules if moving to a different day or time
    if (!is_null($old_hari) && (!is_null($old_jam_mulai) && !is_null($old_jam_selesai))) {
        if ($old_hari !== $hari || $old_jam_mulai !== $jam_mulai || $old_jam_selesai !== $jam_selesai) {
            $sql = "DELETE FROM jadwal_kuliah WHERE hari = ? AND kelas = ? AND jam BETWEEN ? AND ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ssss", $old_hari, $kelas, $old_jam_mulai, $old_jam_selesai);
            if (!$stmt->execute()) {
                $message = "Error: Failed to delete old schedule for " . $old_hari . "<br>" . $stmt->error;
                $alert_class = "alert-danger";
            }
            $stmt->close();
        }
    }

    $sql = "SELECT id, jam FROM jadwal_kuliah WHERE hari = ? AND kelas = ? AND jam BETWEEN ? AND ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ssss", $hari, $kelas, $jam_mulai, $jam_selesai);
    $stmt->execute();
    $result = $stmt->get_result();
    $existing_schedules = [];
    while ($row = $result->fetch_assoc()) {
        $existing_schedules[$row['jam']] = $row['id'];
    }
    $stmt->close();

    for ($i = $start_index; $i <= $end_index; $i++) {
        $current_time = $time_slots[$i];
        if (isset($existing_schedules[$current_time])) {
            $sql = "UPDATE jadwal_kuliah SET matkul = ?, dosen_id = ?, classroom = ?, is_temporary = ?, end_date = ? WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("sisssi", $matkul, $dosen_id, $classroom, $is_temporary, $end_date, $existing_schedules[$current_time]);
            unset($existing_schedules[$current_time]);
        } else {
            $sql = "INSERT INTO jadwal_kuliah (hari, matkul, dosen_id, classroom, kelas, jam, is_temporary, end_date)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ssisssis", $hari, $matkul, $dosen_id, $classroom, $kelas, $current_time, $is_temporary, $end_date);
        }

        if (!$stmt->execute()) {
            $message = "Error: " . $stmt->error;
            $alert_class = "alert-danger";
            break;
        } else {
            $message = "Jadwal berhasil diperbarui";
            $alert_class = "alert-success";
        }
    }

    if (!empty($existing_schedules)) {
        $ids_to_delete = implode(",", array_values($existing_schedules));
        $sql = "DELETE FROM jadwal_kuliah WHERE id IN ($ids_to_delete)";
        if ($db->query($sql) === TRUE) {
            $message .= ", jadwal yang tidak diperlukan sukses dihapus.";
        } else {
            $message .= " Error menghapus jadwal yang tidak diperlukan.";
        }
    }

    return [$message, $alert_class];
}

function fetch_schedule_by_dosen_id($db, $dosen_id)
{
    $time_slots = get_time_slots_for_viewing();
    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

    // Prepare the statement to fetch the schedule based on dosen ID
    $stmt = $db->prepare('SELECT jk.* FROM jadwal_kuliah jk WHERE jk.dosen_id = ?');
    $stmt->bind_param('i', $dosen_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $jadwal = $result->fetch_all(MYSQLI_ASSOC);

    $schedule = [];
    foreach ($jadwal as $item) {
        if (!isset($schedule[$item['hari']])) {
            $schedule[$item['hari']] = [];
        }
        $schedule[$item['hari']][$item['jam']] = $item;
    }

    return [$time_slots, $days, $schedule];
}

// Fetch all slots (both empty and filled)
function fetch_all_slots($db)
{
    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
    $time_slots = get_time_slots_for_viewing();
    $all_slots = [];

    foreach ($days as $day) {
        foreach ($time_slots as $slot) {
            $sql = "SELECT jk.*, dp.nama AS dosen FROM jadwal_kuliah jk 
                    JOIN dosen_profiles dp ON jk.dosen_id = dp.user_id 
                    WHERE jk.hari = ? AND jk.jam = ? AND (jk.is_temporary = 0 OR (jk.is_temporary = 1 AND jk.end_date >= CURDATE()))";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ss", $day, $slot);
            $stmt->execute();
            $result = $stmt->get_result();

            $all_slots[$day][$slot] = [];
            while ($row = $result->fetch_assoc()) {
                $all_slots[$day][$slot][] = [
                    'id' => $row['id'],
                    'matkul' => $row['matkul'],
                    'dosen' => $row['dosen'],
                    'kelas' => $row['kelas'],
                    'classroom' => $row['classroom'],
                    'is_temporary' => $row['is_temporary'],
                ];
            }
            $stmt->close();
        }
    }
    return $all_slots;
}

// Menghapus jadwal pergantian mata kuliah secara otomatis jika sudah hari minggu pada minggu tersebut
function delete_expired_temporary_schedules($db)
{
    $today = date('Y-m-d');
    $sql = "DELETE FROM jadwal_kuliah WHERE is_temporary = 1 AND end_date < ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $today);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
    $stmt->close();
}
function insertPertemuan($data)
{
    global $db;
    $sql = "INSERT INTO pertemuan (mata_kuliah_id, pertemuan, deskripsi, tanggal) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("iiss", $data['mata_kuliah_id'], $data['pertemuan'], $data['deskripsi'], $data['tanggal']);
    if ($stmt->execute()) {
        $id = $stmt->insert_id;
        $stmt->close();
        return $id;
    } else {
        $stmt->close();
        return false;
    }
}

function insertTugasPertemuan($data)
{
    global $db;
    $sql = "INSERT INTO tugas_pertemuan (pertemuan_id, judul, deskripsi, tanggal_deadline, jam_deadline, file_tugas) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("isssss", $data['pertemuan_id'], $data['judul'], $data['deskripsi'], $data['tanggal_deadline'], $data['jam_deadline'], $data['file_tugas']);
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

function uploadFileTugas($file, $target_dir = "../src/files/assignment/", $allowed_types = ['doc', 'docx', 'pdf', 'xls', 'pptx'])
{
    if ($file['error'] == 0) {
        $file_extension = pathinfo($file["name"], PATHINFO_EXTENSION);
        if (in_array($file_extension, $allowed_types)) {
            $file_path = $target_dir . basename($file["name"]);
            if (move_uploaded_file($file["tmp_name"], $file_path)) {
                return basename($file["name"]); // only save the file name in the database
            } else {
                return ['error' => "Gagal mengupload file tugas."];
            }
        } else {
            return ['error' => "Format file tidak didukung. Hanya file dengan format doc, docx, pdf, xls, pptx yang diizinkan."];
        }
    }
    return '';
}


function insertTugasKumpul($data)
{
    global $db;
    $sql = "INSERT INTO tugas_kumpul (tugas_id, mahasiswa_id, file_path, tanggal_kumpul, jam_kumpul) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param(
        "iisss",
        $data['tugas_id'],
        $data['mahasiswa_id'],
        $data['file_path'],
        date('Y-m-d', strtotime($data['tanggal_kumpul'])),
        date('H:i', strtotime($data['jam_kumpul']))
    );
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

function deleteTugasKumpulByPertemuan($pertemuan_id)
{
    global $db;
    $sql = "DELETE FROM tugas_kumpul WHERE tugas_id IN (SELECT id FROM tugas_pertemuan WHERE pertemuan_id = ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $pertemuan_id);
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}
function deletePertemuan($pertemuan_id)
{
    global $db;
    if (deleteTugasKumpulByPertemuan($pertemuan_id)) {
        $sql = "DELETE FROM tugas_pertemuan WHERE pertemuan_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $pertemuan_id);
        if ($stmt->execute()) {
            $sql = "DELETE FROM pertemuan WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i", $pertemuan_id);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
            $stmt->close();
        }
    }
    return false;
}

function getDosenNameById($db, $dosen_id)
{
    $stmt = $db->prepare("SELECT nama FROM dosen_profiles WHERE user_id = ?");
    $stmt->bind_param("s", $dosen_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['nama'] ?? null;
}

function getAllMataKuliah($db)
{
    $sql = "SELECT mk.id, mk.kode, mk.nama, mk.deskripsi, mk.status, mk.reason, dp.nama as dosen 
            FROM mata_kuliah mk
            JOIN dosen_profiles dp ON mk.dosen_id = dp.user_id";
    $result = $db->query($sql);
    $mata_kuliah = [];
    while ($row = $result->fetch_assoc()) {
        $mata_kuliah[] = $row;
    }
    return $mata_kuliah;
}

function approveMataKuliah($db, $id)
{
    $query = "UPDATE mata_kuliah SET status = 'Approved' WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $id);
    return $stmt->execute();
}

function rejectMataKuliah($db, $id, $reason)
{
    $query = "UPDATE mata_kuliah SET status = 'Rejected', reason = ? WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('si', $reason, $id);
    return $stmt->execute();
}

function processCourseFormByAdmin($db)
{
    $message = '';
    $alert_type = '';

    if (isset($_POST['kode'], $_POST['nama'], $_POST['deskripsi'], $_POST['dosen_id'])) {
        // Escape special characters to prevent XSS
        $kode = htmlspecialchars($_POST['kode']);
        $nama = htmlspecialchars($_POST['nama']);
        $deskripsi = htmlspecialchars($_POST['deskripsi']);
        $dosen_id = (int) $_POST['dosen_id'];

        // Prepare SQL statement
        $sql = "INSERT INTO mata_kuliah (kode, nama, deskripsi, dosen_id, status) VALUES (?, ?, ?, ?, 'Pending')";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sssi", $kode, $nama, $deskripsi, $dosen_id);

        if ($stmt->execute()) {
            $message = "Mata Kuliah berhasil ditambahkan. Mohon hubungi administrator untuk proses persetujuan lebih lanjut.";
            $alert_type = "success";
        } else {
            $message = "Mata kuliah gagal ditambahkan, silakan coba lagi";
            $alert_type = "danger";
        }
        $stmt->close();
    }
    return [$message, $alert_type];
}

function deleteMataKuliah($db, $id)
{
    $query = "DELETE FROM mata_kuliah WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function getDosenName($dosen_id)
{
    global $db;
    $query = "SELECT nama FROM dosen_profiles WHERE user_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $dosen_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $dosen = $result->fetch_assoc();
    return $dosen['nama'] ?? 'Dosen Tidak Diketahui';
}

function deleteMateri($materi_id)
{
    global $db;
    $query = "DELETE FROM materi WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $materi_id);
    return $stmt->execute();
}

function get_all_courses($db)
{
    $sql = "SELECT id, nama, dosen_id FROM mata_kuliah WHERE status = 'Approved'";
    $result = $db->query($sql);
    $courses = [];
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
    return $courses;
}
?>