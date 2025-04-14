@extends('pages.tampilan')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="mb-4">Tambah Pelanggan</h2>

                <form action="{{ route('pelanggan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="NamaPelanggan" class="form-label">Nama:</label>
                        <input type="text" class="form-control" name="NamaPelanggan" required>
                    </div>
                    <div class="mb-3">
                        <label for="Alamat" class="form-label">Alamat:</label>
                        <input type="text" class="form-control" name="Alamat">
                    </div>
                    <div class="mb-3">
                        <label for="NomorTelepon" class="form-label">Nomor Telepon:</label>
                        <input type="number" class="form-control" name="NomorTelepon">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
