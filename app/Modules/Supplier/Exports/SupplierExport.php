<?php

namespace App\Modules\Supplier\Exports;

use App\Modules\Supplier\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SupplierExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Supplier::select(
            'name',
            'status',
            'category',
            'contact',
            'position_dept',
            'contact_no',
            'email',
            'location',
            'proof_of_completion',
            'remarks'
        )->get();
    }

    public function headings(): array
    {
        return [
            'name',
            'status',
            'category',
            'contact',
            'position_dept',
            'contact_no',
            'email',
            'location',
            'proof_of_completion',
            'remarks',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
