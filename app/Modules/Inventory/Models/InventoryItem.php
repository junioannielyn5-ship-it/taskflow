<?php

namespace App\Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryItem extends Model
{
    use SoftDeletes;

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
