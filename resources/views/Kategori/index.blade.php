@extends('pages.tampilan')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Kategori</h1>

        <!-- Tombol Tambah Kategori -->
        <a href="{{ route('kategori.create') }}" class="btn btn-success mb-3">Tambah</a>

        <!-- Notifikasi Pesan -->
        @if (session('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if($search)
            <p class="text-muted">Menampilkan hasil pencarian: <strong>{{ $search }}</strong></p>
        @endif

        <!-- Tabel Kategori -->
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategoris as $kategori)
                            <tr>
                                <td>{{ $kategori->NamaKategori }}</td>
                                <td>{{ $kategori->Deskripsi ?? 'Tidak Ada' }}</td>
                                <td>
                                    <a href="{{ route('kategori.edit', $kategori->Kategoriid) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('kategori.destroy', $kategori->Kategoriid) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">Hapus</button>
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
            let alert = document.getElementById("success-alert");
            if (alert) {
                alert.style.transition = "opacity 0.5s";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500);
            }
        }, 1000);
    </script>
@endpush
