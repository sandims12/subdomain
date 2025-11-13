<?php

namespace App\Exports;

use App\Models\Permohonan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PermohonanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Permohonan::with('skpd')
            ->get()
            ->map(function ($p) {
                return [
                    'ID' => $p->id,
                    'SKPD' => $p->skpd->name ?? '-',
                    'Subdomain' => $p->nama_subdomain,
                    'Status' => ucfirst($p->status),
                    'Tanggal Pengajuan' => $p->created_at->format('d-m-Y'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama SKPD',
            'Subdomain',
            'Status',
            'Tanggal Pengajuan'
        ];
    }
}
