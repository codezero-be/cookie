<?php

namespace CodeZero\Cookie;

interface Cookie
{
    /**
     * Get the value of a cookie
     *
     * @param string $cookieName
     *
     * @return null|string
     * @throws \CodeZero\Encrypter\DecryptException
     */
    public function get($cookieName);

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
    public function store($cookieName, $cookieValue, $minutes = 60, $path = "/", $domain = null, $secure = true, $httpOnly = true);

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
    public function forever($cookieName, $cookieValue, $path = '/', $domain = null, $secure = null, $httpOnly = true);

    /**
     * Delete a cookie
     *
     * @param string $cookieName
     * @param string $path
     * @param string $domain
     *
     * @return null|bool
     */
    public function delete($cookieName, $path = '/', $domain = null);

    /**
     * Check if a cookie exists
     *
     * @param string $cookieName
     *
     * @return bool
     */
    public function exists($cookieName);
}
