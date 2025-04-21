<?php

namespace App\Http\Controllers;

use App\Models\Kasir;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    // Menampilkan daftar kasir
    public function index()
    {
        $kasir = Kasir::getKasir();
        return view('kasir.index', compact('kasir'));
    }

    // Menampilkan form untuk menambah kasir
    public function create()
    {
        return view('kasir.create');
    }

    // Menyimpan kasir baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        Kasir::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'kasir', // Secara default, role adalah 'kasir'
        ]);

        return redirect()->route('kasir.index');
    }

    // Menampilkan form untuk mengedit kasir
    public function edit($id)
    {
        $kasir = Kasir::findOrFail($id);
        return view('kasir.edit', compact('kasir'));
    }

    // Menyimpan perubahan data kasir
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $kasir = Kasir::findOrFail($id);
        $kasir->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $kasir->password,
        ]);

        return redirect()->route('kasir.index');
    }

    // Menghapus kasir
    public function destroy($id)
    {
        Kasir::findOrFail($id)->delete();
        return redirect()->route('kasir.index');
    }
}

