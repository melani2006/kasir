<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pelanggans = Pelanggan::query();

        if ($search) {
            $pelanggans->where('NamaPelanggan', 'like', "%{$search}%");
        }

        $pelanggans = $pelanggans->get();

        return view('pelanggan.index', compact('pelanggans', 'search'));
    }


    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'Alamat' => 'nullable|string',
            'NomorTelepon' => 'nullable|string|max:15',
        ]);

        Pelanggan::create([
            'NamaPelanggan' => $request->NamaPelanggan,
            'Alamat' => $request->Alamat,
            'NomorTelepon' => $request->NomorTelepon,
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit($Pelangganid)
    {
        $pelanggan = Pelanggan::findOrFail($Pelangganid);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $Pelangganid)
    {
        $pelanggan = Pelanggan::findOrFail($Pelangganid);

        $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'Alamat' => 'nullable|string',
            'NomorTelepon' => 'nullable|string|max:15',
        ]);

        $pelanggan->update([
            'NamaPelanggan' => $request->NamaPelanggan,
            'Alamat' => $request->Alamat,
            'NomorTelepon' => $request->NomorTelepon,
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy($Pelangganid)
    {
        $pelanggan = Pelanggan::findOrFail($Pelangganid);
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
