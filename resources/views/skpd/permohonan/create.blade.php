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
    {{-- ANGGARAN (BARU) --}}
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

                <div class="mb-3">
                    <label class="form-label">Pengelola</label>
                    <input type="text" name="pengelola" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan Pembangunan</label>
                    <textarea name="ket_pembangunan" class="form-control" rows="3"
                    placeholder="Contoh: Progres pengembangan, pihak yang terlibat, dll."></textarea>
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
                <input type="file" name="file_pengajuan" id="file_pengajuan" class="form-control" accept="application/pdf" required>

                

                {{-- Error File --}}
                <small id="file_error" class="text-danger fw-bold d-none"></small>
            </div>

            {{-- Progress Bar --}}
            <div class="progress mt-3 d-none" id="uploadProgressBox">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                    id="uploadProgress" 
                    role="progressbar" 
                    style="width: 0%">
                    0%
                </div>
            </div>



            <div class="text-start mt-3">
                <button type="submit" class="btn btn-primary btn-sm px-4">
                    <i class="bi bi-send"></i> Kirim Permohonan
                </button>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ============================
       ==  FORM DINAMIS CATEGORY ==
       ============================ */

    const allSubcategories   = @json($subcategories);
    const categorySelect     = document.getElementById('categorySelect');
    const subcategorySelect  = document.getElementById('subcategorySelect');
    const formSubdomain      = document.getElementById('formSubdomain');
    const formLainnya        = document.getElementById('formLainnya');

    const vendorContainer    = document.getElementById('vendor-container');
    const vendorNama         = document.getElementById('vendor-nama-container');
    const vendorSelect       = document.getElementById('vendor');
    const inputNamaVendor    = document.getElementById('nama_vendor');

    const namaView           = document.getElementById('nama_subdomain_view');
    const namaFull           = document.getElementById('nama_subdomain');

    function resetVendor() {
        vendorContainer.style.display = 'none';
        vendorNama.classList.add('d-none');
        vendorSelect.value = 'tidak';
        inputNamaVendor.value = '';
        inputNamaVendor.removeAttribute('required');
    }

    resetVendor();


    /* ============================
       ==  INPUT SUBDOMAIN AUTO ==
       ============================ */

    if (namaView && namaFull) {
        const domain = ".indramayukab.go.id";

        namaView.addEventListener('input', function () {
            let clean = this.value
                .toLowerCase()
                .replace(/\s+/g, '')
                .replace(/[^a-z0-9-]/g, '');

            this.value = clean;
            namaFull.value = clean ? clean + domain : '';
        });
    }


    /* ===============================
       ==  PILIH KATEGORI / SUBKAT ==
       =============================== */

    categorySelect.addEventListener("change", function () {
        subcategorySelect.innerHTML = '<option value="">-- Pilih Subkategori --</option>';
        subcategorySelect.disabled = true;

        formSubdomain.style.display = "none";
        formLainnya.style.display = "none";
        resetVendor();

        const filtered = allSubcategories.filter(sub => sub.category_id == this.value);
        filtered.forEach(sub => {
            const opt = document.createElement("option");
            opt.value = sub.name;
            opt.textContent = sub.name;
            subcategorySelect.appendChild(opt);
        });

        subcategorySelect.disabled = false;
    });

    subcategorySelect.addEventListener("change", function () {
        const selected = this.value.toLowerCase().replace(/\s+/g, '');

        if (selected === "subdomain") {
            formSubdomain.style.display = "block";
            formLainnya.style.display = "none";
            vendorContainer.style.display = "block";
        } else {
            formSubdomain.style.display = "none";
            formLainnya.style.display = "block";
            resetVendor();
        }
    });


    /* ======================
       ==  TOGGLE VENDOR  ==
       ====================== */

    vendorSelect.addEventListener("change", function () {
        if (this.value === "iya") {
            vendorNama.classList.remove("d-none");
            inputNamaVendor.setAttribute("required", true);
        } else {
            vendorNama.classList.add("d-none");
            inputNamaVendor.removeAttribute("required");
        }
    });


    /* ======================
       == VALIDASI PDF    ==
       ====================== */

    const fileInput = document.getElementById("file_pengajuan");
    const fileError = document.getElementById("file_error");

    fileInput.addEventListener("change", function () {
        const file = this.files[0];
        fileError.classList.add("d-none");

        if (!file) return;

        if (file.type !== "application/pdf") {
            fileError.textContent = "❌ File harus PDF!";
            fileError.classList.remove("d-none");
            this.value = "";
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            fileError.textContent = "❌ Ukuran maksimal 2 MB!";
            fileError.classList.remove("d-none");
            this.value = "";
            return;
        }
    });


    /* =======================================
       == UPLOAD AJAX + PROGRESS + SWEETALERT ==
       ======================================= */

    const form = document.querySelector("form");
    const progressBox = document.getElementById("uploadProgressBox");
    const progressBar = document.getElementById("uploadProgress");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        progressBox.classList.remove("d-none");

        const xhr = new XMLHttpRequest();
        xhr.open("POST", this.action, true);

        xhr.upload.addEventListener("progress", function (e) {
            if (e.lengthComputable) {
                let percent = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percent + "%";
                progressBar.textContent = percent + "%";
            }
        });

        xhr.onload = function () {
            if (xhr.status === 200) {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: "Pengajuan berhasil dikirim.",
                    confirmButtonColor: "#3085d6",
                }).then(() => {
                    window.location.href = "/skpd/permohonan";
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text: "Terjadi kesalahan saat mengunggah file."
                });
            }
        };

        xhr.send(formData);
    });

});
</script>

<style>
.shake {
    animation: shake 0.3s;
    border: 2px solid red !important;
}
@keyframes shake {
    0%   { transform: translateX(0); }
    25%  { transform: translateX(-4px); }
    50%  { transform: translateX(4px); }
    75%  { transform: translateX(-4px); }
    100% { transform: translateX(0); }
}
</style>
