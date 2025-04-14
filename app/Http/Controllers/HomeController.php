<?php

namespace App\Http\Controllers;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{

    public function index()
    {
        $jumlahProduk = Produk::count();
        $jumlahPenjualan = Penjualan::count();
        $jumlahPenjualan = Penjualan::count();
        $jumlahPelanggan = Pelanggan::count();
        $user = Auth::user();

         // Ambil produk terlaris berdasarkan jumlah penjualan dari tabel detailpenjualans
    $penjualan = \DB::table('detail_penjualans')
    ->selectRaw('Produkid, SUM(JumlahProduk) as total')
    ->groupBy('Produkid')
    ->orderByDesc('total')
    ->limit(10) // Ambil 8 produk terlaris
    ->get();

// Jika data kosong, atur array kosong
if ($penjualan->isEmpty()) {
    $labels = [];
    $data = [];
} else {
    $labels = $penjualan->map(fn($item) => Produk::find($item->Produkid)->NamaProduk);
    $data = $penjualan->pluck('total');
}

// Filter produk yang expired dalam waktu kurang dari setahun dari hari ini
$batasWaktu = Carbon::now()->addYear(); // Ambil tanggal setahun dari sekarang
$produks = Produk::whereNotNull('Expired')
            ->where('Expired', '<=', $batasWaktu) // Filter yg expired dalam setahun ke depan
            ->orderBy('Expired', 'asc')
            ->get(['NamaProduk', 'Expired']); 

        return view('home', compact('jumlahProduk', 'jumlahPenjualan', 'jumlahPelanggan', 'labels', 'data', 'produks'));
    }
    }
