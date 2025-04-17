@extends('pages.tampilan')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="mb-4">Tambah Produk</h2>

                <form action="{{ route('produk.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="NamaProduk" class="form-label">Nama Produk:</label>
                        <input type="text" name="NamaProduk" id="NamaProduk" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="Harga" class="form-label">Harga:</label>
                        <input type="number" name="Harga" id="Harga" class="form-control" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="Stok" class="form-label">Stok:</label>
                        <input type="number" name="Stok" id="Stok" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="Expired" class="form-label">Expired:</label>
                        <input type="date" name="Expired" id="Expired" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="Kategoriid" class="form-label">Kategori:</label>
                        <select name="Kategoriid" id="Kategoriid" class="form-select" required>
                            <option value="">-- Pilih Kategori Produk --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->Kategoriid }}">{{ $kategori->NamaKategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="Supplierid" class="form-label">Supplier:</label>
                        <select name="Supplierid" id="Supplierid" class="form-select" required>
                            <option value="">-- Pilih Supplier Produk --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->Supplierid }}">{{ $supplier->Nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
