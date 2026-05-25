<?php

namespace App\Modules\Client\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Concerns\LogsAuditTrail;

class Client extends Model
{
    
    use LogsAuditTrail;

    protected $fillable = [
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
