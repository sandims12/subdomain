<?php

namespace App\Exports;

use App\Models\Permohonan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PermohonanExport implements FromCollection, WithHeadings
{
    protected ?int $kategoriId;
    protected ?int $subkategoriId;

    /**
     * Biarkan filter mengikuti halaman index (opsional).
     * Kalau null, berarti tanpa filter.
     */
    public function __construct(?int $kategoriId = null, ?int $subkategoriId = null)
    {
        $this->kategoriId    = $kategoriId ?: null;
        $this->subkategoriId = $subkategoriId ?: null;
    }

    public function collection()
    {
        $q = Permohonan::with('skpd')->latest();

        if ($this->kategoriId) {
            $q->where('category_id', $this->kategoriId);
        }
        if ($this->subkategoriId) {
            $q->where('subcategory_id', $this->subkategoriId);
        }

        return $q->get()->map(function ($p) {
            return [
                'ID'                 => $p->id,
                'SKPD'               => $p->skpd->name ?? '-',
                'Subdomain'          => $p->nama_subdomain,
                'Status'             => ucfirst($p->status),
                'Tanggal Pengajuan'  => optional($p->created_at)->format('d-m-Y'),
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
            'Tanggal Pengajuan',
        ];
    }
}
