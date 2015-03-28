<?php namespace spec\CodeZero\Cookie;

use CodeZero\Cookie\VanillaCookieCore;
use CodeZero\Encrypter\Encrypter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VanillaCookieSpec extends ObjectBehavior
{
    private static $cookieName = "name";
    private static $cookieValue = "value";

    function let(VanillaCookieCore $cookie)
    {
        $this->beConstructedWith(null, $cookie);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('CodeZero\Cookie\VanillaCookie');
    }

    function it_gets_a_cookie(VanillaCookieCore $cookie)
    {
        $cookie->get(self::$cookieName)->shouldBeCalled()->willReturn(self::$cookieValue);
        $this->get(self::$cookieName)->shouldReturn(self::$cookieValue);
    }

    function it_returns_null_if_a_cookie_does_not_exist(VanillaCookieCore $cookie)
    {
        $this->get("not-a-cookie")->shouldReturn(null);
    }

    function it_sets_a_cookie_for_an_hour(VanillaCookieCore $cookie)
    {
        $cookie->set(self::$cookieName, self::$cookieValue, time() + 60 * 60)->shouldBeCalled()->willReturn(true);
        $this->store(self::$cookieName, self::$cookieValue)->shouldReturn(true);
    }

    function it_sets_a_cookie_for_a_custom_duration(VanillaCookieCore $cookie)
    {
        $minutes = 10;
        $cookie->set(self::$cookieName, self::$cookieValue, time() + 60 * $minutes)->shouldBeCalled()->willReturn(true);
        $this->store(self::$cookieName, self::$cookieValue, $minutes)->shouldReturn(true);
    }

    function it_sets_a_cookie_forever(VanillaCookieCore $cookie)
    {
        $cookie->set(self::$cookieName, self::$cookieValue, time() + 60 * 525600 * 5)->shouldBeCalled()->willReturn(true);
        $this->forever(self::$cookieName, self::$cookieValue)->shouldReturn(true);
    }

    function it_deletes_a_cookie(VanillaCookieCore $cookie)
    {
        $cookie->delete(self::$cookieName)->shouldBeCalled()->willReturn(true);
        $this->delete(self::$cookieName)->shouldReturn(true);
    }

    function it_encrypts_a_cookie(Encrypter $encrypter, VanillaCookieCore $cookie)
    {
        $this->beConstructedWith($encrypter, $cookie);
        $encrypter->encrypt(self::$cookieValue)->shouldBeCalled()->willReturn('encrypted cookie');
        $cookie->set(self::$cookieName, 'encrypted cookie', time() + 60 * 60)->shouldBeCalled()->willReturn(true);
        $this->store(self::$cookieName, self::$cookieValue)->shouldReturn(true);
    }

    function it_decrypts_a_cookie(Encrypter $encrypter, VanillaCookieCore $cookie)
    {
        $this->beConstructedWith($encrypter, $cookie);
        $cookie->get(self::$cookieName)->shouldBeCalled()->willReturn('encrypted cookie');
        $encrypter->decrypt('encrypted cookie')->shouldBeCalled()->willReturn(self::$cookieValue);
        $this->get(self::$cookieName)->shouldReturn(self::$cookieValue);
    }
}
