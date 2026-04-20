<?php

namespace App\Modules\Comments\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Modules\Identity\Models\User::class);
    }

    public function task()
    {
        return $this->belongsTo(\App\Modules\Tasks\Models\Task::class);
    }
}
