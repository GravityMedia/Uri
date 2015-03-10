<?php
/**
 * This file is part of the Uri package
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\Uri\Component;

use GravityMedia\Uri\Component\Authority\Userinfo;

/**
 * Authority component
 *
 * @package GravityMedia\Uri\Component
 */
class Authority
{
    /**
     * @var int
     */
    public static $defaultPort = 0;

    /**
     * @var Userinfo
     */
    public $userinfo;

    /**
     * @var string
     */
    public $host;

    /**
     * @var int
     */
    public $port;

    /**
     * Create authority
     *
     * @param array $authority
     */
    public function __construct(array $authority = array())
    {
        if (isset($authority['user'])) {
            $this->setUserinfo(new Userinfo($authority));
        }

        if (isset($authority['host'])) {
            $this->setHost($authority['host']);
        }

        if (isset($authority['port'])) {
            $this->setPort($authority['port']);
        }
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
     * Convert authority into a string representation
     *
     * @return string
     */
    public function toString()
    {
        $authority = $this->getUserinfo();
        if (null === $authority->getUser()) {
            $authority = '';
        } else {
            $authority .= '@';
        }

        $host = $this->getHost();
        if (null !== $host) {
            $authority .= $host;
        }

        $port = $this->getPort();
        if ($port > 0) {
            $authority .= ':' . $port;
        }

        return $authority;
    }

    /**
     * Get userinfo
     *
     * @return Userinfo
     */
    public function getUserinfo()
    {
        if (null === $this->userinfo) {
            $this->userinfo = new Userinfo();
        }
        return $this->userinfo;
    }

    /**
     * Set userinfo
     *
     * @param Userinfo $userinfo
     *
     * @return $this
     */
    public function setUserinfo(Userinfo $userinfo)
    {
        $this->userinfo = $userinfo;
        return $this;
    }

    /**
     * Get host
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set host
     *
     * @param string $host
     *
     * @return $this
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * Get port
     *
     * @return int
     */
    public function getPort()
    {
        if (null === $this->port) {
            return static::$defaultPort;
        }
        return $this->port;
    }

    /**
     * Set port
     *
     * @param int $port
     *
     * @return $this
     */
    public function setPort($port)
    {
        $this->port = intval($port);
        return $this;
    }
}
