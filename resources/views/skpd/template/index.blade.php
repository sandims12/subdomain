@extends('skpd.layouts.wrapper')

@section('content')
<div class="container py-5 text-center animate-fadein">
    <h4 class="fw-bold text-primary mb-4 d-flex justify-content-center align-items-center gap-2 animate-up">
        <i class="bi bi-download"></i> 
        Template Surat Pengajuan
    </h4>

    @if($templates->count())
        <div class="card shadow-lg border-0 mx-auto p-4 animate-float"
             style="max-width: 750px; border-radius: 18px; background: rgba(255, 255, 255, 0.95);">
             
            <p class="fw-semibold text-muted mb-4">
                Pilih file template surat yang sesuai dengan pengajuan anda, <br>
                lalu klik tombol <span class="text-primary fw-bold">Download</span>
            </p>

            <div class="list-group border-0">
                @foreach($templates as $template)
                    @php
                        $ext = strtolower(pathinfo($template->nama_file, PATHINFO_EXTENSION));
                        $sizeKB = $template->ukuran_file ? round($template->ukuran_file / 1024, 2) : '—';
                        $icon = 'bi-file-earmark';
                        $color = '#6c757d';
                        $typeLabel = strtoupper($ext);

                        if ($ext === 'pdf') { $icon = 'bi-file-earmark-pdf'; $color = '#dc3545'; $typeLabel = 'PDF File'; }
                        elseif (in_array($ext, ['doc', 'docx'])) { $icon = 'bi-file-earmark-word'; $color = '#0d6efd'; $typeLabel = 'Word Document'; }
                        elseif (in_array($ext, ['xls', 'xlsx'])) { $icon = 'bi-file-earmark-excel'; $color = '#198754'; $typeLabel = 'Excel Sheet'; }
                        else { $typeLabel = strtoupper($ext).' File'; }
                    @endphp

                    <div class="list-group-item border-0 mb-3 shadow-sm rounded-4 animate-item p-3"
                         style="background: #f9fbff; transition: all 0.3s;">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="d-flex align-items-center text-start mb-2 mb-md-0">
                                <i class="bi {{ $icon }} me-3" style="font-size: 2rem; color: {{ $color }}"></i>
                                <div>
                                    <span class="fw-semibold text-dark">{{ $template->nama_file }}</span>
                                    <div class="small text-muted mt-1">
                                        <i class="bi bi-clock-history me-1"></i> {{ $template->created_at->format('d M Y, H:i') }} <br>
                                        <i class="bi bi-file-earmark me-1"></i> {{ $typeLabel }}
                                        @if($sizeKB !== '—')
                                            <span class="ms-2"><i class="bi bi-hdd me-1"></i> {{ $sizeKB }} KB</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                
                                <a href="{{ route('skpd.template.download', $template->id) }}"
                                   class="btn btn-outline-primary btn-sm px-3 fw-semibold rounded-pill">
                                    <i class="bi bi-arrow-down-circle me-1"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>

                   

                @endforeach
            </div>
        </div>
    @else
        <div class="alert alert-info text-center shadow-sm border-0 mx-auto animate-fadein" style="max-width: 500px;">
            <i class="bi bi-info-circle me-2"></i>
            Belum ada template surat yang diunggah oleh admin.
        </div>
    @endif
</div>

{{-- 🌟 Style tambahan untuk efek halus --}}
<style>
    .animate-fadein { animation: fadeIn 0.8s ease forwards; opacity: 0; }
    .animate-up { animation: slideUp 0.9s ease forwards; opacity: 0; }
    .animate-float { animation: floatIn 1s ease forwards; opacity: 0; }
    .animate-item { animation: fadeInUp 0.6s ease forwards; opacity: 0; }
    .animate-item:nth-child(1) { animation-delay: 0.2s; }
    .animate-item:nth-child(2) { animation-delay: 0.4s; }
    .animate-item:nth-child(3) { animation-delay: 0.6s; }

    .list-group-item:hover {
        background: #eef5ff !important;
        transform: translateY(-3px);
        box-shadow: 0 8px 14px rgba(13,110,253,0.18);
    }
    .btn-outline-primary:hover {
        background: #0d6efd;
        color: #fff;
        transform: scale(1.07);
        box-shadow: 0 6px 12px rgba(13,110,253,0.3);
    }
    .btn-outline-success:hover {
        background: #198754;
        color: #fff;
        transform: scale(1.07);
        box-shadow: 0 6px 12px rgba(25,135,84,0.3);
    }

    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(15px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    @keyframes floatIn {
        0% { opacity: 0; transform: translateY(20px) scale(0.98); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection