<?php

namespace App\Exports;

use App\Models\Driver;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DriversExport implements FromCollection, WithHeadings, WithMapping
{
    protected array $columns;

    public function __construct()
    {
        $this->columns = Schema::getColumnListing('drivers');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Driver::with('createdBy', 'reviewedBy')->get();
    }

    public function headings(): array
    {
        return $this->columns;
    }

    public function map($driver): array
    {
        $row = [];
        foreach ($this->columns as $column) {
            // Handle formatting for specific columns.
            switch ($column) {
                case 'created_by':
                    $row[$column] = $driver->createdBy?->name;
                    break;
                case 'reviewed_by':
                    $row[$column] = $driver->reviewedBy?->name;
                    break;
                case 'status':
                    $row[$column] = ucfirst(str_replace('_', ' ', $driver->status));
                    break;
                default:
                    $row[$column] = $driver->{$column};
            }
        }

        // Hack: replace file paths with Uploaded/Missing
        foreach (Driver::FILE_INPUT_MAP as $details) {
            $row[$details['column']] = $driver->{$details['column']} ? 'Uploaded' : 'Missing';
        }
        return $row;
    }
}