<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = [
        'email',
        'name',
        'opt_in',
        'source',
        'tags',
    ];

    protected $casts = [
        'opt_in' => 'boolean',
        'tags' => 'array',
    ];
}
