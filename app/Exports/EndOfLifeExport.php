<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EndOfLifeExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
            optional($category->manufactur->first())->license_duration ?? '-',
            optional($category->manufactur->first())->first_installation_date?->format('Y-m-d') ?? '-',
            optional($category->manufactur->first())->last_installation_date?->format('Y-m-d') ?? '-',
            $category->version->release_date ?? '-',
            $category->version->expiry_date ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A1:G1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E2E8F0']]],
            'A1:G' . $sheet->getHighestRow() => ['borders' => ['allBorders' => ['borderStyle' => 'thin']]],
        ];
    }
}
