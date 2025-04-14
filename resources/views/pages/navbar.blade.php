
<nav
    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar"
    >
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm"></i>
    </a>
    </div>

    <form action="{{ route('search') }}" method="GET" class="d-flex">
        <input type="hidden" name="page" value="{{ request()->routeIs('pelanggan.index') ? 'pelanggan' : (request()->routeIs('penjualan.index') ? 'penjualan' : '') }}">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" name="q" id="searchInput" class="form-control border-start-0"
                placeholder="Cari pelanggan, kategori, produk..." aria-label="Search"
                value="{{ request('q') ?? '' }}" required />
        </div>
    </form>

    <!-- Tambahkan ini di <head> kalau belum ada Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</nav>
