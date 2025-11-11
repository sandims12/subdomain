@extends('admin.layouts.wrapper')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4">Edit Subdomain</h3>

    <form action="{{ route('admin.subdomain.update', $subdomain->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_subdomain" class="form-label">Nama Subdomain</label>
            <input type="text" class="form-control" id="nama_subdomain" name="nama_subdomain" value="{{ $subdomain->nama_subdomain }}" required>
        </div>

        <div class="mb-3">
            <label for="kondisi" class="form-label">Kondisi</label>
            <select name="kondisi" id="kondisi" class="form-control" required>
                <option value="aktif" {{ $subdomain->kondisi == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ $subdomain->kondisi == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                <option value="error" {{ $subdomain->kondisi == 'error' ? 'selected' : '' }}>Error</option>
            </select>
        </div>

        <button type="submit" class="btn btn-warning">Perbarui</button>
        <a href="{{ route('admin.subdomain.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
