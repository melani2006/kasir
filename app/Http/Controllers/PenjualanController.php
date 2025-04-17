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

        $totalHarga = 0;
        $produkTerpilih = [];

        foreach ($request->Produkid as $index => $Produkid) {
            $produk = Produk::findOrFail($Produkid);
            $jumlah = $request->JumlahProduk[$index];

            if ($produk->Stok < $jumlah) {
                return back()->with('error', "Stok produk {$produk->NamaProduk} tidak mencukupi!");
            }

            $subtotal = $produk->Harga * $jumlah;
            $totalHarga += $subtotal;
            $produkTerpilih[] = ['produk' => $produk, 'jumlah' => $jumlah, 'subtotal' => $subtotal];
        }

        $kembalian = max($request->JumlahBayar - $totalHarga, 0);

        $penjualan = Penjualan::create([
            'TanggalPenjualan' => $request->TanggalPenjualan,
            'TotalHarga' => $totalHarga,
            'JumlahBayar' => $request->JumlahBayar,
            'Kembalian' => $kembalian,
            'MetodePembayaran' => $request->MetodePembayaran,
            'Pelangganid' => $request->StatusMember === 'Member' ? $request->Pelangganid : null,
            'StatusMember' => $request->StatusMember,
        ]);

        foreach ($produkTerpilih as $item) {
            DetailPenjualan::create([
                'penjualanid' => $penjualan->penjualanid,
                'Produkid' => $item['produk']->Produkid,
                'JumlahProduk' => $item['jumlah'],
                'Subtotal' => $item['subtotal'],
            ]);

            $item['produk']->decrement('Stok', $item['jumlah']);
        }

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
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        $minggu = $request->input('minggu', 'all');

        $penjualans = Penjualan::whereYear('TanggalPenjualan', $tahun)
            ->whereMonth('TanggalPenjualan', $bulan);

        if ($minggu !== 'all') {
            $penjualans->whereRaw(
                'WEEK(TanggalPenjualan, 1) - WEEK(DATE_SUB(TanggalPenjualan, INTERVAL DAYOFMONTH(TanggalPenjualan)-1 DAY), 1) + 1 = ?',
                [$minggu]
            );
        }

        $penjualans = $penjualans->get();

        return view('penjualan.laporan', compact('penjualans', 'bulan', 'tahun', 'minggu'));
    }

    public function cetakLaporan(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        $minggu = $request->input('minggu', 'all');

        $penjualans = Penjualan::whereYear('TanggalPenjualan', $tahun)
            ->whereMonth('TanggalPenjualan', $bulan);

        if ($minggu !== 'all') {
            $penjualans->whereRaw(
                'WEEK(TanggalPenjualan, 1) - WEEK(DATE_SUB(TanggalPenjualan, INTERVAL DAYOFMONTH(TanggalPenjualan)-1 DAY), 1) + 1 = ?',
                [$minggu]
            );
        }

        $penjualans = $penjualans->get();

        $pdf = Pdf::loadView('penjualan.cetak-laporan', compact('penjualans', 'bulan', 'tahun', 'minggu'));

        return $pdf->download("Laporan_Penjualan_{$bulan}_{$tahun}_minggu_{$minggu}.pdf");
    }
}
