<?php

namespace App\Providers;

use App\Models\CmsSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Load CMS settings only if table exists
        if (Schema::hasTable('cms_settings')) {
            $setting = CmsSetting::first();
            view()->share('setting', $setting);
        }
    }
}
