<?php

namespace App\Http\Controllers;

use App\Exports\EndOfLifeExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export()
    {
        $sortField = request('sort_field', 'first_installation_date');
        $sortDirection = request('sort_direction', 'asc');

        return Excel::download(
            new EndOfLifeExport($sortField, $sortDirection),
            'end-of-life-data.xlsx'
        );
    }
}
