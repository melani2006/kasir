<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';
    protected $primaryKey = 'penjualanid';
    public $timestamps = false;

    protected $fillable = [
        'TanggalPenjualan',
        'JumlahBayar',
        'Pelangganid',
        'MetodePembayaran',
        'TotalHarga',
        'Kembalian',
        'StatusMember',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'Pelangganid', 'Pelangganid');
    }

    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualanid', 'penjualanid');
    }

    // Kalkulasi TotalHarga otomatis dari detail
    public function getTotalHargaCalculatedAttribute()
    {
        return $this->detailPenjualans()->sum('Subtotal');
    }

    // Kalkulasi Kembalian otomatis
    public function getKembalianCalculatedAttribute()
    {
        return max($this->JumlahBayar - $this->getTotalHargaCalculatedAttribute(), 0);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Auto update total harga & kembalian sebelum disimpan
            $model->TotalHarga = $model->getTotalHargaCalculatedAttribute();
            $model->Kembalian = $model->getKembalianCalculatedAttribute();
        });
    }
}
