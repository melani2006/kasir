@extends('pages.tampilan')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Laporan Penjualan</h2>

    <!-- Form Filter -->
    <form action="{{ route('penjualan.laporan') }}" method="GET" class="card p-4 shadow-sm">
        <div class="row align-items-end g-3">
            <div class="col-md-3">
                <label class="form-label">Minggu:</label>
                <select name="minggu" class="form-select">
                    <option value="all" {{ $minggu == 'all' ? 'selected' : '' }}>Semua Minggu</option>
                    <option value="1" {{ $minggu == '1' ? 'selected' : '' }}>Minggu 1</option>
                    <option value="2" {{ $minggu == '2' ? 'selected' : '' }}>Minggu 2</option>
                    <option value="3" {{ $minggu == '3' ? 'selected' : '' }}>Minggu 3</option>
                    <option value="4" {{ $minggu == '4' ? 'selected' : '' }}>Minggu 4</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Bulan:</label>
                <select name="bulan" class="form-select">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Tahun:</label>
                <select name="tahun" class="form-select">
                    @for ($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                <a href="{{ route('penjualan.cetakLaporan', ['bulan' => $bulan, 'tahun' => $tahun, 'minggu' => $minggu]) }}" class="btn btn-danger w-100">Cetak PDF</a>
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
@endsection
