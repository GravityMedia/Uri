<?php
/**
 * This file is part of the Uri project.
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\UriTest\Component;

use GravityMedia\Uri\Component\Authority;

/**
 * Authority component test class.
 *
 * @package GravityMedia\UriTest\Component
 *
 * @covers  GravityMedia\Uri\Component\Authority
 * @uses    GravityMedia\Uri\Component\UserInfo
 */
class AuthorityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test authority construction from array.
     *
     * @dataProvider provideConstructorArrayArguments()
     *
     * @param array    $input
     * @param string   $userInfo
     * @param string   $host
     * @param null|int $port
     * @param string   $output
     */
    public function testUserInfoConstructionFromArray($input, $userInfo, $host, $port, $output)
    {
        $authority = Authority::fromArray($input);

        $this->assertSame($userInfo, $authority->getUserInfo());
        $this->assertSame($host, $authority->getHost());
        $this->assertSame($port, $authority->getPort());
        $this->assertSame($output, $authority->toString());
        $this->assertSame($output, $authority->__toString());
    }

    /**
     * Provide constructor array arguments.
     *
     * @return array
     */
    public function provideConstructorArrayArguments()
    {
        return [
            [[], '', '', null, ''],
            [['host' => 'example.com'], '', 'example.com', null, 'example.com'],
            [['user' => 'username', 'host' => 'example.com'], 'username', 'example.com', null, 'username@example.com'],
            [['pass' => 'password', 'host' => 'example.com'], '', 'example.com', null, 'example.com'],
            [
                ['user' => 'username', 'pass' => 'password', 'host' => 'example.com'],
                'username:password',
                'example.com',
                null,
                'username:password@example.com'
            ],
            [
                ['user' => 'username', 'pass' => 'password', 'host' => 'example.com', 'port' => '80'],
                'username:password',
                'example.com',
                80,
                'username:password@example.com:80'
            ]
        ];
    }

    /**
     * Test authority construction from array throws exception.
     *
     * @dataProvider             provideInvalidConstructorArrayArguments()
     *
     * @param array $input
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid array argument
     */
    public function testUserInfoConstructionFromArrayThrowsException($input)
    {
        Authority::fromArray($input);
    }

    /**
     * Provide invalid constructor array arguments.
     *
     * @return array
     */
    public function provideInvalidConstructorArrayArguments()
    {
        return [
            [['host' => false]],
            [['host' => 'example.com', 'user' => false]],
            [['host' => 'example.com', 'port' => false]]
        ];
    }

    /**
     * Test authority construction from string.
     *
     * @dataProvider provideConstructorStringArguments()
     *
     * @param string   $input
     * @param string   $userInfo
     * @param string   $host
     * @param null|int $port
     * @param string   $output
     */
    public function testUserInfoConstructionFromString($input, $userInfo, $host, $port, $output)
    {
        $authority = Authority::fromString($input);

        $this->assertSame($userInfo, $authority->getUserInfo());
        $this->assertSame($host, $authority->getHost());
        $this->assertSame($port, $authority->getPort());
        $this->assertSame($output, $authority->toString());
        $this->assertSame($output, $authority->__toString());
    }

    /**
     * Provide constructor string arguments.
     *
     * @return string
     */
    public function provideConstructorStringArguments()
    {
        return [
            ['', '', '', null, ''],
            ['example.com', '', 'example.com', null, 'example.com'],
            ['username@example.com', 'username', 'example.com', null, 'username@example.com'],
            [
                'username:password@example.com',
                'username:password',
                'example.com',
                null,
                'username:password@example.com'
            ],
            [
                'username:password@example.com:80',
                'username:password',
                'example.com',
                80,
                'username:password@example.com:80'
            ]
        ];
    }
}
