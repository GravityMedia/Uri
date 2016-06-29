<?php
/**
 * This file is part of the Uri project.
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\UriTest\Component;

use GravityMedia\Uri\Component\UserInfo;

/**
 * User info component test class.
 *
 * @package GravityMedia\UriTest\Component
 *
 * @covers  GravityMedia\Uri\Component\UserInfo
 */
class UserInfoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test user info construction from array.
     *
     * @dataProvider provideConstructorArrayArguments()
     *
     * @param array       $input
     * @param string      $user
     * @param null|string $password
     * @param string      $output
     */
    public function testUserInfoConstructionFromArray($input, $user, $password, $output)
    {
        $userInfo = UserInfo::fromArray($input);

        $this->assertSame($user, $userInfo->getUser());
        $this->assertSame($password, $userInfo->getPassword());
        $this->assertSame($output, $userInfo->toString());
        $this->assertSame($output, $userInfo->__toString());
    }

    /**
     * Provide constructor array arguments.
     *
     * @return array
     */
    public function provideConstructorArrayArguments()
    {
        return [
            [[], '', null, ''],
            [['user' => 'username'], 'username', null, 'username'],
            [['pass' => 'password'], '', null, ''],
            [['user' => 'username', 'pass' => 'password'], 'username', 'password', 'username:password']
        ];
    }

    /**
     * Test user info construction from array throws exception.
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
        UserInfo::fromArray($input);
    }

    /**
     * Provide invalid constructor array arguments.
     *
     * @return array
     */
    public function provideInvalidConstructorArrayArguments()
    {
        return [
            [['user' => false]],
            [['user' => 'username', 'pass' => false]]
        ];
    }

    /**
     * Test user info construction from string.
     *
     * @dataProvider provideConstructorStringArguments()
     *
     * @param string      $input
     * @param string      $user
     * @param null|string $password
     * @param string      $output
     */
    public function testUserInfoConstructionFromString($input, $user, $password, $output)
    {
        $userInfo = UserInfo::fromString($input);

        $this->assertSame($user, $userInfo->getUser());
        $this->assertSame($password, $userInfo->getPassword());
        $this->assertSame($output, $userInfo->toString());
        $this->assertSame($output, $userInfo->__toString());
    }

    /**
     * Provide constructor string arguments.
     *
     * @return array
     */
    public function provideConstructorStringArguments()
    {
        return [
            ['', '', null, ''],
            ['username', 'username', null, 'username'],
            [':password', '', null, ''],
            ['username:password', 'username', 'password', 'username:password']
        ];
    }
}
