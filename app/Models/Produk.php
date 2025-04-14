<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';
    protected $primaryKey = 'Produkid';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'NamaProduk',
        'Harga',
        'Stok',
        'Expired',
        'Kategoriid',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'Kategoriid', 'Kategoriid');
    }
}
