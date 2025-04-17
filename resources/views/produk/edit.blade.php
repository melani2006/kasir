<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Produk</h1>

        <form action="{{ route('produk.update', $produk->Produkid) }}" method="POST" class="card p-4 shadow-sm">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="NamaProduk" class="form-label">Nama Produk:</label>
                <input type="text" name="NamaProduk" id="NamaProduk" value="{{ $produk->NamaProduk }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="Harga" class="form-label">Harga:</label>
                <input type="number" name="Harga" id="Harga" value="{{ $produk->Harga }}" class="form-control" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="Stok" class="form-label">Stok:</label>
                <input type="number" name="Stok" id="Stok" value="{{ $produk->Stok }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="Expired" class="form-label">Expired:</label>
                <input type="date" name="Expired" id="Expired" value="{{ $produk->Expired }}" class="form-control">
            </div>

            <div class="mb-3">
                <label for="Kategoriid" class="form-label">Kategori:</label>
                <select name="Kategoriid" id="Kategoriid" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->Kategoriid }}" {{ $produk->Kategoriid == $kategori->Kategoriid ? 'selected' : '' }}>
                            {{ $kategori->NamaKategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="Supplierid" class="form-label">Supplier:</label>
                <select name="Supplierid" id="Supplierid" class="form-select" required>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->Supplierid }}" {{ $produk->Supplierid == $supplier->Supplierid ? 'selected' : '' }}>{{ $supplier->Nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
