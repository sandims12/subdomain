@extends('admin.layouts.wrapper')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold text-primary mb-3">
        <i class="bi bi-upload me-2"></i> Upload Template Surat Pengajuan
    </h4>

    <div class="card p-4 shadow-sm border-0">
        <form action="{{ route('admin.template.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Pilih File Template</label>
                <input type="file" class="form-control" name="files[]" multiple required>
                <small class="text-muted">Format: pdf, doc, docx | Maks: 2MB per file</small>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-cloud-arrow-up me-1"></i> Upload File
            </button>
        </form>
    </div>

    @if($templates->count())
    <div class="mt-4">
        <h6 class="fw-semibold text-secondary mb-3"><i class="bi bi-files me-1"></i> Daftar Template Saat Ini:</h6>
        <div class="list-group shadow-sm">
            @foreach($templates as $file)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-file-earmark-text text-primary me-2"></i>
                        {{ $file->nama_file }}
                    </div>
                    <a href="{{ asset(Storage::url($file->path)) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-eye"></i> Lihat
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
