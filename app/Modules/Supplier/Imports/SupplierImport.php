<?php

namespace App\Modules\Supplier\Imports;

use App\Modules\Supplier\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class SupplierImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row)
    {
        // Skip empty rows
        if (!isset($row['name']) || empty($row['name'])) {
            return null;
        }

        return new Supplier([
            'name'                 => $row['name'],
            'status'               => $row['status'] ?? null,
            'category'             => $row['category'] ?? null,
            'contact'              => $row['contact'] ?? null,
            'position_dept'        => $row['position_dept'] ?? null,
            'contact_no'           => $row['contact_no'] ?? null,
            'email'                => $row['email'] ?? null,
            'location'             => $row['location'] ?? null,
            'proof_of_completion'  => $row['proof_of_completion'] ?? null,
            'remarks'              => $row['remarks'] ?? null,
        ]);
    }

    public function uniqueBy()
    {
        return 'name'; // Assuming name is unique for upsert. Excel uses this to find duplicates.
    }
}
