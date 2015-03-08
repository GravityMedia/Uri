<?php
/**
 * This file is part of the Uri package
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\Uri;

use GravityMedia\Uri\Component\Authority;
use GravityMedia\Uri\Component\Query;

/**
 * URI
 *
 * @package GravityMedia\Uri
 */
class Uri
{
    /**
     * @var string
     */
    public static $defaultScheme = 'file';

    /**
     * @var string
     */
    protected $scheme;

    /**
     * @var Authority
     */
    protected $authority;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var Query
     */
    protected $query;

    /**
     * @var string
     */
    protected $fragment;

    /**
     * Create URI
     *
     * @param array $uri
     */
    public function __construct(array $uri = array())
    {
        if (isset($uri['scheme'])) {
            $this->setScheme($uri['scheme']);
        }

        if (isset($uri['host'])) {
            $this->setAuthority(new Authority($uri));
        }

        if (isset($uri['path'])) {
            $this->setPath($uri['path']);
        }

        if (isset($uri['query'])) {
            $this->setQuery($uri['query']);
        }

        if (isset($uri['fragment'])) {
            $this->setFragment($uri['fragment']);
        }
    }

    /**
     * Create URI from string
     *
     * @param string $string
     *
     * @return Uri
     */
    public static function fromString($string)
    {
        return new static(parse_url($string));
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
        $uri = $this->getScheme();
        if (null === $uri) {
            $uri = '';
        } else {
            $uri .= '://';
        }

        $authority = $this->getAuthority();
        if (null !== $authority->getHost()) {
            $uri .= $authority;
        }

        $path = $this->getPath();
        if (null !== $path) {
            $uri .= $path;
        }

        $query = $this->getQuery();
        if (count($query) > 0) {
            $uri .= '?' . $query;
        }

        $fragment = $this->getFragment();
        if (null !== $fragment) {
            $uri .= '#' . $fragment;
        }

        return $uri;
    }

    /**
     * Return true if scheme is supported
     *
     * @return bool
     */
    public function isSchemeSupported()
    {
        return in_array($this->getScheme(), stream_get_wrappers());
    }

    /**
     * Get scheme
     *
     * @return string
     */
    public function getScheme()
    {
        if (null === $this->scheme) {
            return static::$defaultScheme;
        }
        return $this->scheme;
    }

    /**
     * Set scheme
     *
     * @param string $scheme
     *
     * @return $this
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;
        return $this;
    }

    /**
     * Get authority
     *
     * @return Authority
     */
    public function getAuthority()
    {
        if (null === $this->authority) {
            $this->authority = new Authority();
        }
        return $this->authority;
    }

    /**
     * Set authority
     *
     * @param Authority $authority
     *
     * @return $this
     */
    public function setAuthority(Authority $authority)
    {
        $this->authority = $authority;
        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Get query
     *
     * @param mixed $name
     *
     * @return string
     */
    public function getQuery($name = null)
    {
        if (null === $this->query) {
            $this->query = new Query();
        }
        if (null === $name) {
            return $this->query;
        }
        return $this->query[$name];
    }

    /**
     * Set query
     *
     * @param string|array|\Traversable|Query $query
     *
     * @return $this
     */
    public function setQuery($query)
    {
        if (!$query instanceof Query) {
            $query = new Query($query);
        }
        $this->query = $query;
        return $this;
    }

    /**
     * Get fragment
     *
     * @return string
     *
     * @return $this
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * Get fragment
     *
     * @param string $fragment
     *
     * @return $this
     */
    public function setFragment($fragment)
    {
        $this->fragment = $fragment;
    }
}
