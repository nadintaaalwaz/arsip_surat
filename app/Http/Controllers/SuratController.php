<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon; // Pastikan Carbon sudah diimpor

class SuratController extends Controller
{
    /**
     * Menampilkan daftar arsip surat.
     */
    public function index(Request $request)
    {
        // Menggunakan 'search' sesuai dengan yang ada di controller
        $search = $request->query('search');
        $surat = Surat::with('kategori')
            ->when($search, function ($query, $search) {
                $query->where('judul_surat', 'like', "%{$search}%");
            })
            ->orderBy('tanggal_upload', 'desc')
            ->paginate(10);

        return view('surat.index', compact('surat', 'search'));
    }

    /**
     * Menampilkan form untuk membuat arsip surat baru.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('surat.create', compact('kategoris'));
    }

    /**
     * Menyimpan arsip surat baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_surat' => 'required|string|max:255|unique:surat,nomor_surat',
            'judul_surat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id_kategori',
            'file_surat' => 'required|file|mimes:pdf|max:5120', // 5MB
        ]);

        // Simpan file ke storage/app/public/surat
        $path = $request->file('file_surat')->store('surat', 'public');

        // Buat record baru di database
        // Gunakan Carbon::now('Asia/Jakarta') untuk memastikan waktu WIB
        $validatedData['nama_file'] = $path;
        $validatedData['tanggal_upload'] = Carbon::now('Asia/Jakarta');

        Surat::create($validatedData);

        // Redirect ke halaman create dengan pesan sukses
        return redirect()->route('surat.create')->with('success', 'Data berhasil disimpan.');
    }

    /**
     * Menampilkan arsip surat tertentu.
     */
    public function show(Surat $surat)
    {
        return view('surat.show', compact('surat'));
    }

    /**
     * Mengunduh file arsip surat.
     */
    public function download(Surat $surat)
    {
        return Storage::disk('public')->download($surat->nama_file);
    }

    /**
     * Menampilkan form untuk mengedit arsip surat.
     */
    public function edit(Surat $surat)
    {
        $kategoris = Kategori::all();
        return view('surat.edit', compact('surat', 'kategoris'));
    }

    /**
     * Memperbarui arsip surat di database.
     */
    public function update(Request $request, Surat $surat)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:255|unique:surat,nomor_surat,' . $surat->id_surat . ',id_surat',
            'judul_surat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id_kategori',
            'file_surat' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $data = [
            'nomor_surat' => $request->nomor_surat,
            'judul_surat' => $request->judul_surat,
            'kategori_id' => $request->kategori_id,
        ];

        if ($request->hasFile('file_surat')) {
            // Hapus file lama jika ada
            Storage::disk('public')->delete($surat->nama_file);
            // Simpan file baru
            $data['nama_file'] = $request->file('file_surat')->store('surat', 'public');
        }

        $surat->update($data);

        return redirect()->route('surat.index')->with('success', 'Data berhasil diupdate.');
    }

    /**
     * Menghapus arsip surat dari database.
     */
    public function destroy(Surat $surat)
    {
        // Hapus file dari storage
        Storage::disk('public')->delete($surat->nama_file);
        // Hapus record dari database
        $surat->delete();

        return redirect()->route('surat.index')->with('success', 'Data berhasil dihapus.');
    }
}