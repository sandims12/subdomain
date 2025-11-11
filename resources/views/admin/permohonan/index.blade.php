@extends('admin.layouts.wrapper')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4">Daftar Permohonan Subdomain</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama SKPD</th>
                        <th>Subdomain</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($permohonan as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $p->skpd->name ?? '-' }}</td>
                            <td>{{ $p->nama_subdomain }}</td>
                            <td>
                                @if ($p->status == 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif ($p->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>{{ $p->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.permohonan.show', $p->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> Detail Tindak Lanjut
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada permohonan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
