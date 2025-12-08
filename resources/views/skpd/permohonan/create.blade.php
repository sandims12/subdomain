<main class="main-content">
    <div class="container py-4">
        <h3 class="fw-bold text-primary mb-4">Ajukan Permohonan Subdomain</h3>

        @if ($errors->any())
        <div class="alert alert-danger small">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('skpd.permohonan.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
            @csrf

            {{-- Kategori --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Kategori</label>
                <select id="categorySelect" class="form-select" name="category_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Subkategori --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Subkategori</label>
                <select id="subcategorySelect" class="form-select" name="subcategory_id" required disabled>
                    <option value="">-- Pilih Subkategori --</option>
                </select>
            </div>

            {{-- Form Subdomain --}}
            <div id="formSubdomain" style="display: none;">

                {{-- NAMA SUBDOMAIN --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Subdomain</label>

                    <!-- Input Model Gmail -->
                    <div class="input-group">
                        <input 
                            type="text" 
                            id="nama_subdomain_view" 
                            class="form-control"
                            placeholder="Contoh: aplikasi"
                        >
                        <span class="input-group-text">.indramayukab.go.id</span>
                    </div>

                    <!-- Hidden: nilai lengkap ke backend -->
                    <input type="hidden" name="nama_subdomain" id="nama_subdomain">
                </div>

                {{-- Nama Aplikasi --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Aplikasi</label>
                    <input type="text" name="nama_aplikasi" class="form-control" placeholder="Contoh: Aplikasi E-Planning">
                </div>

                <div class="row">
                    {{-- ANGGARAN --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Anggaran</label>
                        <select name="anggaran" class="form-select">
                            <option value="">-- Pilih Anggaran --</option>
                            <option value="lebih dari 1 milyar">lebih dari 1 milyar</option>
                            <option value="lebih dari 500 juta < 1 milyar">lebih dari 500 juta &lt; 1 milyar</option>
                            <option value="lebih dari 100 juta < 500 juta">lebih dari 100 juta &lt; 500 juta</option>
                            <option value="kurang dari 100 juta">kurang dari 100 juta</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tahun Penganggaran</label>
                        <input type="number" name="tahun_penganggaran" class="form-control" placeholder="Contoh: 2022">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sifat Aplikasi</label>
                        <select name="sifat" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="Online">Online</option>
                            <option value="Offline">Offline</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dimanfaatkan Untuk Layanan</label>
                        <input type="text" name="layanan" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Platform OS</label>
                    <select name="platform_os" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Windows">Windows</option>
                        <option value="Linux">Linux</option>
                        <option value="MacOS">MacOS</option>
                        <option value="Web Base">Web Base</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Aplikasi</label>
                    <select name="jenis_aplikasi" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Desktop Client-Server">Desktop Client-Server</option>
                        <option value="Web Base">Web Base</option>
                        <option value="Mobile App">Mobile App</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Database Engine</label>
                    <select name="database_engine" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Mysql">Mysql</option>
                        <option value="PostgreSQL">PostgreSQL</option>
                        <option value="SQL Server">SQL Server</option>
                        <option value="Oracle">Oracle</option>
                    </select>
                </div>

                {{-- BAHASA PEMROGRAMAN + LAINNYA --}}
                <div class="mb-3">
                    <label class="form-label">Bahasa Pemrograman</label>
                    <select name="bahasa_pemrograman" id="bahasa_pemrograman_select" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="PHP">PHP</option>
                        <option value="Java">Java</option>
                        <option value="Python">Python</option>
                        <option value="Javascript">Javascript</option>
                        <option value=".NET">.NET</option>
                        <option value="Lainnya">Lainnya ...</option>
                    </select>

                    {{-- input manual hanya muncul ketika pilih "Lainnya" --}}
                    <input type="text"
                           id="bahasa_pemrograman_custom"
                           class="form-control mt-2 d-none"
                           placeholder="Tulis bahasa pemrograman lain, contoh: Go, Ruby, Laravel, dll.">
                </div>

                {{-- IP POINTING --}}
                <div class="mb-3">
                    <label class="form-label">IP Pointing</label>
                    <input type="text"
                           name="ip_pointing"
                           class="form-control"
                           placeholder="Contoh: 123.123.123.123">
                </div>

                <div class="mb-3">
                    <label class="form-label">Pengelola</label>
                    <input type="text" name="pengelola" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan Pembangunan</label>
                    <textarea name="ket_pembangunan" class="form-control" rows="3"
                              placeholder="Contoh: progres pengembangan aplikasi, status server/hosting, kebutuhan IP pointing, pihak yang terlibat, dll."></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kendala Pengembangan</label>
                    <textarea name="kendala" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rencana Tindak Lanjut</label>
                    <textarea name="tindak_lanjut" class="form-control"></textarea>
                </div>
            </div>

            {{-- Form Lainnya --}}
            <div id="formLainnya" style="display: none;">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Subjek</label>
                    <input type="text" name="subjek" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskiprsi" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Lokasi</label>
                    <select name="lokasi" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Indoor">Indoor</option>
                        <option value="Outdoor">Outdoor</option>
                    </select>
                </div>
            </div>

            {{-- Vendor --}}
            <div class="mb-3" id="vendor-container">
                <label for="vendor" class="form-label fw-bold">Apakah menggunakan vendor?</label>
                <select name="vendor" id="vendor" class="form-select">
                    <option value="tidak">Tidak</option>
                    <option value="iya">Iya</option>
                </select>
            </div>

            {{-- Nama Vendor --}}
            <div class="mb-3 d-none" id="vendor-nama-container">
                <label for="nama_vendor" class="form-label fw-bold">Nama Vendor</label>
                <input type="text" name="nama_vendor" id="nama_vendor" class="form-control">
            </div>

            {{-- File --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Upload File Pengajuan (PDF saja, max 2MB)</label>
                <input
                    type="file"
                    name="file_pengajuan"
                    id="file_pengajuan"
                    class="form-control"
                    accept="application/pdf"
                    required
                >
                <small id="file_error" class="text-danger fw-bold d-none"></small>
            </div>

            <div class="text-start mt-3">
                <button type="submit" name="action" value="submit" class="btn btn-primary btn-sm px-4">
                    <i class="bi bi-send"></i> Kirim Permohonan
                </button>

                <button type="submit" name="action" value="draft" class="btn btn-outline-secondary btn-sm px-4">
                    <i class="bi bi-file-earmark-text"></i> Simpan Draft
                </button>
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

    const bahasaSelect       = document.getElementById('bahasa_pemrograman_select');
    const bahasaCustom       = document.getElementById('bahasa_pemrograman_custom');

    // --- fungsi bantu ---
    function resetVendor() {
        if (vendorContainer) vendorContainer.style.display = 'none';
        if (vendorNama)      vendorNama.classList.add('d-none');

        if (vendorSelect)    vendorSelect.value = 'tidak';
        if (inputNamaVendor) {
            inputNamaVendor.value = '';
            inputNamaVendor.removeAttribute('required');
        }
    }

    // sembunyikan vendor di awal
    resetVendor();

    // ================== INPUT SUBDOMAIN OTOMATIS ==================
    const domain = ".indramayukab.go.id";
    if (namaView && namaFull) {
        namaView.addEventListener('input', function () {
            let clean = this.value.toLowerCase()
                .replace(/\s+/g, '')         // hapus spasi
                .replace(/[^a-z0-9-]/g, ''); // hanya huruf, angka, dash

            this.value     = clean;
            namaFull.value = clean ? (clean + domain) : '';
        });
    }

    // ================== SAAT KATEGORI DIPILIH ==================
    if (categorySelect) {
        categorySelect.addEventListener('change', function () {
            if (!subcategorySelect) return;

            subcategorySelect.innerHTML = '<option value="">-- Pilih Subkategori --</option>';
            subcategorySelect.disabled  = true;

            if (formSubdomain) formSubdomain.style.display = 'none';
            if (formLainnya)   formLainnya.style.display   = 'none';
            resetVendor();

            const filtered = allSubcategories.filter(sub => sub.category_id == this.value);

            filtered.forEach(sub => {
                const opt = document.createElement('option');
                opt.value = sub.name;
                opt.textContent = sub.name;
                subcategorySelect.appendChild(opt);
            });

            subcategorySelect.disabled = false;
        });
    }

    // ================== SAAT SUBKATEGORI DIPILIH ==================
    if (subcategorySelect) {
        subcategorySelect.addEventListener('change', function () {
            const selected = (this.value || '').toLowerCase().replace(/\s+/g, '');

            if (selected === 'subdomain') {
                if (formSubdomain) formSubdomain.style.display = 'block';
                if (formLainnya)   formLainnya.style.display   = 'none';
                if (vendorContainer) vendorContainer.style.display = 'block';
            } else {
                if (formSubdomain) formSubdomain.style.display = 'none';
                if (formLainnya)   formLainnya.style.display   = 'block';
                resetVendor();
            }
        });
    }

    // ================== VENDOR TOGGLE ==================
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

    // ================== BAHASA PEMROGRAMAN: LAINNYA ==================
    function syncBahasaPemrograman() {
        if (!bahasaSelect || !bahasaCustom) return;

        if (bahasaSelect.value === 'Lainnya') {
            bahasaCustom.classList.remove('d-none');
            bahasaCustom.setAttribute('name', 'bahasa_pemrograman');
            bahasaSelect.removeAttribute('name');
        } else {
            bahasaCustom.classList.add('d-none');
            bahasaCustom.removeAttribute('name');
            bahasaSelect.setAttribute('name', 'bahasa_pemrograman');
        }
    }

    if (bahasaSelect) {
        bahasaSelect.addEventListener('change', syncBahasaPemrograman);
        // panggil sekali untuk state awal
        syncBahasaPemrograman();
    }

    // ================== VALIDASI FILE PDF ==================
    const fileInput = document.getElementById('file_pengajuan');
    const fileError = document.getElementById('file_error');

    if (fileInput && fileError) {
        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            fileError.classList.add('d-none');
            fileError.textContent = '';

            if (!file) return;

            if (file.type !== 'application/pdf') {
                fileError.textContent = '❌ File harus berformat PDF (.pdf)';
                fileError.classList.remove('d-none');
                this.value = '';
                return;
            }

            if (file.size > 2 * 1024 * 1024) { // 2 MB
                fileError.textContent = '❌ Ukuran file maksimal 2 MB';
                fileError.classList.remove('d-none');
                this.value = '';
                return;
            }
        });
    }
});
</script>
