<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Permohonan Subdomain</title>
    <style>
        /* ====== Base ====== */
        @page { margin: 28px 28px 40px 28px; }
        body { font-family: DejaVu Sans, Arial, sans-serif; color:#1f2937; font-size:12px; }
        .muted { color:#6b7280; }
        .text-center { text-align:center; }
        .text-right { text-align:right; }
        .mb-4 { margin-bottom:16px; }
        .mb-2 { margin-bottom:8px; }

        /* ====== Header ====== */
        .brand {
            display:flex; align-items:center; gap:12px; justify-content:center; margin-bottom:6px;
        }
        .brand img { width:120px; }
        .title { font-weight:700; font-size:16px; }
        .subtitle { font-size:11px; color:#6b7280; }

        /* ====== Table ====== */
        table { width:100%; border-collapse:collapse; border-spacing:0; }
        th, td { padding:8px 10px; border:1px solid #e5e7eb; }
        thead th {
            font-weight:700; font-size:12px; background:#f3f4f6; color:#374151; text-transform:uppercase;
        }
        tbody tr:nth-child(odd) { background:#fbfdff; } /* zebra */
        td.text-center { text-align:center; }

        /* ====== Status pill ====== */
        .pill { display:inline-block; padding:2px 8px; border-radius:999px; font-size:11px; font-weight:600; }
        .pill-wait   { background:#fff7ed; color:#c2410c;  border:1px solid #fed7aa; }  /* Menunggu */
        .pill-ok     { background:#ecfdf5; color:#047857;  border:1px solid #bbf7d0; }  /* Disetujui */
        .pill-reject { background:#fef2f2; color:#b91c1c;  border:1px solid #fecaca; }  /* Ditolak */

        /* ====== Footer (page number) ====== */
        .footer {
            position: fixed; left: 0; right: 0; bottom: 12px;
            text-align: right; font-size: 11px; color:#6b7280;
        }
        .footer .pageno:before { content: counter(page); }
        .footer .pagecount:before { content: counter(pages); }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="brand">
        <img src="{{ public_path('images/reang.png') }}" alt="Logo">
        <div>
            <div class="title">LAPORAN PERMOHONAN SUBDOMAIN PEMDA INDRAMAYU</div>
            <div class="subtitle">Tanggal Rekap: {{ now()->format('d M Y') }}</div>
        </div>
    </div>

    {{-- Tabel --}}
    <table class="mb-4">
        <thead>
            <tr>
                <th style="width:40px;">No</th>
                <th>Nama SKPD</th>
                <th>Subdomain</th>
                <th style="width:120px;">Status</th>
                <th style="width:120px;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($permohonan as $i => $p)
            @php
                $status = strtolower($p->status ?? '');
                $pillClass = $status === 'disetujui' ? 'pill-ok' : ($status === 'ditolak' ? 'pill-reject' : 'pill-wait');
            @endphp
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $p->skpd->name ?? '-' }}</td>
                <td>{{ $p->nama_subdomain ?: '-' }}</td>
                <td class="text-center">
                    <span class="pill {{ $pillClass }}">{{ ucfirst($p->status ?? '-') }}</span>
                </td>
                <td class="text-center">{{ optional($p->created_at)->format('d M Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- Footer page number --}}
    <div class="footer">
        Halaman <span class="pageno"></span> / <span class="pagecount"></span>
    </div>

</body>
</html>
