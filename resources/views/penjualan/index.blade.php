@extends('pages.tampilan')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Daftar Penjualan</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($search)
            <p class="text-muted">Menampilkan hasil pencarian: <strong>{{ $search }}</strong></p>
    @endif

    <a href="{{ route('penjualan.create') }}" class="btn btn-primary mb-3">Tambah</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total Harga</th>
                <th>Jumlah Bayar</th>
                <th>Kembalian</th>
                <th>Metode Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualans as $index => $penjualan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $penjualan->TanggalPenjualan }}</td>
                <td>{{ $penjualan->pelanggan->NamaPelanggan ?? 'Tidak Diketahui' }}</td>
                <td>Rp {{ number_format($penjualan->TotalHarga, 2, ',', '.') }}</td>
                <td>Rp {{ number_format($penjualan->JumlahBayar, 2, ',', '.') }}</td>
                <td>Rp {{ number_format($penjualan->Kembalian, 2, ',', '.') }}</td>
                <td>{{ ucfirst($penjualan->MetodePembayaran) }}</td>
                <td>
                    <form action="{{ route('penjualan.struk', ['penjualanid' => $penjualan->penjualanid]) }}" method="GET" style="display: inline;">
                        <button type="submit" class="btn btn-primary">Struk</button>
                    </form>

                    <form action="{{ route('penjualan.destroy', $penjualan->penjualanid) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
