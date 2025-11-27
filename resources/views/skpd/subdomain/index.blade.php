<main class="main-content">
    <div class="container py-4">

        <h3 class="fw-bold text-primary mb-4">Daftar Subdomain</h3>

        {{-- Kartu statistik subdomain milik SKPD ini --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <div class="text-muted small">Total Subdomain</div>
                        <div class="fs-3 fw-bold">{{ $total }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <div class="text-muted small">Aktif</div>
                        <div class="fs-3 fw-bold text-success">{{ $aktif }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <div class="text-muted small">Nonaktif</div>
                        <div class="fs-3 fw-bold text-secondary">{{ $nonaktif }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <div class="text-muted small">Error</div>
                        <div class="fs-3 fw-bold text-danger">{{ $error }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel detail subdomain --}}
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Subdomain</th>
                            <th style="width: 150px;">Kondisi</th>
                            <th style="width: 180px;">Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subdomain as $index => $s)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $s->nama_subdomain }}</td>
                                <td>
                                    @if ($s->kondisi === 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif ($s->kondisi === 'nonaktif')
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @else
                                        <span class="badge bg-danger">Error</span>
                                    @endif
                                </td>
                                <td>{{ $s->created_at ? $s->created_at->format('d M Y') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Belum ada subdomain yang dimiliki.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>
