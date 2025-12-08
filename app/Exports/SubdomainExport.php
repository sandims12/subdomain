<?php

namespace App\Exports;

use App\Models\Subdomain;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Events\AfterSheet;

class SubdomainExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize,
    WithEvents,
    WithTitle,
    WithColumnFormatting
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

    /**
     * Nama sheet
     */
    public function title(): string
    {
        return 'Data Subdomain';
    }

    /**
     * Format kolom tertentu
     */
    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER,           // Tahun
            'R' => NumberFormat::FORMAT_DATE_DATETIME,    // Dibuat Pada (kalau mau pakai format datetime)
        ];
    }

    /**
     * Style dasar (header dll)
     */
    public function styles(Worksheet $sheet)
    {
        // Style header di baris 1
        $sheet->getStyle('A1:Q1')->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1F4E78'], // biru tua
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => 'DDDDDD'],
                ],
            ],
        ]);

        // Lebih rapi: angka "No" rata tengah
        $sheet->getStyle('A2:A' . ($sheet->getHighestRow()))->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }

    /**
     * Event untuk fitur interaktif:
     * - Freeze header
     * - Auto filter
     * - Zebra row (baris selang-seling warna)
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();   // baris terakhir
                $highestCol = $sheet->getHighestColumn(); // kolom terakhir (Q)

                // Freeze header (baris 1)
                $sheet->freezePane('A2');

                // Auto filter di header
                $sheet->setAutoFilter("A1:{$highestCol}1");

                // Border untuk semua sel yang terisi
                $sheet->getStyle("A1:{$highestCol}{$highestRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('DDDDDD'));

                // Zebra style: baris genap diberi warna abu-abu muda
                for ($row = 2; $row <= $highestRow; $row++) {
                    if ($row % 2 == 0) {
                        $sheet->getStyle("A{$row}:{$highestCol}{$row}")
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB('F4F6F8');
                    }
                }
            },
        ];
    }
}
