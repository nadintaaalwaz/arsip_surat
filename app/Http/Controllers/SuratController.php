<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        // Ganti 'q' menjadi 'search'
        $search = $request->query('search'); 
        $surat = Surat::with('kategori')
            ->when($search, function ($query, $search) {
                $query->where('judul_surat', 'like', "%{$search}%");
            })
            ->orderBy('tanggal_upload', 'desc')
            ->paginate(10);

        // Ganti 'q' menjadi 'search'
        return view('surat.index', compact('surat', 'search'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('surat.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_surat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id_kategori',
            'file' => 'required|file|mimes:pdf|max:5120', // max 5MB
        ]);

        $path = $request->file('file')->store('surat', 'public');

        Surat::create([
            'judul_surat' => $request->judul_surat,
            'kategori_id' => $request->kategori_id,
            'nama_file' => $path,
            'tanggal_upload' => now(),
        ]);

        return redirect()->route('surat.index')->with('success', 'Data berhasil disimpan');
    }

    public function show(Surat $surat)
    {
        return view('surat.show', compact('surat'));
    }

    public function download(Surat $surat)
    {
        return Storage::disk('public')->download($surat->nama_file);
    }

    public function edit(Surat $surat)
    {
        $kategori = Kategori::all();
        return view('surat.edit', compact('surat', 'kategori'));
    }

    public function update(Request $request, Surat $surat)
    {
        $request->validate([
            'judul_surat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id_kategori',
            'file' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $data = [
            'judul_surat' => $request->judul_surat,
            'kategori_id' => $request->kategori_id,
        ];

        if ($request->hasFile('file')) {
            // hapus file lama
            Storage::disk('public')->delete($surat->nama_file);
            $data['nama_file'] = $request->file('file')->store('surat', 'public');
        }

        $surat->update($data);

        return redirect()->route('surat.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Surat $surat)
    {
        Storage::disk('public')->delete($surat->nama_file);
        $surat->delete();

        return redirect()->route('surat.index')->with('success', 'Data berhasil dihapus');
    }
}