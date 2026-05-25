<?php

namespace App\Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use App\Concerns\LogsAuditTrail;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryItem extends Model
{
    use SoftDeletes, LogsAuditTrail;

    protected $fillable = [
        'name',
        'category',
        'quantity',
        'unit',
        'quantity_acquired',
        'quantity_distributed',
        'quantity_remaining',
        'supplier',
        'brand',
        'remarks',
    ];
}
