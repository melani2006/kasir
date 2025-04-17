<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';
    protected $primaryKey = 'Produkid';
    protected $fillable = [
        'NamaProduk',
        'Harga',
        'Stok',
        'Expired',
        'Kategoriid',
        'Supplierid'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'Kategoriid', 'Kategoriid');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'Supplierid', 'Supplierid');
    }
}
