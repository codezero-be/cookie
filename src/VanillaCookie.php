<?php

namespace CodeZero\Cookie;

use CodeZero\Encrypter\Encrypter;

class VanillaCookie implements Cookie
{
    /**
     * Encrypter
     *
     * @var \CodeZero\Encrypter\Encrypter
     */
    protected $encrypter;

    /**
     * Create a new instance of VanillaCookie
     *
     * @param \CodeZero\Encrypter\Encrypter $encrypter
     */
    public function __construct(Encrypter $encrypter = null)
    {
        $this->encrypter = $encrypter;
    }

    /**
     * Get the value of a cookie
     *
     * @param string $cookieName
     *
     * @return null|string
     * @throws \CodeZero\Encrypter\DecryptException
     */
    public function get($cookieName)
    {
        if ( ! $this->exists($cookieName)) {
            return null;
        }

        return $this->decrypt($_COOKIE[$cookieName]);
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
        return setcookie(
            $cookieName,
            $this->encrypt($cookieValue),
            $this->calculateExpirationTime($minutes),
            $path,
            $domain,
            $secure,
            $httpOnly
        );
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
        return $this->store($cookieName, $cookieValue, 60 * 24 * 365 * 5, $path, $domain, $secure, $httpOnly);
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
        if ( ! $this->exists($cookieName)) {
            return null;
        }

        unset($_COOKIE[$cookieName]);

        return $this->store($cookieName, '', -60, $path, $domain);
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
        return isset($_COOKIE[$cookieName]);
    }

    /**
     * Calculate the expiration time
     *
     * @param int $minutes
     *
     * @return int
     */
    protected function calculateExpirationTime($minutes)
    {
        return time() + (60 * $minutes);
    }

    /**
     * Encrypt a cookie
     *
     * @param string $cookieValue
     *
     * @return string
     */
    protected function encrypt($cookieValue)
    {
        if ($this->encrypter) {
            return $this->encrypter->encrypt($cookieValue);
        }

        return $cookieValue;
    }

    /**
     * Decrypt a cookie
     *
     * @param string $cookieValue
     *
     * @return string
     * @throws \CodeZero\Encrypter\DecryptException
     */
    protected function decrypt($cookieValue)
    {
        if ($this->encrypter && ! empty($cookieValue)) {
            return $this->encrypter->decrypt($cookieValue);
        }

        return $cookieValue;
    }
}
