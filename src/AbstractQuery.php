<?php
/**
 * This file is part of the Uri package.
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\Uri;

/**
 * Abstract query component class.
 *
 * @package GravityMedia\Uri
 */
abstract class AbstractQuery
{
    /**
     * Create query object from array.
     *
     * @param array $array
     *
     * @return static
     */
    public static function fromArray(array $array = [])
    {
        $query = new static();
        foreach ($array as $argument => $value) {
            $query->__set($argument, $value);
        }

        return $query;
    }

    /**
     * Create query object from string.
     *
     * @param string $string
     *
     * @return static
     */
    public static function fromString($string)
    {
        $array = [];
        parse_str($string, $array);

        return static::fromArray($array);
    }

    /**
     * Set a query argument.
     *
     * @param string $argument
     * @param mixed  $value
     */
    public function __set($argument, $value)
    {
        $setter = 'set' . str_replace('_', '', $argument);
        if (is_callable([$this, $setter])) {
            call_user_func([$this, $setter], $value);
        }
    }

    /**
     * Get a query argument.
     *
     * @param string $argument
     *
     * @return mixed
     */
    public function __get($argument)
    {
        $getter = 'get' . str_replace('_', '', $argument);
        if (is_callable([$this, $getter])) {
            return call_user_func([$this, $getter]);
        }

        return null;
    }

    /**
     * Test if a query argument is NULL.
     *
     * @param string $argument
     *
     * @return bool
     */
    public function __isset($argument)
    {
        $getter = 'get' . str_replace('_', '', $argument);
        if (!method_exists($this, $getter)) {
            return false;
        }

        return null !== $this->__get($argument);
    }

    /**
     * Set a query argument to NULL.
     *
     * @param string $argument
     */
    public function __unset($argument)
    {
        $this->__set($argument, null);
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
     * Convert query into a string representation.
     *
     * @return string
     */
    public function toString()
    {
        return http_build_query($this->toArray());
    }

    /**
     * Convert query into a array representation.
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this as $argument => $value) {
            $normalizedArgument = preg_replace_callback('/([A-Z])/', function ($letters) {
                $letter = array_shift($letters);

                return '_' . strtolower($letter);
            }, $argument);

            $array[$normalizedArgument] = $value;
        }

        return $array;
    }
}
