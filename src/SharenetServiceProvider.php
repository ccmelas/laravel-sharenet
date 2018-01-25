<?php
namespace Melas\Sharenet;

use Illuminate\Support\ServiceProvider;

class SharenetServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('laravel-sharenet', function() {
            return new Sharenet;
        });

        $this->mergeConfigFrom(__DIR__.'/config/sharenet.php', 'sharenet');
    }
}