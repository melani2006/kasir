<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan{{ $bulan }} Tahun {{ $tahun }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
            white-space: nowrap;
        }
        th {
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4 text-center">Laporan Penjualan - {{ date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) }}</h2>
        @if ($minggu !== 'all')
            <h3>Minggu ke-{{ $minggu }}</h3>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th>Jumlah Bayar</th>
                        <th>Kembalian</th>
                        <th>Metode Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualans as $penjualan)
                        <tr>
                            <td>{{ date('d-m-Y', strtotime($penjualan->TanggalPenjualan)) }}</td>
                            <td>Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($penjualan->JumlahBayar, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($penjualan->Kembalian, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($penjualan->MetodePembayaran) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
