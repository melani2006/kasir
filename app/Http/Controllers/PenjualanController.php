<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\DetailPenjualan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $penjualans = Penjualan::with(['pelanggan', 'detailPenjualans.produk']);

        if ($search) {
            $penjualans->whereHas('pelanggan', function ($q) use ($search) {
                $q->where('NamaPelanggan', 'like', "%{$search}%");
            });
        }

        $penjualans = $penjualans->get();

        return view('penjualan.index', compact('penjualans', 'search'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();
        return view('penjualan.create', compact('pelanggans', 'produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'TanggalPenjualan' => 'required|date',
            'JumlahBayar' => 'required|numeric|min:0',
            'MetodePembayaran' => 'required|in:cash,debit,e-wallet,dana',
            'StatusMember' => 'required|in:Member,No Member',
            'Pelangganid' => 'nullable|exists:pelanggans,Pelangganid',
            'Produkid' => 'required|array',
            'Produkid.*' => 'exists:produks,Produkid',
            'JumlahProduk' => 'required|array',
            'JumlahProduk.*' => 'required|integer|min:1',
        ]);

        if ($request->StatusMember === 'Member' && !$request->Pelangganid) {
            return back()->with('error', 'Pilih pelanggan jika status Member.');
        }

        $penjualan = Penjualan::create([
            'TanggalPenjualan' => $request->TanggalPenjualan,
            'TotalHarga' => 0, // sementara
            'JumlahBayar' => $request->JumlahBayar,
            'Kembalian' => 0, // sementara
            'MetodePembayaran' => $request->MetodePembayaran,
            'StatusMember' => $request->StatusMember,
            'Pelangganid' => $request->StatusMember === 'Member' ? $request->Pelangganid : null,
        ]);

        $totalHarga = 0;

        foreach ($request->Produkid as $index => $Produkid) {
            $produk = Produk::findOrFail($Produkid);
            $jumlah = $request->JumlahProduk[$index];

            if ($produk->Stok < $jumlah) {
                $penjualan->delete();
                return back()->with('error', "Stok produk {$produk->NamaProduk} tidak mencukupi!");
            }

            $subtotal = $produk->Harga * $jumlah;
            $totalHarga += $subtotal;

            DetailPenjualan::create([
                'penjualanid' => $penjualan->penjualanid,
                'Produkid' => $produk->Produkid,
                'JumlahProduk' => $jumlah,
                'Subtotal' => $subtotal,
            ]);

            $produk->decrement('Stok', $jumlah);
        }

        $kembalian = max($request->JumlahBayar - $totalHarga, 0);

        $penjualan->update([
            'TotalHarga' => $totalHarga,
            'Kembalian' => $kembalian,
        ]);

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function destroy(Penjualan $penjualan)
    {
        foreach ($penjualan->detailPenjualans as $detail) {
            $detail->produk->increment('Stok', $detail->JumlahProduk);
        }

        $penjualan->detailPenjualans()->delete();
        $penjualan->delete();

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function struk($penjualanid)
    {
        $penjualan = Penjualan::findOrFail($penjualanid);
        return view('penjualan.struk', compact('penjualan'));
    }

    public function laporan(Request $request)
{
    $tanggal_mulai = $request->input('tanggal_mulai');
    $tanggal_selesai = $request->input('tanggal_selesai');

    $penjualans = Penjualan::query();

    // Menambahkan filter berdasarkan Tanggal Masuk dan Tanggal Keluar
    if ($tanggal_mulai && $tanggal_selesai) {
        $penjualans->whereBetween('TanggalPenjualan', [$tanggal_mulai, $tanggal_selesai]);
    }

    $penjualans = $penjualans->get();

    // Menghitung total keseluruhan
    $totalKeseluruhan = $penjualans->sum('TotalHarga');

    return view('penjualan.laporan', compact('penjualans', 'tanggal_mulai', 'tanggal_selesai', 'totalKeseluruhan'));
}

public function cetakLaporan(Request $request)
{
    $tanggal_mulai = $request->input('tanggal_mulai');
    $tanggal_selesai = $request->input('tanggal_selesai');

    $penjualans = Penjualan::query();

    // Menambahkan filter berdasarkan Tanggal Masuk dan Tanggal Keluar
    if ($tanggal_mulai && $tanggal_selesai) {
        $penjualans->whereBetween('TanggalPenjualan', [$tanggal_mulai, $tanggal_selesai]);
    }

    $penjualans = $penjualans->get();

    // Menghitung total keseluruhan
    $totalKeseluruhan = $penjualans->sum('TotalHarga');

    $pdf = Pdf::loadView('penjualan.cetak-laporan', compact('penjualans', 'tanggal_mulai', 'tanggal_selesai', 'totalKeseluruhan'));

    return $pdf->download("Laporan_Penjualan_{$tanggal_mulai}_{$tanggal_selesai}.pdf");
}
}
