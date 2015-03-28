<?php namespace CodeZero\Cookie; 

class VanillaCookieCore implements CookieCore
{
    /**
     * Get the value of a cookie
     *
     * @param string $name
     *
     * @return null|string
     */
    public function get($name)
    {
        if ( ! isset($_COOKIE[$name])) {
            return null;
        }

        return $_COOKIE[$name];
    }

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
    public function set($name, $value, $expire, $path = null, $domain = null, $secure = null, $httponly = null)
    {
        return setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }

    /**
     * Delete a cookie
     *
     * @param string $name
     *
     * @return bool
     */
    public function delete($name)
    {
        if (isset($_COOKIE[$name])) {
            unset($_COOKIE[$name]);

            return $this->set($name, null, -1);
        }

        return true;
    }
}
