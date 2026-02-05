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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nisn')->unique();
            $table->enum('kelas', ['10', '11', '12']);
            $table->enum('jurusan', ['AK', 'MK', 'TKJ', 'TM', 'TO', 'TKG']);
            $table->string('email')->unique();
            $table->string('nohp');
            $table->enum('role', [0, 1])->default(1); // 0 = Admin, 1 = Customer
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
