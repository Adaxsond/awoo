<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'users';
    protected $fillable = ['nama', 'nisn', 'kelas', 'jurusan', 'nohp', 'email','password'];
}
