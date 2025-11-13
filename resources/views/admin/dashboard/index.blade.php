@extends('admin.layouts.wrapper')

@section('content')
<div class="container mt-4">

    <h3 class="text-primary fw-bold mb-2">Dashboard Admin</h3>
    <p class="text-muted mb-4">Selamat datang di panel pengelolaan subdomain pemerintah daerah.</p>

    <div class="row g-4">

        <div class="col-md-2">
            <div class="admin-card text-center p-3">
                <h5 class="fw-bold text-primary">{{ $totalSkpd }}</h5>
                <p class="text-secondary small">Total SKPD</p>
            </div>
        </div>

        <div class="col-md-2">
            <div class="admin-card text-center p-3">
                <h5 class="fw-bold text-dark">{{ $totalPermohonan }}</h5>
                <p class="text-secondary small">Total Permohonan</p>
            </div>
        </div>

        <div class="col-md-2">
            <div class="admin-card text-center p-3">
                <h5 class="fw-bold text-success">{{ $permohonanDisetujui }}</h5>
                <p class="text-secondary small">Disetujui</p>
            </div>
        </div>

        <div class="col-md-2">
            <div class="admin-card text-center p-3">
                <h5 class="fw-bold text-danger">{{ $permohonanDitolak }}</h5>
                <p class="text-secondary small">Ditolak</p>
            </div>
        </div>

        <div class="col-md-2">
            <div class="admin-card text-center p-3">
                <h5 class="fw-bold text-warning">{{ $permohonanMenunggu }}</h5>
                <p class="text-secondary small">Menunggu</p>
            </div>
        </div>

        <div class="col-md-2">
            <div class="admin-card text-center p-3">
                <h5 class="fw-bold text-info">{{ $subdomainAktif }}</h5>
                <p class="text-secondary small">Subdomain Aktif</p>
            </div>
        </div>

    </div>
</div>

{{-- CSS Card Modern --}}
<style>
    .admin-card {
        background: rgba(255, 255, 255, 0.88);
        backdrop-filter: blur(12px);
        border-radius: 18px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        transition: 0.3s ease-in-out;
    }

    .admin-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.15);
    }
</style>
@endsection
