<main class="main-content">
    <div class="container py-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="fw-bold text-primary mb-1">
                    <i class="bi bi-hdd-network me-2"></i> Daftar Subdomain
                </h3>
                <p class="text-muted mb-0 small">
                    Ringkasan subdomain yang dimiliki oleh SKPD Anda.
                </p>
            </div>
            <span class="text-muted small">
                <i class="bi bi-calendar3"></i> {{ now()->translatedFormat('d F Y') }}
            </span>
        </div>

        {{-- Kartu statistik subdomain milik SKPD ini --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="card shadow-sm summary-card border-0 rounded-4 h-100">
                    <div class="card-body text-center">
                        <div class="text-muted small">Total Subdomain</div>
                        <div class="fs-3 fw-bold">{{ $total }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="card shadow-sm summary-card border-0 rounded-4 h-100 border-start border-success border-3">
                    <div class="card-body text-center">
                        <div class="text-muted small">Aktif</div>
                        <div class="fs-3 fw-bold text-success">{{ $aktif }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="card shadow-sm summary-card border-0 rounded-4 h-100 border-start border-secondary border-3">
                    <div class="card-body text-center">
                        <div class="text-muted small">Nonaktif</div>
                        <div class="fs-3 fw-bold text-secondary">{{ $nonaktif }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="card shadow-sm summary-card border-0 rounded-4 h-100 border-start border-danger border-3">
                    <div class="card-body text-center">
                        <div class="text-muted small">Error</div>
                        <div class="fs-3 fw-bold text-danger">{{ $error }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FILTER + TABEL DETAIL SUBDOMAIN --}}
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">

                {{-- Filter status --}}
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <span class="text-muted small">Filter status:</span>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary active btn-filter-status" data-status="">
                                Semua
                            </button>
                            <button type="button" class="btn btn-outline-info btn-filter-status" data-status="Menunggu">
                                Menunggu
                            </button>
                            <button type="button" class="btn btn-outline-success btn-filter-status" data-status="Setuju">
                                Setuju
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-filter-status" data-status="Tidak Setuju">
                                Tidak Setuju
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="skpdSubdomainTable" style="width: 100%;">
                        <thead class="table-light">
                            <tr class="text-uppercase small text-secondary">
                                <th style="width: 60px;">No</th>
                                <th>Nama Subdomain</th>
                                <th style="width: 150px;">Status</th>
                                <th style="width: 180px;">Tanggal Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subdomain as $index => $s)
                                <tr>
                                    {{-- No (diisi otomatis oleh DataTables) --}}
                                    <td class="text-center fw-semibold"></td>

                                    {{-- Nama Subdomain --}}
                                    <td>{{ $s->nama_subdomain }}</td>

                                    {{-- Status (Menunggu / Setuju / Tidak Setuju) --}}
                                    <td class="text-nowrap">
                                        @php
                                            $statusPermohonan = strtolower($s->permohonan->status ?? '');
                                        @endphp

                                        @if ($statusPermohonan === 'menunggu')
                                            <span class="badge bg-info text-dark px-3 py-2 rounded-pill">
                                                Menunggu
                                            </span>
                                        @elseif ($statusPermohonan === 'disetujui')
                                            <span class="badge bg-success px-3 py-2 rounded-pill">
                                                Setuju
                                            </span>
                                        @elseif ($statusPermohonan === 'ditolak')
                                            <span class="badge bg-danger px-3 py-2 rounded-pill">
                                                Tidak Setuju
                                            </span>
                                        @else
                                            <span class="badge bg-light text-muted px-3 py-2 rounded-pill">
                                                -
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Tanggal Dibuat --}}
                                    <td>
                                        {{ $s->created_at ? $s->created_at->format('d M Y') : '-' }}
                                    </td>
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

    </div>
</main>

{{-- DataTables CSS --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

{{-- jQuery & DataTables JS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    $(function () {
        const table = $('#skpdSubdomainTable').DataTable({
            responsive: true,
            order: [[1, 'asc']], // urut berdasarkan nama subdomain
            pageLength: 10,
            lengthMenu: [10, 25, 50],
            columnDefs: [
                { orderable: false, searchable: false, targets: 0 } // kolom "No"
            ],
            language: {
                search: "🔍 Cari:",
                lengthMenu: "Tampil _MENU_ data",
                info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                zeroRecords: "Tidak ditemukan data yang cocok",
                paginate: { previous: "‹", next: "›" }
            }
        });

        // Penomoran ulang kolom No
        table.on('order.dt search.dt draw.dt', function () {
            let i = 1;
            table
                .column(0, { search: 'applied', order: 'applied', page: 'current' })
                .nodes()
                .each(function (cell) {
                    cell.innerHTML = i++;
                });
        }).draw();

        // Filter status (kolom ke-2 index=2)
        $('.btn-filter-status').on('click', function () {
            $('.btn-filter-status').removeClass('active');
            $(this).addClass('active');

            const status = $(this).data('status'); // '', 'Menunggu', 'Setuju', 'Tidak Setuju'
            if (!status) {
                table.column(2).search('', true, false).draw();
            } else {
                table.column(2).search(status, true, false).draw();
            }
        });
    });
</script>

<style>
    /* kartu ringkasan */
    .summary-card {
        transition: transform .2s ease, box-shadow .2s ease;
        border-radius: 1.25rem;
    }
    .summary-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,.08);
    }

    #skpdSubdomainTable thead th {
        font-size: .8rem;
        letter-spacing: .5px;
        padding: .75rem .75rem;
    }
    #skpdSubdomainTable tbody td {
        font-size: .9rem;
    }
    #skpdSubdomainTable tbody tr:hover {
        background-color: #f5f8ff;
        transition: .2s;
    }
    .dataTables_filter input {
        border-radius: 999px;
        padding: 4px 10px;
        font-size: .85rem;
    }
    .dataTables_wrapper {
        width: 100%;
        overflow-x: auto;
    }

    @media (max-width: 575.98px) {
        .dataTables_filter {
            margin-top: .5rem;
        }
    }
</style>
