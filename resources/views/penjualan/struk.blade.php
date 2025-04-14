<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .struk { width: 300px; padding: 10px; border: 1px solid #000; }
        .judul { text-align: center; font-size: 18px; font-weight: bold; }
        .total { font-size: 16px; font-weight: bold; text-align: right; }
        .center { text-align: center; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <div class="struk">
        <div class="judul">Toko XYZ</div>
        <div class="center">Jl. Contoh No. 123, Kota ABC</div>
        <hr>
        <p><strong>Tanggal:</strong> {{ $penjualan->TanggalPenjualan }}</p>
        <p><strong>Pelanggan:</strong> {{ $penjualan->pelanggan->NamaPelanggan ?? 'Umum' }}</p>
        <hr>
        <table width="100%">
            <tr>
                <th>Barang</th>
                <th class="right">Jumlah</th>
                <th class="right">Subtotal</th>
            </tr>
            @foreach ($penjualan->detailPenjualans as $detail)
                <tr>
                    <td>{{ $detail->produk->NamaProduk ?? 'Produk Tidak Ditemukan' }}</td>
                    <td class="right">{{ $detail->JumlahProduk }}</td>
                    <td class="right">Rp{{ number_format($detail->Subtotal ?? 0, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>
        <hr>
        <p class="total">Total: Rp{{ number_format($penjualan->TotalHarga ?? 0, 0, ',', '.') }}</p>
        <p class="total">Bayar: Rp{{ number_format($penjualan->JumlahBayar ?? 0, 0, ',', '.') }}</p>
        <p class="total">Kembalian: Rp{{ number_format($penjualan->Kembalian ?? 0, 0, ',', '.') }}</p>
        <hr>
        <div class="center">Terima Kasih!</div>
    </div>

    <script>
        window.onload = function () {
            setTimeout(() => window.print(), 500); // Tambah delay biar user bisa lihat dulu sebelum print
        };
    </script>
</body>
</html>
