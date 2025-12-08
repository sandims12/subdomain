<!-- Tombol Toggle untuk Sidebar -->
<button id="sidebar-toggle" class="position-fixed top-0 start-0 mt-3 ms-3">
    <span class="toggle-dot"></span>
    <span class="toggle-dot"></span>
    <span class="toggle-dot"></span>
</button>

<!-- Sidebar -->
<div class="sidebar skpd-sidebar d-flex flex-column p-3 text-center" id="sidebar">
    <!-- Logo dan Judul Panel -->
    <div class="logo-wrapper mb-3">
        <img src="{{ asset('images/Lambang_Kabupaten_Indramayu.png') }}" 
             alt="Logo Indramayu" 
             style="width: 100px; height: auto; object-fit: contain; margin-top: 5px;"
             class="img-fluid mb-2">
        <h5 class="fw-bold text-primary mb-0">SEGALENGKO</h5>
        <small class="text-muted" style="font-size: 13px;">Sistem Pengajuan Layanan Elektronik dan Gangguan Kominfo</small>
    </div>

    <!-- Navigasi Menu -->
    <ul class="nav nav-pills flex-column mb-auto mt-3 text-start">
        <li class="nav-item">
            <a href="/skpd/dashboard"
               class="nav-link {{ request()->is('skpd/dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
        </li>
        <li>
    <a href="{{ route('skpd.template.index') }}"
       class="nav-link {{ request()->routeIs('skpd.template.index') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-text me-2"></i>
        Template Surat Pengajuan
    </a>
</li>




        <li>
            <a href="{{ route('skpd.permohonan.create') }}"
               class="nav-link {{ request()->routeIs('skpd.permohonan.create') ? 'active' : '' }}">
                <i class="bi bi-pencil-square"></i> Ajukan Permohonan
            </a>
        </li>

        <li>
            <a href="{{ route('skpd.permohonan.index') }}"
               class="nav-link {{ request()->routeIs('skpd.permohonan.index') ? 'active' : '' }}">
                <i class="bi bi-list-check"></i> Permohonan Saya
            </a>
        </li>

        <li>
            <a href="/skpd/subdomain"
               class="nav-link {{ request()->is('skpd/subdomain*') ? 'active' : '' }}">
                <i class="bi bi-globe2"></i> Subdomain Saya
            </a>
        </li>
    </ul>

    <hr>
</div>

<style>
    /* ====== TOGGLE BUTTON – 3 TITIK MINIMALIS ====== */
    #sidebar-toggle {
        width: 34px;
        height: 34px;
        padding: 0;
        border: none;
        border-radius: 999px;
        background: rgba(0, 0, 0, 0.35);       /* bulatan gelap transparan */
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 4px;                              /* jarak antar titik */
        cursor: pointer;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        transition: all 0.2s ease-in-out;
    }

    #sidebar-toggle:hover {
        transform: translateY(-1px);
        background: rgba(0, 0, 0, 0.55);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.35);
    }

    #sidebar-toggle:active {
        transform: translateY(1px) scale(0.96);
    }

    /* titik-titik di dalam button */
    #sidebar-toggle .toggle-dot {
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: #ffffff;
    }

    /* ====== SIDEBAR GLASS / TRANSPARAN (tetap seperti sebelumnya) ====== */
    .skpd-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        min-height: 100vh;
        background: transparent ;
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border-right: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.12);
        z-index: 999;
    }

    .skpd-sidebar .nav-link {
        border-radius: 0.75rem;
        font-weight: 500;
        color: #0b2340;
        padding: 0.6rem 0.9rem;
        margin-bottom: 0.25rem;
        transition: 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .skpd-sidebar .nav-link i {
        font-size: 1rem;
    }

    .skpd-sidebar .nav-link:hover {
        background: rgba(13, 110, 253, 0.12);
        color: #0b5ed7;
    }

.skpd-sidebar .nav-link.active {
    background: linear-gradient(135deg, #00b894, #0d6efd); /* hijau -> biru */
    color: #ffffff !important;
    box-shadow: 0 8px 18px rgba(13, 110, 253, 0.45);
}

</style>