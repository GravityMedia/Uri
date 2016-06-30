<?php
/**
 * This file is part of the Uri project.
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\UriTest;

use GravityMedia\UriTest\Query\TestQuery;

/**
 * Query component test class.
 *
 * @package GravityMedia\UriTest
 *
 * @covers  GravityMedia\Uri\AbstractQuery
 */
class QueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test setting query arguments via setter.
     */
    public function testSettingQueryArgumentsViaSetter()
    {
        $query = new TestQuery();
        $query->setArgument('value');
        $query->setAnotherArgument('another value');

        $this->assertSame('value', $query->getArgument());
        $this->assertSame('another value', $query->getAnotherArgument());
        $this->assertSame('value', $query->argument);
        $this->assertSame('another value', $query->another_argument);
        $this->assertSame('argument=value&another_argument=another+value', (string)$query);
    }

    /**
     * Test setting query arguments via properties.
     */
    public function testSettingQueryArgumentsViaProperties()
    {
        $query = new TestQuery();
        $query->argument = 'value';
        $query->another_argument = 'another value';

        $this->assertSame('value', $query->getArgument());
        $this->assertSame('another value', $query->getAnotherArgument());
        $this->assertSame('value', $query->argument);
        $this->assertSame('another value', $query->another_argument);
        $this->assertSame('argument=value&another_argument=another+value', (string)$query);
    }

    /**
     * Test getting unknown query argument.
     */
    public function testGettingUnknownQueryArgument()
    {
        $query = new TestQuery();

        $this->assertFalse(isset($query->foo));
        $this->assertNull($query->foo);
    }

    /**
     * Test query argument removal.
     */
    public function testQueryArgumentRemoval()
    {
        $query = TestQuery::fromString('argument=value');

        $this->assertSame('value', $query->getArgument());

        unset($query->argument);

        $this->assertFalse(isset($query->argument));
        $this->assertNull($query->argument);

        $query->setArgument(null);

        $this->assertFalse(isset($query->argument));
        $this->assertNull($query->argument);
    }
}
