<?php

use App\Http\Controllers\SuratController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SuratController::class, 'index'])->name('home');
Route::view('coba-surat-create', 'surat.index');

// Gunakan 'only' untuk membatasi rute yang dibuat oleh resource
Route::resource('surat', SuratController::class)->only([
    'index', 'create', 'store', 'show', 'destroy'
]);

// Rute untuk download
Route::get('surat/{surat}/download', [SuratController::class, 'download'])->name('surat.download');

// Perbaikan untuk rute kategori
Route::resource('kategori', KategoriController::class)->parameters([
    'kategori' => 'kategori'
]);

Route::get('/about', function () {
    return view('about');
})->name('about');