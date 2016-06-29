<?php
/**
 * This file is part of the Uri package.
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\Uri\Component;

/**
 * Query component class.
 *
 * @package GravityMedia\Uri\Component
 */
class Query implements \ArrayAccess
{
    /**
     * @var array
     */
    protected $query;

    /**
     * Create query from array.
     *
     * @param array $array
     *
     * @return Query
     */
    public static function fromArray(array $array = [])
    {
        $query = new static();
        $query->query = $array;

        return $query;
    }

    /**
     * Create query from string.
     *
     * @param string $string
     *
     * @return Query
     */
    public static function fromString($string)
    {
        $query = new static();
        parse_str($string, $query->query);

        return $query;
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
     * Convert query into a string representation
     *
     * @return string
     */
    public function toString()
    {
        return http_build_query($this->query);
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        return isset($this->query[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        return isset($this->query[$offset]) ? $this->query[$offset] : null;
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        if (null === $offset) {
            $this->query[] = $value;
        } else {
            $this->query[$offset] = $value;
        }
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        unset($this->query[$offset]);
    }
}
