<main class="main-content">
    <div class="container py-4">
        <h3 class="fw-bold text-primary mb-4">Ajukan Permohonan Subdomain</h3>

        <form action="{{ route('skpd.permohonan.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Subdomain</label>
                <input type="text" name="nama_subdomain" class="form-control" placeholder="contoh: dispendik.indramayukab.go.id" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Kategori</label>
                <select id="categorySelect" class="form-select" name="category_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Subkategori</label>
                <select id="subcategorySelect" class="form-select" name="subcategory_id" required>
                    <option value="">-- Pilih Subkategori --</option>
                    {{-- Akan diisi oleh JavaScript --}}
                </select>
            </div>

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
    // Subcategories dari Laravel ke JavaScript
    const allSubcategories = @json($subcategories);

    const categorySelect = document.getElementById('categorySelect');
    const subcategorySelect = document.getElementById('subcategorySelect');

    categorySelect.addEventListener('change', function () {
        const selectedCategoryId = this.value;

        // Clear subcategory options
        subcategorySelect.innerHTML = '<option value="">-- Pilih Subkategori --</option>';

        // Filter dan tampilkan
        allSubcategories
            .filter(sub => sub.category_id == selectedCategoryId)
            .forEach(sub => {
                const option = document.createElement('option');
                option.value = sub.id;
                option.textContent = sub.name;
                subcategorySelect.appendChild(option);
            });
    });
</script>