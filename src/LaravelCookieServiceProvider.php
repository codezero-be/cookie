<?php namespace CodeZero\Cookie;

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
        $this->registerCookie();
    }

    /**
     * Register the cookie service binding
     *
     * @return void
     */
    private function registerCookie()
    {
        $this->app->singleton(
            'CodeZero\Cookie\Cookie',
            'CodeZero\Cookie\LaravelCookie'
        );
    }
}
