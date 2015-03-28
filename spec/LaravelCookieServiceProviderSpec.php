<?php namespace spec\CodeZero\Cookie;

use Illuminate\Contracts\Foundation\Application;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LaravelCookieServiceProviderSpec extends ObjectBehavior
{
    function let(Application $app)
    {
        $this->beConstructedWith($app);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('CodeZero\Cookie\LaravelCookieServiceProvider');
    }

    function it_binds_the_laravel_cookie_implementation(Application $app)
    {
        $app->singleton('CodeZero\Cookie\Cookie', 'CodeZero\Cookie\LaravelCookie')->shouldBeCalled();
        $this->register();
    }
}
