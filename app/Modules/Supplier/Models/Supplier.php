<?php

namespace App\Modules\Supplier\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

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
