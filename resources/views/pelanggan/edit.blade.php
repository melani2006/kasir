<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelanggan</title>
    <!-- Menambahkan link ke file CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Pelanggan</h1>
        <form action="{{ route('pelanggan.update', $pelanggan->Pelangganid) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="NamaPelanggan" class="form-label">Nama:</label>
                <input type="text" class="form-control" name="NamaPelanggan" value="{{ $pelanggan->NamaPelanggan }}" required>
            </div>
            <div class="mb-3">
                <label for="Alamat" class="form-label">Alamat:</label>
                <input type="text" class="form-control" name="Alamat" value="{{ $pelanggan->Alamat }}">
            </div>
            <div class="mb-3">
                <label for="NomorTelepon" class="form-label">Nomor Telepon:</label>
                <input type="text" class="form-control" name="NomorTelepon" value="{{ $pelanggan->NomorTelepon }}">
            </div>
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <!-- Menambahkan script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
