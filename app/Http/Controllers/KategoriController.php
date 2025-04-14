<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kategoris = Kategori::when($search, function ($query, $search) {
            return $query->where('NamaKategori', 'like', "%{$search}%");
        })->get();

        return view('kategori.index', compact('kategoris', 'search'));
    }


    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NamaKategori' => 'required|string|max:255',
            'Deskripsi' => 'nullable|string',
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($Kategoriid)
    {
        $kategori = Kategori::findOrFail($Kategoriid);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $Kategoriid)
    {
        $request->validate([
            'NamaKategori' => 'required|string|max:255',
            'Deskripsi' => 'nullable|string',
        ]);

        $kategori = Kategori::findOrFail($Kategoriid);
        $kategori->update($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($Kategoriid)
    {
        $kategori = Kategori::findOrFail($Kategoriid);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
