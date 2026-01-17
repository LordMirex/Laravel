<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = [
        'type',
        'order_index',
        'enabled',
        'content',
        'meta',
    ];

    protected $casts = [
        'content' => 'array',
        'meta' => 'array',
        'enabled' => 'boolean',
    ];
}
