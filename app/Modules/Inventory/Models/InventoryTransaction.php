<?php

namespace App\Modules\Inventory\Models;

use App\Modules\Identity\Models\User;
use App\Concerns\LogsAuditTrail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryTransaction extends Model
{
    use SoftDeletes, LogsAuditTrail;

    protected $fillable = [
        'inventory_item_id',
        'type',
        'quantity',
        'transaction_date',
        'reference',
        'remarks',
        'actor_id',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'quantity' => 'integer',
    ];

    /**
     * @return BelongsTo<InventoryItem, InventoryTransaction>
     */
    public function inventoryItem(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class);
    }

    /**
     * @return BelongsTo<User, InventoryTransaction>
     */
    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
