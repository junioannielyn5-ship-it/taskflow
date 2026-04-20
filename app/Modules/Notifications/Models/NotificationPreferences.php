<?php

namespace App\Modules\Notifications\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationPreferences extends Model
{
    protected $table = 'notification_preferences';

    protected $fillable = [
        'user_id',
        'type',
        'is_enabled',
    ];
}
