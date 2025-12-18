@extends('admin.layouts.wrapper')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold text-primary mb-3">
        <i class="bi bi-upload me-2"></i> Upload Template Surat Pengajuan
    </h4>

    {{-- FORM UPLOAD --}}
    <div class="card p-4 shadow-sm border-0 mb-4">
        <form action="{{ route('admin.template.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
<div class="mb-3">
    <label class="form-label fw-semibold">Jenis Template</label>
    <select name="jenis" class="form-control" required>
        <option value="">-- Pilih Jenis Template --</option>
        <option value="subdomain"
            {{ old('jenis') == 'subdomain' ? 'selected' : '' }}>
            Surat Permohonan Subdomain
        </option>
        <option value="non_subdomain"
            {{ old('jenis') == 'non_subdomain' ? 'selected' : '' }}>
            Surat Permohonan Non Subdomain
        </option>
    </select>
    @error('jenis')
        <small class="text-danger d-block mt-1">{{ $message }}</small>
    @enderror
</div>


            <div class="mb-3">
                <label class="form-label fw-semibold">Pilih File Template</label>
                <input type="file" class="form-control" name="files[]" multiple required accept=".docx">
                <small class="text-muted">Format: DOCX saja | Maks: 2MB per file</small>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-cloud-arrow-up me-1"></i> Upload File
            </button>
        </form>
    </div>

    {{-- DATA TABLE TEMPLATE --}}
    @if($templates->count())
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <h6 class="fw-semibold text-secondary mb-0">
                        <i class="bi bi-files me-1"></i> Daftar Template Saat Ini
                    </h6>

                    {{-- FILTER JENIS --}}
                    <div class="btn-group btn-group-sm" role="group" aria-label="Filter Jenis Template">
                        <button type="button"
                                class="btn btn-outline-secondary active"
                                data-filter-jenis="">
                            Semua
                        </button>
                        <button type="button"
                                class="btn btn-outline-secondary"
                                data-filter-jenis="subdomain">
                            Subdomain
                        </button>
                        <button type="button"
                                class="btn btn-outline-secondary"
                                data-filter-jenis="non_subdomain">
                            Non Subdomain
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="templatesTable" style="width: 100%;">
                        <thead class="bg-light">
                            <tr class="text-uppercase small text-secondary">
                                <th style="width: 60px;">No</th>
                                <th>Nama File</th>
                                <th style="width: 150px;">Jenis</th>
                                <th style="width: 180px;">Diupload Pada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($templates as $file)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $loop->iteration }}</td>
                                    <td>
                                        <i class="bi bi-file-earmark-text text-primary me-2"></i>
                                        {{ $file->nama_file }}
                                    </td>
                                    <td>
                                        @if($file->jenis === 'subdomain')
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                                Subdomain
                                            </span>
                                        @else
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                Non Subdomain
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ optional($file->created_at)->translatedFormat('d M Y H:i') ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    @endif
</div>

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
        const table = $('#templatesTable').DataTable({
            responsive: true,
            order: [[1, 'asc']], // urut nama file
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            columnDefs: [
                { orderable: false, searchable: false, targets: 0 },   // kolom No
                { orderable: false, searchable: false, targets: -1 },  // kolom Aksi
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

        // Filter Jenis (kolom index 2)
        $('[data-filter-jenis]').on('click', function () {
            $('[data-filter-jenis]').removeClass('active');
            $(this).addClass('active');

            const val = $(this).data('filter-jenis');

            if (val === '') {
                table.column(2).search('').draw();
            } else if (val === 'subdomain') {
                table.column(2).search('Subdomain', true, false).draw();
            } else {
                table.column(2).search('Non Subdomain', true, false).draw();
            }
        });
    });
</script>

<style>
    #templatesTable thead th {
        font-size: .8rem;
        letter-spacing: .5px;
        padding: .7rem .75rem;
    }
    #templatesTable tbody td {
        font-size: .9rem;
    }
    #templatesTable tbody tr:hover {
        background-color: #f5f8ff;
        transition: .2s;
    }
</style>
@endsection
