<div class="container-fluid px-4 py-4">
    <h4 class="fw-bold mb-3">Edit Permohonan</h4>

    <form action="{{ route('skpd.permohonan.update', $permohonan->id) }}" method="POST" enctype="multipart/form-data" class="card p-3 border-0 shadow-sm rounded-4">
        @csrf
        @method('PUT')

        <div class="row g-3">
            {{-- Kategori --}}
            <div class="col-md-6">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-select">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $permohonan->category_id == $cat->id ? 'selected' : '' }}>
                            {{ strtoupper($cat->name) }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Subkategori (pakai NAME) --}}
            <div class="col-md-6">
                <label class="form-label">Subkategori</label>
                <select name="subcategory_id" class="form-select">
                    @foreach($subcategories as $sub)
                        <option value="{{ $sub->name }}" {{ $permohonan->subcategory?->name === $sub->name ? 'selected' : '' }}>
                            {{ $sub->name }}
                        </option>
                    @endforeach
                </select>
                @error('subcategory_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Form SUBDOMAIN --}}
            @php
                $isSubdomain = strtolower(str_replace(' ', '', $permohonan->subcategory?->name)) === 'subdomain';
            @endphp

            <div class="col-12" id="wrap-subdomain" style="{{ $isSubdomain ? '' : 'display:none' }}">
                <label class="form-label">Nama Subdomain</label>
                <input type="text" name="nama_subdomain" class="form-control"
                       value="{{ old('nama_subdomain', $permohonan->nama_subdomain ?? '') }}"
                       placeholder="contoh: diskominfo">
                @error('nama_subdomain') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Form UMUM --}}
            <div class="col-md-6" id="wrap-subjek" style="{{ $isSubdomain ? 'display:none' : '' }}">
                <label class="form-label">Subjek</label>
                <input type="text" name="subjek" class="form-control" value="{{ old('subjek', $permohonan->subjek) }}">
                @error('subjek') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6" id="wrap-lokasi" style="{{ $isSubdomain ? 'display:none' : '' }}">
                <label class="form-label">Lokasi</label>
                <select name="lokasi" class="form-select">
                    <option value="Indoor"  {{ $permohonan->lokasi === 'Indoor'  ? 'selected' : '' }}>Indoor</option>
                    <option value="Outdoor" {{ $permohonan->lokasi === 'Outdoor' ? 'selected' : '' }}>Outdoor</option>
                </select>
                @error('lokasi') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-12" id="wrap-deskripsi" style="{{ $isSubdomain ? 'display:none' : '' }}">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskiprsi" rows="4" class="form-control">{{ old('deskiprsi', $permohonan->deskiprsi) }}</textarea>
                @error('deskiprsi') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Vendor --}}
            <div class="col-md-6">
                <label class="form-label">Vendor</label>
                <select name="vendor" class="form-select" id="vendorSelect">
                    <option value="iya"   {{ $permohonan->vendor === 'iya' ? 'selected' : '' }}>Iya</option>
                    <option value="tidak" {{ $permohonan->vendor === 'tidak' ? 'selected' : '' }}>Tidak</option>
                </select>
                @error('vendor') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6" id="wrap-nama-vendor" style="{{ $permohonan->vendor === 'iya' ? '' : 'display:none' }}">
                <label class="form-label">Nama Vendor</label>
                <input type="text" name="nama_vendor" class="form-control" value="{{ old('nama_vendor', $permohonan->nama_vendor) }}">
                @error('nama_vendor') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- File --}}
            <div class="col-12">
                <label class="form-label">File Pengajuan (opsional)</label>
                <input type="file" name="file_pengajuan" class="form-control">
                @error('file_pengajuan') <small class="text-danger">{{ $message }}</small> @enderror
                @if($permohonan->file_pengajuan)
                    <small class="text-muted d-block mt-1">File saat ini: {{ $permohonan->file_pengajuan }}</small>
                @endif
            </div>
        </div>

        <div class="mt-3 d-flex gap-2">
            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
            <a href="{{ route('skpd.permohonan.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>

{{-- Toggle tampilan form berdasarkan subkategori & vendor --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const subSelect = document.querySelector('select[name="subcategory_id"]');
    const vendorSel = document.getElementById('vendorSelect');

    function toggleBySub() {
        const isSub = (subSelect.value || '').replace(/\s+/g,'').toLowerCase() === 'subdomain';
        document.getElementById('wrap-subdomain').style.display = isSub ? '' : 'none';
        document.getElementById('wrap-subjek').style.display    = isSub ? 'none' : '';
        document.getElementById('wrap-lokasi').style.display    = isSub ? 'none' : '';
        document.getElementById('wrap-deskripsi').style.display = isSub ? 'none' : '';
    }
    function toggleVendor() {
        document.getElementById('wrap-nama-vendor').style.display = vendorSel.value === 'iya' ? '' : 'none';
    }
    subSelect && subSelect.addEventListener('change', toggleBySub);
    vendorSel && vendorSel.addEventListener('change', toggleVendor);
});
</script>
