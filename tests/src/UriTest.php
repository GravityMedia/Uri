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
 * @uses    GravityMedia\Uri\Component\Authority
 * @uses    GravityMedia\Uri\Component\Query
 * @uses    GravityMedia\Uri\Component\UserInfo
 */
class UriTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test file URI from string.
     */
    public function testFileUriFromString()
    {
        $expected = '/this/is/a/test/path/to/example.txt';

        $uri = Uri::fromString($expected);

        $this->assertEquals(null, $uri->getScheme());
        $this->assertEquals('', $uri->getAuthority());
        $this->assertEquals($expected, $uri->getPath());
        $this->assertEquals(null, $uri->getFragment());
        $this->assertEquals($expected, $uri->toString());
    }

    /**
     * Test HTTP URI from string.
     */
    public function testHttpUriFromString()
    {
        $expected = 'http://user:pass@example.com:8080/this/is/a/test/path?argument=value&array%5B0%5D=1#test_fragment';

        $uri = Uri::fromString($expected);

        $this->assertEquals('http', $uri->getScheme());
        $this->assertEquals('user:pass@example.com:8080', $uri->getAuthority());
        $this->assertEquals('/this/is/a/test/path', $uri->getPath());
        $this->assertEquals('argument=value&array%5B0%5D=1', $uri->getQuery());
        $this->assertEquals('test_fragment', $uri->getFragment());
        $this->assertEquals($expected, $uri->toString());
    }
}
