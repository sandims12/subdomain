@extends('admin.layouts.wrapper')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-1">Daftar Permohonan Subdomain</h3>

    {{-- Aksi Export --}}
    <div class="d-flex gap-2 mb-3">
        <a href="{{ route('admin.permohonan.export.pdf') }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
        <a href="{{ route('admin.permohonan.export') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.permohonan.index') }}" class="mb-4 d-flex gap-3 align-items-end">

        {{-- Filter Kategori --}}
        <div>
            <label for="filter_kategori" class="form-label mb-1 fw-semibold">Kategori</label>
            <select name="kategori" id="filter_kategori" class="form-select">
                <option value="">Semua</option>
                @foreach($allKategori as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filter Subkategori --}}
        <div>
            <label for="filter_subkategori" class="form-label mb-1 fw-semibold">Subkategori</label>
            <select name="subkategori" id="filter_subkategori" class="form-select">
                <option value="">Semua</option>
                @foreach($allSubkategori as $subkategori)
                    <option value="{{ $subkategori->id }}" {{ request('subkategori') == $subkategori->id ? 'selected' : '' }}>
                        {{ $subkategori->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-primary">
                <i class="bi bi-filter"></i> Filter
            </button>
            <a href="{{ route('admin.permohonan.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    {{-- Tabel --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama SKPD</th>
                        <th>Kategori</th>
                        <th>Subkategori</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permohonan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->skpd->name ?? '-' }}</td>
                            <td>{{ $item->category->name ?? '-' }}</td>
                            <td>{{ $item->subcategory->name ?? '-' }}</td>
                            <td>
                                @if ($item->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif ($item->status == 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif ($item->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.permohonan.show', $item->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- DataTables --}}
<script>
    $(document).ready(function () {
        $('table').DataTable();
    });
</script>

{{-- Styling --}}
<style>
    thead { background: #f8f9fc; }
    thead th {
        font-size: 0.8rem;
        text-transform: uppercase;
        color: #6c757d;
        padding-top: 14px !important;
        padding-bottom: 14px !important;
    }
    tbody tr:hover { background: rgba(13,110,253,.05); transition: .2s; }
    .btn-primary { background: #0d6efd; border: none; }
    .btn-danger  { background: #dc3545; border: none; }
    .badge { font-size: .75rem; }
</style>
@endsection
