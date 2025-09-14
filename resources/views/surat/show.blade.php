<!DOCTYPE html>

<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Surat</title>
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
        .btn-unduh {
            background: #ffc107;
            color: #212529;
            font-weight: bold;
        }
        .btn-ganti {
            background: #0d6efd;
            color: white;
            font-weight: bold;
        }
        .nav-link:hover {
            background-color: #e2e6ea;
            color: #0d6efd;
        }
        .pdf-container {
            border: 1px solid #ccc;
            padding: 10px;
            height: 600px;
            width: 100%;
        }
        .pdf-viewer {
            width: 100%;
            height: 100%;
            border: none;
        }
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <h6>Menu</h6>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('surat.index') }}" class="nav-link">
                    <i class="bi bi-star-fill text-dark me-2"></i>Arsip
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kategori.index') }}" class="nav-link">
                    <i class="bi bi-journal-bookmark-fill text-dark me-2"></i>Kategori Surat
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('about') }}" class="nav-link">
                    <i class="bi bi-info-circle-fill text-dark me-2"></i>About
                </a>
            </li>
        </ul>
    </div>

    {{-- Content --}}
    <div class="content">
        <h2>Arsip Surat >> Lihat</h2>
        <p>
            Nomor: {{ $surat->nomor_surat }} <br>
            Kategori: {{ $surat->kategori->nama_kategori }} <br>
            Judul: {{ $surat->judul_surat }} <br>
            Waktu Unggah: {{ \Carbon\Carbon::parse($surat->tanggal_upload)->isoFormat('D MMMM YYYY, H:mm') }}
        </p>
        
        <div class="pdf-container my-4">
            {{-- Menggunakan iframe untuk menampilkan PDF --}}
            <iframe src="{{ asset('storage/' . $surat->nama_file) }}" class="pdf-viewer"></iframe>
        </div>

        {{-- Tombol aksi --}}
        <div class="d-flex justify-content-start gap-2">
            <a href="{{ route('surat.index') }}" class="btn btn-secondary"><< Kembali</a>
            <a href="{{ route('surat.download', $surat->id_surat) }}" class="btn btn-unduh">Unduh</a>
            <button type="button" class="btn btn-ganti">Edit/Ganti File</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.btn-ganti').addEventListener('click', function() {
            alert('Fitur "Edit/Ganti File" tidak tersedia.');
        });
    </script>

</body>
</html>
