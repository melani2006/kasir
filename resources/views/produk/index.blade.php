@extends('pages.tampilan')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Produk</h1>

        @if (session('success'))
            <div id="success-message" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if($search)
            <p class="text-muted">Menampilkan hasil pencarian: <strong>{{ $search }}</strong></p>
        @endif

        @if (auth()->user()->role === 'admin')
            <a href="{{ route('produk.create') }}" class="btn btn-success mb-3">Tambah</a>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Produk</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Expired</th>
                            <th>Kategori</th>
                            @if (auth()->user()->role === 'admin')
                                <th class="text-center text-nowrap">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produks as $produk)
                            <tr>
                                <td>{{ $produk->NamaProduk }}</td>
                                <td class="text-end">Rp{{ number_format($produk->Harga, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $produk->Stok }}</td>
                                <td class="text-center">{{ $produk->Expired ?? '-' }}</td>
                                <td>{{ $produk->kategori->NamaKategori ?? 'Tanpa Kategori' }}</td>
                                @if (auth()->user()->role === 'admin')
                                    <td class="text-center text-nowrap">
                                        <a href="{{ route('produk.edit', $produk->Produkid) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('produk.destroy', $produk->Produkid) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        setTimeout(() => {
            let successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.transition = 'opacity 0.5s';
                successMessage.style.opacity = '0';
                setTimeout(() => successMessage.remove(), 500);
            }
        }, 1000);
    </script>
@endpush
