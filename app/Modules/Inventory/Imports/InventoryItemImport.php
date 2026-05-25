<?php

namespace App\Modules\Inventory\Imports;

use App\Modules\Inventory\Models\InventoryItem;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class InventoryItemImport implements ToModel, WithHeadingRow, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Skip empty rows
        if (!isset($row['name']) || empty($row['name'])) {
            return null;
        }

        return new InventoryItem([
            'name'                 => $row['name'],
            'category'             => $row['category'] ?? null,
            'quantity'             => isset($row['quantity']) ? (int) $row['quantity'] : 0,
            'unit'                 => $row['unit'] ?? null,
            'quantity_acquired'    => isset($row['quantity_acquired']) ? (int) $row['quantity_acquired'] : 0,
            'quantity_distributed' => isset($row['quantity_distributed']) ? (int) $row['quantity_distributed'] : 0,
            'quantity_remaining'   => isset($row['quantity_remaining']) ? (int) $row['quantity_remaining'] : 0,
            'supplier'             => $row['supplier'] ?? null,
            'brand'                => $row['brand'] ?? null,
            'remarks'              => $row['remarks'] ?? null,
        ]);
    }

    /**
     * @return string|array
     */
    public function uniqueBy()
    {
        return 'name';
    }
}
