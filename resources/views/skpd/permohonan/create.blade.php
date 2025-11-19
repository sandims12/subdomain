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

    {{-- Form jika kategori 3 dan subkategori 6 --}}
    <div id="formSubdomain" style="display: none;">
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Subdomain</label>
            <input type="text" name="nama_subdomain" id="nama_subdomain" class="form-control" placeholder="Contoh: aplikasi.indramayukab.go.id">
        </div>
    </div>

    {{-- Form untuk selain kategori 3 dan subkategori 6 --}}
    <div id="formLainnya" style="display: none;">
        <div class="mb-3">
            <label class="form-label fw-semibold">Subjek</label>
            <input type="text" name="subjek" class="form-control" placeholder="Contoh: Layanan Pengaduan">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Deskripsi</label>
            <textarea name="deskiprsi" class="form-control" rows="4" placeholder="Jelaskan permohonan Anda secara detail..."></textarea>
        </div>

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

    <button type="submit" class="btn btn-primary w-100 mt-3">
        <i class="bi bi-send"></i> Kirim Permohonan
    </button>
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
                    option.value = sub.id;
                    option.textContent = sub.name;
                    subcategorySelect.appendChild(option);
                });
                subcategorySelect.disabled = false;
            }
        });

        // Saat subkategori dipilih
        subcategorySelect.addEventListener('change', function () {
            const selectedCategoryId = parseInt(categorySelect.value);
            const selectedSubcategoryId = parseInt(this.value);

            if (selectedCategoryId === 3 && selectedSubcategoryId === 6) {
                formSubdomain.style.display = 'block';
                formLainnya.style.display = 'none';
                namaSubdomainInput.setAttribute('required', true);
            } else {
                formSubdomain.style.display = 'none';
                formLainnya.style.display = 'block';
                namaSubdomainInput.removeAttribute('required');
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

