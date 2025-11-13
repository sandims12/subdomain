<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            font-size: 12px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #444;
            padding: 6px;
            font-size: 12px;
        }

        th {
            text-align: center;
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .logo {
            width: 160px;
            margin-bottom: -10px;
        }
    </style>
</head>

<body>

    {{-- LOGO --}}
    <div style="text-align: center;">
        <img src="{{ public_path('images/reang.png') }}" class="logo">
    </div>

    {{-- TITLE --}}
    <p class="title">LAPORAN PERMOHONAN SUBDOMAIN PEMDA INDRAMAYU</p>
    <p class="subtitle">Tanggal Rekap: {{ date('d M Y') }}</p>

    {{-- TABLE --}}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama SKPD</th>
                <th>Subdomain</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($permohonan as $i => $p)
            <tr>
                <td style="text-align:center;">{{ $i + 1 }}</td>
                <td>{{ $p->skpd->name ?? '-' }}</td>
                <td>{{ $p->nama_subdomain }}</td>
                <td style="text-align:center;">
                    {{ ucfirst($p->status) }}
                </td>
                <td style="text-align:center;">
                    {{ $p->created_at->format('d M Y') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
