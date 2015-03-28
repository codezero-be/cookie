<?php namespace CodeZero\Cookie;

use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;

class LaravelCookie implements Cookie
{
    /**
     * Laravel's Request Class
     *
     * @var Request
     */
    private $request;

    /**
     * Laravel's CookieJar Class
     *
     * @var CookieJar
     */
    private $cookie;

    /**
     * Create a new instance of LaravelCookie
     *
     * @param Request $request
     * @param CookieJar $cookie
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
     *
     * @return bool
     */
    public function store($cookieName, $cookieValue, $minutes = 60)
    {
        $this->cookie->queue($cookieName, $cookieValue, $minutes);

        return true;
    }

    /**
     * Store a cookie for a long, long time
     *
     * @param string $cookieName
     * @param string $cookieValue
     *
     * @return bool
     */
    public function forever($cookieName, $cookieValue)
    {
        return $this->store($cookieName, $cookieValue, 60 * 24 * 365 * 5); // 5 years
    }

    /**
     * Delete a cookie
     *
     * @param string $cookieName
     *
     * @return bool
     */
    public function delete($cookieName)
    {
        $cookie = $this->cookie->forget($cookieName);
        $this->cookie->queue($cookie);

        return true;
    }
}
