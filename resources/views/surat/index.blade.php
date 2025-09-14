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
        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }
        .btn-unduh {
            background: #ffc107;
            color: #212529; 
            font-weight: bold;
        }
        .btn-hapus {
            background: #dc3545;
            color: white;
            font-weight: bold;
        }
        .btn-lihat {
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
        <h2>Arsip Surat</h2>
        <p>Berikut ini adalah surat-surat yang telah terbit dan diarsipkan. 
        Klik <b>"Lihat"</b> pada kolom aksi untuk menampilkan surat.</p>

        {{-- Search --}}
        <form action="{{ route('surat.index') }}" method="GET" class="d-flex mb-3">
            <input type="text" name="search" class="form-control me-2" placeholder="Search...">
            <button class="btn btn-dark" type="submit">Cari</button>
        </form>

        {{-- Tampilkan pesan sukses dari session --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tabel --}}
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nomor Surat</th>
                    <th>Kategori</th>
                    <th>Judul</th>
                    <th>Waktu Pengarsipan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($surat as $s)
                <tr>
                    <td>{{ $s->nomor_surat }}</td>
                    <td>{{ $s->kategori->nama_kategori }}</td>
                    <td>{{ $s->judul_surat }}</td>
                    <td>{{ \Carbon\Carbon::parse($s->tanggal_upload)->isoFormat('D MMMM YYYY, H:mm') }}</td>
                    <td>
                        {{-- Tombol aksi --}}
                        <form action="{{ route('surat.destroy', $s->id_surat) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah anda yakin ingin menghapus arsip surat ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-hapus">Hapus</button>
                        </form>
                        <a href="{{ route('surat.download', $s->id_surat) }}" class="btn btn-sm btn-unduh">Unduh</a>
                        <a href="{{ route('surat.show', $s->id_surat) }}" class="btn btn-sm btn-lihat">Lihat >></a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data surat yang diarsipkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $surat->links() }}
        </div>

        {{-- Tombol arsipkan --}}
        <a href="{{ route('surat.create') }}" class="btn btn-dark mt-3">Arsipkan Surat..</a>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>