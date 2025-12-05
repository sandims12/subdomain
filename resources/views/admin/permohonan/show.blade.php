@extends('admin.layouts.wrapper')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

        {{-- Header --}}
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-info-circle me-2"></i> Detail Permohonan
                </h5>
            </div>
        </div>

        {{-- Body --}}
        <div class="card-body bg-light-subtle p-4">

            {{-- RINGKASAN PERMOHONAN ATAS --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1 text-dark">
                        <i class="bi bi-file-earmark-text me-1 text-primary"></i> Detail Permohonan
                    </h5>
                    <div class="small text-muted">
                        Diajukan oleh
                        <strong>{{ $permohonan->skpd->name ?? '-' }}</strong>
                        @if($permohonan->created_at)
                            pada {{ $permohonan->created_at->translatedFormat('d F Y') }}
                        @endif
                    </div>
                </div>

                <div class="text-end">
                    {{-- status permohonan utama --}}
                    <div class="mb-1">
                        @if ($permohonan->status == 'disetujui')
                            <span class="badge bg-success px-3 py-2 rounded-pill">
                                <i class="bi bi-check-circle me-1"></i> Disetujui
                            </span>
                        @elseif ($permohonan->status == 'menunggu')
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                <i class="bi bi-hourglass-split me-1"></i> Menunggu
                            </span>
                        @else
                            <span class="badge bg-danger px-3 py-2 rounded-pill">
                                <i class="bi bi-x-circle me-1"></i> Ditolak
                            </span>
                        @endif
                    </div>

                    {{-- kategori & subkategori sebagai label kecil --}}
                    <div class="small">
                        <span class="badge rounded-pill bg-light text-secondary border me-1">
                            <i class="bi bi-grid-1x2 me-1"></i>
                            {{ $permohonan->category->name ?? 'Tanpa Kategori' }}
                        </span>
                        <span class="badge rounded-pill bg-light text-secondary border">
                            <i class="bi bi-diagram-3 me-1"></i>
                            {{ $permohonan->subcategory->name ?? 'Tanpa Subkategori' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Info SKPD dan Vendor --}}
            <div class="mb-4">
                <h6 class="fw-bold text-primary mb-2">
                    <i class="bi bi-building me-1"></i> Informasi Umum
                </h6>
                <div class="ps-2 py-2 bg-white p-4 border rounded-3 shadow-sm-sm">
                    <dl class="row mb-0">
                        <dt class="col-sm-3 text-muted small">Nama SKPD</dt>
                        <dd class="col-sm-9">{{ $permohonan->skpd->name ?? '-' }}</dd>

                        <dt class="col-sm-3 text-muted small">Menggunakan Vendor</dt>
                        <dd class="col-sm-9">
                            @if($permohonan->vendor == 'iya')
                                <span class="badge bg-info-subtle text-info">
                                    <i class="bi bi-check2-circle me-1"></i> Iya, menggunakan vendor
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Tidak menggunakan vendor
                                </span>
                            @endif
                        </dd>

                        @if($permohonan->vendor == 'iya')
                            <dt class="col-sm-3 text-muted small">Nama Vendor</dt>
                            <dd class="col-sm-9">{{ $permohonan->nama_vendor ?? '-' }}</dd>
                        @endif
                    </dl>
                </div>
            </div>

            @php
                $subcategoryName = strtolower(str_replace(' ', '', $permohonan->subcategory?->name ?? ''));
                $isSubdomain = !empty($permohonan->nama_subdomain) || $subcategoryName === 'subdomain';
                $sd = $permohonan->subdomain; // relasi subdomain (bisa null)
            @endphp

            {{-- ====== JIKA SUBDOMAIN ====== --}}
            @if ($isSubdomain)
                <div class="row mb-4 g-3">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-primary mb-2">
                            <i class="bi bi-hdd-network me-1"></i> Informasi Subdomain
                        </h6>
                        <div class="ps-2 py-2 bg-white p-4 border rounded-3">
                            <dl class="row mb-0">
                                <dt class="col-sm-4 text-muted small">Nama Subdomain</dt>
                                <dd class="col-sm-8 fw-semibold text-primary">
                                    {{ $permohonan->nama_subdomain ?? $sd?->nama_subdomain ?? '-' }}
                                </dd>

                                <dt class="col-sm-4 text-muted small">Link</dt>
                                <dd class="col-sm-8">
                                    @if($sd?->link)
                                        <a href="{{ $sd->link }}"
                                           target="_blank"
                                           class="text-decoration-none">
                                            <i class="bi bi-box-arrow-up-right me-1"></i>
                                            {{ $sd->link }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </dd>

                                <dt class="col-sm-4 text-muted small">Status Subdomain</dt>
                                <dd class="col-sm-8">
                                    @php
                                        $statusSub = strtolower($sd->status ?? '');
                                        $badgeStatusSub = match($statusSub) {
                                            'aktif'   => 'success',
                                            'pending' => 'info text-dark',
                                            'nonaktif'=> 'secondary',
                                            default   => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badgeStatusSub }} rounded-pill px-3">
                                        {{ ucfirst($sd->status ?? 'Belum Aktif') }}
                                    </span>
                                </dd>

                                <dt class="col-sm-4 text-muted small">Kondisi</dt>
                                <dd class="col-sm-8">
                                    @php
                                        $kondisiVal = strtolower($sd->kondisi ?? '');
                                        $badgeKondisi = match($kondisiVal) {
                                            'aktif'    => 'success',
                                            'nonaktif' => 'warning text-dark',
                                            'error'    => 'danger',
                                            default    => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badgeKondisi }} rounded-pill px-3">
                                        {{ ucfirst($sd->kondisi ?? 'Tidak diketahui') }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold text-primary mb-2">
                            <i class="bi bi-code-slash me-1"></i> Detail Aplikasi
                        </h6>
                        <div class="ps-2 py-2 bg-white p-4 border rounded-3">
                            <dl class="row mb-0">
                                <dt class="col-sm-4 text-muted small">Nama Aplikasi</dt>
                                <dd class="col-sm-8">{{ $sd?->nama_aplikasi ?? '-' }}</dd>

                                <dt class="col-sm-4 text-muted small">Anggaran</dt>
                                <dd class="col-sm-8">{{ $sd?->anggaran ?? '-' }}</dd>

                                <dt class="col-sm-4 text-muted small">Sifat</dt>
                                <dd class="col-sm-8">{{ $sd?->sifat ?? '-' }}</dd>

                                <dt class="col-sm-4 text-muted small">Tahun</dt>
                                <dd class="col-sm-8">{{ $sd?->tahun_penganggaran ?? '-' }}</dd>

                                <dt class="col-sm-4 text-muted small">Layanan</dt>
                                <dd class="col-sm-8">{{ $sd?->layanan ?? '-' }}</dd>

                                <dt class="col-sm-4 text-muted small">Platform OS</dt>
                                <dd class="col-sm-8">{{ $sd?->platform_os ?? '-' }}</dd>

                                <dt class="col-sm-4 text-muted small">Jenis Aplikasi</dt>
                                <dd class="col-sm-8">{{ $sd?->jenis_aplikasi ?? '-' }}</dd>

                                <dt class="col-sm-4 text-muted small">Database</dt>
                                <dd class="col-sm-8">{{ $sd?->database_engine ?? '-' }}</dd>

                                <dt class="col-sm-4 text-muted small">Bahasa Pemrograman</dt>
                                <dd class="col-sm-8">{{ $sd?->bahasa_pemrograman ?? '-' }}</dd>

                                <dt class="col-sm-4 text-muted small">Pengelola</dt>
                                <dd class="col-sm-8">{{ $sd?->pengelola ?? '-' }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                {{-- Catatan pembangunan / kendala / rencana --}}
                <div class="mb-4">
                    <h6 class="fw-bold text-primary mb-2">
                        <i class="bi bi-journal-text me-1"></i> Catatan Pembangunan
                    </h6>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 bg-white border rounded-3 h-100">
                                <div class="small text-muted mb-1">
                                    <i class="bi bi-hammer me-1 text-primary"></i> Keterangan Pembangunan
                                </div>
                                <div class="mt-1 text-muted small">
                                    {!! nl2br(e($sd?->ket_pembangunan ?? '-')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 bg-white border rounded-3 h-100">
                                <div class="small text-muted mb-1">
                                    <i class="bi bi-exclamation-triangle me-1 text-warning"></i> Kendala Pembangunan
                                </div>
                                <div class="mt-1 text-muted small">
                                    {!! nl2br(e($sd?->kendala_pembangunan ?? '-')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 bg-white border rounded-3 h-100">
                                <div class="small text-muted mb-1">
                                    <i class="bi bi-compass me-1 text-success"></i> Rencana Tindak Lanjut
                                </div>
                                <div class="mt-1 text-muted small">
                                    {!! nl2br(e($sd?->rencana_tindak_lanjut ?? '-')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            {{-- ====== JIKA BUKAN SUBDOMAIN ====== --}}
            @else
                <div class="mb-4">
                    <h6 class="fw-bold text-primary mb-2">
                        <i class="bi bi-file-text me-1"></i> Detail Permohonan
                    </h6>
                    <div class="ps-2 py-2 bg-white p-4 border rounded-3">
                        <dl class="row mb-0">
                            <dt class="col-sm-3 text-muted small">Subjek</dt>
                            <dd class="col-sm-9">{{ $permohonan->subjek ?? '-' }}</dd>

                            <dt class="col-sm-3 text-muted small">Deskripsi</dt>
                            <dd class="col-sm-9">{!! nl2br(e($permohonan->deskiprsi ?? '-')) !!}</dd>

                            <dt class="col-sm-3 text-muted small">Lokasi</dt>
                            <dd class="col-sm-9">{{ $permohonan->lokasi ?? '-' }}</dd>
                        </dl>
                    </div>
                </div>
            @endif

            {{-- Status & File --}}
            <div class="mb-4">
                <h6 class="fw-bold text-primary mb-2">
                    <i class="bi bi-folder-check me-1"></i> Status & Dokumen
                </h6>
                <div class="ps-2 py-2 bg-white p-4 border rounded-3">
                    <dl class="row mb-0">
                        <dt class="col-sm-3 text-muted small">Status Permohonan</dt>
                        <dd class="col-sm-9">
                            @if ($permohonan->status == 'disetujui')
                                <span class="badge bg-success px-3 py-2 rounded-pill">
                                    <i class="bi bi-check-circle me-1"></i> Disetujui
                                </span>
                            @elseif ($permohonan->status == 'menunggu')
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                    <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                </span>
                            @else
                                <span class="badge bg-danger px-3 py-2 rounded-pill">
                                    <i class="bi bi-x-circle me-1"></i> Ditolak
                                </span>
                            @endif
                        </dd>

                        {{-- FILE PENGAJUAN --}}
                        @if($permohonan->file_pengajuan)
                            @php
                                $file  = $permohonan->file_pengajuan;
                                $ext   = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                $url   = asset('uploads/permohonan/' . $file);
                            @endphp

                            <dt class="col-sm-3 text-muted small">File Pengajuan</dt>
                            <dd class="col-sm-9">
                                <div class="border rounded shadow-sm p-2" style="background:#fff;">
                                    @if($ext === 'pdf')
                                        <iframe
                                            src="{{ $url }}"
                                            width="100%"
                                            height="600px"
                                            style="border:none;border-radius:6px;">
                                        </iframe>
                                    @else
                                        <a href="{{ $url }}"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-primary rounded-pill">
                                            <i class="bi bi-file-earmark-arrow-down me-1"></i>
                                            Download File
                                        </a>
                                    @endif
                                </div>
                            </dd>
                        @else
                            <dt class="col-sm-3 text-muted small">File Pengajuan</dt>
                            <dd class="col-sm-9 text-muted small">
                                Tidak ada file pengajuan.
                            </dd>
                        @endif
                    </dl>
                </div>
            </div>

            {{-- Form Update --}}
            <div class="border-top pt-4">
                <h6 class="fw-bold text-primary mb-3">
                    <i class="bi bi-gear me-1"></i> Ubah Status Permohonan
                </h6>

                <form action="{{ route('admin.permohonan.updateStatus', $permohonan->id) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="nama_subdomain"
                           value="{{ $permohonan->nama_subdomain }}">

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Status Permohonan</label>
                            <select name="status" class="form-select shadow-sm" required>
                                <option value="menunggu"  {{ $permohonan->status == 'menunggu'  ? 'selected' : '' }}>Menunggu</option>
                                <option value="disetujui" {{ $permohonan->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="ditolak"   {{ $permohonan->status == 'ditolak'   ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-semibold">Keterangan Admin (opsional)</label>
                            <textarea name="keterangan_admin"
                                      rows="3"
                                      class="form-control shadow-sm"
                                      placeholder="Tulis penjelasan singkat...">{{ $permohonan->keterangan_admin }}</textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload Surat Tindak Lanjut (opsional)</label>
                        <input type="file" name="file_tindak_lanjut"
                               class="form-control shadow-sm"
                               accept=".pdf,.doc,.docx">

                        @if ($permohonan->file_tindak_lanjut)
                            <div class="mt-2">
                                <a href="{{ asset('uploads/tindaklanjut/' . $permohonan->file_tindak_lanjut) }}"
                                   target="_blank"
                                   class="btn btn-outline-secondary btn-sm rounded-pill">
                                    <i class="bi bi-file-earmark me-1"></i> Lihat Surat Tindak Lanjut
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                            <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.permohonan.index') }}"
                           class="btn btn-secondary rounded-pill px-4">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<style>
    .card-header { background: linear-gradient(90deg,#0069d9 0%,#007bff 100%); }
    .bg-light-subtle { background-color: #f9fafc; }
    .badge { font-size: .75rem; }
    .form-label { font-size: .9rem; }
    .card-body p { margin-bottom: .4rem; }

    iframe {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection