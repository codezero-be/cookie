<?php

namespace CodeZero\Cookie\Tests;

use CodeZero\Cookie\VanillaCookie;
use CodeZero\Encrypter\DefaultEncrypter;
use PHPUnit\Framework\TestCase;

class VanillaCookieTest extends TestCase
{
    /** @test */
    function it_gets_a_cookie()
    {
        $cookie = new VanillaCookie();
        $_COOKIE['CookieName'] = 'Cookie Value';

        $cookieValue = $cookie->get('CookieName');

        $this->assertEquals('Cookie Value', $cookieValue);
    }

    /** @test */
    function it_returns_null_if_a_cookie_does_not_exist()
    {
        $cookie = new VanillaCookie();

        $value = $cookie->get('not-a-cookie');

        $this->assertNull($value);
    }

    /** @test */
    function it_sets_a_cookie()
    {
        $cookie = new VanillaCookie();

        $testData = $cookie->store('CookieName', 'Cookie Value');

        $this->assertEquals('CookieName', $testData['name']);
        $this->assertEquals('Cookie Value', $testData['value']);
        $this->assertEquals(3600, $testData['expire']); // 60 minutes: time() + 3600
    }

    /** @test */
    function it_sets_a_cookie_for_a_duration()
    {
        $cookie = new VanillaCookie();

        $testData = $cookie->store('CookieName', 'Cookie Value', 30);

        $this->assertEquals(1800, $testData['expire']); // 30 minutes: time() + 1800
    }

    /** @test */
    function it_sets_a_cookie_forever()
    {
        $cookie = new VanillaCookie();

        $testData = $cookie->forever('CookieName', 'Cookie Value');

        $this->assertEquals(60 * 60 * 24 * 365 * 5, $testData['expire']); // 5 years: time() + (60 * 60 * 24 * 365 * 5)
    }

    /** @test */
    function it_deletes_a_cookie()
    {
        $cookie = new VanillaCookie();
        $_COOKIE['CookieName'] = 'Cookie Value';

        $testData = $cookie->delete('CookieName');

        $this->assertNull($cookie->get('CookieName'));
        $this->assertEquals('CookieName', $testData['name']);
        $this->assertEquals('', $testData['value']);
        $this->assertEquals(-3600, $testData['expire']); // -60 minutes: time() - 3600
    }

    /** @test */
    function it_returns_null_if_you_delete_a_cookie_that_does_not_exist()
    {
        $cookie = new VanillaCookie();

        $testData = $cookie->delete('CookieName');

        $this->assertNull($testData);
    }

    /** @test */
    function it_encrypts_a_cookie()
    {
        $encrypter = new DefaultEncrypter('secret key');
        $cookie = new VanillaCookie($encrypter);

        $testData = $cookie->store('CookieName', 'Cookie Value');

        $this->assertEquals('CookieName', $testData['name']);
        $this->assertNotNull($testData['value']);
        $this->assertNotEquals('Cookie Value', $testData['value']);
    }

    /** @test */
    function it_decrypts_a_cookie()
    {
        $encrypter = new DefaultEncrypter('secret key');
        $cookie = new VanillaCookie($encrypter);

        $testData = $cookie->store('CookieName', 'Cookie Value');
        $_COOKIE['CookieName'] = $testData['value'];

        $cookieValue = $cookie->get('CookieName');

        $this->assertEquals('CookieName', $testData['name']);
        $this->assertEquals('Cookie Value', $cookieValue);
    }

    /** @test */
    public function it_throws_if_a_cookie_cannot_be_decrypted()
    {
        $encrypter = new DefaultEncrypter('secret key');
        $cookie = new VanillaCookie($encrypter);
        $_COOKIE['CookieName'] = 'invalid-value';

        $this->expectException(\CodeZero\Encrypter\DecryptException::class);

        $cookie->get('CookieName');
    }
}

namespace CodeZero\Cookie;

function setcookie($name, $value = "", $expire = 0, $path = "", $domain = "", $secure = false, $httpOnly = false) {
    return compact('name', 'value', 'expire', 'path', 'domain', 'secure', 'httpOnly');
}

function time() {
    return 0;
}
