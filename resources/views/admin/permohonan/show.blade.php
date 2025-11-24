@extends('admin.layouts.wrapper')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0 fw-bold">Detail Permohonan Subdomain</h5>
        </div>
        <div class="card-body">

            <p><strong>Nama SKPD:</strong> {{ $permohonan->skpd->name ?? '-' }}</p>

            {{-- Informasi Vendor --}}
            <p><strong>Menggunakan Vendor:</strong>
                {{ $permohonan->vendor == 'iya' ? 'Iya' : 'Tidak' }}
            </p>

            @if($permohonan->vendor == 'iya')
                <p><strong>Nama Vendor:</strong> {{ $permohonan->nama_vendor ?? '-' }}</p>
            @endif

            @php
                // deteksi permohonan subdomain:
                // 1) kalau ada nama_subdomain di permohonan
                // 2) atau nama subkategori-nya "Subdomain"
                $isSubdomain = !empty($permohonan->nama_subdomain)
                    || (strtolower(str_replace(' ', '', $permohonan->subcategory->name ?? '')) === 'subdomain');
            @endphp

            {{-- ====== JIKA SUBDOMAIN ====== --}}
            @if ($isSubdomain)

                <p><strong>Nama Subdomain:</strong>
                    @if($permohonan->subdomain)
                        {{-- sudah punya record di tabel subdomain --}}
                        {{ $permohonan->subdomain->nama_subdomain }}
                    @else
                        {{-- masih menunggu, pakai data di tabel permohonan --}}
                        {{ $permohonan->nama_subdomain ?? '-' }}
                    @endif
                </p>

                @if($permohonan->subdomain)
                    <p><strong>Link:</strong>
                        @if($permohonan->subdomain->link)
                            <a href="{{ $permohonan->subdomain->link }}" target="_blank">
                                {{ $permohonan->subdomain->link }}
                            </a>
                        @else
                            -
                        @endif
                    </p>

                    <p><strong>Status Subdomain:</strong>
                        <span class="badge bg-{{ $permohonan->subdomain->status === 'aktif' ? 'success' : 'secondary' }}">
                            {{ $permohonan->subdomain->status }}
                        </span>
                    </p>

                    <p><strong>Kondisi:</strong>
                        @php
                            $badgeKondisi = match($permohonan->subdomain->kondisi) {
                                'aktif'    => 'success',
                                'nonaktif' => 'secondary',
                                'error'    => 'danger',
                                default    => 'light',
                            };
                        @endphp
                        <span class="badge bg-{{ $badgeKondisi }} text-capitalize">
                            {{ $permohonan->subdomain->kondisi }}
                        </span>
                    </p>

                    {{-- Tambahkan kolom detail aplikasi --}}
                    <p><strong>Nama Aplikasi:</strong> {{ $permohonan->subdomain->nama_aplikasi ?? '-' }}</p>
                    <p><strong>Sifat Aplikasi:</strong> {{ $permohonan->subdomain->sifat ?? '-' }}</p>
                    <p><strong>Tahun Penganggaran:</strong> {{ $permohonan->subdomain->tahun_penganggaran ?? '-' }}</p>
                    <p><strong>Layanan:</strong> {{ $permohonan->subdomain->layanan ?? '-' }}</p>
                    <p><strong>Platform OS:</strong> {{ $permohonan->subdomain->platform_os ?? '-' }}</p>
                    <p><strong>Jenis Aplikasi:</strong> {{ $permohonan->subdomain->jenis_aplikasi ?? '-' }}</p>
                    <p><strong>Database Engine:</strong> {{ $permohonan->subdomain->database_engine ?? '-' }}</p>
                    <p><strong>Bahasa Pemrograman:</strong> {{ $permohonan->subdomain->bahasa_pemrograman ?? '-' }}</p>
                    <p><strong>Status Aplikasi:</strong> {{ $permohonan->subdomain->status_aplikasi ?? '-' }}</p>
                    <p><strong>Pengelola:</strong> {{ $permohonan->subdomain->pengelola ?? '-' }}</p>
                    <p><strong>Keterangan Pembangunan:</strong> {!! nl2br(e($permohonan->subdomain->ket_pembangunan ?? '-')) !!}</p>
                    <p><strong>Kendala Pembangunan:</strong> {!! nl2br(e($permohonan->subdomain->kendala_pembangunan ?? '-')) !!}</p>

                @endif

            @else
            {{-- ====== JIKA BUKAN SUBDOMAIN ====== --}}
                <p><strong>Subjek:</strong> {{ $permohonan->subjek }}</p>
                <p><strong>Deskripsi:</strong> {!! nl2br(e($permohonan->deskiprsi)) !!}</p>
                <p><strong>Lokasi:</strong> {{ $permohonan->lokasi }}</p>
            @endif

            {{-- Status --}}
            <p><strong>Status:</strong>
                @if ($permohonan->status == 'disetujui')
                    <span class="badge bg-success">Disetujui</span>
                @elseif ($permohonan->status == 'menunggu')
                    <span class="badge bg-warning text-dark">Menunggu</span>
                @else
                    <span class="badge bg-danger">Ditolak</span>
                @endif
            </p>

            {{-- Keterangan Admin --}}
            @if(!empty($permohonan->keterangan_admin))
                <div class="mb-3">
                    <label class="form-label fw-bold">Keterangan Admin (terakhir):</label>
                    <div class="p-3 border rounded bg-light">
                        {!! nl2br(e($permohonan->keterangan_admin)) !!}
                    </div>
                </div>
            @endif

            {{-- File Pengajuan --}}
            @if($permohonan->file_pengajuan)
                <p><strong>File Pengajuan:</strong>
                    <a href="{{ asset('uploads/permohonan/' . $permohonan->file_pengajuan) }}" 
                       target="_blank" 
                       class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-file-earmark-pdf"></i> Lihat File
                    </a>
                </p>
            @endif

            {{-- FORM UPDATE STATUS --}}
            <form action="{{ route('admin.permohonan.updateStatus', $permohonan->id) }}" 
                  method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf
                @method('POST')

                <div class="mb-3">
                    <label class="form-label fw-bold">Ubah Status Permohonan</label>
                    <select name="status" class="form-select" required>
                        <option value="menunggu"  {{ $permohonan->status == 'menunggu'  ? 'selected' : '' }}>Menunggu</option>
                        <option value="disetujui" {{ $permohonan->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak"   {{ $permohonan->status == 'ditolak'   ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Keterangan Admin (opsional)</label>
                    <textarea name="keterangan_admin" rows="4" class="form-control" maxlength="500"
                        placeholder="Tulis penjelasan singkat...">{{ $permohonan->keterangan_admin }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Upload Surat Tindak Lanjut (opsional)</label>
                    <input type="file" name="file_tindak_lanjut" class="form-control" accept=".pdf,.doc,.docx">

                    @if ($permohonan->file_tindak_lanjut)
                        <div class="mt-2">
                            <a href="{{ asset('uploads/tindaklanjut/' . $permohonan->file_tindak_lanjut) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-file-earmark"></i> Lihat Surat Tindak Lanjut
                            </a>
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn_success">
                    <i class="bi bi-check-circle"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.permohonan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>

        </div>
    </div>
</div>
@endsection
