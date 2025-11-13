@php
    // kolom default untuk sort + arah (asc/desc)
    $defaultSortCol = $defaultSortCol ?? 0;
    $defaultSortDir = strtolower($defaultSortDir ?? 'asc'); // asc|desc
@endphp

{{-- ============= CLEAN UI CSS (ringan) ============= --}}
<style>
    #dataTable thead { background:#f8f9fc; }
    #dataTable thead th {
        font-size:.8rem; text-transform:uppercase;
        color:#6c757d; padding-top:14px!important; padding-bottom:14px!important;
        cursor: default;
    }
    #dataTable thead th.sortable { cursor: pointer; }
    #dataTable tbody tr:hover { background:rgba(13,110,253,.05); transition:.2s; }
    .sort-icon { font-size:.75rem; margin-left:4px; color:#0d6efd; }
    #searchInput { border-radius:30px; padding-left:14px; }
</style>

{{-- ============= SEARCH + SORT (vanilla) ============= --}}
<script>
(function() {
    const table  = document.getElementById('dataTable');
    const tbody  = table ? table.querySelector('tbody') : null;
    if (!table || !tbody) return;

    // SEARCH
    const search = document.getElementById('searchInput');
    if (search) {
        search.addEventListener('keyup', function () {
            const val = this.value.toLowerCase();
            const rows = tbody.querySelectorAll('tr');
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(val) ? '' : 'none';
            });
        });
    }

    // SORT
    const headers = table.querySelectorAll('thead th.sortable');
    headers.forEach(th => {
        th.addEventListener('click', function () {
            const col  = parseInt(this.dataset.column);
            const type = this.dataset.type;
            let rows   = Array.from(tbody.querySelectorAll('tr')).filter(r => r.style.display !== 'none');

            const asc  = this.dataset.order !== 'asc';

            // reset ikon selain yg aktif
            headers.forEach(h => {
                if (h !== this) { h.dataset.order=''; const si=h.querySelector('.sort-icon'); if (si) si.textContent=''; }
            });

            this.dataset.order = asc ? 'asc' : 'desc';
            const icon = this.querySelector('.sort-icon'); if (icon) icon.textContent = asc ? '▲' : '▼';

            rows.sort((a,b) => {
                let x = a.children[col].innerText.trim();
                let y = b.children[col].innerText.trim();

                if (type === 'number') { x = parseInt(x)||0; y = parseInt(y)||0; }
                else if (type === 'date') { x = new Date(x); y = new Date(y); }
                else { x = x.toLowerCase(); y = y.toLowerCase(); }

                return asc ? (x>y?1:(x<y?-1:0)) : (x<y?1:(x>y?-1:0));
            });

            // re-render
            rows.forEach(r => tbody.appendChild(r));
        });
    });

    // DEFAULT SORT (opsional)
    @if(is_numeric($defaultSortCol))
        const targetTh = table.querySelector(`thead th.sortable[data-column="{{ $defaultSortCol }}"]`);
        if (targetTh) {
            targetTh.dataset.order = '{{ $defaultSortDir === 'asc' ? 'desc' : 'asc' }}'; // trik agar klik set ke dir yg diminta
            targetTh.click();
        }
    @endif
})();
</script>
