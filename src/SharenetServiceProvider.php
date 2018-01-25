<?php
/*
 * This file is part of the Laravel Sharenet package.
 * (c) Chiemela Chinedum <chiemelachinedum@gmail.com>
 */

namespace Melas\Sharenet;

use Illuminate\Support\ServiceProvider;

class SharenetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__. '/config' => config_path()
        ], 'config');
    }

    public function register()
    {
        $this->app->bind('laravel-sharenet', function() {
            return new Sharenet;
        });

        $this->mergeConfigFrom(__DIR__.'/config/sharenet.php', 'sharenet');
    }
}