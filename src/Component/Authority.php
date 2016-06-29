<?php
/**
 * This file is part of the Uri package.
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\Uri\Component;

/**
 * Authority component class.
 *
 * @package GravityMedia\Uri\Component
 */
class Authority
{
    /**
     * The user info
     *
     * @var null|UserInfo
     */
    public $userInfo;

    /**
     * The host
     *
     * @var null|string
     */
    public $host;

    /**
     * The port
     *
     * @var null|int
     */
    public $port;

    /**
     * Create authority from array.
     *
     * @param array $array
     *
     * @return Authority
     * @throws \InvalidArgumentException
     */
    public static function fromArray(array $array = [])
    {
        $authority = new static();

        if (!isset($array['host'])) {
            return $authority;
        }

        try {
            $authority = $authority->withHost($array['host']);
            if (isset($array['user'])) {
                $userInfo = UserInfo::fromArray($array)->toString();
                $authority = $authority->withUserInfo($userInfo);
            }
            if (isset($array['port'])) {
                $authority = $authority->withPort($array['port']);
            }
        } catch (\InvalidArgumentException $exception) {
            throw new \InvalidArgumentException('Invalid array argument', 0, $exception);
        }

        return $authority;
    }

    /**
     * Create authority from string
     *
     * @param string $string
     *
     * @return Authority
     * @throws \InvalidArgumentException
     */
    public static function fromString($string)
    {
        if (strlen($string) > 0 && false === strpos($string, '//')) {
            $string = '//' . $string;
        }

        $array = parse_url($string);
        if (false === $array) {
            throw new \InvalidArgumentException('The string argument appears to be malformed');
        }

        return static::fromArray($array);
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
        $authority = $this->host;
        if (null === $authority) {
            return '';
        }

        if (null !== $this->userInfo) {
            $authority = $this->userInfo . '@' . $authority;
        }

        if (null !== $this->port) {
            $authority .= ':' . $this->port;
        }

        return $authority;
    }

    /**
     * Get user info.
     *
     * If no user info is present, an empty string will be returned.
     *
     * @return string
     */
    public function getUserInfo()
    {
        if (null === $this->userInfo) {
            return '';
        }

        return $this->userInfo->toString();
    }

    /**
     * Return an instance with the specified user info.
     *
     * @param null|string $userInfo
     *
     * @return Authority
     */
    public function withUserInfo($userInfo)
    {
        if (null !== $userInfo) {
            if (!is_string($userInfo)) {
                throw new \InvalidArgumentException('Invalid user info argument');
            }

            $userInfo = UserInfo::fromString($userInfo);
        }

        $authority = clone $this;
        $authority->userInfo = $userInfo;

        return $authority;
    }

    /**
     * Get host.
     *
     * If no host is present, an empty string will be returned.
     *
     * @return string
     */
    public function getHost()
    {
        if (null === $this->host) {
            return '';
        }

        return $this->host;
    }

    /**
     * Return an instance with the specified host.
     *
     * @param string $host
     *
     * @return Authority
     * @throws \InvalidArgumentException
     */
    public function withHost($host)
    {
        if (!is_string($host)) {
            throw new \InvalidArgumentException('Invalid host argument');
        }

        $authority = clone $this;
        $authority->host = $host;

        return $authority;
    }

    /**
     * Get port.
     *
     * @return null|int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Return an instance with the specified port.
     *
     * @param null|int $port
     *
     * @return Authority
     * @throws \InvalidArgumentException
     */
    public function withPort($port)
    {
        if (null !== $port) {
            if (!is_numeric($port)) {
                throw new \InvalidArgumentException('Invalid port argument');
            }

            $port = (int)$port;
        }

        $authority = clone $this;
        $authority->port = $port;

        return $authority;
    }
}
