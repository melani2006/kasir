<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kasir</title>

    <!-- BOOTSTRAP CDN langsung di sini -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h2 class="mb-4">Edit</h2>

        <form action="{{ route('kasir.update', $kasir->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ $kasir->name }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $kasir->email }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="password">Password <small class="text-muted">(Kosongkan jika tidak diganti)</small></label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="form-group mb-4">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('kasir.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

    <!-- Optional: JS Bootstrap buat interaksi -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
