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
        Schema::table('bukus', function (Blueprint $table) {
            // Cegah error jika kolom sudah ada
            if (!Schema::hasColumn('bukus', 'gambar')) {
                $table->string('gambar')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            // Hanya drop kalau kolomnya memang ada
            if (Schema::hasColumn('bukus', 'gambar')) {
                $table->dropColumn('gambar');
            }
        });
    }
};
