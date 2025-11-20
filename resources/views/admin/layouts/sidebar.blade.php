<div class="sidebar-admin d-flex flex-column p-3 shadow-sm">

    {{-- LOGO ADMIN --}}
    <div class="text-center mb-4">
        <img src="{{ asset('images/reang.png') }}" 
             alt="Logo Admin" 
             class="img-fluid mb-2"
             style="height: 60px;">
        <h5 class="fw-bold text-primary mt-1 mb-0">ADMIN REANG</h5>
    </div>

    {{-- MENU --}}
    <ul class="nav nav-pills flex-column mb-auto">

        <li class="nav-item">
            <a href="/admin/dashboard"
               class="nav-link sidebar-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door me-2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="/admin/skpd"
               class="nav-link sidebar-link {{ request()->is('admin/skpd*') ? 'active' : '' }}">
                <i class="bi bi-building me-2"></i>
                <span>Data SKPD</span>
            </a>
        </li>

        <li>
            <a href="/admin/permohonan"
               class="nav-link sidebar-link {{ request()->is('admin/permohonan*') ? 'active' : '' }}">
                <i class="bi bi-envelope-paper me-2"></i>
                <span>Permohonan</span>
            </a>
        </li>

        <li>
            <a href="/admin/categories"
               class="nav-link sidebar-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                <i class="bi bi-folder me-2"></i>
                <span>Kategori</span>
            </a>
        </li>

        <li>
            <a href="/admin/subcategories"
               class="nav-link sidebar-link {{ request()->is('admin/subcategories*') ? 'active' : '' }}">
                <i class="bi bi-folder2-open me-2"></i>
                <span>Subkategori</span>
            </a>
        </li>

        <li>
            <a href="/admin/subdomain"
               class="nav-link sidebar-link {{ request()->is('admin/subdomain*') ? 'active' : '' }}">
                <i class="bi bi-globe2 me-2"></i>
                <span>Subdomain Aktif</span>
            </a>
        </li>

    </ul>
</div>

<style>
    .sidebar-admin {
        width: 250px;
        min-height: 100vh;
        background: #ffffff;
        border-right: 1px solid #e6e6e6;
        position: fixed;
    }

    .sidebar-admin img {
        filter: drop-shadow(0px 3px 4px rgba(0,0,0,0.1));
    }

    .sidebar-link {
        color: #333;
        font-size: 15px;
        padding: 10px 14px;
        border-radius: 10px;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        transition: 0.22s ease;
    }

    .sidebar-link i {
        font-size: 18px;
    }

    .sidebar-link:hover {
        background: #0d6efd;
        color: #fff !important;
        transform: translateX(4px);
        box-shadow: 0 6px 16px rgba(13,110,253,0.25);
    }

    .sidebar-link.active {
        background: #0d6efd;
        color: #fff !important;
        box-shadow: 0 6px 16px rgba(13,110,253,0.25);
    }
</style>