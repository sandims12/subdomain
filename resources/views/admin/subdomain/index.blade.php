@extends('admin.layouts.wrapper')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold text-primary mb-1">
                <i class="bi bi-hdd-network me-2"></i> Data Subdomain
            </h3>
            <p class="text-muted small mb-0">Monitoring seluruh subdomain yang telah terdaftar.</p>
        </div>
        <span class="text-muted small">
            <i class="bi bi-calendar3"></i> {{ now()->translatedFormat('d F Y') }}
        </span>
    </div>

    @php
        $total      = $subdomain->count();
        $aktif      = $subdomain->where('status', 'Aktif')->count();
        $nonaktif   = $subdomain->where('status', 'Nonaktif')->count();
        $pending    = $subdomain->where('status', 'Pending')->count(); // kalau mau dipakai nanti
    @endphp

    {{-- KARTU RINGKASAN (3 kartu, full 1 baris di desktop) --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card shadow-sm border-0 rounded-4 h-100 summary-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Total Subdomain</div>
                        <h4 class="fw-bold mb-0">{{ $total }}</h4>
                    </div>
                    <span class="icon-circle">
                        <i class="bi bi-globe"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card shadow-sm border-0 rounded-4 h-100 summary-card border-start border-success border-3">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Aktif</div>
                        <h4 class="fw-bold text-success mb-0">{{ $aktif }}</h4>
                    </div>
                    <span class="icon-circle">
                        <i class="bi bi-check-circle"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card shadow-sm border-0 rounded-4 h-100 summary-card border-start border-secondary border-3">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Nonaktif</div>
                        <h4 class="fw-bold text-secondary mb-0">{{ $nonaktif }}</h4>
                    </div>
                    <span class="icon-circle">
                        <i class="bi bi-slash-circle"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD UTAMA TABEL --}}
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">

            {{-- FILTER STATUS DOMAIN --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <span class="text-muted small me-1">Filter status domain:</span>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-secondary active btn-filter-status" data-status="">
                            Semua
                        </button>
                        <button type="button" class="btn btn-outline-success btn-filter-status" data-status="Aktif">
                            Aktif
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-filter-status" data-status="Nonaktif">
                            Nonaktif
                        </button>
                        <button type="button" class="btn btn-outline-info btn-filter-status" data-status="Pending">
                            Pending
                        </button>
                    </div>
                    
                    {{-- TOMBOL EXPORT EXCEL --}}
            <div>
                <a href="{{ route('admin.subdomain.export.excel') }}"
                   class="btn btn-success btn-sm rounded-pill">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </a>
            </div>
                </div>
            </div>

            {{-- TABEL --}}
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0" id="subdomainTable" style="width: 100%;">
                    <thead class="bg-light text-uppercase small text-secondary">
                        <tr>
                            <th>No</th>
                            <th>Nama Subdomain</th>
                            <th>Nama Aplikasi</th>
                            <th>Sifat</th>
                            <th>Tahun</th>
                            <th>Anggaran</th>
                            <th>Layanan</th>
                            <th>Platform OS</th>
                            <th>Jenis Aplikasi</th>
                            <th>Database</th>
                            <th>Bahasa</th>
                            <th>Status Aplikasi</th>
                            <th>Pengelola</th>
                            <th>Kondisi</th>
                            <th>Status Domain</th>
                            <th>Link</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subdomain as $index => $s)
                            <tr>
                                <td class="fw-semibold text-center"></td>
                                <td class="fw-semibold text-primary">
                                    <i class="bi bi-circle-fill me-1 small text-success"></i>
                                    {{ $s->nama_subdomain }}
                                </td>
                                <td>{{ $s->nama_aplikasi ?? '-' }}</td>
                                <td>{{ $s->sifat ?? '-' }}</td>
                                <td>
                                    @if($s->tahun_penganggaran)
                                        <span class="badge bg-light text-dark px-2 py-1 rounded-pill">
                                            {{ $s->tahun_penganggaran }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
    @if($s->anggaran)
        <span class="badge bg-info-subtle text-info px-2 py-1 rounded-pill">
            {{ $s->anggaran }}
        </span>
    @else
        <span class="text-muted">-</span>
    @endif
</td>
                                <td>{{ $s->layanan ?? '-' }}</td>
                                <td>{{ $s->platform_os ?? '-' }}</td>
                                <td>{{ $s->jenis_aplikasi ?? '-' }}</td>
                                <td>{{ $s->database_engine ?? '-' }}</td>
                                <td>{{ $s->bahasa_pemrograman ?? '-' }}</td>

                                {{-- STATUS APLIKASI --}}
                                <td>
                                    @php
                                        $statusApp = strtolower($s->status_aplikasi);
                                        $badgeApp = match($statusApp) {
                                            'aktif' => 'bg-success text-white',
                                            'tidak aktif' => 'bg-danger text-white',
                                            default => 'bg-secondary text-white'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeApp }} px-3 py-2 rounded-pill shadow-sm">
                                        {{ ucfirst($s->status_aplikasi ?? 'Belum Ditetapkan') }}
                                    </span>
                                </td>

                                {{-- PENGELOLA --}}
                                <td>{{ $s->pengelola ?? '-' }}</td>

                                {{-- KONDISI --}}
                                <td>
                                    @php
                                        $kondisi = strtolower($s->kondisi);
                                        $badgeKondisi = match($kondisi) {
                                            'aktif' => 'bg-success text-white',
                                            'nonaktif' => 'bg-warning text-dark fw-semibold',
                                            'error' => 'bg-danger text-white',
                                            default => 'bg-secondary text-white'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeKondisi }} px-3 py-2 rounded-pill text-capitalize shadow-sm">
                                        {{ $s->kondisi ?? 'Tidak diketahui' }}
                                    </span>
                                </td>

                                {{-- STATUS DOMAIN --}}
                                <td>
                                    @php
                                        $statusDomain = strtolower($s->status);
                                        $badgeStatus = match($statusDomain) {
                                            'aktif' => 'bg-success text-white',
                                            'pending' => 'bg-info text-dark fw-semibold',
                                            'nonaktif' => 'bg-secondary text-white',
                                            default => 'bg-light text-dark border'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeStatus }} px-3 py-2 rounded-pill shadow-sm domain-status-text">
                                        {{ ucfirst($s->status ?? 'Belum Disetujui') }}
                                    </span>
                                </td>

                                {{-- LINK --}}
                                <td>
                                    @if($s->link)
                                        <div class="d-flex align-items-center gap-1">
                                            <a href="{{ $s->link }}" target="_blank"
                                               class="text-decoration-none fw-semibold text-primary">
                                                {{ \Illuminate\Support\Str::limit($s->link, 25) }}
                                            </a>
                                            <button type="button"
                                                    class="btn btn-sm btn-light border copy-link-btn"
                                                    data-link="{{ $s->link }}"
                                                    title="Salin link">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="text-center">
                                    <div class="d-flex flex-column flex-md-row gap-2 justify-content-center">
                                        <button type="button"
                                                class="btn btn-sm btn-outline-info rounded-pill px-3 shadow-sm btn-detail"
                                                data-bs-toggle="modal"
                                                data-bs-target="#detailModal"
                                                data-nama="{{ $s->nama_subdomain }}"
                                                data-aplikasi="{{ $s->nama_aplikasi ?? '-' }}"
                                                data-sifat="{{ $s->sifat ?? '-' }}"
                                                data-tahun="{{ $s->tahun_penganggaran ?? '-' }}"
                                                data-layanan="{{ $s->layanan ?? '-' }}"
                                                data-os="{{ $s->platform_os ?? '-' }}"
                                                data-jenis="{{ $s->jenis_aplikasi ?? '-' }}"
                                                data-db="{{ $s->database_engine ?? '-' }}"
                                                data-bahasa="{{ $s->bahasa_pemrograman ?? '-' }}"
                                                data-statusaplikasi="{{ $s->status_aplikasi ?? '-' }}"
                                                data-pengelola="{{ $s->pengelola ?? '-' }}"
                                                data-kondisi="{{ $s->kondisi ?? '-' }}"
                                                data-statusdomain="{{ $s->status ?? '-' }}"
                                                data-link="{{ $s->link ?? '-' }}">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>

                                        <a href="{{ route('admin.subdomain.edit', $s->id) }}"
                                           class="btn btn-sm btn-outline-warning rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.subdomain.destroy', $s->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus subdomain ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-sm">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="16" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle"></i> Belum ada data subdomain.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- MODAL DETAIL --}}
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold text-primary">
            <i class="bi bi-info-circle me-2"></i> Detail Subdomain
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-0">
        <dl class="row mb-0 small">
            <dt class="col-sm-4">Nama Subdomain</dt>
            <dd class="col-sm-8" id="detailNama"></dd>

            <dt class="col-sm-4">Nama Aplikasi</dt>
            <dd class="col-sm-8" id="detailAplikasi"></dd>

            <dt class="col-sm-4">Sifat</dt>
            <dd class="col-sm-8" id="detailSifat"></dd>

            <dt class="col-sm-4">Tahun Penganggaran</dt>
            <dd class="col-sm-8" id="detailTahun"></dd>

            <dt class="col-sm-4">Layanan</dt>
            <dd class="col-sm-8" id="detailLayanan"></dd>

            <dt class="col-sm-4">Platform OS</dt>
            <dd class="col-sm-8" id="detailOS"></dd>

            <dt class="col-sm-4">Jenis Aplikasi</dt>
            <dd class="col-sm-8" id="detailJenis"></dd>

            <dt class="col-sm-4">Database</dt>
            <dd class="col-sm-8" id="detailDB"></dd>

            <dt class="col-sm-4">Bahasa Pemrograman</dt>
            <dd class="col-sm-8" id="detailBahasa"></dd>

            <dt class="col-sm-4">Status Aplikasi</dt>
            <dd class="col-sm-8" id="detailStatusApp"></dd>

            <dt class="col-sm-4">Pengelola</dt>
            <dd class="col-sm-8" id="detailPengelola"></dd>

            <dt class="col-sm-4">Kondisi</dt>
            <dd class="col-sm-8" id="detailKondisi"></dd>

            <dt class="col-sm-4">Status Domain</dt>
            <dd class="col-sm-8" id="detailStatusDomain"></dd>

            <dt class="col-sm-4">Link</dt>
            <dd class="col-sm-8" id="detailLink"></dd>
        </dl>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

{{-- DataTables --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
  $(function () {
    // CARI INDEX KOLOM UNTUK FILTER (Status Domain / Kondisi)
    let STATUS_COL_INDEX = $('#subdomainTable thead th')
      .filter(function () {
        return $(this).text().trim() === 'Status Domain';
      })
      .index();

    // Kalau "Status Domain" tidak ketemu, pakai kolom "Kondisi"
    if (STATUS_COL_INDEX === -1) {
      STATUS_COL_INDEX = $('#subdomainTable thead th')
        .filter(function () {
          return $(this).text().trim() === 'Kondisi';
        })
        .index();
    }

    // INIT DATATABLE
    const table = $('#subdomainTable').DataTable({
      responsive: true,
      order: [[1, 'asc']],        // urut berdasarkan Nama Subdomain
      pageLength: 10,
      lengthMenu: [10, 25, 50, 100],
      columnDefs: [
        // kolom "No" tidak bisa sort & tidak ikut search
        { orderable: false, searchable: false, targets: 0 },
        // kolom Link & Aksi tidak bisa sort
        { orderable: false, targets: [-1, -2] }
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

    // === PENOMORAN ULANG KOLUM "No" (SELALU MULAI 1) ===
    table.on('order.dt search.dt draw.dt', function () {
      let i = 1;
      table
        .column(0, { search: 'applied', order: 'applied', page: 'current' })
        .nodes()
        .each(function (cell) {
          cell.innerHTML = i++;
        });
    }).draw();

    // FILTER STATUS (Status Domain / Kondisi)
    $('.btn-filter-status').on('click', function () {
      $('.btn-filter-status').removeClass('active');
      $(this).addClass('active');

      const status = $(this).data('status'); // "", "Aktif", "Nonaktif", "Pending"

      if (!status) {
        // reset filter
        table.column(STATUS_COL_INDEX).search('', false, false).draw();
      } else {
        // filter berdasarkan teks di kolom Status Domain/Kondisi
        table.column(STATUS_COL_INDEX).search(status, false, false).draw();
      }
    });

    // COPY LINK
    $(document).on('click', '.copy-link-btn', function () {
      const link = $(this).data('link');
      if (!navigator.clipboard) {
        alert('Browser tidak mendukung clipboard.');
        return;
      }
      navigator.clipboard.writeText(link).then(() => {
        const originalIcon = $(this).find('i');
        originalIcon.removeClass('bi-clipboard').addClass('bi-clipboard-check');
        setTimeout(() => {
          originalIcon.removeClass('bi-clipboard-check').addClass('bi-clipboard');
        }, 1500);
      });
    });

    // DETAIL MODAL
    $(document).on('click', '.btn-detail', function () {
      $('#detailNama').text($(this).data('nama'));
      $('#detailAplikasi').text($(this).data('aplikasi'));
      $('#detailSifat').text($(this).data('sifat'));
      $('#detailTahun').text($(this).data('tahun'));
      $('#detailLayanan').text($(this).data('layanan'));
      $('#detailOS').text($(this).data('os'));
      $('#detailJenis').text($(this).data('jenis'));
      $('#detailDB').text($(this).data('db'));
      $('#detailBahasa').text($(this).data('bahasa'));
      $('#detailStatusApp').text($(this).data('statusaplikasi'));
      $('#detailPengelola').text($(this).data('pengelola'));
      $('#detailKondisi').text($(this).data('kondisi'));
      $('#detailStatusDomain').text($(this).data('statusdomain'));

      const link = $(this).data('link');
      if (link && link !== '-') {
        $('#detailLink').html(
          '<a href="' + link + '" target="_blank" class="text-decoration-none text-primary">' +
          link +
          '</a>'
        );
      } else {
        $('#detailLink').text('-');
      }
    });
  });
</script>




<style>
  thead th { font-size: .8rem; letter-spacing: .5px; padding: .8rem; }
  tbody tr:hover { background: #f1f6ff; transition: .25s; }
  .table { font-size: .9rem; background-color: #fff; }
  .badge { font-size: .75rem; letter-spacing: .3px; }
  .dataTables_filter input { border-radius: 20px; padding: 6px 12px; }

  .btn-outline-warning:hover { background-color: #ffc107; color: #fff; }
  .btn-outline-danger:hover { background-color: #dc3545; color: #fff; }

  .dataTables_wrapper {
      width: 100%;
      overflow-x: auto;
  }

  /* kartu ringkasan */
  .summary-card {
      transition: transform .2s ease, box-shadow .2s ease;
  }
  .summary-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0,0,0,.08);
  }
  .icon-circle {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: rgba(13,110,253,.08);
      font-size: 1rem;
  }

  /* card hover */
  .card {
      border-radius: 1.25rem;
  }

  @media (max-width: 575.98px) {
      .dataTables_filter {
          margin-top: .5rem;
      }
  }
</style>
@endsection
