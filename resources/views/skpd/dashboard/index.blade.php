<div class="skpd-dashboard-wrapper position-relative">

    {{-- VIDEO BACKGROUND --}}
    <video autoplay muted loop playsinline id="skpd-bg-video">
        <source src="{{ asset('videos/alun_alun_indramayu.mp4') }}" type="video/mp4">
        Browser Anda tidak mendukung video HTML5.
    </video>

    {{-- LAPISAN GELAP TIPIS BIAR TEKS TERBACA --}}
    

    {{-- KONTEN DASHBOARD --}}
    <div class="container-fluid px-4 py-4 skpd-dashboard-content">
        <!-- Header -->
        <div class="text-center mb-5">
            <img src="{{ asset('images/reang.png') }}" alt="Logo Indramayu"
                 class="img-fluid mb-3" style="max-height: 100px;">
            <h2 class="fw-bold text-primary mb-1 text-uppercase">
                Selamat Datang, {{ strtoupper(Auth::user()->name) }}
            </h2>
            <p class="text-light mb-0 fs-6">
                Dashboard Aplikasi Pengajuan Subdomain SKPD Kabupaten Indramayu   
            </p>
            <div class="mx-auto mt-3"
                 style="width: 80px; height: 4px; background-color: #ffffff; border-radius: 10px;"></div>
        </div>

        <!-- Statistik -->
        <div class="row g-4 mb-3 text-center">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 stat-card p-3">
                    <div class="card-body">
                        <div class="stat-icon stat-icon-primary mb-3">
                            <i class="bi bi-globe"></i>
                        </div>
                        <h6 class="text-secondary mb-1">Subdomain Dimiliki</h6>
                        <h2 class="fw-bold text-primary mb-0">{{ $totalSubdomain }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 stat-card p-3">
                    <div class="card-body">
                        <div class="stat-icon stat-icon-success mb-3">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <h6 class="text-secondary mb-1">Subdomain Aktif</h6>
                        <h2 class="fw-bold text-success mb-0">{{ $subdomainAktif }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 stat-card p-3">
                    <div class="card-body">
                        <div class="stat-icon stat-icon-warning mb-3">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <h6 class="text-secondary mb-1">Permohonan Menunggu</h6>
                        <h2 class="fw-bold text-warning mb-0">{{ $permohonanMenunggu }}</h2>
                    </div>
                </div>
            </div>
        </div>

{{-- CSS KHUSUS DASHBOARD VIDEO --}}
<style>
    .skpd-dashboard-wrapper {
        position: relative;
        min-height: 100vh;
        overflow: hidden;
    }

    #skpd-bg-video {
    position: fixed;
    top: 0;
    left: 0;
    min-width: 100%;
    min-height: 100%;
    object-fit: cover;
    z-index: -2;
    /* 🔆 lebih terang dari 0.7 ke 0.9 */
    filter: brightness(0.9);
}

.skpd-bg-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    /* 🔆 kurangi gelapnya overlay */
    background:
        radial-gradient(circle at top, rgba(255,255,255,0.07), transparent 55%),
        linear-gradient(to bottom, rgba(0,0,0,0.25), rgba(0,0,0,0.45));
    z-index: -1;
}


    .skpd-dashboard-content {
        position: relative;
        z-index: 1;
        color: #fff;
    }

    /* Kartu statistik efek glassmorphism */
    .stat-card {
        background: rgba(255, 255, 255, 0.88);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        transition: 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 25px rgba(0, 0, 0, 0.18);
    }

    .stat-card h6 {
        letter-spacing: 0.03em;
        text-transform: uppercase;
        font-size: 0.75rem;
    }
</style>
