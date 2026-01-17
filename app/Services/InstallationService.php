<?php

namespace App\Services;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class InstallationService
{
    /**
     * Determine if the application is installed.
     *
     * @return bool
     */
    public function isInstalled(): bool
    {
        // 1. Authoritative check: installed.lock file
        if (File::exists(storage_path('installed.lock'))) {
            return true;
        }

        // 2. Environment check
        if (config('app.installed') === true || env('APP_INSTALLED') === true) {
            return true;
        }

        // 3. Database check (Minimal metadata check)
        try {
            if (Schema::hasTable('site_settings')) {
                return DB::table('users')->where('role', 'admin')->exists();
            }
        } catch (\Exception $e) {
            // Database might not be connected or reachable
        }

        return false;
    }
}
