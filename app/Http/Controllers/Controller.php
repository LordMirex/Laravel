<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\SiteSetting;

class Controller
{
    public function showHome()
    {
        $site_settings = SiteSetting::first();
        $blocks = Block::where('enabled', true)->orderBy('order_index')->get();
        return view('welcome', compact('site_settings', 'blocks'));
    }
}
