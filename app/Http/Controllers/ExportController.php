<?php

namespace App\Http\Controllers;

use App\Exports\EndOfLifeExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export()
    {
        return Excel::download(new EndOfLifeExport, 'end-of-life-data.xlsx');
    }
}
