<?php namespace CodeZero\Cookie;

interface Cookie
{
    /**
     * Get the value of a cookie
     *
     * @param string $cookieName
     *
     * @return null|string
     */
    public function get($cookieName);

    /**
     * Store a cookie
     *
     * @param string $cookieName
     * @param string $cookieValue
     * @param int $minutes
     *
     * @return bool
     */
    public function store($cookieName, $cookieValue, $minutes = 60);

    /**
     * Store a cookie for a long, long time
     *
     * @param string $cookieName
     * @param string $cookieValue
     *
     * @return bool
     */
    public function forever($cookieName, $cookieValue);

    /**
     * Delete a cookie
     *
     * @param string $cookieName
     *
     * @return bool
     */
    public function delete($cookieName);
}
