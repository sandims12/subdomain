@extends('skpd.layouts.wrapper')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold text-primary mb-3">
        <i class="bi bi-file-earmark-text me-2"></i> Template Surat Pengajuan
    </h4>
    <p class="text-muted mb-4">
        Silakan unduh template surat pengajuan yang sesuai dengan jenis permohonan.
    </p>

    {{-- NAV PILIHAN --}}
    <ul class="nav nav-pills mb-3" id="templateTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="subdomain-tab" data-bs-toggle="pill"
                    data-bs-target="#subdomain-pane" type="button" role="tab">
                <i class="bi bi-hdd-network me-1"></i> Surat Permohonan Subdomain
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="nonsubdomain-tab" data-bs-toggle="pill"
                    data-bs-target="#nonsubdomain-pane" type="button" role="tab">
                <i class="bi bi-file-earmark-text me-1"></i> Surat Permohonan Non Subdomain
            </button>
        </li>
    </ul>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <div class="tab-content" id="templateTabContent">

                {{-- TAB SUBDOMAIN --}}
                <div class="tab-pane fade show active" id="subdomain-pane" role="tabpanel" aria-labelledby="subdomain-tab">
                    @if($subdomainTemplates->count())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr class="text-uppercase small text-secondary">
                                        <th style="width: 60px;">No</th>
                                        <th>Nama File</th>
                                        <th style="width: 180px;">Diupload Pada</th>
                                        <th style="width: 120px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subdomainTemplates as $file)
                                        <tr>
                                            <td class="text-center fw-semibold">{{ $loop->iteration }}</td>
                                            <td>
                                                <i class="bi bi-filetype-docx text-danger me-1"></i>
                                                {{ $file->nama_file }}
                                            </td>
                                            <td>{{ optional($file->created_at)->translatedFormat('d M Y H:i') ?? '-' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('skpd.template.download', $file->id) }}"
                                                   class="btn btn-sm btn-outline-primary rounded-pill">
                                                    <i class="bi bi-download"></i> Unduh
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0 small">
                            Belum ada template surat permohonan subdomain.
                        </p>
                    @endif
                </div>

                {{-- TAB NON SUBDOMAIN --}}
                <div class="tab-pane fade" id="nonsubdomain-pane" role="tabpanel" aria-labelledby="nonsubdomain-tab">
                    @if($nonSubdomainTemplates->count())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr class="text-uppercase small text-secondary">
                                        <th style="width: 60px;">No</th>
                                        <th>Nama File</th>
                                        <th style="width: 180px;">Diupload Pada</th>
                                        <th style="width: 120px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($nonSubdomainTemplates as $file)
                                        <tr>
                                            <td class="text-center fw-semibold">{{ $loop->iteration }}</td>
                                            <td>
                                                <i class="bi bi-filetype-docx text-danger me-1"></i>
                                                {{ $file->nama_file }}
                                            </td>
                                            <td>{{ optional($file->created_at)->translatedFormat('d M Y H:i') ?? '-' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('skpd.template.download', $file->id) }}"
                                                   class="btn btn-sm btn-outline-primary rounded-pill">
                                                    <i class="bi bi-download"></i> Unduh
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0 small">
                            Belum ada template surat permohonan non subdomain.
                        </p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .nav-pills .nav-link {
        border-radius: 999px;
        padding-inline: 1.25rem;
    }
    .nav-pills .nav-link.active {
        background: linear-gradient(90deg,#0d6efd,#00b894);
    }
    table tbody tr:hover {
        background-color: #f5f8ff;
        transition: .2s;
    }
</style>
@endsection
