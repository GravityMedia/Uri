<?php
/**
 * This file is part of the Uri project
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\UriTest;

use GravityMedia\Uri\Component\Authority;
use GravityMedia\Uri\Uri;

/**
 * URI test
 *
 * @package GravityMedia\UriTest
 */
class UriTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test file URI
     */
    public function testFileUri()
    {
        $expected = __DIR__ . '/this/is/a/test/path/to/example.txt';

        $uri = new Uri();
        $uri->setPath($expected);

        $this->assertEquals($expected, strval($uri));
    }

    /**
     * Test file URI from string
     */
    public function testFileUriFromString()
    {
        $expected = __DIR__ . '/this/is/a/test/path/to/example.txt';

        $uri = Uri::fromString($expected);

        $this->assertInstanceOf('GravityMedia\Uri\Component\Authority', $uri->getAuthority());
        $this->assertInstanceOf('GravityMedia\Uri\Component\Authority\Userinfo', $uri->getAuthority()->getUserinfo());
        $this->assertInstanceOf('GravityMedia\Uri\Component\Query', $uri->getQuery());

        $this->assertEquals(null, $uri->getScheme());
        $this->assertEquals(null, $uri->getAuthority()->getUserinfo()->getUser());
        $this->assertEquals(null, $uri->getAuthority()->getUserinfo()->getPass());
        $this->assertEquals(null, $uri->getAuthority()->getHost());
        $this->assertEquals(0, $uri->getAuthority()->getPort());
        $this->assertEquals($expected, $uri->getPath());
        $this->assertEquals(null, $uri->getQuery('no-existent-argument'));
        $this->assertEquals(null, $uri->getFragment());

        $this->assertEquals('', strval($uri->getAuthority()));
        $this->assertEquals('', strval($uri->getAuthority()->getUserinfo()));
        $this->assertEquals('', strval($uri->getQuery()));
        $this->assertEquals($expected, strval($uri));
    }

    /**
     * Test HTTP URI
     */
    public function testHttpUri()
    {
        $expected = 'http://user:pass@example.com:8080/this/is/a/test/path?argument=value&array%5B0%5D=1#test_fragment';

        $uri = new Uri();

        $query = $uri->getQuery();
        $query['argument'] = 'value';
        $query['array'] = array(1);

        $uri
            ->setScheme('http')
            ->setAuthority(new Authority(array(
                'user' => 'user',
                'pass' => 'pass',
                'host' => 'example.com',
                'port' => 8080
            )))
            ->setPath('/this/is/a/test/path')
            ->setFragment('test_fragment');

        $this->assertEquals($expected, strval($uri));
    }

    /**
     * Test HTTP URI from string
     */
    public function testHttpUriFromString()
    {
        $expected = 'http://user:pass@example.com:8080/this/is/a/test/path?argument=value&array%5B0%5D=1#test_fragment';

        $uri = Uri::fromString($expected);

        $this->assertInstanceOf('GravityMedia\Uri\Component\Authority', $uri->getAuthority());
        $this->assertInstanceOf('GravityMedia\Uri\Component\Authority\Userinfo', $uri->getAuthority()->getUserinfo());
        $this->assertInstanceOf('GravityMedia\Uri\Component\Query', $uri->getQuery());

        $this->assertEquals('http', $uri->getScheme());
        $this->assertEquals('user', $uri->getAuthority()->getUserinfo()->getUser());
        $this->assertEquals('pass', $uri->getAuthority()->getUserinfo()->getPass());
        $this->assertEquals('example.com', $uri->getAuthority()->getHost());
        $this->assertEquals(8080, $uri->getAuthority()->getPort());
        $this->assertEquals('/this/is/a/test/path', $uri->getPath());
        $this->assertEquals('value', $uri->getQuery('argument'));
        $this->assertEquals(null, $uri->getQuery('no-existent-argument'));
        $this->assertEquals('test_fragment', $uri->getFragment());

        $this->assertEquals('user:pass@example.com:8080', strval($uri->getAuthority()));
        $this->assertEquals('user:pass', strval($uri->getAuthority()->getUserinfo()));
        $this->assertEquals('argument=value&array%5B0%5D=1', strval($uri->getQuery()));
        $this->assertEquals($expected, strval($uri));
    }
}
