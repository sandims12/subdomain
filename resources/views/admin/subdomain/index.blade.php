@extends('admin.layouts.wrapper')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-3">Data Subdomain</h3>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <table class="table table-hover align-middle mb-0" id="subdomainTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Subdomain</th>
                        <th>Nama Aplikasi</th>
                        <th>Sifat</th>
                        <th>Tahun</th>
                        <th>Layanan</th>
                        <th>Platform OS</th>
                        <th>Jenis Aplikasi</th>
                        <th>Database Engine</th>
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
                            <td>{{ $index + 1 }}</td>

                            {{-- kolom dari tabel subdomain --}}
                            <td>{{ $s->nama_subdomain }}</td>
                            <td>{{ $s->nama_aplikasi ?? '-' }}</td>
                            <td>{{ $s->sifat ?? '-' }}</td>
                            <td>{{ $s->tahun_penganggaran ?? '-' }}</td>
                            <td>{{ $s->layanan ?? '-' }}</td>
                            <td>{{ $s->platform_os ?? '-' }}</td>
                            <td>{{ $s->jenis_aplikasi ?? '-' }}</td>
                            <td>{{ $s->database_engine ?? '-' }}</td>
                            <td>{{ $s->bahasa_pemrograman ?? '-' }}</td>

                            {{-- status aplikasi (Aktif / Tidak Aktif) --}}
                            <td>
                                @php
                                    $badgeStatusAplikasi = match($s->status_aplikasi) {
                                        'Aktif'       => 'success',
                                        'Tidak Aktif' => 'secondary',
                                        default       => 'light',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeStatusAplikasi }} px-3 py-2 rounded-pill">
                                    {{ $s->status_aplikasi ?? '-' }}
                                </span>
                            </td>

                            <td>{{ $s->pengelola ?? '-' }}</td>

                            {{-- kondisi subdomain (aktif / nonaktif / error) --}}
                            <td>
                                @php
                                    $badgeKondisi = match($s->kondisi) {
                                        'aktif'    => 'success',
                                        'nonaktif' => 'secondary',
                                        'error'    => 'danger',
                                        default    => 'light',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeKondisi }} px-3 py-2 rounded-pill text-capitalize">
                                    {{ $s->kondisi ?? '-' }}
                                </span>
                            </td>

                            {{-- status domain (enum: aktif / nonaktif) --}}
                            <td>
                                @php
                                    $badgeStatus = match($s->status) {
                                        'aktif'    => 'success',
                                        'nonaktif' => 'secondary',
                                        default    => 'light',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeStatus }} px-3 py-2 rounded-pill text-capitalize">
                                    {{ $s->status ?? '-' }}
                                </span>
                            </td>

                            <td>
                                @if($s->link)
                                    <a href="{{ $s->link }}" target="_blank">{{ $s->link }}</a>
                                @else
                                    -
                                @endif
                            </td>

                            {{-- aksi --}}
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.subdomain.edit', $s->id) }}"
                                       class="btn btn-warning btn-sm rounded-pill px-3">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.subdomain.destroy', $s->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus subdomain ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm rounded-pill px-3">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="16" class="text-center text-muted">Belum ada data subdomain.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- DataTables --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script>
  $(function(){
    const dt = $('#subdomainTable').DataTable({
      order: [[1, 'asc']],                         // urut default: nama subdomain
      pageLength: 10,
      lengthMenu: [10, 25, 50, 100],
      columnDefs: [
        { orderable:false, targets:[-1] }          // kolom terakhir (Aksi) tidak bisa di-sort
      ],
      language: {
        search: "Cari:",
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
  thead{background:#f8f9fc}
  thead th{font-size:.8rem;text-transform:uppercase;color:#6c757d;padding:.8rem .5rem}
  tbody tr:hover{background:rgba(13,110,253,.05);transition:.2s}
</style>
@endsection
