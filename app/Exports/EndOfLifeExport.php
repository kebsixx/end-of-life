<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EndOfLifeExport implements FromCollection, WithHeadings, WithMapping
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
            $category->manufactur->license_duration ?? '-',
            $category->manufactur->first_installation_date ?? '-',
            $category->manufactur->last_installation_date ?? '-',
            $category->version->release_date ?? '-',
            $category->version->expiry_date ?? '-',
        ];
    }
}
