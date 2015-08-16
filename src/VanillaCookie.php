<?php namespace CodeZero\Cookie;

use CodeZero\Encrypter\Encrypter;

class VanillaCookie implements Cookie
{
    /**
     * Encrypter
     *
     * @var Encrypter
     */
    private $encrypter;

    /**
     * Cookie Core
     *
     * @var CookieCore
     */
    private $cookie;

    /**
     * Create a new instance of VanillaCookie
     *
     * @param Encrypter $encrypter
     * @param CookieCore $cookie
     */
    public function __construct(Encrypter $encrypter = null, CookieCore $cookie = null)
    {
        $this->encrypter = $encrypter;
        $this->cookie = $cookie ?: new VanillaCookieCore();
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
        $cookieValue = $this->cookie->get($cookieName);

        return $this->decrypt($cookieValue);
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
     * @param bool $httponly
     *
     * @return bool
     */
    public function store($cookieName, $cookieValue, $minutes = 60, $path = "/", $domain = null, $secure = true, $httponly = true)
    {
        return $this->cookie->set(
            $cookieName,
            $this->encrypt($cookieValue),
            $this->calculateExpirationTime($minutes),
            $path,
            $domain,
            $secure,
            $httponly
        );
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
        return $this->store($cookieName, $cookieValue, 525600 * 5); // 525600 minutes = 1 year
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
        return $this->cookie->delete($cookieName);
    }

    /**
     * Calculate the expiration time
     *
     * @param int $minutes
     *
     * @return int
     */
    private function calculateExpirationTime($minutes)
    {
        return ($minutes > 0)
            ? time() + (60 * $minutes)
            : -1;
    }

    /**
     * Encrypt a cookie
     *
     * @param string $cookieValue
     *
     * @return string
     */
    private function encrypt($cookieValue)
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
     */
    private function decrypt($cookieValue)
    {
        if ($this->encrypter && ! empty($cookieValue)) {
            return $this->encrypter->decrypt($cookieValue);
        }

        return $cookieValue;
    }
}
