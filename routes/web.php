<?php

use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::middleware([
    'auth',
    'verified'
])->group(function () {
    Route::get('/export', [ExportController::class, 'export'])->name('export.excel');
});
