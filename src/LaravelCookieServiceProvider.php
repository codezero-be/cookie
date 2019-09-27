<?php

namespace CodeZero\Cookie;

use Illuminate\Support\ServiceProvider;

class LaravelCookieServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('CodeZero\Cookie\Cookie', 'CodeZero\Cookie\LaravelCookie');
    }
}
