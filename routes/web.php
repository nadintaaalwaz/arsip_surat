<?php

use App\Http\Controllers\SuratController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SuratController::class, 'index'])->name('home');
Route::view('coba-surat-create', 'surat.index');

Route::resource('surat', SuratController::class);
Route::get('surat/{surat}/download', [SuratController::class, 'download'])->name('surat.download');

Route::resource('kategori', KategoriController::class);

Route::view('about', 'about')->name('about');

