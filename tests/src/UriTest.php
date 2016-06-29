<?php
/**
 * This file is part of the Uri project.
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\UriTest;

use GravityMedia\Uri\Uri;

/**
 * URI test class.
 *
 * @package GravityMedia\UriTest
 *
 * @covers  GravityMedia\Uri\Uri
 */
class UriTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test URI construction without scheme from string.
     */
    public function testUriWithoutSchemeFromString()
    {
        $string = '/this/is/a/test/path/to/example.txt';
        $uri = Uri::fromString($string);

        $this->assertSame('', $uri->getScheme());
        $this->assertSame('', $uri->getAuthority());
        $this->assertSame('', $uri->getUserInfo());
        $this->assertSame('', $uri->getHost());
        $this->assertSame(null, $uri->getPort());
        $this->assertSame($string, $uri->getPath());
        $this->assertSame('', $uri->getQuery());
        $this->assertSame('', $uri->getFragment());
        $this->assertSame($string, $uri->toString());
    }

    /**
     * Test HTTP URI construction from string.
     */
    public function testHttpUriFromString()
    {
        $string = 'http://user:pass@example.com:8080/this/is/a/test/path?argument=value&array%5B0%5D=1#test_fragment';
        $uri = Uri::fromString($string);

        $this->assertSame('http', $uri->getScheme());
        $this->assertSame('user:pass@example.com:8080', $uri->getAuthority());
        $this->assertSame('user:pass', $uri->getUserInfo());
        $this->assertSame('example.com', $uri->getHost());
        $this->assertSame(8080, $uri->getPort());
        $this->assertSame('/this/is/a/test/path', $uri->getPath());
        $this->assertSame('argument=value&array%5B0%5D=1', $uri->getQuery());
        $this->assertSame('test_fragment', $uri->getFragment());
        $this->assertSame($string, $uri->toString());
    }
}
