@extends('admin.layouts.wrapper')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        {{-- Header --}}
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-info-circle me-2"></i> Detail Permohonan</h5>
                
                
            </div>
        </div>

        {{-- Body --}}
        <div class="card-body bg-light-subtle p-4">
            {{-- Info SKPD dan Vendor --}}
            <div class="mb-4">
                <h6 class="fw-bold text-primary"><i class="bi bi-building"></i> Informasi Umum</h6>
                <div class="ps-2">
                    <p><strong>Nama SKPD:</strong> {{ $permohonan->skpd->name ?? '-' }}</p>
                    <p><strong>Menggunakan Vendor:</strong> {{ $permohonan->vendor == 'iya' ? 'Iya' : 'Tidak' }}</p>
                    @if($permohonan->vendor == 'iya')
                        <p><strong>Nama Vendor:</strong> {{ $permohonan->nama_vendor ?? '-' }}</p>
                    @endif
                </div>
            </div>

            @php
                $isSubdomain = !empty($permohonan->nama_subdomain)
                    || (strtolower(str_replace(' ', '', $permohonan->subcategory->name ?? '')) === 'subdomain');
            @endphp

            {{-- ====== JIKA SUBDOMAIN ====== --}}
            @if ($isSubdomain)
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-primary"><i class="bi bi-hdd-network"></i> Informasi Subdomain</h6>
                        <div class="ps-2">
                            <p><strong>Nama Subdomain:</strong> {{ $permohonan->nama_subdomain ?? '-' }}</p>
                            <p><strong>Link:</strong> 
                                @if($permohonan->subdomain?->link)
                                    <a href="{{ $permohonan->subdomain->link }}" target="_blank">{{ $permohonan->subdomain->link }}</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </p>
                            <p><strong>Status Subdomain:</strong>
                                <span class="badge bg-{{ ($permohonan->subdomain->status ?? '') === 'aktif' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($permohonan->subdomain->status ?? 'Belum Aktif') }}
                                </span>
                            </p>
                            <p><strong>Kondisi:</strong>
                                @php
                                    $badgeKondisi = match($permohonan->subdomain->kondisi ?? '') {
                                        'aktif' => 'success',
                                        'nonaktif' => 'warning text-dark',
                                        'error' => 'danger',
                                        default => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeKondisi }} rounded-pill">
                                    {{ ucfirst($permohonan->subdomain->kondisi ?? 'Tidak diketahui') }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold text-primary"><i class="bi bi-code-slash"></i> Detail Aplikasi</h6>
                        <div class="ps-2">
                            <p><strong>Nama Aplikasi:</strong> {{ $permohonan->subdomain->nama_aplikasi ?? '-' }}</p>
                            <p><strong>Sifat:</strong> {{ $permohonan->subdomain->sifat ?? '-' }}</p>
                            <p><strong>Tahun:</strong> {{ $permohonan->subdomain->tahun_penganggaran ?? '-' }}</p>
                            <p><strong>Layanan:</strong> {{ $permohonan->subdomain->layanan ?? '-' }}</p>
                            <p><strong>Platform OS:</strong> {{ $permohonan->subdomain->platform_os ?? '-' }}</p>
                            <p><strong>Jenis Aplikasi:</strong> {{ $permohonan->subdomain->jenis_aplikasi ?? '-' }}</p>
                            <p><strong>Database Engine:</strong> {{ $permohonan->subdomain->database_engine ?? '-' }}</p>
                            <p><strong>Bahasa Pemrograman:</strong> {{ $permohonan->subdomain->bahasa_pemrograman ?? '-' }}</p>
                            <p><strong>Pengelola:</strong> {{ $permohonan->subdomain->pengelola ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-primary"><i class="bi bi-journal-text"></i> Catatan Pembangunan</h6>
                    <div class="p-3 bg-white border rounded shadow-sm mb-3">
                        <strong>Keterangan Pembangunan:</strong>
                        <div class="mt-2 text-muted">{!! nl2br(e($permohonan->subdomain->ket_pembangunan ?? '-')) !!}</div>
                    </div>
                    <div class="p-3 bg-white border rounded shadow-sm">
                        <strong>Kendala Pembangunan:</strong>
                        <div class="mt-2 text-muted">{!! nl2br(e($permohonan->subdomain->kendala_pembangunan ?? '-')) !!}</div>
                    </div>
                </div>

            {{-- ====== JIKA BUKAN SUBDOMAIN ====== --}}
            @else
                <div class="mb-4">
                    <h6 class="fw-bold text-primary"><i class="bi bi-file-text"></i> Detail Permohonan</h6>
                    <div class="ps-2">
                        <p><strong>Subjek:</strong> {{ $permohonan->subjek ?? '-' }}</p>
                        <p><strong>Deskripsi:</strong> {!! nl2br(e($permohonan->deskiprsi ?? '-')) !!}</p>
                        <p><strong>Lokasi:</strong> {{ $permohonan->lokasi ?? '-' }}</p>
                    </div>
                </div>
            @endif

            {{-- Status & File --}}
            <div class="mb-4">
                <h6 class="fw-bold text-primary"><i class="bi bi-folder-check"></i> Status & File</h6>
                <div class="ps-2">
                    <p><strong>Status Permohonan:</strong>
                        @if ($permohonan->status == 'disetujui')
                            <span class="badge bg-success px-3 py-2 rounded-pill">Disetujui</span>
                        @elseif ($permohonan->status == 'menunggu')
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Menunggu</span>
                        @else
                            <span class="badge bg-danger px-3 py-2 rounded-pill">Ditolak</span>
                        @endif
                    </p>

                    @if($permohonan->file_pengajuan)
                        <p><strong>File Pengajuan:</strong>
                            <a href="{{ asset('uploads/permohonan/' . $permohonan->file_pengajuan) }}" 
                               target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-file-earmark-pdf"></i> Lihat File Pengajuan
                            </a>
                        </p>
                    @endif
                </div>
            </div>

            {{-- Form Update --}}
            <div class="border-top pt-4">
                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-gear"></i> Ubah Status Permohonan</h6>
                <form action="{{ route('admin.permohonan.updateStatus', $permohonan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

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
                            <textarea name="keterangan_admin" rows="3" class="form-control shadow-sm"
                                placeholder="Tulis penjelasan singkat...">{{ $permohonan->keterangan_admin }}</textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload Surat Tindak Lanjut (opsional)</label>
                        <input type="file" name="file_tindak_lanjut" class="form-control shadow-sm" accept=".pdf,.doc,.docx">

                        @if ($permohonan->file_tindak_lanjut)
                            <div class="mt-2">
                                <a href="{{ asset('uploads/tindaklanjut/' . $permohonan->file_tindak_lanjut) }}" 
                                   target="_blank" 
                                   class="btn btn-outline-secondary btn-sm rounded-pill">
                                    <i class="bi bi-file-earmark"></i> Lihat Surat Tindak Lanjut
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                            <i class="bi bi-check-circle"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.permohonan.index') }}" class="btn btn-secondary rounded-pill px-4">
                            <i class="bi bi-arrow-left"></i> Kembali
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
</style>
@endsection
