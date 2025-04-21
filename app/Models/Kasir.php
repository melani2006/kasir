<?php

// app/Models/Kasir.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasir extends User
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'role'];

    public static function getKasir()
    {
        return self::where('role', 'admin')->orWhere('role', 'kasir')->get();
    }
}

