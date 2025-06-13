<?php

namespace App\Http\Controllers;

use App\Exports\DriversExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelFormats;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function exportDriversXLSX()
    {
        return Excel::download(new DriversExport, 'drivers.xlsx', ExcelFormats::XLSX);
    }

    public function exportDriversCSV()
    {
        return Excel::download(new DriversExport, 'drivers.csv', ExcelFormats::CSV, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
