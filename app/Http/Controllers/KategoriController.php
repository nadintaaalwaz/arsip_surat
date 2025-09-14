<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->filled('q')) {
            $search = $request->q;
            $kategori = Kategori::where('nama_kategori', 'like', "{$search}%")->get();

            // Kirim hasil pencarian sekali, lalu redirect agar URL kembali bersih
            return redirect()->route('kategori.index')->with([
                'search_results' => $kategori,
                'search_query' => $search
            ]);
        }

        // Ambil data hasil pencarian dari session, kalau ada
        $kategori = session('search_results') ?? Kategori::all();
        $search_query = session('search_query') ?? '';

        return view('kategori.index', compact('kategori', 'search_query'));
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
