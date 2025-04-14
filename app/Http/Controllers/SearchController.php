<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Penjualan;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        $page = $request->input('page'); // Ambil halaman asal pencarian

        // Jika pencarian dilakukan di halaman pelanggan
        if ($page == 'pelanggan') {
            return redirect()->route('pelanggan.index', ['search' => $query]);
        }

        // Jika pencarian dilakukan di halaman penjualan
        if ($page == 'penjualan') {
            return redirect()->route('penjualan.index', ['search' => $query]);
        }

        // Cari di Kategori
        $kategori = Kategori::where('NamaKategori', 'like', "%{$query}%")->first();
        if ($kategori) {
            return redirect()->route('kategori.index', ['search' => $query]);
        }

        // Cari di Produk
        $produk = Produk::where('NamaProduk', 'like', "%{$query}%")->first();
        if ($produk) {
            return redirect()->route('produk.index', ['search' => $query]);
        }

        // Jika tidak ada hasil, kembali ke halaman sebelumnya
        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }
}
