<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::all();
        return view('kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk dari form
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'keterangan' => 'required|string',
        ]);

        // Menyimpan data ke database
        Kategori::create($validated);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        // Menampilkan form edit dengan data kategori yang dipilih
        return view('kategori.create', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        // Validasi data yang masuk dari form
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'keterangan' => 'required|string',
        ]);

        // Memperbarui data kategori
        $kategori->update($validated);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        // Menghapus data kategori
        $kategori->delete();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
