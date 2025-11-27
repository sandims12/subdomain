@extends('admin.layouts.wrapper')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-primary mb-0">
            <i class="bi bi-hdd-network me-2"></i> Data Subdomain
        </h3>
        <span class="text-muted small">
            <i class="bi bi-calendar3"></i> {{ now()->translatedFormat('d F Y') }}
        </span>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0" id="subdomainTable" style="width: 100%;">
                    <thead class="bg-light text-uppercase small text-secondary">
                        <tr>
                            <th>No</th>
                            <th>Nama Subdomain</th>
                            <th>Nama Aplikasi</th>
                            <th>Sifat</th>
                            <th>Tahun</th>
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
                                <td class="fw-semibold text-center">{{ $index + 1 }}</td>
                                <td class="fw-semibold text-primary">{{ $s->nama_subdomain }}</td>
                                <td>{{ $s->nama_aplikasi ?? '-' }}</td>
                                <td>{{ $s->sifat ?? '-' }}</td>
                                <td>{{ $s->tahun_penganggaran ?? '-' }}</td>
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
                                    <span class="badge {{ $badgeStatus }} px-3 py-2 rounded-pill shadow-sm">
                                        {{ ucfirst($s->status ?? 'Belum Disetujui') }}
                                    </span>
                                </td>

                                {{-- LINK --}}
                                <td>
                                    @if($s->link)
                                        <a href="{{ $s->link }}" target="_blank" class="text-decoration-none fw-semibold text-primary">
                                            {{ \Illuminate\Support\Str::limit($s->link, 25) }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
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

{{-- DataTables --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
  $(function () {
    $('#subdomainTable').DataTable({
      responsive: true,                 // ⬅️ bikin tabel ikut responsif
      order: [[1, 'asc']],
      pageLength: 10,
      lengthMenu: [10, 25, 50, 100],
      columnDefs: [
        { orderable: false, targets: [-1] }  // kolom aksi tidak bisa di-sort
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
  });
</script>

<style>
  thead th { font-size: .8rem; letter-spacing: .5px; padding: .8rem; }
  tbody tr:hover { background: #f1f6ff; transition: .25s; }
  .table { font-size: .9rem; }
  .badge { font-size: .75rem; letter-spacing: .3px; }
  .dataTables_filter input { border-radius: 20px; padding: 6px 12px; }

  .btn-outline-warning:hover { background-color: #ffc107; color: #fff; }
  .btn-outline-danger:hover { background-color: #dc3545; color: #fff; }

  /* Biar scroll horizontal cuma di area tabel, bukan satu halaman */
  .dataTables_wrapper {
      width: 100%;
      overflow-x: auto;
  }
  body {
      overflow-x: hidden;
  }
</style>
@endsection