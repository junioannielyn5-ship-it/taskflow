<?php

namespace App\Modules\Client\Exports;

use App\Modules\Client\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Client::select(
            'company',
            'status',
            'category',
            'pricing',
            'items_inclusions',
            'contact_person',
            'position_dept',
            'contact_no',
            'email',
            'location',
            'quotation',
            'remarks'
        )->get();
    }

    public function headings(): array
    {
        return [
            'company',
            'status',
            'category',
            'pricing',
            'items_inclusions',
            'contact_person',
            'position_dept',
            'contact_no',
            'email',
            'location',
            'quotation',
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
