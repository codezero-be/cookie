<?php namespace spec\CodeZero\Cookie;

use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LaravelCookieSpec extends ObjectBehavior
{
    private static $cookieName = "name";
    private static $cookieValue = "value";

    function let(Request $request, CookieJar $cookie)
    {
        $this->beConstructedWith($request, $cookie);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('CodeZero\Cookie\LaravelCookie');
    }

    function it_gets_a_cookie(Request $request)
    {
        $request->cookie(self::$cookieName)->shouldBeCalled()->willReturn(self::$cookieValue);
        $this->get(self::$cookieName)->shouldReturn(self::$cookieValue);
    }

    function it_returns_null_if_a_cookie_does_not_exist(Request $request)
    {
        $request->cookie("not-a-cookie")->shouldBeCalled()->willReturn(null);
        $this->get("not-a-cookie")->shouldReturn(null);
    }

    function it_sets_a_cookie_for_an_hour(CookieJar $cookie)
    {
        $cookie->queue(self::$cookieName, self::$cookieValue, 60)->shouldBeCalled();
        $this->store(self::$cookieName, self::$cookieValue)->shouldReturn(true);
    }

    function it_sets_a_cookie_for_a_custom_duration(CookieJar $cookie)
    {
        $minutes = 10;
        $cookie->queue(self::$cookieName, self::$cookieValue, $minutes)->shouldBeCalled();
        $this->store(self::$cookieName, self::$cookieValue, $minutes)->shouldReturn(true);
    }

    function it_sets_a_cookie_forever(CookieJar $cookie)
    {
        $cookie->queue(self::$cookieName, self::$cookieValue, 525600 * 5)->shouldBeCalled();
        $this->forever(self::$cookieName, self::$cookieValue)->shouldReturn(true);
    }

    function it_deletes_a_cookie(CookieJar $cookie)
    {
        $cookie->forget(self::$cookieName)->shouldBeCalled()->willReturn("cookie-object");
        $cookie->queue("cookie-object")->shouldBeCalled();
        $this->delete(self::$cookieName)->shouldReturn(true);
    }
}
