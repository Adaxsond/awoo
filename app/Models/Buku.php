<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'bukus';
    protected $fillable = [
        'judul', 'stok', 'penerbit', 'tanggal_terbit',
        'kode_rak', 'kategori_id', 'bidang_kajian_id', 'deskripsi', 'gambar'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function bidangKajian()
    {
        return $this->belongsTo(BidangKajian::class);
    }
}
