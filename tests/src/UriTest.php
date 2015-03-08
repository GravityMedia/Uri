<?php
/**
 * This file is part of the Uri project
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\UriTest;

use GravityMedia\Uri\Uri;

/**
 * URI test
 *
 * @package GravityMedia\UriTest
 */
class UriTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test HTTP URI
     */
    public function testHttpUri()
    {
        $expected = 'http://user:pass@example.com:8080/this/is/a/test/path?argument=value&array%5B0%5D=1#test_fragment';
        $uri = Uri::fromString($expected);

        $this->assertEquals('http', $uri->getScheme());
        $this->assertEquals('user', $uri->getAuthority()->getUserinfo()->getUser());
        $this->assertEquals('pass', $uri->getAuthority()->getUserinfo()->getPass());
        $this->assertEquals('example.com', $uri->getAuthority()->getHost());
        $this->assertEquals(8080, $uri->getAuthority()->getPort());
        $this->assertEquals('/this/is/a/test/path', $uri->getPath());
        $this->assertEquals('argument=value&array%5B0%5D=1', strval($uri->getQuery()));
        $this->assertEquals('test_fragment', $uri->getFragment());
        $this->assertEquals($expected, strval($uri));
    }
}
