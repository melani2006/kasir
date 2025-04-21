@extends('pages.tampilan')

@section('content')
<div class="container mt-4">
    <h2>Tambah Penjualan</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penjualan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="TanggalPenjualan" class="form-label">Tanggal Penjualan</label>
            <input type="date" name="TanggalPenjualan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status Member</label>
            <div>
                <input type="radio" id="noMember" name="StatusMember" value="No Member" checked>
                <label for="noMember">No Member</label>
                <input type="radio" id="member" name="StatusMember" value="Member">
                <label for="member">Member</label>
            </div>
        </div>

        <div class="mb-3" id="PelangganContainer" style="display: none;">
            <label for="Pelangganid" class="form-label">Pelanggan</label>
            <select name="Pelangganid" class="form-select">
                <option value="" disabled selected>Pilih Pelanggan</option>
                @foreach ($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->Pelangganid }}">{{ $pelanggan->NamaPelanggan }}</option>
                @endforeach
            </select>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="produk-list">
                <tr class="produk-item">
                    <td>
                        <select name="Produkid[]" class="form-select produk-select" required>
                            <option value="" disabled selected>Pilih Produk</option>
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->Produkid }}" data-harga="{{ $produk->Harga }}">{{ $produk->NamaProduk }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control harga-produk" readonly>
                    </td>
                    <td>
                        <input type="number" name="JumlahProduk[]" class="form-control jumlah-produk" min="1" required>
                    </td>
                    <td>
                        <input type="text" name="Subtotal[]" class="form-control subtotal-produk" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger remove-produk">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-success" id="add-produk">Tambah Produk</button>

        <div class="mb-3 mt-3">
            <label for="TotalHarga" class="form-label">Total Harga</label>
            <input type="text" id="TotalHarga" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label for="JumlahBayar" class="form-label">Jumlah Bayar</label>
            <input type="number" name="JumlahBayar" id="JumlahBayar" class="form-control" min="1">
        </div>

        <div class="mb-3">
            <label for="Kembalian" class="form-label">Kembalian</label>
            <input type="text" id="Kembalian" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label for="MetodePembayaran" class="form-label">Metode Pembayaran</label>
            <select name="MetodePembayaran" class="form-select" required>
                <option value="cash">Cash</option>
                <option value="debit">Debit</option>
                <option value="e-wallet">E-Wallet</option>
                <option value="dana">DANA</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const produkList = document.getElementById("produk-list");

        function hitungSubtotal(row) {
            const harga = parseFloat(row.querySelector(".harga-produk").value) || 0;
            const jumlah = parseInt(row.querySelector(".jumlah-produk").value) || 0;
            const subtotal = harga * jumlah;
            row.querySelector(".subtotal-produk").value = subtotal.toFixed(2);
            hitungTotal();
        }

        function hitungTotal() {
            let total = 0;
            document.querySelectorAll(".subtotal-produk").forEach(el => {
                total += parseFloat(el.value) || 0;
            });
            document.getElementById("TotalHarga").value = total.toFixed(2);
            hitungKembalian();
        }

        function hitungKembalian() {
            const total = parseFloat(document.getElementById("TotalHarga").value) || 0;
            const bayar = parseFloat(document.getElementById("JumlahBayar").value) || 0;
            const kembalian = Math.max(bayar - total, 0);
            document.getElementById("Kembalian").value = kembalian.toFixed(2);
        }

        produkList.addEventListener("change", function (e) {
            if (e.target.classList.contains("produk-select")) {
                const row = e.target.closest("tr");
                const harga = e.target.selectedOptions[0].getAttribute("data-harga") || 0;
                row.querySelector(".harga-produk").value = harga;
                hitungSubtotal(row);
            }
        });

        produkList.addEventListener("input", function (e) {
            if (e.target.classList.contains("jumlah-produk")) {
                const row = e.target.closest("tr");
                hitungSubtotal(row);
            }
        });

        document.getElementById("add-produk").addEventListener("click", function () {
            const template = document.querySelector(".produk-item");
            const newRow = template.cloneNode(true);

            newRow.querySelector(".produk-select").value = "";
            newRow.querySelector(".harga-produk").value = "";
            newRow.querySelector(".jumlah-produk").value = "";
            newRow.querySelector(".subtotal-produk").value = "";

            produkList.appendChild(newRow);
        });

        produkList.addEventListener("click", function (e) {
            if (e.target.classList.contains("remove-produk")) {
                const row = e.target.closest("tr");
                if (document.querySelectorAll(".produk-item").length > 1) {
                    row.remove();
                    hitungTotal();
                }
            }
        });

        document.getElementById("JumlahBayar").addEventListener("input", hitungKembalian);

        // Toggle pelanggan
        const pelangganContainer = document.getElementById("PelangganContainer");
        const statusRadios = document.querySelectorAll('input[name="StatusMember"]');

        function togglePelanggan() {
            const selected = document.querySelector('input[name="StatusMember"]:checked').value;
            if (selected === "Member") {
                pelangganContainer.style.display = "block";
            } else {
                pelangganContainer.style.display = "none";
                pelangganContainer.querySelector("select").selectedIndex = 0;
            }
        }

        statusRadios.forEach(radio => radio.addEventListener("change", togglePelanggan));
        togglePelanggan(); // initial
    });
</script>
@endsection
