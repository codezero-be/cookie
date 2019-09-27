<?php

namespace CodeZero\Cookie\Laravel;

use CodeZero\Cookie\Cookie;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;

class LaravelCookie implements Cookie
{
    /**
     * Laravel's Request Class
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Laravel's CookieJar Class
     *
     * @var \Illuminate\Cookie\CookieJar
     */
    protected $cookie;

    /**
     * Create a new instance of LaravelCookie
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Cookie\CookieJar $cookie
     */
    public function __construct(Request $request, CookieJar $cookie)
    {
        $this->request = $request;
        $this->cookie = $cookie;
    }

    /**
     * Get the value of a cookie
     *
     * @param string $cookieName
     *
     * @return null|string
     */
    public function get($cookieName)
    {
        return $this->request->cookie($cookieName);
    }

    /**
     * Store a cookie
     *
     * @param string $cookieName
     * @param string $cookieValue
     * @param int $minutes
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httpOnly
     *
     * @return bool
     */
    public function store($cookieName, $cookieValue, $minutes = 60, $path = "/", $domain = null, $secure = true, $httpOnly = true)
    {
        $this->cookie->queue($cookieName, $cookieValue, $minutes);

        return true;
    }

    /**
     * Store a cookie for a long, long time
     *
     * @param string $cookieName
     * @param string $cookieValue
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httpOnly
     *
     * @return bool
     */
    public function forever($cookieName, $cookieValue, $path = '/', $domain = null, $secure = null, $httpOnly = true)
    {
        $cookie = $this->cookie->forever($cookieName, $cookieValue, 60 * 24 * 365 * 5, $path, $domain, $secure, $httpOnly);
        $this->cookie->queue($cookie);

        return true;
    }

    /**
     * Delete a cookie
     *
     * @param string $cookieName
     * @param string $path
     * @param string $domain
     *
     * @return null|bool
     */
    public function delete($cookieName, $path = '/', $domain = null)
    {
        $cookie = $this->cookie->forget($cookieName);
        $this->cookie->queue($cookie);

        return true;
    }

    /**
     * Check if a cookie exists
     *
     * @param string $cookieName
     *
     * @return bool
     */
    public function exists($cookieName)
    {
        return $this->get($cookieName) !== null;
    }
}
