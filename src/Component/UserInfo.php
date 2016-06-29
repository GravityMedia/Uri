<?php
/**
 * This file is part of the Uri package.
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\Uri\Component;

/**
 * User info component class.
 *
 * @package GravityMedia\Uri\Component
 */
class UserInfo
{
    /**
     * The user.
     *
     * @var null|string
     */
    protected $user;

    /**
     * The password.
     *
     * @var null|string
     */
    protected $password;

    /**
     * Create user info from array.
     *
     * @param array $array
     *
     * @return UserInfo
     * @throws \InvalidArgumentException
     */
    public static function fromArray(array $array = [])
    {
        $userInfo = new static();

        if (!isset($array['user'])) {
            return $userInfo;
        }

        try {
            $userInfo = $userInfo->withUser($array['user']);
            if (isset($array['pass'])) {
                $userInfo = $userInfo->withPassword($array['pass']);
            }
        } catch (\InvalidArgumentException $exception) {
            throw new \InvalidArgumentException('Invalid array argument', 0, $exception);
        }

        return $userInfo;
    }

    /**
     * Create user info from string.
     *
     * @param string $string
     *
     * @return UserInfo
     */
    public static function fromString($string)
    {
        $array = explode(':', $string, 2);

        if (strlen($array[0]) > 0) {
            $array['user'] = $array[0];
        }

        if (isset($array[1])) {
            $array['pass'] = $array[1];
        }

        return static::fromArray($array);
    }

    /**
     * Return string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Convert user info into a string representation.
     *
     * @return string
     */
    public function toString()
    {
        $userInfo = $this->user;
        if (null === $userInfo) {
            return '';
        }

        if (null !== $this->password) {
            $userInfo .= ':' . $this->password;
        }

        return $userInfo;
    }

    /**
     * Get user.
     *
     * If no user is present, an empty string will be returned.
     *
     * @return string
     */
    public function getUser()
    {
        if (null === $this->user) {
            return '';
        }

        return $this->user;
    }

    /**
     * Return an instance with the specified user.
     *
     * @param string $user
     *
     * @return UserInfo
     */
    public function withUser($user)
    {
        if (!is_string($user)) {
            throw new \InvalidArgumentException('Invalid user argument');
        }

        $userInfo = clone $this;
        $userInfo->user = $user;

        return $userInfo;
    }

    /**
     * Get password.
     *
     * @return null|string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Return an instance with the specified password.
     *
     * @param null|string $password
     *
     * @return UserInfo
     */
    public function withPassword($password = null)
    {
        if (null !== $password && !is_string($password)) {
            throw new \InvalidArgumentException('Invalid password argument');
        }

        $userInfo = clone $this;
        $userInfo->password = $password;

        return $userInfo;
    }
}
