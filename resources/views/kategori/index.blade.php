<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Surat</title>
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
        .table td, .table th {
            vertical-align: middle;
            text-align: left; 
        }
        .table th:first-child, .table td:first-child {
            text-align: center; 
        }
        .table th:last-child, .table td:last-child {
            text-align: center; 
        }
        .btn-hapus {
            background: #dc3545;
            color: white;
            font-weight: bold;
        }
        .btn-edit {
            background: #0d6efd;
            color: white;
            font-weight: bold;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.2rem;
        }
        .nav-link:hover {
            background-color: #e2e6ea;
            color: #0d6efd;
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
    </style>
</head>
<body>

    <!-- Sidebar  -->
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
        <h2>Kategori Surat</h2>
        <p>Berikut ini adalah kategori yang bisa digunakan untuk melabeli surat. <br>
        Klik "Tambah" pada kolom aksi untuk menambahkan kategori baru.</p>

        <!-- Search  -->
        <form action="{{ route('kategori.index') }}" method="GET" class="d-flex mb-3">
            <input type="text" name="q" class="form-control me-2" placeholder="Cari kategori...">
            <button class="btn btn-dark" type="submit">Cari</button>
        </form>

        <!-- Tabel dengan data dari database -->
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th style="width: 10%;">ID Kategori</th>
                    <th style="width: 25%;">Nama Kategori</th>
                    <th style="width: 45%;">Keterangan</th>
                    <th style="width: 20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategori as $item)
                <tr>
                    <td class="text-center">{{ $item->id_kategori }}</td>
                    <td>{{ $item->nama_kategori }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td class="text-center">
                        <form action="{{ route('kategori.destroy', $item->id_kategori) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-hapus">Hapus</button>
                        </form>
                        <a href="{{ route('kategori.edit', $item->id_kategori) }}" class="btn btn-sm btn-edit">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data kategori yang ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <a href="{{ route('kategori.create') }}" class="btn btn-success mt-3">
            <i class="bi bi-plus-lg"></i> Tambah Kategori Baru...
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
