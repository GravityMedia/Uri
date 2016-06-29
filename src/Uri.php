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
     * Unreserved characters used in paths, query strings, and fragments.
     *
     * @const string
     */
    const CHAR_UNRESERVED = 'a-zA-Z0-9_\-\.~';

    /**
     * Sub-delimiters used in query strings and fragments.
     *
     * @const string
     */
    const CHAR_SUB_DELIMS = '!\$&\'\(\)\*\+,;=';

    /**
     * Pattern for path filtering.
     *
     * @const string
     */
    const PATTERN_PATH_FILTER = '/(?:[^' . self::CHAR_UNRESERVED . self::CHAR_SUB_DELIMS
    . '%:@\/]++|%(?![A-Fa-f0-9]{2}))/';

    /**
     * Pattern for query or fragment filtering.
     *
     * @const string
     */
    const PATTERN_QUERY_OR_FRAGMENT_FILTER = '/(?:[^' . self::CHAR_UNRESERVED . self::CHAR_SUB_DELIMS
    . '%:@\/\?]++|%(?![A-Fa-f0-9]{2}))/';

    /**
     * The schemes.
     *
     * @var array
     */
    protected static $schemes = [
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
    protected $userInfo;

    /**
     * The host.
     *
     * @var null|string
     */
    protected $host;

    /**
     * The port.
     *
     * @var null|int
     */
    protected $port;

    /**
     * The path.
     *
     * @var null|string
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
     * Create URI object from array.
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
            $password = null;
            if (isset($array['pass'])) {
                $password = $array['pass'];
            }

            $uri = $uri->withUserInfo($array['user'], $password);
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
     * Create URI object from string.
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
     * Register scheme.
     *
     * @param string     $scheme
     * @param int|string $port
     *
     * @throws \InvalidArgumentException
     */
    public static function registerScheme($scheme, $port)
    {
        if (!is_string($scheme)) {
            throw new \InvalidArgumentException('Invalid scheme argument');
        }

        if (!is_numeric($port)) {
            throw new \InvalidArgumentException('Invalid port argument');
        }

        static::$schemes[strtolower($scheme)] = (int)$port;
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
        $authority = $this->getHost();
        if (0 === strlen($authority)) {
            return '';
        }

        $userInfo = $this->getUserInfo();
        if (strlen($userInfo) > 0) {
            $authority = $userInfo . '@' . $authority;
        }

        $port = $this->getPort();
        if (is_int($port)) {
            $authority .= ':' . $port;
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

        return strtolower($this->host);
    }

    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        $scheme = $this->getScheme();
        if (0 === strlen($scheme) && null === $this->port) {
            return null;
        }

        if (!isset(static::$schemes[$scheme]) || static::$schemes[$scheme] === $this->port) {
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

        return $this->filterPathValue($this->path);
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        if (null === $this->query) {
            return '';
        }

        return $this->filterQueryOrFragmentValue($this->query);
    }

    /**
     * {@inheritdoc}
     */
    public function getFragment()
    {
        if (null === $this->fragment) {
            return '';
        }

        return $this->filterQueryOrFragmentValue($this->fragment);
    }

    /**
     * Filter path value.
     *
     * @param string $value
     *
     * @return string
     */
    protected function filterPathValue($value)
    {
        return preg_replace_callback(static::PATTERN_PATH_FILTER, [$this, 'urlEncodeFirstMatch'], $value);
    }

    /**
     * Filter query or fragment value.
     *
     * @param string $value
     *
     * @return string
     */
    protected function filterQueryOrFragmentValue($value)
    {
        return preg_replace_callback(static::PATTERN_QUERY_OR_FRAGMENT_FILTER, [$this, 'urlEncodeFirstMatch'], $value);
    }

    /**
     * URL encode a the first match returned by a regex.
     *
     * @param array $matches
     *
     * @return string
     */
    protected function urlEncodeFirstMatch(array $matches)
    {
        return rawurlencode($matches[0]);
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

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Convert URI into a string representation.
     *
     * @return string
     */
    public function toString()
    {
        $uri = $this->getScheme();
        if (strlen($uri) > 0) {
            $uri .= ':';
        }

        $authority = $this->getAuthority();
        if (strlen($authority) > 0) {
            $uri .= '//' . $authority;
        }

        $path = $this->getPath();
        if (strlen($path) > 0) {
            $uri .= '/' . ltrim($this->path, '/');
        }

        $query = $this->getQuery();
        if (strlen($query) > 0) {
            $uri .= '?' . $query;
        }

        $fragment = $this->getFragment();
        if (strlen($fragment) > 0) {
            $uri .= '#' . $fragment;
        }

        return $uri;
    }
}
