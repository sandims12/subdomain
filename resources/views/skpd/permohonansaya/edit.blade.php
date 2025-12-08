<main class="main-content">
    <div class="container py-4">
        <h3 class="fw-bold text-primary mb-4">Edit Permohonan Subdomain</h3>

        @if ($errors->any())
            <div class="alert alert-danger small">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('skpd.permohonan.update', $permohonan->id) }}"
              method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
            @csrf
            @method('PUT')

            {{-- Kategori --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Kategori</label>
                <select id="categorySelect" class="form-select" name="category_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $permohonan->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Subkategori --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Subkategori</label>
                <select id="subcategorySelect" class="form-select" name="subcategory_id" required>
                    <option value="">-- Pilih Subkategori --</option>
                    {{-- akan diisi via JS, tapi kalau ada old() kita tetap render default --}}
                    @php
                        $selectedSubName = old('subcategory_id', $permohonan->subcategory->name ?? '');
                    @endphp
                    @foreach ($subcategories as $sub)
                        <option value="{{ $sub->name }}"
                            {{ $selectedSubName === $sub->name ? 'selected' : '' }}>
                            {{ $sub->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Form Subdomain --}}
            <div id="formSubdomain" style="display: none;">

                {{-- NAMA SUBDOMAIN --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Subdomain</label>
                    @php
                        $fullSub = old('nama_subdomain', $permohonan->nama_subdomain);
                        $prefixSub = $fullSub
                            ? str_replace('.indramayukab.go.id', '', $fullSub)
                            : '';
                    @endphp

                    <div class="input-group">
                        <input 
                            type="text" 
                            id="nama_subdomain_view" 
                            class="form-control"
                            placeholder="Contoh: aplikasi"
                            value="{{ $prefixSub }}"
                        >
                        <span class="input-group-text">.indramayukab.go.id</span>
                    </div>

                    <input type="hidden" name="nama_subdomain" id="nama_subdomain"
                           value="{{ $fullSub }}">
                </div>

                {{-- Nama Aplikasi --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Aplikasi</label>
                    <input type="text" name="nama_aplikasi" class="form-control"
                           placeholder="Contoh: Aplikasi E-Planning"
                           value="{{ old('nama_aplikasi', optional($permohonan->subdomain)->nama_aplikasi) }}">
                </div>

                <div class="row">
                    {{-- ANGGARAN --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Anggaran</label>
                        @php
                            $anggaranVal = old('anggaran', optional($permohonan->subdomain)->anggaran);
                        @endphp
                        <select name="anggaran" class="form-select">
                            <option value="">-- Pilih Anggaran --</option>
                            <option value="lebih dari 1 milyar"
                                {{ $anggaranVal === 'lebih dari 1 milyar' ? 'selected' : '' }}>
                                lebih dari 1 milyar
                            </option>
                            <option value="lebih dari 500 juta < 1 milyar"
                                {{ $anggaranVal === 'lebih dari 500 juta < 1 milyar' ? 'selected' : '' }}>
                                lebih dari 500 juta &lt; 1 milyar
                            </option>
                            <option value="lebih dari 100 juta < 500 juta"
                                {{ $anggaranVal === 'lebih dari 100 juta < 500 juta' ? 'selected' : '' }}>
                                lebih dari 100 juta &lt; 500 juta
                            </option>
                            <option value="kurang dari 100 juta"
                                {{ $anggaranVal === 'kurang dari 100 juta' ? 'selected' : '' }}>
                                kurang dari 100 juta
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tahun Penganggaran</label>
                        <input type="number" name="tahun_penganggaran" class="form-control"
                               placeholder="Contoh: 2022"
                               value="{{ old('tahun_penganggaran', optional($permohonan->subdomain)->tahun_penganggaran) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sifat Aplikasi</label>
                        @php
                            $sifatVal = old('sifat', optional($permohonan->subdomain)->sifat);
                        @endphp
                        <select name="sifat" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="Online"  {{ $sifatVal === 'Online'  ? 'selected' : '' }}>Online</option>
                            <option value="Offline" {{ $sifatVal === 'Offline' ? 'selected' : '' }}>Offline</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dimanfaatkan Untuk Layanan</label>
                        <input type="text" name="layanan" class="form-control"
                               value="{{ old('layanan', optional($permohonan->subdomain)->layanan) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Platform OS</label>
                    @php
                        $osVal = old('platform_os', optional($permohonan->subdomain)->platform_os);
                    @endphp
                    <select name="platform_os" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Windows"  {{ $osVal === 'Windows'  ? 'selected' : '' }}>Windows</option>
                        <option value="Linux"    {{ $osVal === 'Linux'    ? 'selected' : '' }}>Linux</option>
                        <option value="MacOS"    {{ $osVal === 'MacOS'    ? 'selected' : '' }}>MacOS</option>
                        <option value="Web Base" {{ $osVal === 'Web Base' ? 'selected' : '' }}>Web Base</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Aplikasi</label>
                    @php
                        $jenisVal = old('jenis_aplikasi', optional($permohonan->subdomain)->jenis_aplikasi);
                    @endphp
                    <select name="jenis_aplikasi" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Desktop Client-Server"
                            {{ $jenisVal === 'Desktop Client-Server' ? 'selected' : '' }}>
                            Desktop Client-Server
                        </option>
                        <option value="Web Base"
                            {{ $jenisVal === 'Web Base' ? 'selected' : '' }}>
                            Web Base
                        </option>
                        <option value="Mobile App"
                            {{ $jenisVal === 'Mobile App' ? 'selected' : '' }}>
                            Mobile App
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Database Engine</label>
                    @php
                        $dbVal = old('database_engine', optional($permohonan->subdomain)->database_engine);
                    @endphp
                    <select name="database_engine" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Mysql"      {{ $dbVal === 'Mysql'      ? 'selected' : '' }}>Mysql</option>
                        <option value="PostgreSQL" {{ $dbVal === 'PostgreSQL' ? 'selected' : '' }}>PostgreSQL</option>
                        <option value="SQL Server" {{ $dbVal === 'SQL Server' ? 'selected' : '' }}>SQL Server</option>
                        <option value="Oracle"     {{ $dbVal === 'Oracle'     ? 'selected' : '' }}>Oracle</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bahasa Pemrograman</label>
                    @php
                        $langVal = old('bahasa_pemrograman', optional($permohonan->subdomain)->bahasa_pemrograman);
                    @endphp
                    <select name="bahasa_pemrograman" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="PHP"        {{ $langVal === 'PHP'        ? 'selected' : '' }}>PHP</option>
                        <option value="Java"       {{ $langVal === 'Java'       ? 'selected' : '' }}>Java</option>
                        <option value="Python"     {{ $langVal === 'Python'     ? 'selected' : '' }}>Python</option>
                        <option value="Javascript" {{ $langVal === 'Javascript' ? 'selected' : '' }}>Javascript</option>
                        <option value=".NET"       {{ $langVal === '.NET'       ? 'selected' : '' }}>.NET</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Pengelola</label>
                    <input type="text" name="pengelola" class="form-control"
                           value="{{ old('pengelola', optional($permohonan->subdomain)->pengelola) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan Pembangunan</label>
                    <textarea name="ket_pembangunan" class="form-control" rows="3"
                        placeholder="Contoh: Progres pengembangan, pihak yang terlibat, dll.">{{ old('ket_pembangunan', optional($permohonan->subdomain)->ket_pembangunan) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kendala Pengembangan</label>
                    <textarea name="kendala" class="form-control">{{ old('kendala', optional($permohonan->subdomain)->kendala_pembangunan) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rencana Tindak Lanjut</label>
                    <textarea name="tindak_lanjut" class="form-control">{{ old('tindak_lanjut', optional($permohonan->subdomain)->rencana_tindak_lanjut) }}</textarea>
                </div>
            </div>

            {{-- Form Lainnya --}}
            <div id="formLainnya" style="display: none;">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Subjek</label>
                    <input type="text" name="subjek" class="form-control"
                           value="{{ old('subjek', $permohonan->subjek) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskiprsi" class="form-control">{{ old('deskiprsi', $permohonan->deskiprsi) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Lokasi</label>
                    @php
                        $lokasiVal = old('lokasi', $permohonan->lokasi);
                    @endphp
                    <select name="lokasi" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Indoor"  {{ $lokasiVal === 'Indoor'  ? 'selected' : '' }}>Indoor</option>
                        <option value="Outdoor" {{ $lokasiVal === 'Outdoor' ? 'selected' : '' }}>Outdoor</option>
                    </select>
                </div>
            </div>

            {{-- Vendor --}}
            <div class="mb-3" id="vendor-container">
                <label for="vendor" class="form-label fw-bold">Apakah menggunakan vendor?</label>
                @php
                    $vendorVal = old('vendor', $permohonan->vendor);
                @endphp
                <select name="vendor" id="vendor" class="form-select">
                    <option value="tidak" {{ $vendorVal === 'tidak' ? 'selected' : '' }}>Tidak</option>
                    <option value="iya"   {{ $vendorVal === 'iya'   ? 'selected' : '' }}>Iya</option>
                </select>
            </div>

            {{-- Nama Vendor --}}
            <div class="mb-3 d-none" id="vendor-nama-container">
                <label for="nama_vendor" class="form-label fw-bold">Nama Vendor</label>
                <input type="text" name="nama_vendor" id="nama_vendor" class="form-control"
                       value="{{ old('nama_vendor', $permohonan->nama_vendor) }}">
            </div>

            {{-- File (Hanya PDF) --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Upload File Pengajuan (PDF saja)</label>

                <input 
                    type="file" 
                    name="file_pengajuan" 
                    id="file_pengajuan_edit"
                    class="form-control"
                    accept="application/pdf"
                >

                <small class="text-danger d-none" id="fileErrorEdit">
                    ❌ Format tidak valid! Hanya file PDF yang diperbolehkan.
                </small>

                @if($permohonan->file_pengajuan)
                    <small class="text-muted d-block mt-1">
                        File saat ini: {{ $permohonan->file_pengajuan }}
                    </small>
                @endif
            </div>


            <div class="text-start mt-3">
                <button type="submit" class="btn btn-primary btn-sm px-4">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('skpd.permohonan.index') }}" class="btn btn-light btn-sm px-4 ms-2">
                    Batal
                </a>
            </div>
        </form>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const allSubcategories   = @json($subcategories);

    const categorySelect     = document.getElementById('categorySelect');
    const subcategorySelect  = document.getElementById('subcategorySelect');
    const formSubdomain      = document.getElementById('formSubdomain');
    const formLainnya        = document.getElementById('formLainnya');

    const vendorContainer    = document.getElementById('vendor-container');
    const vendorSelect       = document.getElementById('vendor');
    const vendorNama         = document.getElementById('vendor-nama-container');
    const inputNamaVendor    = document.getElementById('nama_vendor');

    const namaView           = document.getElementById('nama_subdomain_view');
    const namaFull           = document.getElementById('nama_subdomain');

    const initialCategory    = '{{ old('category_id', $permohonan->category_id) }}';
    const initialSubName     = @json(old('subcategory_id', $selectedSubName));
    const initialVendor      = '{{ $vendorVal }}';

    function resetVendor() {
        if (vendorNama) {
            vendorNama.classList.add('d-none');
        }
        if (inputNamaVendor) {
            inputNamaVendor.removeAttribute('required');
        }
    }

    function showVendorIfNeeded(isSubdomain) {
        if (!vendorContainer) return;
        vendorContainer.style.display = isSubdomain ? 'block' : 'none';

        if (isSubdomain && initialVendor === 'iya') {
            vendorNama.classList.remove('d-none');
            inputNamaVendor.setAttribute('required', true);
        }
    }

    // Render subkategori berdasarkan kategori
    function renderSubcategories(catId, selectedName) {
        if (!subcategorySelect) return;

        subcategorySelect.innerHTML = '<option value="">-- Pilih Subkategori --</option>';

        if (!catId) {
            subcategorySelect.disabled = true;
            return;
        }

        const filtered = allSubcategories.filter(sub => sub.category_id == catId);
        filtered.forEach(sub => {
            const opt = document.createElement('option');
            opt.value = sub.name;
            opt.textContent = sub.name;
            if (sub.name === selectedName) opt.selected = true;
            subcategorySelect.appendChild(opt);
        });

        subcategorySelect.disabled = false;
    }

    function handleSubcategoryChange(value) {
        const selected = (value || '').toLowerCase().replace(/\s+/g, '');

        if (selected === 'subdomain') {
            if (formSubdomain) formSubdomain.style.display = 'block';
            if (formLainnya)   formLainnya.style.display   = 'none';
            showVendorIfNeeded(true);
        } else if (value) {
            if (formSubdomain) formSubdomain.style.display = 'none';
            if (formLainnya)   formLainnya.style.display   = 'block';
            if (vendorContainer) vendorContainer.style.display = 'none';
            resetVendor();
        } else {
            // tidak pilih apa-apa
            if (formSubdomain) formSubdomain.style.display = 'none';
            if (formLainnya)   formLainnya.style.display   = 'none';
            if (vendorContainer) vendorContainer.style.display = 'none';
            resetVendor();
        }
    }

    // INIT KATEGORI & SUBKATEGORI
    if (categorySelect) {
        categorySelect.value = initialCategory || '';
        renderSubcategories(initialCategory, initialSubName);
    }

    handleSubcategoryChange(initialSubName);

    // INIT VENDOR
    if (vendorSelect) {
        vendorSelect.value = initialVendor || 'tidak';

        if (initialVendor === 'iya') {
            vendorNama.classList.remove('d-none');
            inputNamaVendor.setAttribute('required', true);
        }
    }

    // Event kategori berubah
    if (categorySelect) {
        categorySelect.addEventListener('change', function () {
            renderSubcategories(this.value, '');
            handleSubcategoryChange('');
        });
    }

    // Event subkategori berubah
    if (subcategorySelect) {
        subcategorySelect.addEventListener('change', function () {
            handleSubcategoryChange(this.value);
        });
    }

    // Input subdomain otomatis
    const domain = ".indramayukab.go.id";
    if (namaView && namaFull) {
        namaView.addEventListener('input', function () {
            let clean = this.value.toLowerCase()
                .replace(/\s+/g, '')
                .replace(/[^a-z0-9-]/g, '');

            this.value     = clean;
            namaFull.value = clean ? (clean + domain) : '';
        });
    }

    // Toggle vendor
    if (vendorSelect) {
        vendorSelect.addEventListener('change', function () {
            if (!vendorNama || !inputNamaVendor) return;

            if (this.value === 'iya') {
                vendorNama.classList.remove('d-none');
                inputNamaVendor.setAttribute('required', true);
            } else {
                vendorNama.classList.add('d-none');
                inputNamaVendor.removeAttribute('required');
                inputNamaVendor.value = '';
            }
        });
    }
});

// VALIDASI FILE EDIT — Hanya PDF
const fileEdit = document.getElementById('file_pengajuan_edit');
const fileErrEdit = document.getElementById('fileErrorEdit');

if (fileEdit) {
    fileEdit.addEventListener('change', function () {
        const file = this.files[0];

        if (file && file.type !== "application/pdf") {
            fileErrEdit.classList.remove('d-none');
            this.value = ""; // Reset jika salah format
        } else {
            fileErrEdit.classList.add('d-none');
        }
    });
}

</script>