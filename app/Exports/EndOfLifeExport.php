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
    protected $sortField;
    protected $sortDirection;

    public function __construct($sortField = 'first_installation_date', $sortDirection = 'asc')
    {
        $this->sortField = $sortField;
        $this->sortDirection = $sortDirection;
    }

    public function collection()
    {
        $data = Category::with(['manufactur' => function ($query) {
            $query->latest();
        }, 'version'])->get();

        return $data->sort(function ($a, $b) {
            $aValue = $this->getValueForSort($a);
            $bValue = $this->getValueForSort($b);

            if ($this->sortDirection === 'asc') {
                return $aValue <=> $bValue;
            }
            return $bValue <=> $aValue;
        });
    }

    private function getValueForSort($category)
    {
        return match ($this->sortField) {
            'first_installation_date' => $category->manufactur->first()?->first_installation_date,
            'last_installation_date' => $category->manufactur->first()?->last_installation_date,
            'release_date' => $category->version?->release_date,
            'expiry_date' => $category->version?->expiry_date,
            default => null
        };
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
        // Format dates consistently with blade template
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
        $lastRow = $sheet->getHighestRow();

        // Header styling
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getFill()->setFillType('solid')->getStartColor()->setRGB('E2E8F0');

        // Mengatur border untuk semua cell
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
