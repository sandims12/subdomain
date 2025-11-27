<div class="skpd-dashboard-wrapper position-relative">

    {{-- 🎥 VIDEO BACKGROUND --}}
    <video autoplay muted loop playsinline id="skpd-bg-video">
        <source src="{{ asset('videos/alun_alun_indramayu.mp4') }}" type="video/mp4">
        Browser Anda tidak mendukung video HTML5.
    </video>

    {{-- 🌫️ LAPISAN OVERLAY --}}
    <div class="skpd-bg-overlay"></div>

    {{-- 🧭 KONTEN DASHBOARD --}}
    <div class="container-fluid px-4 py-4 skpd-dashboard-content">
        <!-- Header -->
        <div class="text-center mb-5">
            <img src="{{ asset('images/reang.png') }}" alt="Logo Indramayu"
                 class="img-fluid mb-3" style="max-height: 100px;">
            
            {{-- Greeting Dinamis --}}
            @php
                $hour = date('H');
                $greeting = $hour < 12 ? 'Selamat Pagi' : ($hour < 18 ? 'Selamat Siang' : 'Selamat Malam');
            @endphp
            <h2 class="fw-bold text-primary mb-1 text-uppercase">
                {{ $greeting }}, {{ strtoupper(Auth::user()->name) }}
            </h2>

            <p class="text-light mb-0 fs-6">
                Dashboard Sistem Pengajuan Layanan Elektronik dan Gangguan Kominfo 
            </p>

            <div class="mx-auto mt-3 garis-putih"></div>
        </div>

        <!-- Statistik -->
        <div class="row g-4 mb-3 text-center">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 stat-card p-4">
                    <div class="card-body">
                        <div class="stat-icon text-primary mb-3">
                            <i class="bi bi-globe fs-1"></i>
                        </div>
                        <h6 class="text-secondary mb-1">Permohonan Dimiliki</h6>
                        <h2 class="fw-bold text-primary mb-0">{{ $totalSubdomain }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 stat-card p-4">
                    <div class="card-body">
                        <div class="stat-icon text-success mb-3">
                            <i class="bi bi-check-circle fs-1"></i>
                        </div>
                        <h6 class="text-secondary mb-1">Permohonan Disetujui</h6>
                        <h2 class="fw-bold text-success mb-0">{{ $subdomainAktif }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 stat-card p-4">
                    <div class="card-body">
                        <div class="stat-icon text-warning mb-3">
                            <i class="bi bi-hourglass-split fs-1"></i>
                        </div>
                        <h6 class="text-secondary mb-1">Permohonan Menunggu</h6>
                        <h2 class="fw-bold text-warning mb-0">{{ $permohonanMenunggu }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 🌟 CSS KHUSUS DASHBOARD --}}
    <style>
        /* --- Wrapper --- */
        .skpd-dashboard-wrapper {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
        }

        /* --- Video --- */
        #skpd-bg-video {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
            z-index: -2;
            filter: brightness(0.9);
        }

        /* --- Overlay lembut --- */
        .skpd-bg-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at top, rgba(255,255,255,0.07), transparent 55%),
                linear-gradient(to bottom, rgba(0,0,0,0.25), rgba(0,0,0,0.45));
            z-index: -1;
        }

        /* --- Konten --- */
        .skpd-dashboard-content {
            position: relative;
            z-index: 1;
            color: #fff;
            text-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        /* --- Garis putih di bawah header --- */
        .garis-putih {
            width: 90px;
            height: 4px;
            background-color: #ffffff;
            border-radius: 10px;
        }

        /* --- Kartu Statistik (Glass Effect) --- */
        .stat-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: all 0.3s ease-in-out;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 25px rgba(0, 0, 0, 0.2);
        }

        /* --- Icon --- */
        .stat-icon i {
            filter: drop-shadow(0 6px 10px rgba(0,0,0,0.15));
        }

        /* --- Teks Judul --- */
        .stat-card h6 {
            letter-spacing: 0.03em;
            text-transform: uppercase;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* --- Responsif --- */
        @media (max-width: 768px) {
            .skpd-dashboard-content {
                padding-top: 2rem;
            }
            .stat-card {
                padding: 1.5rem !important;
            }
            .stat-icon i {
                font-size: 1.8rem !important;
            }
        }
    </style>

</div>
