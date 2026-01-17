<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_title',
        'site_tagline',
        'whatsapp_number',
        'currency_symbol',
        'category',
        'theme_config',
        'features',
    ];

    protected $casts = [
        'theme_config' => 'array',
        'features' => 'array',
    ];
}
