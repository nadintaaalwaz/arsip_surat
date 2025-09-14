<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 200px;
            height: 100vh;
            background: #f8f9fa;
            padding: 20px;
            position: fixed;
            left: 0;
            top: 0;
            transition: transform 0.3s ease-in-out;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
        }
        .profile-picture {
            /* Sesuaikan ukuran agar lebih besar dan sesuai proporsi foto asli (899 x 1225) */
            width: 180px;
            height: 245px;
            border: 2px solid black;
            border-radius: 0;
            overflow: hidden;
        }
        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .nav-link:hover {
            background-color: #e2e6ea;
            color: #0d6efd;
        }
        
        /* Highlight untuk halaman About */
        .nav-item .nav-link.active {
            background-color: #0d6efd;
            color: white !important;
            border-radius: 5px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .content {
                margin-left: 0;
            }
        }

        /* Aturan baru untuk menyesuaikan ukuran font teks */
        .d-flex strong {
            font-size: 1.25rem; /* Membuat teks "Aplikasi ini dibuat oleh:" lebih besar */
        }
        .d-flex table td {
            font-size: 1.1rem; /* Menyesuaikan ukuran font pada isi tabel */
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h6>Menu</h6>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="{{ route('surat.index') }}" class="nav-link"><i class="bi bi-star-fill text-dark me-2"></i>Arsip</a></li>
            <li class="nav-item"><a href="{{ route('kategori.index') }}" class="nav-link"><i class="bi bi-journal-bookmark-fill text-dark me-2"></i>Kategori Surat</a></li>
            <li class="nav-item"><a href="{{ route('about') }}" class="nav-link active"><i class="bi bi-info-circle-fill text-white me-2"></i>About</a></li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content">
        <h2>About</h2>
        <hr>
        <div class="d-flex align-items-center mb-4">
            <div class="profile-picture me-4">
                 <img src="{{ asset('images/fotonadinta.jpg') }}" alt="Foto Nadinta">
            </div>
            <div>
                <strong>Aplikasi ini dibuat oleh:</strong>
                <table class="ms-3 mt-1">
                    <tbody>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>Nadinta Alwa Zahira</td>
                        </tr>
                        <tr>
                            <td>Prodi</td>
                            <td>:</td>
                            <td>D3-MI PSDKU Kediri</td>
                        </tr>
                        <tr>
                            <td>NIM</td>
                            <td>:</td>
                            <td>2331730004</td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>14 September 2025</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
