<?php
/**
 * This file is part of the Uri package
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\Uri\Component\Authority;

/**
 * Userinfo component
 *
 * @package GravityMedia\Uri\Component\Authority
 */
class Userinfo
{
    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $pass;

    /**
     * Create userinfo
     *
     * @param array $userinfo
     */
    public function __construct(array $userinfo = array())
    {
        if (isset($userinfo['user'])) {
            $this->setUser($userinfo['user']);
        }

        if (isset($userinfo['pass'])) {
            $this->setPass($userinfo['pass']);
        }
    }

    /**
     * Create Userinfo from string
     *
     * @param string $string
     *
     * @return Userinfo
     */
    public static function fromString($string)
    {
        $parts = explode(':', $string, 2);

        $userinfo = array('user' => $parts[0]);

        if (2 === count($parts)) {
            $userinfo['pass'] = $parts[1];
        }

        return new static($userinfo);
    }

    /**
     * Return string representation
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Convert userinfo into a string representation
     *
     * @return string
     */
    public function toString()
    {
        $userinfo = $this->getUser();

        $credentials = $this->getPass();
        if (null !== $credentials) {
            $userinfo .= ':' . $credentials;
        }

        return $userinfo;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get pass
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set pass
     *
     * @param string $pass
     *
     * @return string
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
        return $this;
    }
}
