@extends('pages.tampilan')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="mb-4">Tambah Kategori</h2>

                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="NamaKategori" class="form-label">Nama Kategori:</label>
                        <input type="text" name="NamaKategori" class="form-control" maxlength="100" required>
                    </div>

                    <div class="mb-3">
                        <label for="Deskripsi" class="form-label">Deskripsi (Opsional):</label>
                        <textarea name="Deskripsi" class="form-control" rows="3" maxlength="255"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
