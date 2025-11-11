@extends('admin.layouts.wrapper')

@section('content')
<div class="container mt-4">
    <h3 class="text-primary fw-bold mb-3">Dashboard Admin</h3>
    <p class="text-muted mb-4">Selamat datang di panel pengelolaan subdomain pemerintah daerah.</p>

    <div class="row g-4 mb-4">
        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center">
                <h6 class="text-secondary">Total SKPD</h6>
                <h2 class="fw-bold text-primary">{{ $totalSkpd }}</h2>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center">
                <h6 class="text-secondary">Total Permohonan</h6>
                <h2 class="fw-bold text-dark">{{ $totalPermohonan }}</h2>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center">
                <h6 class="text-secondary">Disetujui</h6>
                <h2 class="fw-bold text-success">{{ $permohonanDisetujui }}</h2>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center">
                <h6 class="text-secondary">Ditolak</h6>
                <h2 class="fw-bold text-danger">{{ $permohonanDitolak }}</h2>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center">
                <h6 class="text-secondary">Menunggu</h6>
                <h2 class="fw-bold text-warning">{{ $permohonanMenunggu }}</h2>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center">
                <h6 class="text-secondary">Subdomain Aktif</h6>
                <h2 class="fw-bold text-info">{{ $subdomainAktif }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection
