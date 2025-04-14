<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;

    protected $table = 'detail_penjualans';
    protected $primaryKey = 'detail_penjualanid';
    protected $fillable = ['penjualanid', 'Produkid', 'JumlahProduk', 'Subtotal'];
    public $timestamps = false;

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualanid', 'penjualanid');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'Produkid', 'Produkid');
    }
}
