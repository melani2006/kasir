<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $produks = Produk::when($search, function ($query, $search) {
            return $query->where('NamaProduk', 'like', "%{$search}%");
        })->get();

        return view('produk.index', compact('produks', 'search'));
    }


    public function create()
    {
        $kategoris = Kategori::all();
        $suppliers = Supplier::all();
        return view('produk.create', compact('kategoris', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NamaProduk' => 'required|string|max:255',
            'Harga' => 'required|numeric|min:0',
            'Stok' => 'required|integer|min:0',
            'Expired' => 'required|date',
            'Kategoriid' => 'required|exists:kategoris,Kategoriid',
            'Supplierid' => 'required|exists:suppliers,Supplierid',
        ]);

        Produk::create([
            'NamaProduk' => $request->NamaProduk,
            'Harga' => $request->Harga,
            'Stok' => $request->Stok,
            'Expired' => $request->Expired,
            'Kategoriid' => $request->Kategoriid,
            'Supplierid' => $request->Supplierid,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($Produkid)
    {
        $produk = Produk::findOrFail($Produkid);
        $kategoris = Kategori::all();
        $suppliers = Supplier::all();
        return view('produk.edit', compact('produk', 'kategoris', 'suppliers'));
    }

    public function update(Request $request, $Produkid)
    {
        $request->validate([
            'NamaProduk' => 'required|string|max:255',
            'Harga' => 'required|numeric|min:0',
            'Stok' => 'required|integer|min:0',
            'Expired' => 'required|date',
            'Kategoriid' => 'required|exists:kategoris,Kategoriid',
            'Supplierid' => 'required|exists:suppliers,Supplierid',
        ]);

        $produk = Produk::findOrFail($Produkid);
        $produk->update([
            'NamaProduk' => $request->NamaProduk,
            'Harga' => $request->Harga,
            'Stok' => $request->Stok,
            'Expired' => $request->Expired,
            'Kategoriid' => $request->Kategoriid,
            'Supplierid' => $request->Supplierid,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($Produkid)
    {
        $produk = Produk::findOrFail($Produkid);
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
