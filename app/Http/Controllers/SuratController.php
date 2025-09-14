<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class SuratController extends Controller
{
    /**
     * Menampilkan daftar arsip surat.
     */
    public function index(Request $request)
    {
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

        $path = $request->file('file_surat')->store('surat', 'public');

        $validatedData['nama_file'] = $path;
        $validatedData['tanggal_upload'] = Carbon::now('Asia/Jakarta');

        Surat::create($validatedData);

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