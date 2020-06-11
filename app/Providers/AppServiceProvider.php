<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $view = config('view.compiled');
        $ssr = config('ssr.node.temp_path');
        foreach ([$view, $ssr] as $path) {
            if (! is_dir($path)) {
                mkdir($path, 0755, true);
            }
        }
    }
}
