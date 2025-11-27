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

  {{-- Kartu Tabel + Filter di dalamnya --}}
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">

      {{-- Filter toolbar --}}
      <form method="GET" action="{{ route('admin.permohonan.index') }}"
            class="table-filter-toolbar d-flex flex-wrap align-items-end gap-2 mb-3">

        {{-- Kategori --}}
        <div class="filter-field">
          <label class="filter-label">Kategori</label>
          <div class="position-relative">
            <i class="bi bi-grid-1x2 filter-icon"></i>
            <select name="kategori" id="filter_kategori" class="form-select filter-select">
              <option value="">Semua</option>
              @foreach($allKategori as $kategori)
                <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                  {{ $kategori->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        {{-- Subkategori (punya data-category) --}}
        <div class="filter-field">
          <label class="filter-label">Subkategori</label>
          <div class="position-relative">
            <i class="bi bi-diagram-3 filter-icon"></i>
            <select name="subkategori" id="filter_subkategori" class="form-select filter-select">
              <option value="">Semua</option>
              @foreach($allSubkategori as $subkategori)
                <option value="{{ $subkategori->id }}"
                        data-category="{{ $subkategori->category_id }}"
                        {{ request('subkategori') == $subkategori->id ? 'selected' : '' }}>
                  {{ $subkategori->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="ms-0">
          <button type="submit" class="btn btn-primary btn-sm px-3">
            <i class="bi bi-funnel"></i> Terapkan
          </button>
          <a href="{{ route('admin.permohonan.index') }}" class="btn btn-outline-secondary btn-sm px-3">
            <i class="bi bi-arrow-counterclockwise"></i> Reset
          </a>
        </div>

        {{-- Chips filter aktif --}}
        @if(request('kategori') || request('subkategori'))
          <div class="w-100 filter-chips mt-2">
            @if(request('kategori'))
              <span class="chip">
                <i class="bi bi-tag"></i>
                <span class="chip-label">Kategori:</span>
                {{ optional($allKategori->firstWhere('id', request('kategori')))->name ?? '—' }}
              </span>
            @endif
            @if(request('subkategori'))
              <span class="chip">
                <i class="bi bi-tag"></i>
                <span class="chip-label">Subkategori:</span>
                {{ optional($allSubkategori->firstWhere('id', request('subkategori')))->name ?? '—' }}
              </span>
            @endif
          </div>
        @endif
      </form>

      <div class="table-responsive">
        <table class="table align-middle">
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
</div>

{{-- DataTables + Filter Dependen Kategori/Subkategori --}}
<script>
  $(document).ready(function () {
    // Inisialisasi DataTable
    $('table').DataTable();

    // ====== FILTER SUBKATEGORI BERDASARKAN KATEGORI ======
    const $kategoriSelect    = $('#filter_kategori');
    const $subkategoriSelect = $('#filter_subkategori');

    // Simpan semua option subkategori (asli)
    const allSubOptions = $subkategoriSelect.find('option').clone();

    function applySubkategoriFilter() {
      const selectedKategori = $kategoriSelect.val();

      // kosongkan dulu, lalu isi ulang dari allSubOptions
      $subkategoriSelect.empty();

      // filter: kalau option tidak punya data-category (artinya "Semua") -> tetap tampil
      allSubOptions.each(function () {
        const catId = $(this).data('category');

        if (catId === undefined || catId === null || catId === '') {
          // option "Semua"
          $subkategoriSelect.append($(this));
        } else {
          // hanya tampilkan yang category_id sama dengan kategori yang dipilih
          if (!selectedKategori || String(catId) === String(selectedKategori)) {
            $subkategoriSelect.append($(this));
          }
        }
      });

      // kalau kategori berganti, default subkategori jadi "Semua"
      if (selectedKategori) {
        $subkategoriSelect.val('{{ request('subkategori') }}');
        // kalau request subkategori tidak cocok dengan kategori, akan otomatis ke ""
        if ($subkategoriSelect.val() === null) {
          $subkategoriSelect.val('');
        }
      } else {
        $subkategoriSelect.val('{{ request('subkategori') }}');
      }
    }

    // Terapkan saat halaman pertama kali load
    applySubkategoriFilter();

    // Terapkan ulang setiap kali kategori diganti
    $kategoriSelect.on('change', function () {
      // hilangkan nilai subkategori sebelumnya saat ganti kategori
      $subkategoriSelect.val('');
      applySubkategoriFilter();
    });
  });
</script>

{{-- Styling --}}
<style>
  thead { background:#f8f9fc; }
  thead th{
    font-size:.8rem;
    text-transform:uppercase;
    color:#6c757d;
    padding-top:14px!important;
    padding-bottom:14px!important;
  }
  tbody tr:hover{ background:rgba(13,110,253,.05); transition:.2s; }
  .btn-primary{ background:#0d6efd; border:none; }
  .btn-danger{ background:#dc3545; border:none; }
  .badge{ font-size:.75rem; }

  .table-filter-toolbar{
    background: linear-gradient(180deg,#ffffff 0%, #f8faff 100%);
    border:1px solid #e8eef7;
    border-radius:14px;
    padding:12px 14px;
    box-shadow: 0 6px 18px rgba(13,110,253,.06);
    max-width: fit-content;
  }
  .filter-label{
    font-size:.75rem;
    text-transform:uppercase;
    letter-spacing:.04em;
    color:#6c7a89;
    margin-bottom:4px!important;
  }
  .filter-field{ min-width: 190px; }
  .filter-icon{
    position:absolute; left:12px; top:50%; transform:translateY(-50%);
    color:#6c757d; font-size:1rem; pointer-events:none;
  }
  .filter-select{
    padding-left:38px; height:40px;
    border-radius:10px; border:1px solid #dfe7f3;
    transition:border-color .15s ease, box-shadow .15s ease;
  }
  .filter-select:focus{
    border-color:#86b7fe; box-shadow:0 0 0 .2rem rgba(13,110,253,.12);
  }
  .table-filter-toolbar .btn.btn-sm{ border-radius:10px; }

  .filter-chips .chip{
    display:inline-flex; align-items:center; gap:.25rem;
    background:#eef4ff; border:1px solid #dbe7ff; color:#0b5ed7;
    border-radius:999px; padding:6px 10px; font-size:.82rem; text-decoration:none;
  }
  .chip:hover{ background:#e6f0ff; border-color:#cfe2ff; }
  .chip-label{ opacity:.75; }
  .chip i{ font-size:.7rem; opacity:.7; }
</style>
@endsection
