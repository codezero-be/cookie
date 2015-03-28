<?php namespace spec\CodeZero\Cookie;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VanillaCookieCoreSpec extends ObjectBehavior
{
    private static $cookieName = "name";
    private static $cookieValue = "value";

    function let()
    {
        $this->beConstructedWith([]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('CodeZero\Cookie\VanillaCookieCore');
    }

    function it_gets_a_cookie()
    {
        $this->beConstructedWith([self::$cookieName => self::$cookieValue]);
        $this->get(self::$cookieName)->shouldReturn(self::$cookieValue);
    }

    function it_returns_null_if_a_cookie_does_not_exist()
    {
        $this->get("not-a-cookie")->shouldReturn(null);
    }

    function it_sets_a_cookie()
    {
        $this->set(self::$cookieName, self::$cookieValue, time() + 60)->shouldReturn(true);
    }

    function it_deletes_a_cookie()
    {
        $this->beConstructedWith([self::$cookieName => self::$cookieValue]);
        $this->get(self::$cookieName)->shouldReturn(self::$cookieValue);
        $this->delete(self::$cookieName)->shouldReturn(true);
        $this->get(self::$cookieName)->shouldReturn(null);
    }

    function it_returns_true_if_you_delete_a_cookie_that_does_not_exist()
    {
        $this->get(self::$cookieName)->shouldReturn(null);
        $this->delete(self::$cookieName)->shouldReturn(true);
    }
}
