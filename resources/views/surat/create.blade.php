<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Surat</title>
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
        .nav-link:hover {
            background-color: #e2e6ea;
            color: #0d6efd;
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
            <li class="nav-item"><a href="{{ route('surat.index') }}" class="nav-link text-dark"><i class="bi bi-star-fill me-2"></i>Arsip</a></li>
            <li class="nav-item"><a href="{{ route('kategori.index') }}" class="nav-link text-dark"><i class="bi bi-journal-bookmark-fill me-2"></i>Kategori Surat</a></li>
            <li class="nav-item"><a href="{{ route('about') }}" class="nav-link text-dark"><i class="bi bi-info-circle-fill me-2"></i>About</a></li>
        </ul>
    </div>

    {{-- Content --}}
    <div class="content">
        <h2>Arsip Surat >> {{ isset($surat) ? 'Edit' : 'Unggah' }}</h2>
        <p>{{ isset($surat) ? 'Perbarui data surat yang telah terbit pada form ini.' : 'Unggah surat yang telah terbit pada form ini untuk diarsipkan.' }} <br>
        <span style="font-weight: bold;">Catatan:</span><br>
        <ul style="list-style-type: disc;">
            <li>Gunakan file berformat PDF</li>
        </ul>
        </p>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($surat) ? route('surat.update', $surat->id_surat) : route('surat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($surat))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="nomor_surat" class="form-label">Nomor Surat</label>
                <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat', $surat->nomor_surat ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="kategori_id" class="form-label">Kategori</label>
                <select class="form-select" id="kategori_id" name="kategori_id" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id_kategori }}" {{ (old('kategori_id', $surat->kategori_id ?? '') == $kategori->id_kategori) ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="judul_surat" class="form-label">Judul</label>
                <input type="text" class="form-control" id="judul_surat" name="judul_surat" value="{{ old('judul_surat', $surat->judul_surat ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="file_surat" class="form-label">File Surat (PDF)</label>
                <input type="file" class="form-control" id="file_surat" name="file_surat" accept=".pdf" {{ isset($surat) ? '' : 'required' }}>
                @if(isset($surat) && $surat->nama_file)
                    <small class="form-text text-muted">File saat ini: {{ basename($surat->nama_file) }}</small>
                @endif
            </div>

            <a href="{{ route('surat.index') }}" class="btn btn-secondary me-2"> << Kembali</a>
            <button type="submit" class="btn btn-dark">Simpan</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>