<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;
    
    // TAMBAHKAN BARIS INI
    protected $table = 'surat'; 
    
    // Beri tahu model untuk menggunakan primary key 'id_surat'
    protected $primaryKey = 'id_surat'; 
    
    // Beri tahu model kolom mana saja yang bisa diisi (mass-assignable)
    protected $fillable = ['judul_surat', 'kategori_id', 'nama_file', 'tanggal_upload'];

    // Relasi dengan model Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id_kategori');
    }
}