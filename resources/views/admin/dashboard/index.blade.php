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

        {{-- ROW 2: Ringkasan status + Weekly Stats --}}
        <div class="row g-4">

            {{-- Kiri: Ringkasan Status Permohonan (progress bar) --}}
            <div class="col-lg-8">
                <div class="dash-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-0">Ringkasan Status Permohonan</h5>
                            <small class="text-muted">Distribusi permohonan berdasarkan status</small>
                        </div>
                        <span class="badge bg-light text-muted border rounded-pill small">
                            <i class="bi bi-calendar3 me-1"></i>
                            Update {{ now()->translatedFormat('d M Y') }}
                        </span>
                    </div>

                    <div class="status-progress-list">

                        {{-- Disetujui --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1 small">
                                <span>
                                    <span class="status-dot bg-success"></span>
                                    Disetujui
                                </span>
                                <span class="fw-semibold">
                                    {{ $permohonanDisetujui }} ({{ $persenSetuju }}%)
                                </span>
                            </div>
                            <div class="progress soft-progress">
                                <div class="progress-bar bg-success"
                                     role="progressbar"
                                     style="width: {{ $persenSetuju }}%;"
                                     aria-valuenow="{{ $persenSetuju }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>

                        {{-- Menunggu --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1 small">
                                <span>
                                    <span class="status-dot bg-warning"></span>
                                    Menunggu
                                </span>
                                <span class="fw-semibold">
                                    {{ $permohonanMenunggu }} ({{ $persenMenunggu }}%)
                                </span>
                            </div>
                            <div class="progress soft-progress">
                                <div class="progress-bar bg-warning"
                                     role="progressbar"
                                     style="width: {{ $persenMenunggu }}%;"
                                     aria-valuenow="{{ $persenMenunggu }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>

                        {{-- Ditolak --}}
                        <div class="mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-1 small">
                                <span>
                                    <span class="status-dot bg-danger"></span>
                                    Ditolak
                                </span>
                                <span class="fw-semibold">
                                    {{ $permohonanDitolak }} ({{ $persenTolak }}%)
                                </span>
                            </div>
                            <div class="progress soft-progress">
                                <div class="progress-bar bg-danger"
                                     role="progressbar"
                                     style="width: {{ $persenTolak }}%;"
                                     aria-valuenow="{{ $persenTolak }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="mt-3 pt-2 border-top small text-muted">
                            <div class="d-flex justify-content-between">
                                <span>Total permohonan</span>
                                <span class="fw-semibold text-dark">{{ $totalPermohonan }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Subdomain aktif</span>
                                <span class="fw-semibold text-primary">{{ $subdomainAktif }}</span>
                            </div>
                        </div>

                    </div>
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

    {{-- CSS dashboard --}}
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

        /* Progress status */
        .status-dot{
            display:inline-block;
            width:10px;
            height:10px;
            border-radius:999px;
            margin-right:6px;
        }

        .progress.soft-progress{
            height:9px;
            background-color:#eef2ff;
            border-radius:999px;
            overflow:hidden;
        }
        .progress.soft-progress .progress-bar{
            border-radius:999px;
        }
    </style>
@endsection