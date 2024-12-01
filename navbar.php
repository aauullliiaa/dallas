<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="src/css/style.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-navbar fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php#home">
                <img src="src/images/logo kampus.png" alt="Logo" width="40" height="45"
                    class="d-inline-block align-text-top" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Informasi Program Studi
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="index.php#about">Tentang Prodi</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php#vision-mission">Visi dan Misi Prodi</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="dosen.php">Dosen Pengajar</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="kurikulum.php">Kurikulum</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Fasilitas
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="laboratorium.php">Laboratorium</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="kelas.php">Gedung</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="pusat-studi.php">Pusat Studi</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Kemahasiswaan
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="unit-kegiatan.php">Unit Kegiatan</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="https://hmanpnup.or.id/">Himpunan Mahasiswa Jurusan</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Login
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="login-pegawai.php">Login Dosen/Admin</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="login-mahasiswa.php">Login Mahasiswa</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>

</html>