<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo" style="width: 55px; height: 55px;">
                <img src="../assets/img/favicon/logo apk.png" alt="Logo apk" style="width: 100%; height: 100%; object-fit: contain;">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2" style="font-size: 1rem;">The Cashy Store</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>

    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard (Admin & Petugas) -->
        @if (in_array(auth()->user()->role, ['admin', 'petugas']))
        <li class="menu-item {{ request()->routeIs('pages.dashboard') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>
        @endif

        <!-- Menu Header "Pages" (Admin & Petugas) -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>

        <!-- Menu Khusus Admin -->
        @if (auth()->user()->role == 'admin')
        <li class="menu-item {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
            <a href="{{ route('pelanggan.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div>Pelanggan</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
            <a href="{{ route('kategori.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div>Kategori</div>
            </a>
        </li>
        @endif

        <!-- Produk, Penjualan, Laporan (Admin & Petugas) -->
        @if (in_array(auth()->user()->role, ['admin', 'petugas']))
        <li class="menu-item {{ request()->routeIs('produk.*') ? 'active' : '' }}">
            <a href="{{ route('produk.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div>Produk</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('penjualan.*') ? 'active' : '' }}">
            <a href="{{ route('penjualan.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cart"></i>
                <div>Penjualan</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('penjualan.laporan') ? 'active' : '' }}">
            <a href="{{ route('penjualan.laporan') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div>Laporan</div>
            </a>
        </li>
        @endif

        <!-- Logout (Semua role) -->
        <li class="menu-item">
            <form action="{{ route('logout') }}" method="post" style="margin: 0;">
                @csrf
                <a href="javascript:void(0);" class="menu-link"
                   onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="menu-icon tf-icons bx bx-log-out"></i>
                    <div>Keluar</div>
                </a>
            </form>
        </li>
    </ul>
</aside>
