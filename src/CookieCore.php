<?php namespace CodeZero\Cookie;

interface CookieCore
{
    /**
     * Get the value of a cookie
     *
     * @param string $name
     *
     * @return null|string
     */
    public function get($name);

    /**
     * Set a cookie
     *
     * @param string $name
     * @param string $value
     * @param int $expire
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httponly
     *
     * @return bool
     */
    public function set($name, $value, $expire, $path = null, $domain = null, $secure = null, $httponly = null);

    /**
     * Delete a cookie
     *
     * @param string $name
     *
     * @return bool
     */
    public function delete($name);
}
