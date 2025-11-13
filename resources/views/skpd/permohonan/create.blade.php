<main class="main-content">
    <div class="container py-4">
        <h3 class="fw-bold text-primary mb-4">Ajukan Permohonan Subdomain</h3>

        <form action="{{ route('skpd.permohonan.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
            @csrf

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
                <select id="subcategorySelect" class="form-select" name="subcategory_id" required disabled>
                    <option value="">-- Pilih Subkategori --</option>
                </select>
            </div>

            <!-- ✅ FORM jika subkategori punya category_id = 3 -->
            <div id="subdomainForm" class="mb-3" style="display:none;">
                <label class="form-label fw-semibold">Nama Subdomain</label>
                <input type="text" name="subdomain_name" class="form-control" placeholder="contoh: dispendik.indramayukab.go.id">
            </div>

            <!-- ✅ FORM LAIN jika subkategori selain category_id = 3 -->
            <div id="formLain" class="mb-3" style="display:none;">
                <label class="form-label fw-semibold">Keperluan</label>
                <textarea name="keperluan" class="form-control" rows="3" placeholder="Jelaskan keperluan Anda..."></textarea>
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
    document.addEventListener('DOMContentLoaded', function () {
        const allSubcategories = @json($subcategories);
        const categorySelect = document.getElementById('categorySelect');
        const subcategorySelect = document.getElementById('subcategorySelect');
        const subdomainForm = document.getElementById('subdomainForm');
        const formLain = document.getElementById('formLain');

        categorySelect.addEventListener('change', function () {
            const selectedCategoryId = this.value;

            subcategorySelect.innerHTML = '<option value="">-- Pilih Subkategori --</option>';
            subcategorySelect.disabled = true;
            subdomainForm.style.display = 'none';
            formLain.style.display = 'none';

            if (!selectedCategoryId) return;

            const filtered = allSubcategories.filter(sub => sub.category_id == selectedCategoryId);

            if (filtered.length > 0) {
                filtered.forEach(sub => {
                    const option = document.createElement('option');
                    option.value = sub.id;
                    option.textContent = sub.name;
                    option.dataset.category = sub.category_id;
                    subcategorySelect.appendChild(option);
                });

                subcategorySelect.disabled = false;
            } else {
                const option = document.createElement('option');
                option.value = "";
                option.textContent = "Tidak ada subkategori tersedia";
                subcategorySelect.appendChild(option);
            }
        });

        subcategorySelect.addEventListener('change', function () {
            const selectedSubcategoryId = this.value;
            const selectedSubcategory = allSubcategories.find(sub => sub.id == selectedSubcategoryId);

            subdomainForm.style.display = 'none';
            formLain.style.display = 'none';

            if (selectedSubcategory && selectedSubcategory.category_id == 3) {
                subdomainForm.style.display = 'block';
            } else if (selectedSubcategory) {
                formLain.style.display = 'block';
            }
        });
    });
</script>
