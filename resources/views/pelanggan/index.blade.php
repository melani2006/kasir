@extends('pages.tampilan')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Pelanggan</h1>
        <a href="{{ route('pelanggan.create') }}" class="btn btn-success mb-3">Tambah</a>

        @if (session('success'))
            <div id="success-message" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if($search)
            <p class="text-muted">Menampilkan hasil pencarian: <strong>{{ $search }}</strong></p>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Nomor Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelanggans as $pelanggan)
                            <tr>
                                <td>{{ $pelanggan->NamaPelanggan }}</td>
                                <td>{{ $pelanggan->Alamat }}</td>
                                <td>{{ $pelanggan->NomorTelepon }}</td>
                                <td>
                                    <a href="{{ route('pelanggan.edit', $pelanggan->Pelangganid) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('pelanggan.destroy', $pelanggan->Pelangganid) }}" method="POST" style="display:inline;">
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
        </div>
    </div>
@endsection

@push('script')
    <script>
        setTimeout(function() {
            let alert = document.getElementById("success-message");
            if (alert) {
                alert.style.transition = "opacity 0.5s";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500);
            }
        }, 1000);
    </script>
@endpush
