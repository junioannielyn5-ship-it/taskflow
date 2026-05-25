<?php

namespace App\Modules\Supplier\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Concerns\LogsAuditTrail;

class Supplier extends Model
{
    
    use LogsAuditTrail;

    protected $fillable = [
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
