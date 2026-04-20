<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotKnowledge extends Model
{
    use HasFactory;

    protected $table = 'chatbot_knowledge';

    protected $fillable = [
        'language',
        'intent',
        'title',
        'summary',
        'steps',
        'keywords',
        'links',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'steps' => 'array',
            'keywords' => 'array',
            'links' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
