<?php
/**
 * This file is part of the Uri project.
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\UriTest\Query;

use GravityMedia\Uri\AbstractQuery;

/**
 * Test query class.
 *
 * @package GravityMedia\UriTest\Query
 */
class TestQuery extends AbstractQuery
{
    /**
     * The argument.
     *
     * @var mixed
     */
    protected $argument;

    /**
     * Another argument.
     *
     * @var mixed
     */
    protected $anotherArgument;

    /**
     * Get argument.
     *
     * @return mixed
     */
    public function getArgument()
    {
        return $this->argument;
    }

    /**
     * Set argument.
     *
     * @param mixed $argument
     *
     * @return $this
     */
    public function setArgument($argument)
    {
        $this->argument = $argument;

        return $this;
    }

    /**
     * Get another argument
     *
     * @return mixed
     */
    public function getAnotherArgument()
    {
        return $this->anotherArgument;
    }

    /**
     * Set another argument
     *
     * @param mixed $anotherArgument
     *
     * @return $this
     */
    public function setAnotherArgument($anotherArgument)
    {
        $this->anotherArgument = $anotherArgument;

        return $this;
    }
}
