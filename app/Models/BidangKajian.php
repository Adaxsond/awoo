<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangKajian extends Model
{
    protected $table = 'bidang_kajian';
    protected $fillable = ['nama'];

    public function buku()
    {
        return $this->hasMany(Buku::class);
    }
}
