<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h2 class="fw-bold text-primary mb-1">Permohonan Saya</h2>
        <p class="text-muted">Riwayat seluruh permohonan subdomain yang pernah diajukan oleh SKPD Anda.</p>
        <div class="mt-2 gradient-line"></div>
    </div>

    {{-- STATISTIK --}}
    @php
        $total     = $riwayat->count();
        $menunggu  = $riwayat->where('status', 'menunggu')->count();
        $disetujui = $riwayat->where('status', 'disetujui')->count();
        $ditolak   = $riwayat->where('status', 'ditolak')->count();
    @endphp

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="perm-card stat-total">
                <div class="perm-icon"><i class="bi bi-list-ul"></i></div>
                <div>
                    <div class="perm-label">Total Permohonan</div>
                    <div class="perm-value">{{ $total }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="perm-card stat-waiting">
                <div class="perm-icon"><i class="bi bi-hourglass-split"></i></div>
                <div>
                    <div class="perm-label">Menunggu</div>
                    <div class="perm-value">{{ $menunggu }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="perm-card stat-approve">
                <div class="perm-icon"><i class="bi bi-check-circle"></i></div>
                <div>
                    <div class="perm-label">Disetujui</div>
                    <div class="perm-value">{{ $disetujui }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="perm-card stat-reject">
                <div class="perm-icon"><i class="bi bi-x-octagon"></i></div>
                <div>
                    <div class="perm-label">Ditolak</div>
                    <div class="perm-value">{{ $ditolak }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL RIWAYAT --}}
    <div class="card shadow-sm border-0 rounded-4 bg-white bg-opacity-75">
        <div class="card-header bg-white border-0 rounded-top-4 pb-0 pt-3 px-4 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-semibold mb-1"><i class="bi bi-clock-history text-primary me-2"></i>Riwayat Permohonan Terakhir</h5>
                <small class="text-muted">Urutan berdasarkan permohonan terbaru yang Anda ajukan.</small>
            </div>
        </div>

        <div class="card-body px-4 pt-0">
            <div class="table-responsive mt-3">
                <table class="table table-hover align-middle perm-table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Subkategori</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Tanggal</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($riwayat as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->category->name ?? '-' }}</td>
                                <td>{{ $item->subcategory->name ?? '-' }}</td>
                                <td class="text-center">
                                    @if($item->status == 'menunggu')
                                        <span class="status-badge status-waiting"><i class="bi bi-hourglass-split me-1"></i>Menunggu</span>
                                    @elseif($item->status == 'disetujui')
                                        <span class="status-badge status-approve"><i class="bi bi-check-circle me-1"></i>Disetujui</span>
                                    @elseif($item->status == 'ditolak')
                                        <span class="status-badge status-reject"><i class="bi bi-x-octagon me-1"></i>Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-end text-muted">
                                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
                                </td>

                                {{-- AKSI --}}
                                <td class="text-end">
                                    <a href="{{ route('skpd.permohonan.show', $item->id) }}"
                                       class="btn btn-sm btn-outline-info rounded-pill px-3 me-1">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>

                                    @if($item->status === 'menunggu')
                                        <a href="{{ route('skpd.permohonan.edit', $item->id) }}"
                                           class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('skpd.permohonan.destroy', $item->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Hapus permohonan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 me-1" disabled>
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" disabled>
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
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

{{-- STYLE --}}
<style>
    .gradient-line {
        width: 100px; height: 3px;
        background: linear-gradient(90deg, #0d6efd, #00b894);
        border-radius: 999px;
    }

    .perm-card {
        display: flex; align-items: center; gap: 12px;
        background: #fff; border-radius: 18px;
        padding: 16px 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,.04);
        border: 1px solid rgba(0,0,0,.03);
        transition: all .25s ease;
    }
    .perm-card:hover { transform: translateY(-3px); box-shadow: 0 6px 16px rgba(0,0,0,.06); }

    .perm-icon {
        font-size: 1.5rem;
        display: flex; align-items: center; justify-content: center;
        width: 40px; height: 40px;
        border-radius: 50%; background: #f1f3f9;
        color: #0d6efd;
    }

    .perm-label { font-size: 12px; text-transform: uppercase; color: #6c757d; margin-bottom: 3px; }
    .perm-value { font-size: 22px; font-weight: 700; color: #222; }

    .stat-total .perm-icon { background: #eaf1ff; color: #0d6efd; }
    .stat-waiting .perm-icon { background: #fff4d6; color: #c58a00; }
    .stat-approve .perm-icon { background: #d8fbe8; color: #15803d; }
    .stat-reject .perm-icon { background: #ffe1e3; color: #c53030; }

    .status-badge {
        font-size: 12px; font-weight: 600;
        padding: 6px 14px; border-radius: 999px;
        display: inline-flex; align-items: center;
    }
    .status-waiting { background: #fff4d6; color: #c58a00; }
    .status-approve { background: #d8fbe8; color: #15803d; }
    .status-reject { background: #ffe1e3; color: #c53030; }

    .table th { font-size: .85rem; text-transform: uppercase; color: #6c757d; letter-spacing: .5px; }
    .table td { font-size: .9rem; }
</style>
