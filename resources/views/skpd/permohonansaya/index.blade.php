<div class="container-fluid px-4 py-4">

    {{-- Header --}}
    <div class="mb-4">
        <h2 class="fw-bold text-primary mb-1">Permohonan Saya</h2>
        <p class="text-muted mb-0">
            Riwayat seluruh permohonan subdomain yang pernah diajukan oleh SKPD Anda.
        </p>
        <div class="mt-2" style="width: 80px; height: 3px; background: linear-gradient(90deg, #0d6efd, #00b894); border-radius: 999px;"></div>
    </div>

    @php
        $total      = $riwayat->count();
        $menunggu   = $riwayat->where('status', 'menunggu')->count();
        $disetujui  = $riwayat->where('status', 'disetujui')->count();
        $ditolak    = $riwayat->where('status', 'ditolak')->count();
    @endphp

    {{-- Statistik kecil --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="perm-card stat-total">
                <div class="perm-label">Total Permohonan</div>
                <div class="perm-value">{{ $total }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="perm-card stat-waiting">
                <div class="perm-label">Menunggu</div>
                <div class="perm-value">{{ $menunggu }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="perm-card stat-approve">
                <div class="perm-label">Disetujui</div>
                <div class="perm-value">{{ $disetujui }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="perm-card stat-reject">
                <div class="perm-label">Ditolak</div>
                <div class="perm-value">{{ $ditolak }}</div>
            </div>
        </div>
    </div>

    {{-- Tabel Permohonan --}}
    <div class="card border-0 shadow-sm rounded-4 bg-white bg-opacity-75">
        <div class="card-header bg-white border-0 rounded-top-4 pb-0 pt-3 px-4 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-semibold mb-1">
                    <i class="bi bi-list-check me-2 text-primary"></i>Riwayat Permohonan Terakhir
                </h5>
                <small class="text-muted">Urut dari permohonan terbaru yang Anda ajukan.</small>
            </div>
        </div>

        <div class="card-body p-0 mt-2">
            <div class="table-responsive">
                <table class="table align-middle mb-0 perm-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th>Nama Subdomain</th>
                            <th class="text-center">Status</th>
                            <th class="text-end" style="width: 18%">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="fw-medium">
                                    <span class="domain-pill">{{ $item->nama_subdomain }}</span>
                                </td>
                                <td class="text-center">
                                    @if($item->status == 'menunggu')
                                        <span class="status-badge status-waiting">Menunggu</span>
                                    @elseif($item->status == 'disetujui')
                                        <span class="status-badge status-approve">Disetujui</span>
                                    @elseif($item->status == 'ditolak')
                                        <span class="status-badge status-reject">Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-end text-muted">
                                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    Belum ada permohonan yang diajukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- CSS khusus halaman ini --}}
<style>
    .perm-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 14px 16px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.03);
        transition: all .25s ease;
    }
    .perm-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(0,0,0,0.06);
    }
    .perm-label {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #8b8b8b;
        margin-bottom: 4px;
    }
    .perm-value {
        font-size: 26px;
        font-weight: 700;
    }
    .stat-total .perm-value   { color: #0d6efd; }
    .stat-waiting .perm-value { color: #f0ad00; }
    .stat-approve .perm-value { color: #28a745; }
    .stat-reject .perm-value  { color: #dc3545; }

    .perm-table thead {
        background: #f8fafc;
        border-bottom: 1px solid #edf1f7;
    }
    .perm-table thead th {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #6b7280;
        border-bottom: none;
    }
    .perm-table tbody tr {
        border-top: 1px solid #f1f5f9;
    }
    .perm-table tbody tr:hover {
        background: #f8fbff;
    }

    .domain-pill {
        padding: 6px 12px;
        border-radius: 999px;
        background: #f5f7ff;
        font-size: 14px;
        color: #111827;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-waiting {
        background: #fff4d6;
        color: #c58a00;
    }
    .status-approve {
        background: #d8fbe8;
        color: #15803d;
    }
    .status-reject {
        background: #ffe1e3;
        color: #c53030;
    }
</style>
