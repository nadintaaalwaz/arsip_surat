<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->id('id_surat');
            $table->string('nomor_surat', 255)->unique();
            $table->string('judul_surat', length: 255);
            $table->unsignedBigInteger('kategori_id');
            $table->string('nama_file', 255); // menyimpan path di storage/public/surat/...
            $table->timestamp('tanggal_upload')->useCurrent();
            $table->timestamps();

            $table->foreign('kategori_id')->references('id_kategori')->on('kategori')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
