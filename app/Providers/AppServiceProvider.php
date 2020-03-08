<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ([config('view.compiled'), config('ssr.node.temp_path')] as $path) {
            // Make sure the directory for compiled views exist
            if (! is_dir($path)) {
                mkdir($path, 0755, true);
            }
        }
    }
}
