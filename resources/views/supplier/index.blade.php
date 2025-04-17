@extends('pages.tampilan')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Daftar Supplier</h1>

    <a href="{{ route('supplier.create') }}" class="btn btn-primary mb-3">Tambah</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suppliers as $supplier)
            <tr>
                <td>{{ $supplier->Nama }}</td>
                <td>{{ $supplier->Alamat }}</td>
                <td>{{ $supplier->Telepon }}</td>
                <td>
                    <a href="{{ route('supplier.edit', $supplier->Supplierid) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('supplier.destroy', $supplier->Supplierid) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
