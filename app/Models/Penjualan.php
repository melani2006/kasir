<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';
    protected $primaryKey = 'penjualanid';
    public $timestamps = false; // Jika tabel tidak memiliki created_at dan updated_at

    protected $fillable = [
        'TanggalPenjualan',
        'JumlahBayar',
        'Pelangganid',
        'MetodePembayaran',
        'TotalHarga'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'Pelangganid', 'Pelangganid');
    }

    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualanid', 'penjualanid');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'Produkid', 'Produkid');
    }

    // Hitung Total Harga secara otomatis
    public function getTotalHargaAttribute()
    {
        return $this->detailPenjualans()->sum('Subtotal');
    }

    // Hitung Kembalian secara otomatis
    public function getKembalianAttribute()
    {
        return max($this->JumlahBayar - $this->TotalHarga, 0);
    }

    // Override save() supaya TotalHarga dan Kembalian selalu update
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->TotalHarga = $model->getTotalHargaAttribute();
            $model->Kembalian = $model->getKembalianAttribute();
        });
    }
}
