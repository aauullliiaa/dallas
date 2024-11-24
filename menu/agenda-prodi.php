<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Program Studi Administrasi Perkantoran Digital</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../src/css/style.css" />
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <style>
        .agenda-date {
            min-width: 100px;
            text-align: center;
            border-right: 2px solid #dee2e6;
        }

        .agenda-item {
            transition: transform 0.2s;
        }

        .agenda-item:hover {
            transform: translateX(5px);
        }

        .status-upcoming {
            background-color: #e8f4ff;
        }

        .status-ongoing {
            background-color: #e8fff0;
        }

        .status-completed {
            background-color: #f8f9fa;
        }

        .filter-button.active {
            background-color: #0d6efd !important;
            color: white !important;
        }
    </style>
</head>
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
                                <a class="dropdown-item" href="">Kurikulum</a>
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
                                <a class="dropdown-item" href="">Gedung</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="">Pusat Studi</a>
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
                                <a class="dropdown-item" href="">Unit Kegiatan</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="">Himpunan Mahasiswa</a>
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

<body>
    <section class="agendaprodi-hero d-flex align-items-center justify-content-center">
        <div class="row text-center">
            <h1>Agenda Program Studi</h1>
        </div>
    </section>
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <!-- Search and Filter -->
                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control" id="searchAgenda" placeholder="Cari agenda...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2 justify-content-md-end">
                            <button class="btn btn-outline-primary filter-button active" data-filter="all">
                                Semua
                            </button>
                            <button class="btn btn-outline-primary filter-button" data-filter="upcoming">
                                Akan Datang
                            </button>
                            <button class="btn btn-outline-primary filter-button" data-filter="ongoing">
                                Sedang Berlangsung
                            </button>
                            <button class="btn btn-outline-primary filter-button" data-filter="completed">
                                Selesai
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Calendar View Toggle -->
                <div class="d-flex justify-content-end mb-3">
                    <div class="btn-group">
                        <button class="btn btn-outline-secondary active" id="listView">
                            <i class="bi bi-list-ul"></i> List
                        </button>
                        <button class="btn btn-outline-secondary" id="calendarView">
                            <i class="bi bi-calendar3"></i> Calendar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- List View -->
        <div id="listViewContent">
            <div class="row">
                <div class="col-12">
                    <!-- Upcoming Events -->
                    <div class="agenda-item card mb-3 status-upcoming">
                        <div class="card-body d-flex">
                            <div class="agenda-date pe-3">
                                <div class="fw-bold">DES</div>
                                <div class="display-6">15</div>
                                <div class="small">2024</div>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title">Seminar Proposal Tugas Akhir</h5>
                                <p class="card-text">
                                    <i class="bi bi-clock me-2"></i>09:00 - 12:00 WIB
                                    <br>
                                    <i class="bi bi-geo-alt me-2"></i>Ruang Seminar Lt. 3
                                </p>
                                <span class="badge bg-primary">Akan Datang</span>
                                <button class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal"
                                    data-bs-target="#detailModal">
                                    Detail
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Ongoing Events -->
                    <div class="agenda-item card mb-3 status-ongoing">
                        <div class="card-body d-flex">
                            <div class="agenda-date pe-3">
                                <div class="fw-bold">DES</div>
                                <div class="display-6">10</div>
                                <div class="small">2024</div>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title">Periode Ujian Akhir Semester</h5>
                                <p class="card-text">
                                    <i class="bi bi-clock me-2"></i>07:00 - 17:00 WIB
                                    <br>
                                    <i class="bi bi-geo-alt me-2"></i>Semua Ruang Kuliah
                                </p>
                                <span class="badge bg-success">Sedang Berlangsung</span>
                                <button class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal"
                                    data-bs-target="#detailModal">
                                    Detail
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Events -->
                    <div class="agenda-item card mb-3 status-completed">
                        <div class="card-body d-flex">
                            <div class="agenda-date pe-3">
                                <div class="fw-bold">NOV</div>
                                <div class="display-6">28</div>
                                <div class="small">2024</div>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title">Workshop Artificial Intelligence</h5>
                                <p class="card-text">
                                    <i class="bi bi-clock me-2"></i>13:00 - 16:00 WIB
                                    <br>
                                    <i class="bi bi-geo-alt me-2"></i>Lab Komputer
                                </p>
                                <span class="badge bg-secondary">Selesai</span>
                                <button class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal"
                                    data-bs-target="#detailModal">
                                    Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar View (Hidden by default) -->
        <div id="calendarViewContent" style="display: none;">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Minggu</th>
                                    <th>Senin</th>
                                    <th>Selasa</th>
                                    <th>Rabu</th>
                                    <th>Kamis</th>
                                    <th>Jumat</th>
                                    <th>Sabtu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Calendar cells -->
                                <tr>
                                    <td class="text-muted">26</td>
                                    <td class="text-muted">27</td>
                                    <td class="text-muted">28</td>
                                    <td>1</td>
                                    <td>2</td>
                                    <td>3</td>
                                    <td>4</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>6</td>
                                    <td>7</td>
                                    <td>8</td>
                                    <td>9</td>
                                    <td class="bg-success text-white">10</td>
                                    <td>11</td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td>13</td>
                                    <td>14</td>
                                    <td class="bg-primary text-white">15</td>
                                    <td>16</td>
                                    <td>17</td>
                                    <td>18</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Agenda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h5>Seminar Proposal Tugas Akhir</h5>
                    <div class="mb-3">
                        <i class="bi bi-calendar-event me-2"></i>15 Desember 2024
                        <br>
                        <i class="bi bi-clock me-2"></i>09:00 - 12:00 WIB
                        <br>
                        <i class="bi bi-geo-alt me-2"></i>Ruang Seminar Lt. 3
                    </div>
                    <h6>Deskripsi:</h6>
                    <p>Seminar proposal tugas akhir untuk mahasiswa semester 7. Presentasi akan dilakukan oleh 5
                        mahasiswa dengan pembimbing dan penguji yang telah ditentukan.</p>
                    <h6>Peserta:</h6>
                    <ul>
                        <li>Mahasiswa semester 7</li>
                        <li>Dosen pembimbing</li>
                        <li>Dosen penguji</li>
                    </ul>
                    <h6>Catatan:</h6>
                    <p>Peserta dimohon hadir 15 menit sebelum acara dimulai dan mempersiapkan semua dokumen yang
                        diperlukan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Tambah ke Kalender</button>
                </div>
            </div>
        </div>
    </div>
    <footer class="py-4">
        <div class="container text-center">
            <small>&copy; APD Learning Space - 2024</small>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle View
        document.getElementById('listView').addEventListener('click', function () {
            document.getElementById('listViewContent').style.display = 'block';
            document.getElementById('calendarViewContent').style.display = 'none';
            this.classList.add('active');
            document.getElementById('calendarView').classList.remove('active');
        });

        document.getElementById('calendarView').addEventListener('click', function () {
            document.getElementById('listViewContent').style.display = 'none';
            document.getElementById('calendarViewContent').style.display = 'block';
            this.classList.add('active');
            document.getElementById('listView').classList.remove('active');
        });

        // Filter Buttons
        document.querySelectorAll('.filter-button').forEach(button => {
            button.addEventListener('click', function () {
                // Remove active class from all buttons
                document.querySelectorAll('.filter-button').forEach(btn => {
                    btn.classList.remove('active');
                });
                // Add active class to clicked button
                this.classList.add('active');
            });
        });

        // Search functionality
        document.getElementById('searchAgenda').addEventListener('input', function (e) {
            const searchText = e.target.value.toLowerCase();
            document.querySelectorAll('.agenda-item').forEach(item => {
                const title = item.querySelector('.card-title').textContent.toLowerCase();
                if (title.includes(searchText)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>