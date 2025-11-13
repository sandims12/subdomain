@extends('admin.layouts.wrapper')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-1">Daftar Permohonan Subdomain</h3>
    <p class="text-muted mb-3" style="font-size: 0.85rem;">
        Klik judul kolom untuk mengurutkan (↑ naik, ↓ turun).
    </p>

    {{-- SEARCH LEFT + EXPORT RIGHT --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        {{-- SEARCH LEFT --}}
        <!-- <div class="w-25">
            <input type="text" id="searchInput" class="form-control shadow-sm"
                   placeholder="🔎 Cari data...">
        </div> -->

        {{-- EXPORT BUTTONS RIGHT --}}
        <div class="d-flex gap-2">
            <a href="{{ route('admin.permohonan.export.pdf') }}" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
            <a href="{{ route('admin.permohonan.export') }}" class="btn btn-success">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            <table class="table table-hover align-middle mb-0" id="permohonanTable">
                <thead>
                <tr>
                    <th class="sortable" data-column="0" data-type="number"># <span class="sort-icon"></span></th>
                    <th class="sortable" data-column="1" data-type="text">Nama SKPD <span class="sort-icon"></span></th>
                    <th class="sortable" data-column="2" data-type="text">Subdomain <span class="sort-icon"></span></th>
                    <th class="sortable" data-column="3" data-type="text">Status <span class="sort-icon"></span></th>
                    <th class="sortable" data-column="4" data-type="date">Tanggal <span class="sort-icon"></span></th>
                    <th class="text-center">Aksi</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($permohonan as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $p->skpd->name ?? '-' }}</td>
                        <td>{{ $p->nama_subdomain }}</td>

                        <td>
                            @if ($p->status == 'disetujui')
                                <span class="badge bg-success px-3 py-2 rounded-pill text-white">Disetujui</span>
                            @elseif ($p->status == 'menunggu')
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill text-white">Menunggu</span>
                            @else
                                <span class="badge bg-danger px-3 py-2 rounded-pill text-white">Ditolak</span>
                            @endif
                        </td>

                        <td>{{ $p->created_at->format('d M Y') }}</td>

                        <td class="text-center">
                            {{-- Stack vertikal: Detail di atas, Hapus di bawah --}}
                            <div class="d-flex flex-column align-items-stretch gap-2 aksi-stack mx-auto">
                                <a href="{{ route('admin.permohonan.show', $p->id) }}"
                                   class="btn btn-sm btn-primary rounded-pill w-100">
                                    <i class="bi bi-eye"></i> Detail
                                </a>

                                @if ($p->status == 'ditolak')
                                    <form action="{{ route('admin.permohonan.destroy', $p->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus permohonan ini?')"
                                          class="w-100">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger rounded-pill w-100">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>
</div>

<!-- datatable -->

<script>
  $(document).ready(function () {
    $('#permohonanTable').DataTable();
  });
</script>


{{-- ================== SCRIPT ================== --}}
<script>
    // 🔎 SEARCH FUNCTION
    document.getElementById("searchInput").addEventListener("keyup", function () {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll("#permohonanTable tbody tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(value) ? "" : "none";
        });
    });

    // 🔽 SORTING FUNCTION
    const headers = document.querySelectorAll(".sortable");

    headers.forEach(header => {
        header.addEventListener("click", function () {
            const table = document.getElementById("permohonanTable");
            const tbody = table.querySelector("tbody");
            const column = parseInt(this.dataset.column);
            const type = this.dataset.type;
            let rows = Array.from(tbody.querySelectorAll("tr"));

            const asc = this.dataset.order !== "asc";

            // Reset icon header lain
            headers.forEach(h => {
                if (h !== this) {
                    h.dataset.order = "";
                    h.querySelector(".sort-icon").textContent = "";
                }
            });

            // Set icon baru
            this.dataset.order = asc ? "asc" : "desc";
            this.querySelector(".sort-icon").textContent = asc ? "▲" : "▼";

            rows.sort((a, b) => {
                let x = a.children[column].innerText.trim();
                let y = b.children[column].innerText.trim();

                if (type === "number") {
                    x = parseInt(x); y = parseInt(y);
                } else if (type === "date") {
                    x = new Date(x); y = new Date(y);
                } else {
                    x = x.toLowerCase(); y = y.toLowerCase();
                }

                return asc ? (x > y ? 1 : -1) : (x < y ? 1 : -1);
            });

            tbody.innerHTML = "";
            rows.forEach(row => tbody.appendChild(row));
        });
    });

    // 📌 DEFAULT SORT BY DATE DESC
    window.onload = function () {
        const thDate = document.querySelector('[data-column="4"]');
        if (thDate) {
            thDate.dataset.order = "asc"; // biar klik pertama => DESC
            thDate.click();
        }
    };
</script>

{{-- UI CLEAN CSS --}}
<style>
    thead { background: #f8f9fc; }

    thead th {
        font-size: 0.8rem;
        text-transform: uppercase;
        color: #6c757d;
        padding-top: 14px !important;
        padding-bottom: 14px !important;
    }

    tbody tr:hover { background: rgba(13,110,253,.05); transition: .2s; }

    .sort-icon { font-size: .75rem; margin-left: 4px; color: #0d6efd; }

    #searchInput { border-radius: 30px; padding-left: 14px; }

    .btn-primary { background: #0d6efd; border: none; }
    .btn-danger  { background: #dc3545; border: none; }

    .badge { font-size: .75rem; }

    /* Biar tombol aksi rapi & tidak melebar */
    .aksi-stack { width: 150px; }
</style>
@endsection
