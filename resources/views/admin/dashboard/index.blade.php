@extends('admin.layouts.wrapper')

@section('content')
    @php
        $userName       = auth()->user()->name ?? 'Admin';
        $total          = max($totalPermohonan, 1);
        $persenSetuju   = round($permohonanDisetujui / $total * 100);
        $persenMenunggu = round($permohonanMenunggu / $total * 100);
        $persenTolak    = round($permohonanDitolak / $total * 100);
    @endphp

    {{-- Banner Logo + Nama User --}}
    <div class="container-fluid mt-2">
        <div class="alert alert-warning bg-white text-black text-center">
            <img src="{{ asset('vendor/publish/imyu.png') }}"
                 class="rounded-image"
                 width="200"
                 height="auto"
                 alt="logo.jpg">

            <div class="mt-2 fs-1 fw-bold">
                <strong>Halo, {{ $userName }}</strong>
            </div>

            <p class="mb-0 text-muted small">
                Selamat datang di panel pengelolaan subdomain pemerintah daerah.
            </p>
        </div>
    </div>

    <div class="container-fluid mt-4">

        {{-- ROW 1: Kartu ringkasan di atas --}}
        <div class="row g-3 mb-4">

            <div class="col-md-2 col-sm-4">
                <div class="dash-stat-card">
                    <div class="dash-stat-icon bg-primary-soft">
                        <i class="bi bi-building text-primary"></i>
                    </div>
                    <p class="label">Total SKPD</p>
                    <h4 class="value">{{ $totalSkpd }}</h4>
                </div>
            </div>

            <div class="col-md-2 col-sm-4">
                <div class="dash-stat-card">
                    <div class="dash-stat-icon bg-info-soft">
                        <i class="bi bi-file-earmark-text text-info"></i>
                    </div>
                    <p class="label">Total Permohonan</p>
                    <h4 class="value">{{ $totalPermohonan }}</h4>
                </div>
            </div>

            <div class="col-md-2 col-sm-4">
                <div class="dash-stat-card">
                    <div class="dash-stat-icon bg-success-soft">
                        <i class="bi bi-check-circle text-success"></i>
                    </div>
                    <p class="label">Disetujui</p>
                    <h4 class="value">{{ $permohonanDisetujui }}</h4>
                </div>
            </div>

            <div class="col-md-2 col-sm-4">
                <div class="dash-stat-card">
                    <div class="dash-stat-icon bg-danger-soft">
                        <i class="bi bi-x-circle text-danger"></i>
                    </div>
                    <p class="label">Ditolak</p>
                    <h4 class="value">{{ $permohonanDitolak }}</h4>
                </div>
            </div>

            <div class="col-md-2 col-sm-4">
                <div class="dash-stat-card">
                    <div class="dash-stat-icon bg-warning-soft">
                        <i class="bi bi-hourglass-split text-warning"></i>
                    </div>
                    <p class="label">Menunggu</p>
                    <h4 class="value">{{ $permohonanMenunggu }}</h4>
                </div>
            </div>

            <div class="col-md-2 col-sm-4">
                <div class="dash-stat-card">
                    <div class="dash-stat-icon bg-primary-soft">
                        <i class="bi bi-hdd-network text-primary"></i>
                    </div>
                    <p class="label">Subdomain Aktif</p>
                    <h4 class="value">{{ $subdomainAktif }}</h4>
                </div>
            </div>

        </div>

        {{-- ROW 2: Grafik + Weekly Stats --}}
        <div class="row g-4">

            {{-- Kiri: Grafik Overview (ala CodePen Pygbbm) --}}
            <div class="col-lg-8">
                <div class="dash-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-0">Permohonan Overview</h5>
                            <small class="text-muted">Perbandingan status permohonan</small>
                        </div>
                        <div class="d-flex align-items-center gap-3 small text-muted">
                            <span><span class="legend-dot legend-approve"></span> Disetujui</span>
                            <span><span class="legend-dot legend-pending"></span> Menunggu</span>
                            <span><span class="legend-dot legend-reject"></span> Ditolak</span>
                        </div>
                    </div>

                    {{-- GRAFIK ANIMASI ala Pygbbm --}}
                    <div class="animated-graph-wrapper">
                        <svg class="animated-graph-svg" width="529px" height="286px"
                             viewBox="30 27 529 286" xmlns="http://www.w3.org/2000/svg">
                            <g id="graph-copy" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                               transform="translate(30, 27)">
                                {{-- Axis Y --}}
                                <g id="y_axis" font-size="11" fill="#FFFFFF" opacity="0.4">
                                    <text><tspan x="25.3" y="264.3">0</tspan></text>
                                    <text><tspan x="12.8" y="232.7">200</tspan></text>
                                    <text><tspan x="12.8" y="201">400</tspan></text>
                                    <text><tspan x="12.8" y="169.3">600</tspan></text>
                                    <text><tspan x="12.8" y="137.7">800</tspan></text>
                                    <text><tspan x="6.5" y="106">1000</tspan></text>
                                    <text><tspan x="6.5" y="74.3">1200</tspan></text>
                                    <text><tspan x="6.5" y="42.7">1400</tspan></text>
                                    <text><tspan x="6.5" y="11">1600</tspan></text>
                                </g>

                                {{-- Garis grafik (3 line = 3 status + 1 untuk Subdomain) --}}
                                <g id="GRAPHS" transform="translate(64, 16)"
                                   stroke-linecap="round" stroke-width="8" stroke-linejoin="round">
                                    {{-- Disetujui (biru) --}}
                                    <polyline id="Disetujui"
                                              stroke="#2962FF"
                                              points="0 1 88.04 1 128.99 137 180.17 137 224.19 182 256.95 91 301.99 137 346.01 91 392.09 91 429.95 179"></polyline>

                                    {{-- Menunggu (kuning) --}}
                                    <polyline id="Menunggu"
                                              stroke="#FFB300"
                                              points="2.05 183 54.26 227 96.23 47 133.08 1 302.02 1 346.68 44.63 386.96 0 427.91 43"></polyline>

                                    {{-- Ditolak (merah) --}}
                                    <polyline id="Ditolak"
                                              stroke="#E53935"
                                              points="2.05 180 53.27 180 99.30 91 137.18 47 219.08 47 256.95 90 301.99 47 349.08 137 398.23 137 432 91"></polyline>

                                    {{-- Subdomain (biru muda) --}}
                                    <polyline id="SubDomain"
                                              stroke="#03A9F4"
                                              points="2.05 183 52.26 27 23 47 13.08 1 30.02 1 36.68 44.63 386.60 0 427.11 23"></polyline>
                                </g>

                                {{-- Axis X --}}
                                <g id="x_axis" transform="translate(71.97, 271.54)"
                                   font-size="11" fill="#FFFFFF" opacity="0.4">
                                    <text><tspan x="0.4" y="11">1</tspan></text>
                                    <text><tspan x="39.26" y="11">2</tspan></text>
                                    <text><tspan x="78.88" y="11">3</tspan></text>
                                    <text><tspan x="118.50" y="11">4</tspan></text>
                                    <text><tspan x="158.12" y="11">5</tspan></text>
                                    <text><tspan x="197.73" y="11">6</tspan></text>
                                    <text><tspan x="237.35" y="11">7</tspan></text>
                                    <text><tspan x="276.97" y="11">8</tspan></text>
                                    <text><tspan x="316.59" y="11">9</tspan></text>
                                    <text><tspan x="359.23" y="11">10</tspan></text>
                                    <text><tspan x="400.04" y="11">11</tspan></text>
                                    <text><tspan x="438.47" y="11">12</tspan></text>
                                </g>

                                {{-- Grid --}}
                                <g id="grid" transform="translate(46.62, 4.75)"
                                   stroke="#FFFFFF" stroke-linecap="square" opacity="0.08">
                                    <path d="M0.4,1.19 L478.99,1.19"></path>
                                    <path d="M0.4,32.85 L478.99,32.85"></path>
                                    <path d="M0.4,64.52 L478.99,64.52"></path>
                                    <path d="M0.4,96.19 L478.99,96.19"></path>
                                    <path d="M0.4,127.85 L478.99,127.85"></path>
                                    <path d="M0.4,159.52 L478.99,159.52"></path>
                                    <path d="M0.4,191.19 L478.99,191.19"></path>
                                    <path d="M0.4,222.85 L478.99,222.85"></path>
                                    <path d="M0.4,254.52 L478.99,254.52"></path>
                                </g>
                            </g>
                        </svg>
                    </div>
                    {{-- END grafik animasi --}}
                </div>
            </div>

            {{-- Kanan: Weekly Stats --}}
            <div class="col-lg-4">
                <div class="dash-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Weekly Stats</h5>
                        <span class="small text-muted">
                            <i class="bi bi-calendar3"></i> {{ now()->translatedFormat('d F Y') }}
                        </span>
                    </div>

                    <div class="list-group list-group-flush dashboard-list">
                        <div class="list-group-item d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle bg-primary-soft">
                                    <i class="bi bi-check2-all text-primary"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Permohonan Disetujui</div>
                                    <small class="text-muted">Total permohonan yang telah disetujui</small>
                                </div>
                            </div>
                            <span class="badge rounded-pill bg-primary-subtle text-primary">
                                +{{ $persenSetuju }}%
                            </span>
                        </div>

                        <div class="list-group-item d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle bg-warning-soft">
                                    <i class="bi bi-hourglass-split text-warning"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Permohonan Menunggu</div>
                                    <small class="text-muted">Masih dalam proses verifikasi</small>
                                </div>
                            </div>
                            <span class="badge rounded-pill bg-warning-subtle text-warning">
                                {{ $persenMenunggu }}%
                            </span>
                        </div>

                        <div class="list-group-item d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle bg-danger-soft">
                                    <i class="bi bi-x-circle text-danger"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Permohonan Ditolak</div>
                                    <small class="text-muted">Tidak memenuhi persyaratan</small>
                                </div>
                            </div>
                            <span class="badge rounded-pill bg-danger-subtle text-danger">
                                {{ $persenTolak }}%
                            </span>
                        </div>

                        <div class="list-group-item d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle bg-info-soft">
                                    <i class="bi bi-hdd-network text-info"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Subdomain Aktif</div>
                                    <small class="text-muted">Total subdomain yang sudah berjalan</small>
                                </div>
                            </div>
                            <span class="badge rounded-pill bg-info-subtle text-info">
                                {{ $subdomainAktif }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- CSS dashboard + grafik --}}
    <style>
        body {
            background-color: #f5f7fb;
        }

        .dash-card {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            padding: 20px 22px;
            border: 0;
        }

        .dash-stat-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 14px 16px;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.06);
            display: flex;
            flex-direction: column;
            gap: 4px;
            height: 100%;
        }

        .dash-stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 4px;
            font-size: 1.1rem;
        }

        .dash-stat-card .label {
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #6b7280;
            margin-bottom: 0;
        }

        .dash-stat-card .value {
            font-size: 1.35rem;
            margin-bottom: 0;
        }

        .bg-primary-soft  { background-color: rgba(41,98,255,0.12); }
        .bg-success-soft  { background-color: rgba(46,125,50,0.12); }
        .bg-danger-soft   { background-color: rgba(211,47,47,0.12); }
        .bg-warning-soft  { background-color: rgba(251,140,0,0.15); }
        .bg-info-soft     { background-color: rgba(3,169,244,0.12); }

        .bg-primary-subtle { background-color: rgba(41,98,255,0.12); }
        .bg-warning-subtle { background-color: rgba(251,140,0,0.15); }
        .bg-danger-subtle  { background-color: rgba(211,47,47,0.12); }
        .bg-info-subtle    { background-color: rgba(3,169,244,0.12); }

        .legend-dot {
            display:inline-block;
            width:10px;
            height:10px;
            border-radius:999px;
            margin-right:4px;
        }
        .legend-approve { background:#2962ff; }
        .legend-pending { background:#ffb300; }
        .legend-reject  { background:#e53935; }

        .avatar-circle{
            width:40px;
            height:40px;
            border-radius:14px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:1.1rem;
        }

        .dashboard-list .list-group-item{
            border:0;
            padding-left:0;
            padding-right:0;
        }
        .dashboard-list .list-group-item + .list-group-item{
            border-top:1px solid #edf1f7;
        }

        /* ====== AREA GRAFIK ANIMASI ala CodePen Pygbbm ====== */
        .animated-graph-wrapper {
            height: 260px;
            border-radius: 18px;
            overflow: hidden;
            background: linear-gradient(135deg, #de437d 0%, #5b44b9 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .animated-graph-svg {
            width: 100%;
            max-width: 100%;
            padding: 20px;
        }

        .animated-graph-svg polyline {
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000;
            animation: dash 5s ease-in forwards;
            animation-iteration-count: infinite;
            animation-direction: alternate;
        }

        @keyframes dash {
            to {
                stroke-dashoffset: 0;
            }
        }
    </style>
@endsection
