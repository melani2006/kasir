@extends('pages.tampilan')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
.dashboard-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: stretch;
    gap: 20px; /* Kurangi gap */
    padding: 10px;
}



    .card {
        flex: 1 1 250px; /* Lebar fleksibel */
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 15px;
        transition: transform 0.3s ease;
        text-align: center;

    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 15px;

    }

    .icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 22px;
        color: white;
        margin-bottom: 10px;
    }

    .card-content {
        display: flex;
        flex-direction: column;
    }

    .card h2 {
        color: #555;
        font-size: 16px;
        margin: 0;
    }

    .card p {
        font-size: 24px;
        font-weight: bold;
        color: #555;
        margin: 0;
    }

    /* Warna Ikon */
    .icon.pelanggan { background: #00C853; } /* Hijau */
    .icon.penjualan { background: #2196F3; } /* Biru */
    .icon.produk { background: #FFD600; } /* Kuning */
</style>

@php
    use Carbon\Carbon;
    \Carbon\Carbon::setLocale('id');
@endphp

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-0">
            <div class="card">
                <div class="d-flex align-items-center p-4 justify-content-between">
                    <div class="text-start">
                        <h4 class="mb-1">Halo {{ auth()->check() ? (auth()->user()->role === 'admin' ? 'Admin' : auth()->user()->name) : 'User' }}</h4>
                        <h4 class="text-muted fw-bold mb-1">{{ Carbon::now()->translatedFormat('l, d F Y') }}</h4>
                        <small class="text-muted">*) Laporan Hari Ini</small>
                    </div>
                    <img src="{{ asset('assets/img/illustrations/kasir.jpg') }}" height="140" alt="Kasir">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="dashboard-container">
    <div class="card">
        <div class="card-header">
            <div class="icon pelanggan">
                <i class="fas fa-users"></i>
            </div>
            <h2>Pelanggan</h2>
            <p>{{ $jumlahPelanggan }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="icon penjualan">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h2>Penjualan</h2>
            <p>{{ $jumlahPenjualan }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="icon produk">
                <i class="fas fa-box"></i>
            </div>
            <h2>Produk</h2>
            <p>{{ $jumlahProduk }}</p>
        </div>
    </div>
</div>

<div class="dashboard-container">
    <div class="card" style="width: 100%; max-width: 400px; margin: auto;">
        <div style="position: relative; width: 100%; height: 400px;">
            <canvas id="chartProduk"></canvas>
        </div>
    </div>

    <div class="card" style="border-radius: 10px; overflow: hidden;">
        <div class="card-header" style="background: #d32f2f; color: white; text-align: center; padding: 15px;">

            <h3 style="margin: 0; font-weight: bold; color: white;"><i class="fas fa-calendar-alt" style="font-size: 30px; margin-bottom: 5px;"></i> Produk Expired</h3>
        </div>

        <div class="card-body" style="padding: 15px;">
            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                <thead>
                    <tr style="background: #f5f5f5; border-bottom: 2px solid #ddd;">
                        <th style="padding: 12px; font-weight: bold; color: #333;">Produk</th>
                        <th style="padding: 12px; font-weight: bold; color: #333;">Expired</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produks as $produk)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 12px; color: #333;">{{ $produk->NamaProduk }}</td>
                            <td style="padding: 12px; color: #d32f2f; font-weight: bold;">
                                {{ \Carbon\Carbon::parse($produk->Expired)->format('Y-m-d') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="padding: 12px; color: #999; font-style: italic;">
                                Tidak ada produk yang akan expired dalam setahun
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById("chartProduk").getContext("2d");
        var chartProduk = new Chart(ctx, {
            type: "bar",
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: "Jumlah Penjualan",
                    data: {!! json_encode($data) !!},
                    backgroundColor: "#2196F3",
                    borderRadius: 5,
                    barThickness: "flex",
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: "📊 Produk Terlaris Bulan Ini",
                        font: { size: 18, weight: "bold" },
                        color: "#333"
                    }
                },
                scales: { x: { grid: { display: false } }, y: { beginAtZero: true, ticks: { stepSize: 5 } } }
            }
        });
    });
</script>
@endsection
