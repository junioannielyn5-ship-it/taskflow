<?php

namespace App\Modules\Client\Imports;

use App\Modules\Client\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ClientImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row)
    {
        // Skip empty rows
        if (!isset($row['company']) || empty($row['company'])) {
            return null;
        }

        return new Client([
            'company'              => $row['company'],
            'status'               => $row['status'] ?? null,
            'category'             => $row['category'] ?? null,
            'pricing'              => $row['pricing'] ?? null,
            'items_inclusions'     => $row['items_inclusions'] ?? null,
            'contact_person'       => $row['contact_person'] ?? null,
            'position_dept'        => $row['position_dept'] ?? null,
            'contact_no'           => $row['contact_no'] ?? null,
            'email'                => $row['email'] ?? null,
            'location'             => $row['location'] ?? null,
            'quotation'            => $row['quotation'] ?? null,
            'remarks'              => $row['remarks'] ?? null,
        ]);
    }

    public function uniqueBy()
    {
        return 'company'; // Using company as unique identifier for upsert
    }
}
