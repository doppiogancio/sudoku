<?php

use core\Coordinate\Coordinate;


class CoordinateTest extends PHPUnit_Framework_TestCase
{
    public function testCoordinate()
    {
        $row = 4;
        $column = 5;

        $coordinate = new Coordinate($row, $column);

        $this->assertEquals($row, $coordinate->getRow());
        $this->assertEquals($column, $coordinate->getColumn());
    }
}
