<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $primaryKey = 'Supplierid';
    protected $table = 'suppliers';

    protected $fillable = ['Nama', 'Alamat', 'Telepon'];

    public function produks()
    {
        return $this->hasMany(Produk::class, 'Supplierid', 'Supplierid');
    }
}
