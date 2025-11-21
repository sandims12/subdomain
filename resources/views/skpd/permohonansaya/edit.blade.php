@extends('skpd.layouts.wrapper')

@section('content')
<div class="container-fluid px-4 py-4">
  <h2 class="fw-bold mb-3">Edit Permohonan</h2>

  <form action="{{ route('skpd.permohonan.update', $permohonan->id) }}"
        method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm border-0 rounded-4">
    @csrf @method('PUT')

    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select" required>
          @foreach($categories as $c)
            <option value="{{ $c->id }}" {{ $permohonan->category_id==$c->id?'selected':'' }}>
              {{ strtoupper($c->name) }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Subkategori</label>
        <select name="subcategory_id" class="form-select" required>
          @foreach($subcategories as $s)
            <option value="{{ $s->id }}" {{ $permohonan->subcategory_id==$s->id?'selected':'' }}>
              {{ $s->name }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Jika case umum --}}
      <div class="col-md-6">
        <label class="form-label">Subjek</label>
        <input type="text" name="subjek" class="form-control"
               value="{{ old('subjek', $permohonan->subjek) }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Lokasi</label>
        <select name="lokasi" class="form-select">
          <option value="">-- pilih --</option>
          <option value="Indoor"  {{ $permohonan->lokasi==='Indoor'?'selected':'' }}>Indoor</option>
          <option value="Outdoor" {{ $permohonan->lokasi==='Outdoor'?'selected':'' }}>Outdoor</option>
        </select>
      </div>
      <div class="col-12">
        <label class="form-label">Deskripsi</label>
        <textarea name="deskripsi" rows="4" class="form-control">{{ old('deskripsi', $permohonan->deskripsi) }}</textarea>
      </div>

      {{-- Jika case SUBDOMAIN (3 & 6) --}}
      <div class="col-md-6">
        <label class="form-label">Nama Subdomain</label>
        <input type="text" name="nama_subdomain" class="form-control"
               value="{{ old('nama_subdomain', $permohonan->nama_subdomain) }}">
      </div>

      {{-- Vendor --}}
      <div class="col-md-6">
        <label class="form-label">Menggunakan Vendor?</label>
        <select name="vendor" class="form-select" required>
          <option value="tidak" {{ $permohonan->vendor==='tidak'?'selected':'' }}>Tidak</option>
          <option value="iya"   {{ $permohonan->vendor==='iya'?'selected':'' }}>Iya</option>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Nama Vendor (jika iya)</label>
        <input type="text" name="nama_vendor" class="form-control"
               value="{{ old('nama_vendor', $permohonan->nama_vendor) }}">
      </div>

      {{-- File pengajuan --}}
      <div class="col-md-6">
        <label class="form-label">File Pengajuan (pdf/doc/docx, maks 2MB)</label>
        <input type="file" name="file_pengajuan" class="form-control">
        @if($permohonan->file_pengajuan)
          <small class="text-muted">File sekarang: {{ $permohonan->file_pengajuan }}</small>
        @endif
      </div>
    </div>

    <div class="mt-4 d-flex gap-2">
      <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
      <a href="{{ route('skpd.permohonan.index') }}" class="btn btn-light">Batal</a>
    </div>
  </form>
</div>
@endsection
