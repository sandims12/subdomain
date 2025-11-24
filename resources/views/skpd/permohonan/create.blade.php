<main class="main-content">
    <div class="container py-4">
        <h3 class="fw-bold text-primary mb-4">Ajukan Permohonan Subdomain</h3>

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

            {{-- Form jika kategori 3 dan subkategori 6 (Subdomain) --}}
            <div id="formSubdomain" style="display: none;">
                {{-- Nama Subdomain --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Subdomain</label>
                    <input type="text" name="nama_subdomain" id="nama_subdomain" class="form-control" placeholder="Contoh: aplikasi.indramayukab.go.id">
                </div>

                {{-- Nama Aplikasi --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Aplikasi</label>
                    <input type="text" name="nama_aplikasi" class="form-control" placeholder="Contoh: Aplikasi E-Planning">
                </div>

                {{-- Sifat Aplikasi --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sifat Aplikasi</label>
                        <select name="sifat" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="Online">Online</option>
                            <option value="Offline">Offline</option>
                        </select>
                    </div>

                    {{-- Tahun Penganggaran --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tahun Penganggaran</label>
                        <input type="number" name="tahun_penganggaran" class="form-control" placeholder="Contoh: 2022">
                    </div>
                </div>

                {{-- Dimanfaatkan Untuk Layanan --}}
                <div class="mb-3">
                    <label class="form-label">Dimanfaatkan Untuk Layanan</label>
                    <input type="text" name="layanan" class="form-control" placeholder="Contoh: E-Planning, E-Budgeting">
                </div>

                {{-- Platform OS --}}
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

                {{-- Jenis Aplikasi --}}
                <div class="mb-3">
                    <label class="form-label">Jenis Aplikasi</label>
                    <select name="jenis_aplikasi" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Desktop Client-Server">Desktop Client-Server</option>
                        <option value="Web Base">Web Base</option>
                        <option value="Mobile App">Mobile App</option>
                    </select>
                </div>

                {{-- Database Engine --}}
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

                {{-- Bahasa Pemrograman --}}
                <div class="mb-3">
                    <label class="form-label">Bahasa Pemrograman</label>
                    <select name="bahasa_pemrograman" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="PHP">PHP</option>
                        <option value="Java">Java</option>
                        <option value="Python">Python</option>
                        <option value="Javascript">Javascript</option>
                        <option value=".NET">.NET</option>
                    </select>
                </div>

                {{-- Pengelola --}}
                <div class="mb-3">
                    <label class="form-label">Pengelola</label>
                    <input type="text" name="pengelola" class="form-control" placeholder="Contoh: BKD, BAPPEDA, Dinas TIK">
                </div>

                {{-- Kendala Pengembangan --}}
                <div class="mb-3">
                    <label class="form-label">Kendala Pengembangan</label>
                    <textarea name="kendala" class="form-control" rows="3" placeholder="Tuliskan kendala pengembangan..."></textarea>
                </div>

                {{-- Rencana Tindak Lanjut --}}
                <div class="mb-3">
                    <label class="form-label">Rencana Tindak Lanjut</label>
                    <textarea name="tindak_lanjut" class="form-control" rows="3" placeholder="Tuliskan rencana tindak lanjut..."></textarea>
                </div>
            </div>

            {{-- Form untuk selain kategori 3 dan subkategori 6 --}}
            <div id="formLainnya" style="display: none;">
                {{-- Subjek --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Subjek</label>
                    <input type="text" name="subjek" class="form-control" placeholder="Contoh: Layanan Pengaduan">
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskiprsi" class="form-control" rows="4" placeholder="Jelaskan permohonan Anda secara detail..."></textarea>
                </div>

                {{-- Lokasi --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Lokasi</label>
                    <select name="lokasi" class="form-select">
                        <option value="">-- Pilih Lokasi --</option>
                        <option value="Indoor">Indoor</option>
                        <option value="Outdoor">Outdoor</option>
                    </select>
                </div>
            </div>

            {{-- Pilihan Vendor --}}
            <div class="mb-3">
                <label for="vendor" class="form-label fw-bold">Apakah menggunakan vendor?</label>
                <select name="vendor" id="vendor" class="form-select" required>
                    <option value="tidak">Tidak</option>
                    <option value="iya">Iya</option>
                </select>
            </div>

            {{-- Nama Vendor (muncul jika iya) --}}
            <div class="mb-3 d-none" id="vendor-nama-container">
                <label for="nama_vendor" class="form-label fw-bold">Nama Vendor</label>
                <input type="text" name="nama_vendor" id="nama_vendor" class="form-control" placeholder="Isi nama vendor">
            </div>

            {{-- File Pengajuan --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Upload File Pengajuan</label>
                <input type="file" name="file_pengajuan" class="form-control">
                <small class="text-muted">Format: pdf/doc/docx (maks 2MB)</small>
            </div>

            <div class="text-start mt-3">
                <button type="submit" class="btn btn-primary btn-sm px-4">
                    <i class="bi bi-send"></i> Kirim Permohonan
                </button>
            </div>
        </form>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const allSubcategories = @json($subcategories);
        const categorySelect = document.getElementById('categorySelect');
        const subcategorySelect = document.getElementById('subcategorySelect');
        const formSubdomain = document.getElementById('formSubdomain');
        const formLainnya = document.getElementById('formLainnya');
        const namaSubdomainInput = document.getElementById('nama_subdomain');

        // Saat kategori dipilih
        categorySelect.addEventListener('change', function () {
            const selectedCategoryId = this.value;
            subcategorySelect.innerHTML = '<option value="">-- Pilih Subkategori --</option>';
            subcategorySelect.disabled = true;
            formSubdomain.style.display = 'none';
            formLainnya.style.display = 'none';
            namaSubdomainInput.removeAttribute('required');

            if (!selectedCategoryId) return;

            const filtered = allSubcategories.filter(sub => sub.category_id == selectedCategoryId);

            if (filtered.length > 0) {
                filtered.forEach(sub => {
                    const option = document.createElement('option');
                    option.value = sub.name;
                    option.textContent = sub.name;
                    subcategorySelect.appendChild(option);
                });
                subcategorySelect.disabled = false;
            }
        });

        // Saat subkategori dipilih
        subcategorySelect.addEventListener('change', function () {
            const selectedCategoryId = parseInt(categorySelect.value);
            const selectedSubcategoryId = this.value;

            if ((selectedSubcategoryId ?? '').toLowerCase().replace(/\s+/g, '') === 'subdomain') {
                formSubdomain.style.display = 'block';
                formLainnya.style.display = 'none';
                namaSubdomainInput.setAttribute('required', true);
                document.querySelector('[name="sifat"]').setAttribute('required', true);
                document.querySelector('[name="platform_os"]').setAttribute('required', true);
            } else {
                formSubdomain.style.display = 'none';
                formLainnya.style.display = 'block';
                namaSubdomainInput.removeAttribute('required');

                // Hapus required saat form disembunyikan
                document.querySelector('[name="sifat"]').removeAttribute('required');
                document.querySelector('[name="platform_os"]').removeAttribute('required');
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Vendor toggle
        const vendorSelect = document.getElementById('vendor');
        const vendorNama = document.getElementById('vendor-nama-container');
        const inputNamaVendor = document.getElementById('nama_vendor');

        vendorSelect.addEventListener('change', function () {
            if (this.value === 'iya') {
                vendorNama.classList.remove('d-none');
                inputNamaVendor.setAttribute('required', true);
            } else {
                vendorNama.classList.add('d-none');
                inputNamaVendor.removeAttribute('required');
                inputNamaVendor.value = '';
            }
        });
    });
</script>
