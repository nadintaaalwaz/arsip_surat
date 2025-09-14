<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';
    protected $primaryKey = 'id_surat';

    // TAMBAHKAN 'nomor_surat' KE DALAM ARRAY INI
    protected $fillable = ['nomor_surat', 'judul_surat', 'kategori_id', 'nama_file','nama_asli_file', 'tanggal_upload'];

    // Relasi dengan model Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id_kategori');
    }
}