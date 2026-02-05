<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->integer('stok');
            $table->string('penerbit');
            $table->year('tanggal_terbit');
            $table->enum('kode_rak', ['RAK 1', 'RAK 2', 'RAK 3', 'RAK 4', 'RAK 5']);
            $table->text('deskripsi');
            $table->string('gambar')->nullable();

            // Relasi ke kategori dan bidang kajian
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->foreignId('bidang_kajian_id')->constrained('bidang_kajian')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
