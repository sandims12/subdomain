<?php

namespace App\Exports;

use App\Models\Subdomain;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubdomainExport implements FromCollection, WithHeadings, WithMapping
{
    // data yang akan di-export
    public function collection()
    {
        return Subdomain::orderBy('nama_subdomain', 'asc')->get();
    }

    // header kolom di excel
    public function headings(): array
    {
        return [
            'No',
            'Nama Subdomain',
            'Nama Aplikasi',
            'Sifat',
            'Tahun Penganggaran',
            'Anggaran',
            'Layanan',
            'Platform OS',
            'Jenis Aplikasi',
            'Database',
            'Bahasa Pemrograman',
            'Status Aplikasi',
            'Pengelola',
            'Kondisi',
            'Status Domain',
            'Link',
            'Dibuat Pada',
        ];
    }

    // mapping setiap baris
    public function map($s): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $s->nama_subdomain,
            $s->nama_aplikasi,
            $s->sifat,
            $s->tahun_penganggaran,
            $s->anggaran,
            $s->layanan,
            $s->platform_os,
            $s->jenis_aplikasi,
            $s->database_engine,
            $s->bahasa_pemrograman,
            $s->status_aplikasi,
            $s->pengelola,
            $s->kondisi,
            $s->status,
            $s->link,
            optional($s->created_at)->format('d-m-Y H:i'),
        ];
    }
}