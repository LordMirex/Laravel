<?php

namespace App\Repositories;

use App\Models\SiteSetting;

class SiteSettingsRepository
{
    public function getSettings()
    {
        return SiteSetting::first();
    }

    public function updateSettings(array $data)
    {
        $settings = SiteSetting::firstOrNew([]);
        $settings->fill($data);
        $settings->save();
        return $settings;
    }
}
