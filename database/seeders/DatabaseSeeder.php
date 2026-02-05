<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@gmail.com',
            'kelas' => '10',
            'nisn' => '0',
            'nohp' => '0123456789',
            'role' => '0',
            'password' => bcrypt('litazlibrary'),
        ]);

        DB::table('kategori')->insert([
        ['nama' => 'Bahasa Indonesia'],
        ['nama' => 'Bahasa Inggris'],
        ['nama' => 'Bahasa Jepang'],
        ['nama' => 'Kamus Bahasa'],
        ['nama' => 'Matematika'],
        ['nama' => 'PPKN'],
        ['nama' => 'Seni Budaya'],
        ['nama' => 'Agama'],
        ['nama' => 'IPAS'],
        ['nama' => 'Sejarah'],
        ['nama' => 'PJOK'],
        ['nama' => 'MP/AK'],
        ['nama' => 'PKWU'],
        ['nama' => 'Novel'],
        ['nama' => 'Umum'],
        ['nama' => 'Jurusan'],
        ]);
        
        DB::table('bidang_kajian')->insert([
        ['nama' => 'Karya Umum'],
        ['nama' => 'Filsafat dan Psikologi'],
        ['nama' => 'Agama-agama'],
        ['nama' => 'Ilmu-ilmu Sosial'],
        ['nama' => 'Ilmu Bahasa'],
        ['nama' => 'Ilmu-ilmu Murni Eksakta'],
        ['nama' => 'Ilmu-ilmu Terapan dan Teknologi'],
        ['nama' => 'Kesenian, Arsitektur, dan Olahraga'],
        ['nama' => 'Kesusasteraan'],
        ['nama' => 'Sejarah, Geografi, dan Biografi'],
        ]);
    }

}
