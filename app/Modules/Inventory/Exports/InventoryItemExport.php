<?php

namespace App\Modules\Inventory\Exports;

use App\Modules\Inventory\Models\InventoryItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoryItemExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return InventoryItem::select(
            'name',
            'category',
            'quantity',
            'unit',
            'quantity_acquired',
            'quantity_distributed',
            'quantity_remaining',
            'supplier',
            'brand',
            'remarks'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Category',
            'Quantity',
            'Unit',
            'Quantity Acquired',
            'Quantity Distributed',
            'Quantity Remaining',
            'Supplier',
            'Brand',
            'Remarks',
        ];
    }
}
