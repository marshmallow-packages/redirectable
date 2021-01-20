<?php

namespace Marshmallow\Redirectable;

use Illuminate\Support\ServiceProvider;

class RedirectableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/redirectable.php', 'redirectable');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/redirectable.php' => config_path('redirectable.php'),
        ]);
    }
}
