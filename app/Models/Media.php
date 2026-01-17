<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'filename',
        'path',
        'type',
        'alt_text',
        'variants',
        'focal_x',
        'focal_y',
    ];

    protected $casts = [
        'variants' => 'array',
    ];
}
