@extends('pages.tampilan')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Supplier</h1>

    <form action="{{ route('supplier.update', $supplier->Supplierid) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Supplier:</label>
            <input type="text" class="form-control" id="nama" name="Nama" value="{{ $supplier->Nama }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat:</label>
            <input type="text" class="form-control" id="alamat" name="Alamat" value="{{ $supplier->Alamat }}">
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon:</label>
            <input type="text" class="form-control" id="telepon" name="Telepon" value="{{ $supplier->Telepon }}">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
