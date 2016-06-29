<?php
/**
 * This file is part of the Uri project.
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\UriTest\Component;

use GravityMedia\Uri\Component\Query;

/**
 * Query test class.
 *
 * @package GravityMedia\UriTest\Component
 *
 * @covers  GravityMedia\Uri\Component\Query
 */
class QueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test query construction.
     */
    public function testQueryConstruction()
    {
        $query = new Query();

        $this->assertFalse(isset($query['argument']));
        $this->assertEquals(null, $query['argument']);

        $query[] = 'value';
        $this->assertEquals('value', $query[0]);

        unset($query[0]);

        $this->assertFalse(isset($query[0]));
        $this->assertEquals(null, $query[0]);
    }

    /**
     * Test query construction from array.
     */
    public function testQueryConstructionFromArray()
    {
        $query = Query::fromArray(['argument' => 'value']);

        $this->assertTrue(isset($query['argument']));
        $this->assertEquals('value', $query['argument']);

        unset($query['argument']);

        $this->assertFalse(isset($query['argument']));
        $this->assertEquals(null, $query['argument']);
    }

    /**
     * Test query construction from string.
     */
    public function testQueryConstructionFromString()
    {
        $query = Query::fromString('argument=value');

        $this->assertTrue(isset($query['argument']));
        $this->assertEquals('value', $query['argument']);

        unset($query['argument']);

        $this->assertFalse(isset($query['argument']));
        $this->assertEquals(null, $query['argument']);
    }
}
