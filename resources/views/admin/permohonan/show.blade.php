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
    @if($permohonan->vendor == 'iya')
        <span class="text">Iya</span>
    @else
        <span class="text">Tidak</span>
    @endif
</p>

@if($permohonan->vendor == 'iya')
    <p><strong>Nama Vendor:</strong> {{ $permohonan->nama_vendor ?? '-' }}</p>
@endif


            {{-- Tampilkan nama subdomain jika kategori = 3 dan subkategori = 6 --}}
            @if ($permohonan->category_id == 3 && $permohonan->subcategory_id == 6)
                <p><strong>Nama Subdomain:</strong> {{ optional($permohonan->subdomain)->nama_subdomain ?? '-' }}</p>
            @else
                <p><strong>Subjek:</strong> {{ $permohonan->subjek }}</p>
                <p><strong>Deskripsi:</strong> {!! nl2br(e($permohonan->deskiprsi)) !!}</p>
                <p><strong>Lokasi:</strong> {{ $permohonan->lokasi }}</p>
            @endif

            <p><strong>Status:</strong>
                @if ($permohonan->status == 'disetujui')
                    <span class="badge bg-success">Disetujui</span>
                @elseif ($permohonan->status == 'menunggu')
                    <span class="badge bg-warning text-dark">Menunggu</span>
                @else
                    <span class="badge bg-danger">Ditolak</span>
                @endif
            </p>

            {{-- tampilkan keterangan admin jika sudah ada --}}
            @if(!empty($permohonan->keterangan_admin))
                <div class="mb-3">
                    <label class="form-label fw-bold">Keterangan Admin (terakhir):</label>
                    <div class="p-3 border rounded bg-light">
                        {!! nl2br(e($permohonan->keterangan_admin)) !!}
                    </div>
                </div>
            @endif

            @if($permohonan->file_pengajuan)
                <p><strong>File Pengajuan:</strong>
                    <a href="{{ asset('uploads/permohonan/' . $permohonan->file_pengajuan) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-file-earmark-pdf"></i> Lihat File
                    </a>
                </p>
            @endif

            <form action="{{ route('admin.permohonan.updateStatus', $permohonan->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf
                @method('POST')

                <div class="mb-3">
                    <label for="status" class="form-label fw-bold">Ubah Status Permohonan</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="menunggu"  {{ $permohonan->status == 'menunggu'  ? 'selected' : '' }}>Menunggu</option>
                        <option value="disetujui" {{ $permohonan->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak"   {{ $permohonan->status == 'ditolak'   ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="keterangan_admin" class="form-label fw-bold">Keterangan Admin (opsional)</label>
                    <textarea name="keterangan_admin" id="keterangan_admin" rows="4" class="form-control" maxlength="500" placeholder="Tulis penjelasan singkat...">@if(old('keterangan_admin')){{ old('keterangan_admin') }}@else{{ $permohonan->keterangan_admin }}@endif</textarea>
                    <div class="form-text">Maks. 500 karakter.</div>
                    @error('keterangan_admin') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Upload Surat Tindak Lanjut (opsional)</label>
                    <input type="file" name="file_tindak_lanjut" class="form-control" accept=".pdf,.doc,.docx">
                    @error('file_tindak_lanjut') <small class="text-danger">{{ $message }}</small> @enderror

                    @if ($permohonan->file_tindak_lanjut)
                        <div class="mt-2">
                            <a href="{{ asset('uploads/tindaklanjut/' . $permohonan->file_tindak_lanjut) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-file-earmark"></i> Lihat Surat Tindak Lanjut
                            </a>
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.permohonan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection