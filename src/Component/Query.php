<?php
/**
 * This file is part of the Uri package
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\Uri\Component;

/**
 * Query component
 *
 * @package GravityMedia\Uri\Component
 */
class Query implements \ArrayAccess, \Countable, \Serializable
{
    /**
     * @var array
     */
    protected $query;

    /**
     * Create query
     *
     * @param string|array|\Traversable $query
     */
    public function __construct($query = array())
    {
        if ($query instanceof \Traversable) {
            $query = iterator_to_array($query, true);
        }

        if (is_array($query)) {
            $this->query = $query;
        } else {
            $this->unserialize($query);
        }
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
        return $this->serialize();
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
        if (is_null($offset)) {
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

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->query);
    }

    /**
     * @inheritdoc
     */
    public function serialize()
    {
        return http_build_query($this->query);
    }

    /**
     * @inheritdoc
     */
    public function unserialize($serialized)
    {
        $this->query = array();
        parse_str($serialized, $this->query);
    }
}
