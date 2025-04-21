<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - {{ date('d F Y', strtotime($tanggal_mulai)) }} - {{ date('d F Y', strtotime($tanggal_selesai)) }}</title>
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
        <h2 class="mb-4 text-center">Laporan Penjualan</h2>
        <h4 class="mb-4 text-center">{{ date('d F Y', strtotime($tanggal_mulai)) }} - {{ date('d F Y', strtotime($tanggal_selesai)) }}</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th>Metode Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualans as $penjualan)
                        <tr>
                            <td>{{ date('d-m-Y', strtotime($penjualan->TanggalPenjualan)) }}</td>
                            <td>Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($penjualan->MetodePembayaran) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td><strong>Total Keseluruhan</strong></td>
                        <td><strong>Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</strong></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
