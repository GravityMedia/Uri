<?php
/**
 * This file is part of the Uri package.
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\Uri;

use Psr\Http\Message\UriInterface;

/**
 * URI class.
 *
 * @package GravityMedia\Uri
 */
class Uri implements UriInterface
{
    /**
     * The registered schemes.
     *
     * @var array
     */
    protected static $registeredSchemes = [
        'http' => 80,
        'https' => 443,
    ];

    /**
     * The scheme.
     *
     * @var null|string
     */
    protected $scheme;

    /**
     * The user info.
     *
     * @var null|string
     */
    public $userInfo;

    /**
     * The host.
     *
     * @var null|string
     */
    public $host;

    /**
     * The port.
     *
     * @var null|int
     */
    public $port;

    /**
     * The path.
     *
     * @var string
     */
    protected $path;

    /**
     * The query.
     *
     * @var null|string
     */
    protected $query;

    /**
     * The fragment.
     *
     * @var null|string
     */
    protected $fragment;

    /**
     * Create URI from array.
     *
     * @param array $array
     *
     * @return Uri
     * @throws \InvalidArgumentException
     */
    public static function fromArray(array $array = [])
    {
        $uri = new static();

        if (isset($array['scheme'])) {
            $uri = $uri->withScheme($array['scheme']);
        }

        if (isset($array['user'])) {
            if (isset($array['pass'])) {
                $uri = $uri->withUserInfo($array['user'], $array['pass']);
            } else {
                $uri = $uri->withUserInfo($array['user']);
            }
        }

        if (isset($array['host'])) {
            $uri = $uri->withHost($array['host']);
        }

        if (isset($array['port'])) {
            $uri = $uri->withPort($array['port']);
        }

        if (isset($array['path'])) {
            $uri = $uri->withPath($array['path']);
        }

        if (isset($array['query'])) {
            $uri = $uri->withQuery($array['query']);
        }

        if (isset($array['fragment'])) {
            $uri = $uri->withFragment($array['fragment']);
        }

        return $uri;
    }

    /**
     * Create URI from string.
     *
     * @param string $string
     *
     * @return Uri
     * @throws \InvalidArgumentException
     */
    public static function fromString($string)
    {
        $array = parse_url($string);
        if (false === $array) {
            throw new \InvalidArgumentException('The string argument appears to be malformed');
        }

        return static::fromArray($array);
    }

    /**
     * Register port.
     *
     * @param string     $scheme
     * @param int|string $port
     *
     * @throws \InvalidArgumentException
     */
    public static function registerPort($scheme, $port)
    {
        if (!is_string($scheme)) {
            throw new \InvalidArgumentException('Invalid scheme argument');
        }

        if (!is_numeric($port)) {
            throw new \InvalidArgumentException('Invalid port argument');
        }

        static::$registeredSchemes[strtolower($scheme)] = (int)$port;
    }

    /**
     * Returns whether the port is the non-standard port for the scheme provided.
     *
     * @param string     $scheme
     * @param int|string $port
     *
     * @return bool
     */
    public static function isNonStandardPort($scheme, $port)
    {
        if (!is_string($scheme)) {
            return true;
        }

        $scheme = strtolower($scheme);
        if (!isset(static::$registeredSchemes[$scheme])) {
            return true;
        }

        if (!is_numeric($port)) {
            return false;
        }

        $port = (int)$port;
        return $port !== static::$registeredSchemes[$scheme];
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
     * Convert URI into a string representation
     *
     * @return string
     */
    public function toString()
    {
        $uri = '';

        if (null !== $this->scheme) {
            $uri .= strtolower($this->scheme) . '://';
        }

        $uri .= $this->getAuthority();

        if (null !== $this->path) {
            if (0 == strlen($this->path) || '/' !== substr($this->path, 0, 1)) {
                $uri .= '/';
            }

            $uri .= $this->path;
        }

        if (null !== $this->query) {
            $uri .= '?' . $this->query;
        }

        if (null !== $this->fragment) {
            $uri .= '#' . $this->fragment;
        }

        return $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function getScheme()
    {
        if (null === $this->scheme) {
            return '';
        }

        return strtolower($this->scheme);
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthority()
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
     * {@inheritdoc}
     */
    public function getUserInfo()
    {
        if (null === $this->userInfo) {
            return '';
        }

        return $this->userInfo;
    }

    /**
     * {@inheritdoc}
     */
    public function getHost()
    {
        if (null === $this->host) {
            return '';
        }

        return $this->host;
    }

    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        if (!static::isNonStandardPort($this->scheme, $this->port)) {
            return null;
        }

        return $this->port;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        if (null === $this->path) {
            return '';
        }

        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        if (null === $this->query) {
            return '';
        }

        return $this->query;
    }

    /**
     * {@inheritdoc}
     */
    public function getFragment()
    {
        if (null === $this->fragment) {
            return '';
        }

        return $this->fragment;
    }

    /**
     * {@inheritdoc}
     */
    public function withScheme($scheme)
    {
        if (!is_string($scheme)) {
            throw new \InvalidArgumentException('Invalid scheme argument');
        }

        $uri = clone $this;
        $uri->scheme = $scheme;

        return $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function withUserInfo($user, $password = null)
    {
        if (!is_string($user)) {
            throw new \InvalidArgumentException('Invalid user argument');
        }

        if (null !== $password && !is_string($password)) {
            throw new \InvalidArgumentException('Invalid password argument');
        }

        $userInfo = $user;
        if (null !== $password) {
            $userInfo .= ':' . $password;
        }

        $uri = clone $this;
        $uri->userInfo = $userInfo;

        return $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function withHost($host)
    {
        if (!is_string($host)) {
            throw new \InvalidArgumentException('Invalid host argument');
        }

        $uri = clone $this;
        $uri->host = $host;

        return $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function withPort($port)
    {
        if (null !== $port) {
            if (!is_numeric($port)) {
                throw new \InvalidArgumentException('Invalid port argument');
            }

            $port = (int)$port;
        }

        $uri = clone $this;
        $uri->port = $port;

        return $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function withPath($path)
    {
        if (!is_string($path)) {
            throw new \InvalidArgumentException('Invalid path argument');
        }

        $uri = clone $this;
        $uri->path = $path;

        return $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function withQuery($query)
    {
        if (!is_string($query)) {
            throw new \InvalidArgumentException('Invalid query argument');
        }

        $uri = clone $this;
        $uri->query = $query;

        return $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function withFragment($fragment)
    {
        if (!is_string($fragment)) {
            throw new \InvalidArgumentException('Invalid fragment argument');
        }

        $uri = clone $this;
        $uri->fragment = $fragment;

        return $uri;
    }
}
