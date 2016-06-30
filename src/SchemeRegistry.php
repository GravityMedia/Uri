<?php
/**
 * This file is part of the Uri package.
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\Uri;

/**
 * Scheme registry class.
 *
 * @package GravityMedia\Uri
 */
class SchemeRegistry
{
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
     * Register schemes.
     *
     * @param array $schemes
     *
     * @throws \InvalidArgumentException
     */
    public static function registerSchemes(array $schemes)
    {
        foreach ($schemes as $scheme => $port) {
            static::registerScheme($scheme, $port);
        }
    }

    /**
     * Return whether or not the scheme is registered.
     *
     * @param string $scheme
     *
     * @return bool
     * @throws \InvalidArgumentException
     */
    public static function isSchemeRegistered($scheme)
    {
        if (!is_string($scheme)) {
            throw new \InvalidArgumentException('Invalid scheme argument');
        }

        return isset(static::$schemes[strtolower($scheme)]);
    }

    /**
     * Return whether or not the port is the standard port of the scheme.
     *
     * @param string     $scheme
     * @param int|string $port
     *
     * @return bool
     * @throws \InvalidArgumentException
     */
    public static function isStandardPort($scheme, $port)
    {
        if (!static::isSchemeRegistered($scheme)) {
            throw new \InvalidArgumentException('Scheme is not registered');
        }

        if (!is_numeric($port)) {
            return false;
        }

        return (int)$port === static::$schemes[strtolower($scheme)];
    }
}
