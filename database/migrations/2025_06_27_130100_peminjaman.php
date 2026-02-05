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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('buku_id')->constrained('bukus')->onDelete('cascade');
            $table->integer('jumlah');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->integer('denda')->default(0);
            $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');
            $table->enum('kondisi', ['baik', 'rusak', 'hilang'])->nullable();
            $table->integer('denda_kondisi')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
        $table->dropColumn('tanggal_jatuh_tempo');
    });
    }
};
