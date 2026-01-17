<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SiteSettingsRepository;
use App\Repositories\BlockRepository;
use App\Repositories\ProductRepository;
use App\Repositories\MediaRepository;
use App\Repositories\SubscriberRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SiteSettingsRepository::class);
        $this->app->singleton(BlockRepository::class);
        // ... other repositories
    }

    public function boot(): void
    {
        //
    }
}
