<?php

namespace CodeZero\Cookie\Laravel;

use Illuminate\Support\ServiceProvider;

class CookieServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('CodeZero\Cookie\Cookie', 'CodeZero\Cookie\Laravel\LaravelCookie');
    }
}
