<?php
require 'config.php';
// koneksi ke database
date_default_timezone_set('Asia/Makassar');

// query fetch data
// src/db/functions.php
function retrieve($query, $params = [])
{
    global $db;
    $stmt = $db->prepare($query);
    if ($stmt === false) {
        die("Error preparing statement: " . $db->error);
    }
    if ($params) {
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    }
    if (!$stmt->execute()) {
        die("Error executing query: " . $stmt->error);
    }

    // Check the type of query and handle accordingly
    if (stripos($query, 'SELECT') === 0) {
        $result = $stmt->get_result();
        if ($result === false) {
            die("Error getting result: " . $stmt->error);
        }
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    } else {
        // For UPDATE, INSERT, DELETE
        $affectedRows = $stmt->affected_rows;
        $stmt->close();
        return $affectedRows;
    }
}
function checkRole($role)
{
    if (!isset($_SESSION["role"])) {
        header("Location: ../login.php");
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
function registerUser($email, $password, $role)
{
    global $db;
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $db->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $hashed_password, $role);
    if ($stmt->execute()) {
        return $stmt->insert_id; // Mengembalikan ID pengguna yang baru
    } else {
        error_log("Error in registerUser: " . $stmt->error);
        return false;
    }
}

function updateDosenProfile($user_id, $email, $password, $nip)
{
    global $db;
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $db->prepare("UPDATE daftar_dosen SET email = ?, password = ?, user_id = ? WHERE nip = ?");
    $stmt->bind_param("ssis", $email, $hashed_password, $user_id, $nip);
    if ($stmt->execute()) {
        return true;
    } else {
        error_log("Error in updateDosenProfile: " . $stmt->error);
        return false;
    }
}

function updateMahasiswaProfile($user_id, $email, $password, $nim)
{
    global $db;
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $db->prepare("UPDATE daftar_mahasiswa SET email = ?, password = ?, user_id = ? WHERE nim = ?");
    $stmt->bind_param("ssis", $email, $hashed_password, $user_id, $nim);
    if ($stmt->execute()) {
        return true;
    } else {
        error_log("Error in updateMahasiswaProfile: " . $stmt->error);
        return false;
    }
}

function updateAdminProfile($user_id, $email, $password, $nip)
{
    global $db;
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $db->prepare("UPDATE daftar_admin SET email = ?, password = ?, user_id = ? WHERE nip = ?");
    $stmt->bind_param("ssis", $email, $hashed_password, $user_id, $nip);
    if ($stmt->execute()) {
        return true;
    } else {
        error_log("Error in updateAdminProfile: " . $stmt->error);
        return false;
    }
}

function loginUser($emailOrId, $password)
{
    global $db;

    // Cek apakah input adalah NIP atau NIM
    if (isNIP($emailOrId)) {
        // Admin atau Dosen menggunakan NIP
        $query = "SELECT u.id, u.password, 
                  CASE 
                      WHEN EXISTS (SELECT 1 FROM daftar_admin da WHERE da.user_id = u.id AND da.nip = ?) THEN 'admin'
                      WHEN EXISTS (SELECT 1 FROM daftar_dosen dd WHERE dd.user_id = u.id AND dd.nip = ?) THEN 'dosen'
                      ELSE NULL 
                  END as role
                  FROM users u
                  WHERE u.id IN (SELECT user_id FROM daftar_admin WHERE nip = ? UNION SELECT user_id FROM daftar_dosen WHERE nip = ?)";
        $role = 'admin/dosen';
    } elseif (isNIM($emailOrId)) {
        // Mahasiswa menggunakan NIM
        $query = "SELECT u.id, u.password, 'mahasiswa' as role
                  FROM users u
                  JOIN daftar_mahasiswa dm ON u.id = dm.user_id
                  WHERE dm.nim = ?";
        $role = 'mahasiswa';
    } else {
        // Jika bukan NIP atau NIM, return false
        return false;
    }

    $stmt = $db->prepare($query);
    if (!$stmt) {
        error_log("Prepare failed: " . $db->error);
        return false;
    }

    if ($role === 'admin/dosen') {
        $stmt->bind_param("ssss", $emailOrId, $emailOrId, $emailOrId, $emailOrId);
    } else {
        $stmt->bind_param("s", $emailOrId);
    }

    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password, $role);
    $stmt->fetch();
    $stmt->close();

    if (isset($hashed_password) && password_verify($password, $hashed_password)) {
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['emailOrId'] = $emailOrId;
        $_SESSION['role'] = $role;

        return true;
    } else {
        return false;
    }
}

// Fungsi untuk mengecek apakah input adalah NIP
function isNIP($input)
{
    return preg_match('/^\d{18}$/', $input);
}

// Fungsi untuk mengecek apakah input adalah NIM
function isNIM($input)
{
    return preg_match('/^\d+$/', $input); // Sesuaikan dengan format NIM yang benar
}

// end of halaman login functions

// Reset Password
function resetPasswordStaff($db, $nip, $password1, $password2)
{
    if (empty($nip) || empty($password1) || empty($password2)) {
        return array("Semua field harus diisi.", "danger");
    } elseif ($password1 !== $password2) {
        return array("Password baru dan konfirmasi password tidak cocok.", "danger");
    }

    $stmt = $db->prepare("SELECT user_id, 'dosen' as role FROM daftar_dosen WHERE nip = ?
                          UNION
                          SELECT user_id, 'admin' as role FROM daftar_admin WHERE nip = ?");
    $stmt->bind_param("ss", $nip, $nip);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $user_id = $user['user_id'];
        $role = $user['role'];

        $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

        $update_stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update_stmt->bind_param("si", $hashed_password, $user_id);

        if ($update_stmt->execute()) {
            $table = ($role === 'dosen') ? 'daftar_dosen' : 'daftar_admin';
            $update_role_stmt = $db->prepare("UPDATE $table SET password = ? WHERE nip = ?");
            $update_role_stmt->bind_param("ss", $hashed_password, $nip);
            $update_role_stmt->execute();

            return array("Password berhasil direset. Silakan login dengan password baru Anda.", "success");
        } else {
            return array("Gagal mereset password. Silakan coba lagi.", "danger");
        }
    } else {
        return array("NIP tidak ditemukan atau bukan milik dosen atau admin prodi APD.", "danger");
    }
}

function resetPasswordMahasiswa($db, $nim, $password1, $password2)
{
    if (empty($nim) || empty($password1) || empty($password2)) {
        return array("Semua field harus diisi.", "danger");
    } elseif ($password1 !== $password2) {
        return array("Password baru dan konfirmasi password tidak cocok.", "danger");
    }

    $stmt = $db->prepare("SELECT user_id FROM daftar_mahasiswa WHERE nim = ?");
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $user_id = $user['user_id'];

        $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

        $update_stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update_stmt->bind_param("si", $hashed_password, $user_id);

        if ($update_stmt->execute()) {
            $update_mhs_stmt = $db->prepare("UPDATE daftar_mahasiswa SET password = ? WHERE nim = ?");
            $update_mhs_stmt->bind_param("ss", $hashed_password, $nim);
            $update_mhs_stmt->execute();

            return array("Password berhasil direset. Silakan login dengan password baru Anda.", "success");
        } else {
            return array("Gagal mereset password. Silakan coba lagi.", "danger");
        }
    } else {
        return array("NIM tidak ditemukan.", "danger");
    }
}
// End of Reset Password
// halaman edit profil mahasiswa functions
function updateProfile($user_id, $role, $data)
{
    global $db;
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
            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                $message = "Foto berhasil diunggah.";
                $alert_type = "success";
                $data['foto'] = $newFileName;

                // Remove old photo if it exists
                if (!empty($profile['foto']) && file_exists($target_dir . $profile['foto'])) {
                    unlink($target_dir . $profile['foto']);
                }
            } else {
                $message = "Maaf, terjadi kesalahan saat mengunggah foto Anda.";
                $alert_type = "danger";
            }
        }
    } else {
        // Use the existing photo if no new file is uploaded
        $data['foto'] = $profile['foto'];
    }

    if (updateUserProfile($user_id, $role, $data)) {
        $message .= " Profil berhasil diperbarui.";
        $alert_type = "success";
        // Fetch updated profile
        $profile = getUserProfile($user_id, $role);
    } else {
        $message .= " Terjadi kesalahan saat memperbarui profil.";
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
            // Sesuaikan query untuk admin jika ada tabel atau kolom yang relevan untuk admin
            $stmt = $db->prepare("SELECT email FROM users WHERE id = ?");
            break;
        case 'mahasiswa':
            $stmt = $db->prepare("SELECT * FROM daftar_mahasiswa WHERE user_id = ?");
            break;
        case 'dosen':
            $stmt = $db->prepare("SELECT * FROM daftar_dosen WHERE user_id = ?");
            break;
        default:
            return null;
    }

    if (!$stmt) {
        error_log("Prepare failed: " . $db->error);
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
        case 'mahasiswa':
            $stmt = $db->prepare("UPDATE daftar_mahasiswa SET foto = ? WHERE user_id = ?");
            $stmt->bind_param("si", $data['foto'], $user_id);
            break;
        case 'dosen':
            $stmt = $db->prepare("UPDATE daftar_dosen SET foto = ? WHERE user_id = ?");
            $stmt->bind_param("si", $data['foto'], $user_id);
            break;
        default:
            return false;
    }

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        error_log("Update failed: " . $stmt->error);
        $stmt->close();
        return false;
    }
}

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

            $file_extension = strtolower(pathinfo($_FILES['materi_file']['name'], PATHINFO_EXTENSION));
            $unique_file_name = uniqid('materi_', true) . '.' . $file_extension;
            $materi_file_path = $upload_dir . $unique_file_name;

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
function insert_schedule(
    $db,
    $hari,
    $matkul,
    $dosen_id_1,
    $dosen_id_2,
    $classroom,
    $kelas,
    $time_slots,
    $start_index,
    $end_index,
    $is_temporary = 0,
    $end_date = NULL
) {
    $message = "";
    $alert_class = "";

    if (empty($hari) || empty($matkul) || empty($dosen_id_1) || empty($classroom) || empty($kelas) || $start_index === false || $end_index === false || $start_index > $end_index) {
        return ["Error: Invalid input data", "alert-danger"];
    }

    // Validate presence of dosen_id_1 in daftar_dosen
    $stmt = $db->prepare("SELECT 1 FROM daftar_dosen WHERE id = ?");
    $stmt->bind_param("i", $dosen_id_1);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 0) {
        $stmt->close();
        return ["Error: Invalid dosen_id_1", "alert-danger"];
    }
    $stmt->close();

    // If dosen_id_2 is empty, set it to NULL
    $dosen_id_2 = !empty($dosen_id_2) ? $dosen_id_2 : NULL;

    // Validate dosen_id_2 only if it is not NULL
    if ($dosen_id_2 !== NULL) {
        $stmt = $db->prepare("SELECT 1 FROM daftar_dosen WHERE id = ?");
        $stmt->bind_param("i", $dosen_id_2);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 0) {
            $stmt->close();
            return ["Error: Invalid dosen_id_2", "alert-danger"];
        }
        $stmt->close();
    }

    // Insert into jadwal_kuliah
    $stmt = $db->prepare("INSERT INTO jadwal_kuliah (hari, matkul, dosen_id_1, dosen_id_2, classroom, kelas, jam, is_temporary, end_date, is_deleted_temporarily) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
    if (!$stmt) {
        return ["Error: " . $db->error, "alert-danger"];
    }

    $db->begin_transaction();
    try {
        for ($i = $start_index; $i <= $end_index; $i++) {
            $current_time = $time_slots[$i];
            $stmt->bind_param("ssiisssis", $hari, $matkul, $dosen_id_1, $dosen_id_2, $classroom, $kelas, $current_time, $is_temporary, $end_date);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
        }
        $db->commit();
        $message = "Jadwal berhasil ditambahkan";
        $alert_class = "alert-success";
    } catch (Exception $e) {
        $db->rollback();
        $message = "Error: " . $e->getMessage();
        $alert_class = "alert-danger";
    }
    $stmt->close();
    return [$message, $alert_class];
}

// Akhir kode untuk fungsi tambah jadwal

function get_dosen_id_by_user_id($db, $user_id)
{
    $sql = "SELECT id FROM daftar_dosen WHERE user_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['id'];
    } else {
        return null;
    }
}

function get_jadwal_kuliah_for_dosen($db, $dosen_id)
{
    $sql = "SELECT 
        jk.hari,
        jk.matkul,
        dd1.nama AS dosen1,
        dd2.nama AS dosen2,
        MIN(jk.jam) AS jam_awal,
        MAX(jk.jam) AS jam_akhir,
        jk.kelas,
        jk.classroom,
        GROUP_CONCAT(jk.id ORDER BY jk.jam) AS id_list
    FROM jadwal_kuliah jk
    LEFT JOIN daftar_dosen dd1 ON jk.dosen_id_1 = dd1.id
    LEFT JOIN daftar_dosen dd2 ON jk.dosen_id_2 = dd2.id
    WHERE jk.is_deleted_temporarily = 0 AND (jk.dosen_id_1 = ? OR jk.dosen_id_2 = ?)
    GROUP BY jk.hari, jk.matkul, dd1.nama, dd2.nama, jk.kelas, jk.classroom
    ORDER BY jk.hari, MIN(jk.jam), jk.matkul";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ii", $dosen_id, $dosen_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function process_request($db, $jadwal_ids, $tanggal_awal, $tanggal_baru, $jadwal_baru_mulai, $jadwal_baru_selesai, $alasan)
{
    $jadwal_ids_array = explode(',', $jadwal_ids);
    $first_jadwal_id = $jadwal_ids_array[0];
    $last_jadwal_id = end($jadwal_ids_array);

    // Get logged-in user ID (assuming a function exists)
    $user_id = get_current_user_id();

    // Find dosen data based on user ID (assuming 'daftar_dosen' table has 'user_id')
    $stmt = $db->prepare('SELECT id FROM daftar_dosen WHERE user_id = ?');
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $dosen = $result->fetch_assoc();

    if (!$dosen) {
        return ["danger", "Dosen tidak ditemukan untuk ID pengguna ini."];
    }

    $dosen_id = $dosen['id'];

    // Fetch original schedule details for the first entry
    $stmt = $db->prepare("SELECT matkul, jam FROM jadwal_kuliah WHERE id = ?");
    $stmt->bind_param("i", $first_jadwal_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $original_schedule_first = $result->fetch_assoc();

    $mata_kuliah = $original_schedule_first['matkul'];
    $jadwal_awal_mulai = $original_schedule_first['jam'];

    // Fetch original schedule details for the last entry
    $stmt = $db->prepare("SELECT jam FROM jadwal_kuliah WHERE id = ?");
    $stmt->bind_param("i", $last_jadwal_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $original_schedule_last = $result->fetch_assoc();

    $jadwal_awal_selesai = $original_schedule_last['jam'];

    // Insert request into the database
    $sql = "INSERT INTO requests (dosen_id, mata_kuliah, tanggal_awal, jadwal_awal_mulai, jadwal_awal_selesai, tanggal_baru, jadwal_baru_mulai, jadwal_baru_selesai, alasan)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("issssssss", $dosen_id, $mata_kuliah, $tanggal_awal, $jadwal_awal_mulai, $jadwal_awal_selesai, $tanggal_baru, $jadwal_baru_mulai, $jadwal_baru_selesai, $alasan);

    if ($stmt->execute()) {
        return ["success", "Request pergantian jadwal berhasil dikirim."];
    } else {
        return ["danger", "Error: " . $stmt->error];
    }
}


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
function delete_schedule_permanently($db, $schedule_id, $hari, $matkul, $dosen_id_1, $dosen_id_2, $classroom, $kelas)
{
    // Query untuk mendapatkan nilai-nilai yang terkait dengan schedule_id
    $sql_select = "SELECT hari, matkul, dosen_id_1, dosen_id_2, classroom, kelas FROM jadwal_kuliah WHERE id = ?";
    $stmt_select = $db->prepare($sql_select);
    $stmt_select->bind_param("i", $schedule_id);
    $stmt_select->execute();
    $stmt_select->bind_result($hari, $matkul, $dosen_id_1, $dosen_id_2, $classroom, $kelas);
    $stmt_select->fetch();
    $stmt_select->close();

    // Menyiapkan query DELETE berdasarkan apakah dosen_id_2 NULL atau tidak
    if ($dosen_id_2 === null) {
        $sql_delete = "DELETE FROM jadwal_kuliah WHERE hari = ? AND matkul = ? AND dosen_id_1 = ? AND dosen_id_2 IS NULL AND classroom = ? AND kelas = ?";
        $stmt_delete = $db->prepare($sql_delete);
        $stmt_delete->bind_param("ssiss", $hari, $matkul, $dosen_id_1, $classroom, $kelas);
    } else {
        $sql_delete = "DELETE FROM jadwal_kuliah WHERE hari = ? AND matkul = ? AND dosen_id_1 = ? AND dosen_id_2 = ? AND classroom = ? AND kelas = ?";
        $stmt_delete = $db->prepare($sql_delete);
        $stmt_delete->bind_param("ssiiss", $hari, $matkul, $dosen_id_1, $dosen_id_2, $classroom, $kelas);
    }

    $result = $stmt_delete->execute();
    $stmt_delete->close();

    return $result;
}

function delete_temp_schedule($hari, $matkul, $dosen_id_1, $dosen_id_2, $kelas)
{
    global $db;

    if ($dosen_id_2) {
        $sql = "DELETE FROM jadwal_kuliah 
                WHERE hari = ? AND matkul = ? AND dosen_id_1 = ? AND dosen_id_2 = ? AND kelas = ? 
                AND (is_temporary = 1 OR is_deleted_temporarily = 1)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sssss", $hari, $matkul, $dosen_id_1, $dosen_id_2, $kelas);
    } else {
        $sql = "DELETE FROM jadwal_kuliah 
                WHERE hari = ? AND matkul = ? AND dosen_id_1 = ? AND (dosen_id_2 IS NULL OR dosen_id_2 = '') AND kelas = ? 
                AND (is_temporary = 1 OR is_deleted_temporarily = 1)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssss", $hari, $matkul, $dosen_id_1, $kelas);
    }

    $stmt->execute();

    return $stmt->affected_rows;
}
// Akhir kode untuk menghapus jadwal

// Fungsi untuk menampilkan jadwal sesuai dengan kelas
function fetch_schedules($db, $kelas)
{
    $sql = "SELECT jk.*, 
                   dd1.nama as dosen1, 
                   dd2.nama as dosen2 
            FROM jadwal_kuliah jk
            LEFT JOIN daftar_dosen dd1 ON jk.dosen_id_1 = dd1.id
            LEFT JOIN daftar_dosen dd2 ON jk.dosen_id_2 = dd2.id
            WHERE jk.kelas = ? AND jk.is_deleted_temporarily = 0 AND (jk.end_date IS NULL OR jk.end_date >= CURDATE())";
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


function fetch_all_schedules($db)
{
    $sql = "SELECT jk.*, dd1.nama as dosen_1, dd2.nama as dosen_2 
            FROM jadwal_kuliah jk
            LEFT JOIN daftar_dosen dd1 ON jk.dosen_id_1 = dd1.id
            LEFT JOIN daftar_dosen dd2 ON jk.dosen_id_2 = dd2.id
            ORDER BY jk.kelas, jk.hari, jk.jam";
    $result = $db->query($sql);
    if (!$result) {
        die('Error: ' . $db->error);
    }
    $schedules = [];
    while ($row = $result->fetch_assoc()) {
        $schedules[$row['hari']][$row['jam']][] = $row;
    }
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
function update_or_insert_schedule(
    $db,
    $hari,
    $matkul,
    $dosen_id_1,
    $dosen_id_2,
    $classroom,
    $kelas,
    $jam_mulai,
    $jam_selesai,
    $time_slots,
    $is_temporary = 0,
    $end_date = NULL,
    $old_hari = NULL,
    $old_jam_mulai = NULL,
    $old_jam_selesai = NULL
) {
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
            $sql = "UPDATE jadwal_kuliah SET matkul = ?, dosen_id_1 = ?, dosen_id_2 = ?, classroom = ?, is_temporary = ?, end_date = ? WHERE id = ?";
            $stmt = $db->prepare($sql);
            $dosen_id_2 = empty($dosen_id_2) ? NULL : $dosen_id_2;
            $stmt->bind_param(
                "siisssi",
                $matkul,
                $dosen_id_1,
                $dosen_id_2,
                $classroom,
                $is_temporary,
                $end_date,
                $existing_schedules[$current_time]
            );
            unset($existing_schedules[$current_time]);
        } else {
            $sql = "INSERT INTO jadwal_kuliah (hari, matkul, dosen_id_1, dosen_id_2, classroom, kelas, jam, is_temporary, end_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $dosen_id_2 = empty($dosen_id_2) ? NULL : $dosen_id_2;
            $stmt->bind_param(
                "ssiisssis",
                $hari,
                $matkul,
                $dosen_id_1,
                $dosen_id_2,
                $classroom,
                $kelas,
                $current_time,
                $is_temporary,
                $end_date
            );
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

function get_current_user_id()
{
    // Check if session is started
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // Check if user ID is stored in session
    if (isset($_SESSION['user_id'])) {
        return $_SESSION['user_id']; // Return user ID from session
    }

    // User not logged in or ID not found in session
    return null;
}

function fetch_schedule_by_dosen_id($db)
{
    // Get logged-in user ID (assuming a function exists)
    $user_id = get_current_user_id();

    // Check if user ID is available
    if (!$user_id) {
        return null; // Handle case where user is not logged in
    }

    // Find dosen data based on user ID (assuming 'daftar_dosen' table has 'user_id')
    $stmt = $db->prepare('SELECT id FROM daftar_dosen WHERE user_id = ?');
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $dosen = $result->fetch_assoc();

    if (!$dosen) {
        return null; // Handle case where dosen not found for user ID
    }

    // Continue with original logic using dosen ID
    $dosen_id = $dosen['id'];
    $time_slots = get_time_slots_for_viewing();
    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
    $stmt = $db->prepare('SELECT jk.*, 
                                 dd1.nama as dosen1, 
                                 dd2.nama as dosen2 
                          FROM jadwal_kuliah jk
                          LEFT JOIN daftar_dosen dd1 ON jk.dosen_id_1 = dd1.id
                          LEFT JOIN daftar_dosen dd2 ON jk.dosen_id_2 = dd2.id
                          WHERE jk.dosen_id_1 = ? OR jk.dosen_id_2 = ?');
    $stmt->bind_param('ii', $dosen_id, $dosen_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $jadwal = $result->fetch_all(MYSQLI_ASSOC);
    $schedule = [];
    foreach ($jadwal as $item) {
        if (!isset($schedule[$item['hari']])) {
            $schedule[$item['hari']] = [];
        }
        if (!isset($schedule[$item['hari']][$item['jam']])) {
            $schedule[$item['hari']][$item['jam']] = [];
        }
        $schedule[$item['hari']][$item['jam']][] = $item;
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
            $sql = "SELECT jk.*, dd1.nama AS dosen_1, dd2.nama AS dosen_2, dd1.id AS dosen_id_1, dd2.id AS dosen_id_2 
                    FROM jadwal_kuliah jk
                    LEFT JOIN daftar_dosen dd1 ON jk.dosen_id_1 = dd1.id
                    LEFT JOIN daftar_dosen dd2 ON jk.dosen_id_2 = dd2.id
                    WHERE jk.hari = ? AND jk.jam = ? 
                    AND (jk.is_temporary = 0 OR (jk.is_temporary = 1 AND jk.end_date >= CURDATE()) OR jk.is_deleted_temporarily = 1)";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ss", $day, $slot);
            $stmt->execute();
            $result = $stmt->get_result();

            $all_slots[$day][$slot] = [];
            while ($row = $result->fetch_assoc()) {
                $all_slots[$day][$slot][] = [
                    'id' => $row['id'],
                    'matkul' => $row['matkul'],
                    'dosen_1' => $row['dosen_1'],
                    'dosen_id_1' => $row['dosen_id_1'],
                    'dosen_2' => $row['dosen_2'],
                    'dosen_id_2' => $row['dosen_id_2'],
                    'kelas' => $row['kelas'],
                    'classroom' => $row['classroom'],
                    'is_temporary' => $row['is_temporary'],
                    'is_deleted_temporarily' => $row['is_deleted_temporarily']
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
function delete_schedule_temporarily($db, $hari, $matkul, $dosen_id_1, $dosen_id_2, $kelas)
{
    $db->begin_transaction();

    try {
        $current_date = date('Y-m-d');
        $end_date = date('Y-m-d', strtotime('next Sunday'));

        // Update jadwal_kuliah
        $sql = "UPDATE jadwal_kuliah SET is_deleted_temporarily = 1, end_date = ? 
                WHERE hari = ? AND matkul = ? AND dosen_id_1 = ? AND (dosen_id_2 = ? OR (dosen_id_2 IS NULL AND ? IS NULL)) AND kelas = ?";
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            throw new Exception($db->error);
        }
        $stmt->bind_param("sssssss", $end_date, $hari, $matkul, $dosen_id_1, $dosen_id_2, $dosen_id_2, $kelas);
        $stmt->execute();

        // Insert into temporary_deleted_schedules
        $sql = "INSERT INTO temporary_deleted_schedules (original_id, hari, jam_mulai, jam_selesai, matkul, dosen_id_1, dosen_id_2, classroom, kelas, end_date)
                SELECT id, hari, SUBSTRING_INDEX(jam, ' - ', 1), SUBSTRING_INDEX(jam, ' - ', -1), matkul, dosen_id_1, dosen_id_2, classroom, kelas, ?
                FROM jadwal_kuliah 
                WHERE hari = ? AND matkul = ? AND dosen_id_1 = ? AND (dosen_id_2 = ? OR (dosen_id_2 IS NULL AND ? IS NULL)) AND kelas = ?";
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            throw new Exception($db->error);
        }
        $stmt->bind_param("sssssss", $end_date, $hari, $matkul, $dosen_id_1, $dosen_id_2, $dosen_id_2, $kelas);
        $stmt->execute();

        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollback();
        error_log("Error in delete_schedule_temporarily: " . $e->getMessage());
        return false;
    }
}

function cancel_temporary_delete($db, $hari, $matkul, $dosen_id_1, $dosen_id_2, $kelas)
{
    $db->begin_transaction();

    try {
        // Update jadwal_kuliah table
        $sql1 = "UPDATE jadwal_kuliah 
                 SET is_deleted_temporarily = 0, end_date = NULL 
                 WHERE hari = ? AND matkul = ? AND dosen_id_1 = ? AND (dosen_id_2 = ? OR (dosen_id_2 IS NULL AND ? IS NULL)) AND kelas = ?";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bind_param("ssiiss", $hari, $matkul, $dosen_id_1, $dosen_id_2, $dosen_id_2, $kelas);
        $stmt1->execute();
        $affected_rows_jadwal = $stmt1->affected_rows;
        $stmt1->close();

        // Get the IDs of the updated rows in jadwal_kuliah
        $sql2 = "SELECT id FROM jadwal_kuliah 
                 WHERE hari = ? AND matkul = ? AND dosen_id_1 = ? AND (dosen_id_2 = ? OR (dosen_id_2 IS NULL AND ? IS NULL)) AND kelas = ?";
        $stmt2 = $db->prepare($sql2);
        $stmt2->bind_param("ssiiss", $hari, $matkul, $dosen_id_1, $dosen_id_2, $dosen_id_2, $kelas);
        $stmt2->execute();
        $result = $stmt2->get_result();
        $ids = [];
        while ($row = $result->fetch_assoc()) {
            $ids[] = $row['id'];
        }
        $stmt2->close();

        // Delete from temporary_deleted_schedules table using the collected IDs
        if (!empty($ids)) {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $sql3 = "DELETE FROM temporary_deleted_schedules 
                     WHERE original_id IN ($placeholders)";
            $stmt3 = $db->prepare($sql3);
            $stmt3->bind_param(str_repeat('i', count($ids)), ...$ids);
            $stmt3->execute();
            $affected_rows_temp = $stmt3->affected_rows;
            $stmt3->close();
        } else {
            $affected_rows_temp = 0;
        }

        $db->commit();

        // Return the total number of affected rows from both operations
        return $affected_rows_temp;
    } catch (Exception $e) {
        $db->rollback();
        error_log("Error in cancel_temporary_delete: " . $e->getMessage());
        return 0; // Indicating failure
    }
}

function checkRegularSchedule($db, $hari, $jam_mulai, $jam_selesai, $kelas)
{
    $sql = "SELECT * FROM jadwal_kuliah 
            WHERE hari = ? 
            AND kelas = ? 
            AND is_temporary = 0 
            AND is_deleted_temporarily = 0
            AND (
                (SUBSTRING_INDEX(jam, ' - ', 1) <= ? AND SUBSTRING_INDEX(jam, ' - ', -1) > ?) 
                OR (SUBSTRING_INDEX(jam, ' - ', 1) < ? AND SUBSTRING_INDEX(jam, ' - ', -1) >= ?)
            )";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("ssssss", $hari, $kelas, $jam_mulai, $jam_mulai, $jam_selesai, $jam_selesai);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
}

function restore_temporary_deleted_schedules($db)
{
    $db->begin_transaction();

    try {
        // Ambil tanggal hari ini
        $today = date('Y-m-d');

        // Ambil semua jadwal sementara yang sudah kadaluarsa
        $sql = "SELECT * FROM temporary_deleted_schedules WHERE end_date < ?";
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            throw new Exception($db->error);
        }
        $stmt->bind_param("s", $today);
        $stmt->execute();
        $result = $stmt->get_result();
        $expired_schedules = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($expired_schedules as $schedule) {
            // Kembalikan jadwal ke tabel jadwal_kuliah
            $sql = "UPDATE jadwal_kuliah SET is_deleted_temporarily = 0, end_date = NULL WHERE id = ?";
            $stmt = $db->prepare($sql);
            if (!$stmt) {
                throw new Exception($db->error);
            }
            $stmt->bind_param("i", $schedule['original_id']);
            $stmt->execute();

            // Hapus jadwal dari tabel temporary_deleted_schedules
            $sql = "DELETE FROM temporary_deleted_schedules WHERE id = ?";
            $stmt = $db->prepare($sql);
            if (!$stmt) {
                throw new Exception($db->error);
            }
            $stmt->bind_param("i", $schedule['id']);
            $stmt->execute();
        }

        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollback();
        error_log("Error in restore_temporary_deleted_schedules: " . $e->getMessage());
        return false;
    }
}

function insertPertemuan($data)
{
    global $db;
    $sql = "INSERT INTO pertemuan (mata_kuliah_id, pertemuan, deskripsi, tanggal, dosen_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param(
        "iissi",
        $data['mata_kuliah_id'],
        $data['pertemuan'],
        $data['deskripsi'],
        $data['tanggal'],
        $data['dosen_id']  // New parameter
    );
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
    $sql = "INSERT INTO tugas_pertemuan (pertemuan_id, judul, deskripsi, tanggal_deadline, jam_deadline,
                file_tugas, dosen_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param(
        "isssssi",
        $data['pertemuan_id'],
        $data['judul'],
        $data['deskripsi'],
        $data['tanggal_deadline'],
        $data['jam_deadline'],
        $data['file_tugas'],
        $data['dosen_id']  // New parameter
    );
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

function uploadFileTugas(
    $file,
    $target_dir = "../src/files/assignment/",
    $allowed_types = [
        'doc',
        'docx',
        'pdf',
        'xls',
        'pptx'
    ]
) {
    if ($file['error'] == 0) {
        $file_extension = pathinfo($file["name"], PATHINFO_EXTENSION);
        if (in_array($file_extension, $allowed_types)) {
            // Generate unique filename using uniqid and extension
            $unique_filename = uniqid('', true) . '.' . $file_extension;
            $file_path = $target_dir . $unique_filename;

            if (move_uploaded_file($file["tmp_name"], $file_path)) {
                return $unique_filename; // Return the unique filename
            } else {
                return ['error' => "Gagal mengupload file tugas."];
            }
        } else {
            return [
                'error' => "Format file tidak didukung. Hanya file dengan format doc, docx, pdf, xls, pptx yang
                diizinkan."
            ];
        }
    }
    return '';
}

function uploadTugas($tugas_id, $matkul_id, $pertemuan_id, $mahasiswa_id, $mahasiswa_nim, $pertemuan_ke, $file)
{
    $target_dir = "../src/files/tugas/";
    $file_extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . $mahasiswa_nim . '_tugas_pertemuan_' . $pertemuan_ke . '.' . $file_extension;
    $uploadOk = 1;
    $uploadMessage = "";

    // Allow certain file formats
    $allowedTypes = ["pdf", "doc", "docx", "pptx", "xls", "jpg", "png", "jpeg"];
    if (!in_array($file_extension, $allowedTypes)) {
        $uploadOk = 0;
        $uploadMessage = "Maaf, hanya file dengan format berikut yang diperbolehkan: " . implode(", ", $allowedTypes) . ".";
    }

    // Check file size
    if ($file["size"] > 5000000) {
        $uploadOk = 0;
        $uploadMessage = "Maaf, ukuran file terlalu besar. Maksimal 5MB.";
    }

    if ($uploadOk) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            // Check if there's already a submission
            $existingSubmission = retrieve("SELECT * FROM tugas_kumpul WHERE tugas_id = ? AND mahasiswa_id = ?", [$tugas_id, $mahasiswa_id]);
            if ($existingSubmission) {
                // Update existing submission
                retrieve("UPDATE tugas_kumpul SET file_path = ?, tanggal_kumpul = NOW(), jam_kumpul = NOW() WHERE tugas_id = ? AND mahasiswa_id = ?", [$target_file, $tugas_id, $mahasiswa_id]);
                $uploadMessage = "File berhasil diupdate.";
            } else {
                // Insert new submission
                retrieve("INSERT INTO tugas_kumpul (tugas_id, mahasiswa_id, file_path, tanggal_kumpul, jam_kumpul) VALUES (?, ?, ?, NOW(), NOW())", [$tugas_id, $mahasiswa_id, $target_file]);
                $uploadMessage = "File berhasil diupload.";
            }
        } else {
            $uploadMessage = "Maaf, terjadi kesalahan saat mengupload file.";
        }
    }

    return $uploadMessage;
}


function getTugasDetail($tugas_id, $mahasiswa_id)
{
    return retrieve("SELECT tp.*, p.pertemuan, p.tanggal, mk.nama as mata_kuliah, dm.nama as mahasiswa, dm.nim, dm.kelas, 
                     DATE_FORMAT(tp.tanggal_kumpul, '%Y-%m-%d') as tanggal_kumpul, 
                     DATE_FORMAT(tp.jam_kumpul, '%H:%i') as jam_kumpul 
                     FROM tugas_kumpul tp 
                     JOIN tugas_pertemuan t ON tp.tugas_id = t.id 
                     JOIN pertemuan p ON t.pertemuan_id = p.id 
                     JOIN mata_kuliah mk ON p.mata_kuliah_id = mk.id 
                     JOIN daftar_mahasiswa dm ON tp.mahasiswa_id = dm.id 
                     WHERE tp.tugas_id = ? AND tp.mahasiswa_id = ?", [$tugas_id, $mahasiswa_id])[0];
}

function getPertemuanDetail($pertemuan_id)
{
    return retrieve("SELECT pertemuan FROM pertemuan WHERE id = ?", [$pertemuan_id])[0];
}

function deleteTugasKumpulByPertemuan($pertemuan_id)
{
    global $db;
    $sql = "DELETE FROM tugas_kumpul WHERE tugas_id IN (SELECT id FROM tugas_pertemuan WHERE pertemuan_id =
                ?)";
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

function getAllMataKuliah($db)
{
    $sql = "SELECT mk.id, mk.kode, mk.nama, mk.deskripsi,
                   dd1.nama as dosen_1,
                   dd2.nama as dosen_2
            FROM mata_kuliah mk
            LEFT JOIN daftar_dosen dd1 ON mk.dosen_id_1 = dd1.id
            LEFT JOIN daftar_dosen dd2 ON mk.dosen_id_2 = dd2.id";
    $result = $db->query($sql);
    if (!$result) {
        die('Error: ' . $db->error);
    }
    $mata_kuliah = [];
    while ($row = $result->fetch_assoc()) {
        $mata_kuliah[] = $row;
    }
    return $mata_kuliah;
}

function processCourseFormByAdmin($db)
{
    $message = '';
    $alert_type = '';

    if (isset($_POST['kode'], $_POST['nama'], $_POST['deskripsi'], $_POST['dosen_id_1'])) {
        // Escape special characters to prevent XSS
        $kode = htmlspecialchars($_POST['kode']);
        $nama = htmlspecialchars($_POST['nama']);
        $deskripsi = htmlspecialchars($_POST['deskripsi']);
        $dosen_id_1 = (int) $_POST['dosen_id_1'];
        $dosen_id_2 = !empty($_POST['dosen_id_2']) ? (int) $_POST['dosen_id_2'] : NULL;

        // Cek apakah dosen_id_1 ada di daftar_dosen berdasarkan kolom id
        $query = "SELECT id FROM daftar_dosen WHERE id = ?";
        $stmt = $db->prepare($query);
        if (!$stmt) {
            $message = "Terjadi kesalahan pada persiapan statement: " . $db->error;
            $alert_type = "danger";
            return [$message, $alert_type];
        }

        $stmt->bind_param("i", $dosen_id_1);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            $message = "Dosen dengan ID tersebut tidak ditemukan.";
            $alert_type = "danger";
            $stmt->close();
            return [$message, $alert_type];
        }

        $stmt->close();

        // Cek apakah dosen_id_2 ada di daftar_dosen (jika ada)
        if ($dosen_id_2 !== NULL) {
            $stmt = $db->prepare($query);
            if (!$stmt) {
                $message = "Terjadi kesalahan pada persiapan statement: " . $db->error;
                $alert_type = "danger";
                return [$message, $alert_type];
            }

            $stmt->bind_param("i", $dosen_id_2);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 0) {
                $message = "Dosen kedua dengan ID tersebut tidak ditemukan.";
                $alert_type = "danger";
                $stmt->close();
                return [$message, $alert_type];
            }

            $stmt->close();
        }

        // Lanjutkan dengan insert jika dosen_id valid
        $sql = "INSERT INTO mata_kuliah (kode, nama, deskripsi, dosen_id_1, dosen_id_2) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            $message = "Terjadi kesalahan pada persiapan statement: " . $db->error;
            $alert_type = "danger";
            return [$message, $alert_type];
        }

        $stmt->bind_param("sssii", $kode, $nama, $deskripsi, $dosen_id_1, $dosen_id_2);

        if ($stmt->execute()) {
            $message = "Mata Kuliah berhasil ditambahkan.";
            $alert_type = "success";
        } else {
            $message = "Mata kuliah gagal ditambahkan, silakan coba lagi. Kesalahan: " . $stmt->error;
            $alert_type = "danger";
        }
        $stmt->close();
    } else {
        $message = "Harap isi semua kolom yang diperlukan.";
        $alert_type = "warning";
    }

    return [$message, $alert_type];
}


function deleteMataKuliah($db, $id)
{
    // Start transaction
    $db->begin_transaction();

    try {
        // Then, delete the mata_kuliah entry
        $query = "DELETE FROM mata_kuliah WHERE id = ?";
        $stmt = $db->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare failed for mata_kuliah: " . $db->error);
        }
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed for mata_kuliah: " . $stmt->error);
        }
        $stmt->close();

        // If we get here, both operations were successful
        $db->commit();
        return true;
    } catch (Exception $e) {
        // An error occurred, rollback the transaction
        $db->rollback();
        error_log("Failed to delete mata kuliah: " . $e->getMessage());
        return false;
    }
}

function getDosenName($dosen_id)
{
    global $db;
    $query = "SELECT nama FROM daftar_dosen WHERE id = ?";
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

function deleteUserAndDependencies($db, $delete_id, $role)
{
    try {
        mysqli_begin_transaction($db);

        if ($role == 'dosen') {
            // Ambil user_id dari daftar_dosen
            $stmt = $db->prepare("SELECT user_id FROM daftar_dosen WHERE id = ?");
            $stmt->bind_param("i", $delete_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $dosen = $result->fetch_assoc();

            if (!$dosen) {
                throw new Exception("Dosen tidak ditemukan.");
            }

            $user_id = $dosen['user_id'];

            // Hapus requests terkait dengan dosen
            $stmt = $db->prepare("DELETE FROM requests WHERE dosen_id = ?");
            $stmt->bind_param("i", $delete_id);
            $stmt->execute();

            // Update mata_kuliah
            $stmt = $db->prepare("UPDATE mata_kuliah SET 
                                  dosen_id_1 = CASE WHEN dosen_id_1 = ? THEN NULL ELSE dosen_id_1 END,
                                  dosen_id_2 = CASE WHEN dosen_id_2 = ? THEN NULL ELSE dosen_id_2 END
                                  WHERE dosen_id_1 = ? OR dosen_id_2 = ?");
            $stmt->bind_param("iiii", $delete_id, $delete_id, $delete_id, $delete_id);
            $stmt->execute();

            // Update jadwal_kuliah
            $stmt = $db->prepare("UPDATE jadwal_kuliah SET 
                                  dosen_id_1 = CASE WHEN dosen_id_1 = ? THEN NULL ELSE dosen_id_1 END,
                                  dosen_id_2 = CASE WHEN dosen_id_2 = ? THEN NULL ELSE dosen_id_2 END
                                  WHERE dosen_id_1 = ? OR dosen_id_2 = ?");
            $stmt->bind_param("iiii", $delete_id, $delete_id, $delete_id, $delete_id);
            $stmt->execute();

            // Hapus tugas_kumpul terkait dengan tugas_pertemuan dari pertemuan dosen
            $stmt = $db->prepare("DELETE tk FROM tugas_kumpul tk
                                  INNER JOIN tugas_pertemuan tp ON tk.tugas_id = tp.id
                                  INNER JOIN pertemuan p ON tp.pertemuan_id = p.id
                                  WHERE p.dosen_id = ?");
            $stmt->bind_param("i", $delete_id);
            $stmt->execute();

            // Hapus tugas_pertemuan
            $stmt = $db->prepare("DELETE tp FROM tugas_pertemuan tp
                                  INNER JOIN pertemuan p ON tp.pertemuan_id = p.id
                                  WHERE p.dosen_id = ?");
            $stmt->bind_param("i", $delete_id);
            $stmt->execute();

            // Hapus pertemuan
            $stmt = $db->prepare("DELETE FROM pertemuan WHERE dosen_id = ?");
            $stmt->bind_param("i", $delete_id);
            $stmt->execute();

            // Hapus dari daftar_dosen
            $stmt = $db->prepare("DELETE FROM daftar_dosen WHERE id = ?");
            $stmt->bind_param("i", $delete_id);
            $stmt->execute();

            // Hapus dari users
            $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

        } elseif ($role == 'mahasiswa') {
            // Ambil user_id dari daftar_mahasiswa
            $stmt = $db->prepare("SELECT user_id FROM daftar_mahasiswa WHERE id = ?");
            $stmt->bind_param("i", $delete_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $mahasiswa = $result->fetch_assoc();

            if (!$mahasiswa) {
                throw new Exception("Mahasiswa tidak ditemukan.");
            }

            $user_id = $mahasiswa['user_id'];

            // Hapus dari tugas_kumpul
            $stmt = $db->prepare("DELETE FROM tugas_kumpul WHERE mahasiswa_id = ?");
            $stmt->bind_param("i", $delete_id);
            $stmt->execute();

            // Hapus dari daftar_mahasiswa
            $stmt = $db->prepare("DELETE FROM daftar_mahasiswa WHERE id = ?");
            $stmt->bind_param("i", $delete_id);
            $stmt->execute();

            // Hapus dari users
            $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
        }

        mysqli_commit($db);
        return ["message" => "Data berhasil dihapus", "alert_class" => "success"];
    } catch (Exception $e) {
        mysqli_rollback($db);
        error_log("Error in deleteUserAndDependencies: " . $e->getMessage());
        return ["message" => "Gagal menghapus data: " . $e->getMessage(), "alert_class" => "danger"];
    }
}

function add_schedule($kelas, $semester, $tahun, $file_jadwal, $file_type)
{
    global $db;

    $upload_dir = '../src/files/jadwal/';
    $file_name = uniqid() . '_' . basename($file_jadwal['name']);
    $file_path = $upload_dir . $file_name;

    if (move_uploaded_file($file_jadwal['tmp_name'], $file_path)) {
        $stmt = $db->prepare('INSERT INTO jadwal_perkuliahan (kelas, semester, tahun, file_jadwal, file_type) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sssss', $kelas, $semester, $tahun, $file_path, $file_type);
        return $stmt->execute();
    }
    return false;
}

function get_schedule($kelas, $semester, $tahun)
{
    global $db;
    $stmt = $db->prepare('SELECT * FROM jadwal_perkuliahan WHERE kelas = ? AND semester = ? AND tahun = ?');
    $stmt->bind_param('sss', $kelas, $semester, $tahun);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function update_schedule($kelas, $semester, $tahun, $file_tmp, $file_type)
{
    global $db;

    // Tentukan direktori untuk menyimpan file
    $upload_dir = '../src/files/jadwal/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Generate nama file unik
    $file_name = uniqid() . '_' . basename($file_tmp);
    $file_path = $upload_dir . $file_name;

    // Pindahkan file yang diunggah
    if (move_uploaded_file($file_tmp, $file_path)) {
        // File berhasil dipindahkan, simpan path-nya ke database
        $stmt = $db->prepare("UPDATE jadwal_perkuliahan 
                              SET file_jadwal = ?, file_type = ? 
                              WHERE kelas = ? AND semester = ? AND tahun = ?");
        $stmt->bind_param("sssss", $file_path, $file_type, $kelas, $semester, $tahun);

        if ($stmt->execute()) {
            return true;
        } else {
            // Jika gagal menyimpan ke database, hapus file yang sudah diunggah
            unlink($file_path);
            return false;
        }
    } else {
        return false;
    }
}
?>