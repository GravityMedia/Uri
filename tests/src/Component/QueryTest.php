<?php
/**
 * This file is part of the Uri project
 *
 * @author Daniel Schröder <daniel.schroeder@gravitymedia.de>
 */

namespace GravityMedia\UriTest\Component;
use GravityMedia\Uri\Component\Query;

/**
 * Query test
 *
 * @package GravityMedia\UriTest\Component
 */
class QueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test query construction
     */
    public function testQueryConstruction()
    {
        $query = new Query();

        $this->assertFalse(isset($query['argument']));
        $this->assertEquals(null, $query['argument']);
    }

    /**
     * Test query construction from traversable
     */
    public function testQueryConstructionFromTraversable()
    {
        $query = new Query(new \ArrayObject(array('argument' => 'value')));

        $this->assertTrue(isset($query['argument']));
        $this->assertEquals('value', $query['argument']);

        unset($query['argument']);

        $this->assertFalse(isset($query['argument']));
        $this->assertEquals(null, $query['argument']);
    }

    /**
     * Test query construction from array
     */
    public function testQueryConstructionFromArray()
    {
        $query = new Query(array('argument' => 'value'));

        $this->assertTrue(isset($query['argument']));
        $this->assertEquals('value', $query['argument']);

        unset($query['argument']);

        $this->assertFalse(isset($query['argument']));
        $this->assertEquals(null, $query['argument']);
    }

    /**
     * Test query construction from string
     */
    public function testQueryConstructionFromString()
    {
        $query = new Query('argument=value');

        $this->assertTrue(isset($query['argument']));
        $this->assertEquals('value', $query['argument']);

        unset($query['argument']);

        $this->assertFalse(isset($query['argument']));
        $this->assertEquals(null, $query['argument']);
    }
}
