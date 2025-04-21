@extends('pages.tampilan')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Laporan Penjualan</h2>

    <!-- Form Filter -->
    <form action="{{ route('penjualan.laporan') }}" method="GET" class="card p-4 shadow-sm">
        <div class="row align-items-end g-3">
            <div class="col-md-3">
                <label class="form-label">Tanggal Mulai:</label>
                <input type="date" name="tanggal_mulai" class="form-control" value="{{ $tanggal_mulai }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Selesai:</label>
                <input type="date" name="tanggal_selesai" class="form-control" value="{{ $tanggal_selesai }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                <a href="{{ route('penjualan.cetakLaporan', ['tanggal_mulai' => $tanggal_mulai, 'tanggal_selesai' => $tanggal_selesai]) }}" class="btn btn-danger w-100">Cetak PDF</a>
            </div>
        </div>
    </form>

    <!-- Tabel Laporan -->
    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
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
@endsection
