@extends('skpd.layouts.wrapper')

@section('content')
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
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Subkategori</label>
            <select name="subcategory_id" id="subcategory_id" class="form-control" required>
                <option value="">Pilih Subkategori</option>
                <!-- Subkategori akan dimuat oleh JavaScript -->
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
@endsection

@section('scripts')
<script>
    // Membuat object untuk menyimpan subkategori berdasarkan kategori
    const subcategoriesData = @json($subcategories); // Data subkategori dari controller
    
    // Mendengarkan perubahan kategori
    document.getElementById('category_id').addEventListener('change', function() {
        const categoryId = this.value;
        const subcategorySelect = document.getElementById('subcategory_id');
        
        // Kosongkan subkategori
        subcategorySelect.innerHTML = '<option value="">Pilih Subkategori</option>';

        if (categoryId) {
            // Ambil subkategori yang sesuai dengan kategori yang dipilih
            const subcategories = subcategoriesData.filter(subcategory => subcategory.category_id == categoryId);

            // Masukkan subkategori ke dalam select
            subcategories.forEach(subcategory => {
                const option = document.createElement('option');
                option.value = subcategory.id;
                option.textContent = subcategory.name;
                subcategorySelect.appendChild(option);
            });
        }
    });
</script>
@endsection
