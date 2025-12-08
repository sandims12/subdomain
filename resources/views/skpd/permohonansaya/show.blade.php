@extends('skpd.layouts.wrapper')

@section('content')
<div class="container-fluid px-4 py-4">

  <div class="mb-4">
    <h4 class="fw-bold text-primary">
        <i class="bi bi-info-circle"></i> Detail Permohonan
    </h4>
    <p class="text-muted mb-0">Informasi lengkap tentang permohonan subdomain Anda.</p>
    <div class="mt-2"
         style="width:100px;height:3px;background:linear-gradient(90deg,#0d6efd,#00b894);border-radius:999px">
    </div>
  </div>

  @php
      $isSubdomain = $permohonan->subcategory
          && strtolower(str_replace(' ', '', $permohonan->subcategory->name)) === 'subdomain';

      $sd = $permohonan->subdomain; // relasi Subdomain (bisa null)
  @endphp

  <div class="card shadow-sm border-0 rounded-4 bg-white">
    <div class="card-body p-4">

      {{-- INFORMASI SKPD --}}
      <h6 class="fw-bold text-primary mb-3">
        <i class="bi bi-building"></i> Informasi SKPD
      </h6>
      <p><strong>Nama SKPD:</strong> {{ $permohonan->skpd->name ?? '-' }}</p>
      <p><strong>Menggunakan Vendor:</strong> {{ $permohonan->vendor == 'iya' ? 'Iya' : 'Tidak' }}</p>
      @if($permohonan->vendor == 'iya')
        <p><strong>Nama Vendor:</strong> {{ $permohonan->nama_vendor ?? '-' }}</p>
      @endif

      <hr>

      {{-- KATEGORI & TANGGAL --}}
      <h6 class="fw-bold text-primary mb-3">
        <i class="bi bi-tags"></i> Kategori Permohonan
      </h6>
      <p><strong>Kategori:</strong> {{ $permohonan->category->name ?? '-' }}</p>
      <p><strong>Subkategori:</strong> {{ $permohonan->subcategory->name ?? '-' }}</p>
      <p><strong>Tanggal Pengajuan:</strong> {{ $permohonan->created_at?->translatedFormat('d M Y') }}</p>

      <hr>

      {{-- RINCIAN PERMOHONAN --}}
      <h6 class="fw-bold text-primary mb-3">
        <i class="bi bi-info-lg"></i> Rincian Permohonan
      </h6>

      @if($isSubdomain)
        {{-- === MODE SUBDOMAIN === --}}
        <div class="row small">
          <div class="col-md-6">
            <p><strong>Nama Subdomain:</strong> {{ $permohonan->nama_subdomain ?? $sd->nama_subdomain ?? '-' }}</p>
            <p><strong>Nama Aplikasi:</strong> {{ $sd->nama_aplikasi ?? '-' }}</p>

            <p><strong>Anggaran:</strong> {{ $sd->anggaran ?? '-' }}</p>
            <p><strong>Tahun Penganggaran:</strong> {{ $sd->tahun_penganggaran ?? '-' }}</p>

            <p><strong>Sifat Aplikasi:</strong> {{ $sd->sifat ?? '-' }}</p>
            <p><strong>Dimanfaatkan Untuk Layanan:</strong> {{ $sd->layanan ?? '-' }}</p>

            <p><strong>Platform OS:</strong> {{ $sd->platform_os ?? '-' }}</p>
            <p><strong>Jenis Aplikasi:</strong> {{ $sd->jenis_aplikasi ?? '-' }}</p>

            <p><strong>Database Engine:</strong> {{ $sd->database_engine ?? '-' }}</p>
            <p><strong>Bahasa Pemrograman:</strong> {{ $sd->bahasa_pemrograman ?? '-' }}</p>

            <p><strong>Pengelola:</strong> {{ $sd->pengelola ?? '-' }}</p>
          </div>

          <div class="col-md-6">
            <p><strong>Keterangan Pembangunan:</strong><br>
              {!! nl2br(e($sd->ket_pembangunan ?? '-')) !!}
            </p>

            <p><strong>Kendala Pengembangan:</strong><br>
              {!! nl2br(e($sd->kendala_pembangunan ?? '-')) !!}
            </p>

            <p><strong>Rencana Tindak Lanjut:</strong><br>
              {!! nl2br(e($sd->rencana_tindak_lanjut ?? '-')) !!}
            </p>

            <p><strong>Status Aplikasi:</strong>
              @if(!empty($sd?->status_aplikasi))
                <span class="badge bg-secondary">
                    {{ ucfirst($sd->status_aplikasi) }}
                </span>
              @else
                -
              @endif
            </p>

            <p><strong>Status Domain:</strong>
              @if(!empty($sd?->status))
                <span class="badge bg-info text-dark">
                    {{ ucfirst($sd->status) }}
                </span>
              @else
                <span class="badge bg-light text-dark border">Belum Disetujui</span>
              @endif
            </p>

            <p><strong>Kondisi:</strong>
              @if(!empty($sd?->kondisi))
                <span class="badge bg-light text-dark">
                    {{ ucfirst($sd->kondisi) }}
                </span>
              @else
                -
              @endif
            </p>

            <p><strong>IP Pointing:</strong>
              {{ $sd?->ip_pointing ?? '-' }}
            </p>

            <p><strong>Link Subdomain:</strong>
              @if(!empty($sd?->link))
                <a href="{{ $sd->link }}" target="_blank"
                   class="text-decoration-none text-primary">
                    {{ $sd->link }}
                </a>
              @else
                -
              @endif
            </p>
          </div>
        </div>
      @else
        {{-- === MODE PERMOHONAN LAINNYA (non subdomain) === --}}
        <p><strong>Subjek:</strong> {{ $permohonan->subjek ?? '-' }}</p>
        <p><strong>Deskripsi:</strong> {!! nl2br(e($permohonan->deskiprsi ?? '-')) !!}</p>
        <p><strong>Lokasi:</strong> {{ $permohonan->lokasi ?? '-' }}</p>
      @endif

      <hr>

      {{-- STATUS PERMOHONAN --}}
      <h6 class="fw-bold text-primary mb-3">
        <i class="bi bi-clipboard-check"></i> Status Permohonan
      </h6>
      <p>
        @if($permohonan->status == 'disetujui')
          <span class="badge bg-success">Disetujui</span>
        @elseif($permohonan->status == 'menunggu')
          <span class="badge bg-warning text-dark">Menunggu</span>
        @else
          <span class="badge bg-danger">Ditolak</span>
        @endif
      </p>

      {{-- FILE PENGAJUAN (PREVIEW PDF MINIMALIS) --}}
<h6 class="fw-bold text-primary mb-2">
    <i class="bi bi-file-earmark-pdf"></i> File Pengajuan
</h6>

@if($permohonan->file_pengajuan)
    <div class="border rounded p-2 mb-3" style="background:#fafafa;">
        <iframe 
            src="{{ asset('uploads/permohonan/' . $permohonan->file_pengajuan) }}"
            style="width:100%; height:350px; border:0; border-radius:8px;"
        ></iframe>
    </div>

    <a href="{{ asset('uploads/permohonan/' . $permohonan->file_pengajuan) }}"
       target="_blank"
       class="btn btn-outline-primary btn-sm rounded-pill">
        <i class="bi bi-box-arrow-up-right"></i> Buka PDF
    </a>
@else
    <p class="text-muted fst-italic">Belum ada file pengajuan.</p>
@endif


      {{-- BALASAN ADMIN --}}
      @if($permohonan->status != 'menunggu')
        <hr>
        <h6 class="fw-bold text-primary mb-3">
          <i class="bi bi-chat-left-text"></i> Balasan Admin
        </h6>
        <div class="bg-light border rounded p-3 mb-3 small">
          {!! nl2br(e($permohonan->keterangan_admin ?? 'Belum ada keterangan dari admin.')) !!}
        </div>

        @if($permohonan->file_tindak_lanjut)
          <a href="{{ asset('uploads/tindaklanjut/' . $permohonan->file_tindak_lanjut) }}"
             target="_blank"
             class="btn btn-sm btn-outline-success rounded-pill">
            <i class="bi bi-file-earmark-arrow-down"></i> Lihat File Balasan
          </a>
        @endif
      @endif

      <div class="mt-4">
        <a href="{{ route('skpd.permohonan.index') }}"
           class="btn btn-secondary rounded-pill px-4">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
      </div>

    </div>
  </div>
</div>
@endsection