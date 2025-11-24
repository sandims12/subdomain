@extends('skpd.layouts.wrapper')

@section('content')
<div class="container-fluid px-4 py-4">

  <div class="mb-4">
    <h4 class="fw-bold text-primary"><i class="bi bi-info-circle"></i> Detail Permohonan</h4>
    <p class="text-muted mb-0">Informasi lengkap tentang permohonan subdomain Anda.</p>
    <div class="mt-2" style="width:100px;height:3px;background:linear-gradient(90deg,#0d6efd,#00b894);border-radius:999px"></div>
  </div>

  <div class="card shadow-sm border-0 rounded-4 bg-white">
    <div class="card-body p-4">

      <h6 class="fw-bold text-primary mb-3"><i class="bi bi-building"></i> Informasi SKPD</h6>
      <p><strong>Nama SKPD:</strong> {{ $permohonan->skpd->name ?? '-' }}</p>
      <p><strong>Menggunakan Vendor:</strong> {{ $permohonan->vendor == 'iya' ? 'Iya' : 'Tidak' }}</p>
      @if($permohonan->vendor == 'iya')
        <p><strong>Nama Vendor:</strong> {{ $permohonan->nama_vendor ?? '-' }}</p>
      @endif

      <hr>
      <h6 class="fw-bold text-primary mb-3"><i class="bi bi-tags"></i> Kategori Permohonan</h6>
      <p><strong>Kategori:</strong> {{ $permohonan->category->name ?? '-' }}</p>
      <p><strong>Subkategori:</strong> {{ $permohonan->subcategory->name ?? '-' }}</p>
      <p><strong>Tanggal Pengajuan:</strong> {{ $permohonan->created_at?->translatedFormat('d M Y') }}</p>

      <hr>
      <h6 class="fw-bold text-primary mb-3"><i class="bi bi-info-lg"></i> Rincian</h6>
      <p><strong>Subjek:</strong> {{ $permohonan->subjek ?? '-' }}</p>
      <p><strong>Deskripsi:</strong> {!! nl2br(e($permohonan->deskiprsi ?? '-')) !!}</p>
      <p><strong>Lokasi:</strong> {{ $permohonan->lokasi ?? '-' }}</p>

      <hr>
      <h6 class="fw-bold text-primary mb-3"><i class="bi bi-clipboard-check"></i> Status Permohonan</h6>
      <p>
        @if($permohonan->status == 'disetujui')
          <span class="badge bg-success">Disetujui</span>
        @elseif($permohonan->status == 'menunggu')
          <span class="badge bg-warning text-dark">Menunggu</span>
        @else
          <span class="badge bg-danger">Ditolak</span>
        @endif
      </p>

      @if($permohonan->file_pengajuan)
        <p><strong>File Pengajuan:</strong>
          <a href="{{ asset('uploads/permohonan/' . $permohonan->file_pengajuan) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
            <i class="bi bi-file-earmark"></i> Lihat File
          </a>
        </p>
      @endif

      @if($permohonan->status != 'menunggu')
        <hr>
        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-chat-left-text"></i> Balasan Admin</h6>
        <div class="bg-light border rounded p-3 mb-3">
          {!! nl2br(e($permohonan->keterangan_admin ?? 'Belum ada keterangan dari admin.')) !!}
        </div>

        @if($permohonan->file_tindak_lanjut)
          <a href="{{ asset('uploads/tindaklanjut/' . $permohonan->file_tindak_lanjut) }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill">
            <i class="bi bi-file-earmark-arrow-down"></i> Lihat File Balasan
          </a>
        @endif
      @endif

      <div class="mt-4">
        <a href="{{ route('skpd.permohonan.index') }}" class="btn btn-secondary rounded-pill px-4">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
      </div>

    </div>
  </div>
</div>
@endsection
