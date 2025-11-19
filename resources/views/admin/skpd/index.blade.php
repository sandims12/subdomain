@extends('admin.layouts.wrapper')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-1">Data SKPD</h3>
    <p class="text-muted mb-3" style="font-size:.85rem;">Klik judul kolom untuk mengurutkan.</p>

    <div class="mb-3 text-end">
        <a href="{{ route('admin.skpd.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah SKPD
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <table id="skpdTable" class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama SKPD</th>
                        <th>Email</th>
                        <th>Tanggal Terdaftar</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($skpd as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.skpd.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.skpd.destroy', $user->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data SKPD.</td>
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
        const dt = $('#skpdTable').DataTable({
            order: [[1, 'asc']],
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            columnDefs: [{ orderable: false, targets: [4] }],
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
    thead {
        background: #f8f9fc;
    }
    thead th {
        font-size: .8rem;
        text-transform: uppercase;
        color: #6c757d;
        padding: .8rem .5rem;
    }
    tbody tr:hover {
        background: rgba(13, 110, 253, .05);
        transition: .2s;
    }
</style>
@endsection
