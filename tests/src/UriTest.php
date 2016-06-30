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
 * @uses    GravityMedia\Uri\SchemeRegistry
 */
class UriTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test URI construction from malformed string throws exception.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The string argument appears to be malformed
     */
    public function testUriConstructionFromMalformedStringThrowsException()
    {
        Uri::fromString('//');
    }

    /**
     * Test URI construction from string.
     *
     * @dataProvider provideUriStrings()
     *
     * @param string $input
     * @param string $output
     * @param array  $expectations
     */
    public function testUriConstructionFromString($input, $output, array $expectations)
    {
        $uri = Uri::fromString($input);

        $this->assertSame($output, (string)$uri);
        $this->assertSame($expectations['scheme'], $uri->getScheme());
        $this->assertSame($expectations['authority'], $uri->getAuthority());
        $this->assertSame($expectations['user_info'], $uri->getUserInfo());
        $this->assertSame($expectations['host'], $uri->getHost());
        $this->assertSame($expectations['port'], $uri->getPort());
        $this->assertSame($expectations['path'], $uri->getPath());
        $this->assertSame($expectations['query'], $uri->getQuery());
        $this->assertSame($expectations['fragment'], $uri->getFragment());
    }

    /**
     * Provide URI strings.
     *
     * @return array
     */
    public function provideUriStrings()
    {
        return [
            [
                'urn:example:animal:ferret:nose',
                'urn:example:animal:ferret:nose',
                [
                    'scheme' => 'urn',
                    'authority' => '',
                    'user_info' => '',
                    'host' => '',
                    'port' => null,
                    'path' => 'example:animal:ferret:nose',
                    'query' => '',
                    'fragment' => ''
                ]
            ],
            [
                '/this/is/a/path/to/example.txt',
                '/this/is/a/path/to/example.txt',
                [
                    'scheme' => '',
                    'authority' => '',
                    'user_info' => '',
                    'host' => '',
                    'port' => null,
                    'path' => '/this/is/a/path/to/example.txt',
                    'query' => '',
                    'fragment' => ''
                ]
            ],
            [
                'http://www.example.com:80',
                'http://www.example.com',
                [
                    'scheme' => 'http',
                    'authority' => 'www.example.com',
                    'user_info' => '',
                    'host' => 'www.example.com',
                    'port' => null,
                    'path' => '',
                    'query' => '',
                    'fragment' => ''
                ]
            ],
            [
                'http://user:pass@example.com:8080/this/is/a/path?argument=value&array[0]=1#test_fragment',
                'http://user:pass@example.com:8080/this/is/a/path?argument=value&array%5B0%5D=1#test_fragment',
                [
                    'scheme' => 'http',
                    'authority' => 'user:pass@example.com:8080',
                    'user_info' => 'user:pass',
                    'host' => 'example.com',
                    'port' => 8080,
                    'path' => '/this/is/a/path',
                    'query' => 'argument=value&array%5B0%5D=1',
                    'fragment' => 'test_fragment'
                ]
            ]
        ];
    }
}
