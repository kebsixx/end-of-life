<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EndOfLifeExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Category::with(['manufactur', 'version'])->get();
    }

    public function headings(): array
    {
        return [
            'Product Name',
            'Description',
            'Duration',
            'First Install',
            'Last Install',
            'Release Date',
            'Expiry Date',
        ];
    }

    public function map($category): array
    {
        return [
            $category->product_name,
            $category->description,
            $category->manufactur->first()?->license_duration ?? '-',
            $category->manufactur->first()?->first_installation_date?->translatedFormat('j F Y') ?? '-',
            $category->manufactur->first()?->last_installation_date?->translatedFormat('j F Y') ?? '-',
            $category->version?->release_date?->translatedFormat('j F Y') ?? '-',
            $category->version?->expiry_date?->translatedFormat('j F Y') ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Mengatur style
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getFill()->setFillType('solid')->getStartColor()->setRGB('E2E8F0');

        // Mengatur border untuk semua cell
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:G' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle('thin');

        // Mengatur alignment
        $sheet->getStyle('A1:G' . $lastRow)->getAlignment()->setVertical('center');
        $sheet->getStyle('A1:G' . $lastRow)->getAlignment()->setHorizontal('left');

        // Mengatur wrap text untuk deskripsi
        $sheet->getStyle('B2:B' . $lastRow)->getAlignment()->setWrapText(true);

        return [
            1 => ['font' => ['bold' => true]],
            'A1:G1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E2E8F0']]],
            'A1:G' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin']]],
        ];
    }
}
