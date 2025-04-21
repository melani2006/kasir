@extends('pages.tampilan')

@section('content')
    <div class="container">
        <h2>Daftar Kasir</h2>
        <a href="{{ route('kasir.create') }}" class="btn btn-primary mb-3">Tambah</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kasir as $kasirItem)
                    <tr>
                        <td>{{ $kasirItem->name }}</td>
                        <td>{{ $kasirItem->email }}</td>
                        <td>
                            <a href="{{ route('kasir.edit', $kasirItem->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('kasir.destroy', $kasirItem->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
