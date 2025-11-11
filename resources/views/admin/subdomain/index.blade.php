@extends('admin.layouts.wrapper')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4">Data Subdomain</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Subdomain</th>
                        <th>Status</th>
                        <th>SKPD</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subdomain as $index => $s)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $s->nama_subdomain }}</td>
                            <td>{{ $s->status }}</td>

                            {{-- ini yang penting --}}
                            <td>{{ $s->skpd?->name ?? 'Tidak Ditemukan' }}</td>

                            <td>
                                <a href="{{ route('admin.subdomain.edit', $s->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.subdomain.destroy', $s->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus subdomain ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data subdomain.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
