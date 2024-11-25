<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Diskusi || APD Learning Space</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../src/css/style.css" />
    <style>
        .forum-post {
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .forum-post:hover {
            transform: translateY(-2px);
        }

        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .action-button {
            color: #6c757d;
            cursor: pointer;
            transition: color 0.2s;
        }

        .action-button:hover {
            color: #0d6efd;
        }

        .reply-section {
            border-left: 3px solid #dee2e6;
        }

        .badge-role {
            font-size: 0.8em;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-navbar fixed-top shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="../index.php#home">
                    <img src="../src/images/logo kampus.png" alt="Logo" width="40" height="45"
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
                                    <a class="dropdown-item" href="../index.php#about">Tentang Prodi</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="../index.php#vision-mission">Visi dan Misi Prodi</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="../dosen.php">Dosen Pengajar</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="../kurikulum.php">Kurikulum</a>
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
                                    <a class="dropdown-item" href="../fasilitas/laboratorium.php">Laboratorium</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="../fasilitas/gedung.php">Gedung</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="../fasilitas/pusat-studi.php">Pusat Studi</a>
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
                                    <a class="dropdown-item" href="../unit-kegiatan.php">Unit Kegiatan</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="https://hmanpnup.or.id/">Himpunan Mahasiswa
                                        Jurusan</a>
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
                                    <a class="dropdown-item" href="../login-pegawai.php">Login Dosen/Admin</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="../login-mahasiswa.php">Login Mahasiswa</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <section class="container">
        <div class="container py-5">
            <!-- Header -->
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="text-center mb-4">Forum Diskusi Akademik</h2>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                Filter Diskusi
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Terbaru</a></li>
                                <li><a class="dropdown-item" href="#">Terpopuler</a></li>
                                <li><a class="dropdown-item" href="#">Belum Terjawab</a></li>
                            </ul>
                        </div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newPostModal">
                            <i class="fas fa-plus-circle me-2"></i>Buat Diskusi Baru
                        </button>
                    </div>
                </div>
            </div>

            <!-- Forum Posts -->
            <div class="row">
                <div class="col-12">
                    <!-- Post 1 -->
                    <div class="forum-post bg-white p-4 mb-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex gap-3">
                                <img src="/api/placeholder/50/50" alt="Foto Profil" class="profile-img">
                                <div>
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="mb-0">Dr. Sarah Johnson</h5>
                                        <span class="badge bg-primary badge-role">Dosen</span>
                                    </div>
                                    <small class="text-muted">2 jam yang lalu</small>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-link" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-bookmark me-2"></i>Simpan</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="#"><i
                                                class="fas fa-flag me-2"></i>Laporkan</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h6>Pengumuman: Materi Pembelajaran Minggu Ini</h6>
                            <p>Selamat pagi mahasiswa sekalian. Saya telah mengunggah materi untuk minggu ini di
                                e-learning. Silakan dipelajari sebelum pertemuan besok. Jika ada pertanyaan, bisa
                                didiskusikan di sini.</p>
                        </div>
                        <div class="d-flex gap-3 mt-3">
                            <button class="btn btn-light action-button">
                                <i class="far fa-heart me-1"></i>23
                            </button>
                            <button class="btn btn-light action-button">
                                <i class="far fa-comment me-1"></i>12
                            </button>
                            <button class="btn btn-light action-button">
                                <i class="far fa-share-square me-1"></i>Bagikan
                            </button>
                        </div>

                        <!-- Reply Section -->
                        <div class="reply-section mt-4 ps-4">
                            <div class="mb-3">
                                <div class="d-flex gap-3 mb-3">
                                    <img src="/api/placeholder/50/50" alt="Foto Profil" class="profile-img">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <h6 class="mb-0">Alex Rahman</h6>
                                            <span class="badge bg-secondary badge-role">Mahasiswa</span>
                                        </div>
                                        <small class="text-muted">1 jam yang lalu</small>
                                        <p class="mt-2">Terima kasih Bu. Apakah ada bagian khusus yang perlu lebih
                                            difokuskan untuk quiz minggu depan?</p>
                                        <div class="d-flex gap-3">
                                            <button class="btn btn-sm btn-light action-button">
                                                <i class="far fa-heart me-1"></i>5
                                            </button>
                                            <button class="btn btn-sm btn-light action-button">
                                                <i class="far fa-comment me-1"></i>Balas
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Post 2 -->
                    <div class="forum-post bg-white p-4 mb-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex gap-3">
                                <img src="/api/placeholder/50/50" alt="Foto Profil" class="profile-img">
                                <div>
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="mb-0">Budi Santoso</h5>
                                        <span class="badge bg-secondary badge-role">Mahasiswa</span>
                                    </div>
                                    <small class="text-muted">1 jam yang lalu</small>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-link" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-bookmark me-2"></i>Simpan</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="#"><i
                                                class="fas fa-flag me-2"></i>Laporkan</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h6>Pertanyaan tentang Tugas Akhir</h6>
                            <p>Selamat sore teman-teman. Ada yang bisa bantu jelaskan tentang format penulisan daftar
                                pustaka? Saya masih bingung dengan penggunaan APA style.</p>
                        </div>
                        <div class="d-flex gap-3 mt-3">
                            <button class="btn btn-light action-button">
                                <i class="far fa-heart me-1"></i>8
                            </button>
                            <button class="btn btn-light action-button">
                                <i class="far fa-comment me-1"></i>3
                            </button>
                            <button class="btn btn-light action-button">
                                <i class="far fa-share-square me-1"></i>Bagikan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Buat Diskusi Baru -->
        <div class="modal fade" id="newPostModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Buat Diskusi Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" class="form-control" placeholder="Masukkan judul diskusi">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select">
                                    <option>Umum</option>
                                    <option>Tugas</option>
                                    <option>Materi Kuliah</option>
                                    <option>Pengumuman</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Isi Diskusi</label>
                                <textarea class="form-control" rows="5"
                                    placeholder="Tulis isi diskusi Anda..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lampiran (opsional)</label>
                                <input type="file" class="form-control">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary">Posting Diskusi</button>
                    </div>
                </div>
            </div>
    </section>
    <footer class="py-4">
        <div class="container text-center">
            <small>&copy; APD Learning Space - 2024</small>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>