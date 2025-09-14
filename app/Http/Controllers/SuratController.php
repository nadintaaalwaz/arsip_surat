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
        
        if ($request->filled('search')) {
            $search = $request->search;
            $surat = Surat::with('kategori')
                ->where('judul_surat', 'like', "%{$search}%") // cari di mana saja
                ->orderBy('tanggal_upload', 'desc')
                ->paginate(10);

            return redirect()->route('surat.index')->with([
                'search_results' => $surat,
                'search_query' => $search
            ]);
        }

        if (session()->has('search_results')) {
            $surat = session('search_results');
        } else {
            $surat = Surat::with('kategori')->orderBy('tanggal_upload', 'desc')->paginate(10);
        }

        return view('surat.index', compact('surat'));
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
        $file = $request->file('file_surat');
        $path = $file->store('surat', 'public');
        $originalName = $file->getClientOriginalName();

        // Buat record baru di database
        $surat = new Surat;
        $surat->nomor_surat = $validatedData['nomor_surat'];
        $surat->judul_surat = $validatedData['judul_surat'];
        $surat->kategori_id = $validatedData['kategori_id'];
        $surat->nama_file = $path; // Nama file di storage
        $surat->nama_asli_file = $originalName; // Nama file asli
        $surat->tanggal_upload = Carbon::now('Asia/Jakarta');
        $surat->save();
        
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
     * Mengunduh file arsip surat dengan nama asli.
     */
    public function download(Surat $surat)
    {
        // Pastikan nama asli file tidak kosong
        $fileName = $surat->nama_asli_file ?? 'dokumen-surat.pdf';
        return Storage::disk('public')->download($surat->nama_file, $fileName);
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