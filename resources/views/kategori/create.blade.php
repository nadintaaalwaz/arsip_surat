<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Judul halaman dinamis: Tambah atau Edit --}}
    <title>{{ isset($kategori) ? 'Edit' : 'Tambah' }} Kategori Surat</title>
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
        }
        .content {
            margin-left: 220px;
            padding: 20px;
        }
        .form-label {
            font-weight: bold;
        }
        .form-container {
            max-width: 800px;
        }
        .btn-kembali {
            background: #6c757d;
            color: white;
        }
        .nav-link:hover {
            background-color: #e2e6ea;
            color: #0d6efd;
        }
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .content { margin-left: 0; }
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
            <li class="nav-item"><a href="{{ route('about') }}" class="nav-link"><i class="bi bi-info-circle-fill text-dark me-2"></i>About</a></li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="form-container">
            {{-- Judul dinamis sesuai aksi (Tambah/Edit) --}}
            <h2>Kategori Surat >> {{ isset($kategori) ? 'Edit' : 'Tambah' }}</h2>
            <p>Tambahkan atau edit data kategori. Jika sudah selesai, jangan lupa untuk mengklik tombol "Simpan".</p>
            <hr>

            {{-- Menentukan action form berdasarkan mode (edit atau create) --}}
            @php
                $actionUrl = isset($kategori) ? route('kategori.update', $kategori->id) : route('kategori.store');
            @endphp

            <form action="{{ $actionUrl }}" method="POST">
                @csrf
                {{-- Menambahkan method spoofing untuk request PUT saat edit --}}
                @if(isset($kategori))
                    @method('PUT')
                @endif

                <div class="mb-3 row">
                    <label for="id_kategori" class="col-sm-3 col-form-label form-label">ID (Auto Increment)</label>
                    <div class="col-sm-9">
                        {{-- ID ditampilkan jika mode edit, jika mode create akan terlihat kosong/placeholder --}}
                        <input type="text" class="form-control" id="id_kategori" value="{{ isset($kategori) ? $kategori->id : 'Otomatis' }}" disabled readonly>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="nama_kategori" class="col-sm-3 col-form-label form-label">Nama Kategori</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', isset($kategori) ? $kategori->nama_kategori : '') }}" required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    {{-- Label 'Judul' sesuai gambar, namun name='keterangan' agar sesuai database --}}
                    <label for="keterangan" class="col-sm-3 col-form-label form-label">Judul</label>
                    <div class="col-sm-9">
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="5" required>{{ old('keterangan', isset($kategori) ? $kategori->keterangan : '') }}</textarea>
                         @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-sm-9 offset-sm-3">
                        <a href="{{ route('kategori.index') }}" class="btn btn-kembali"><< Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
