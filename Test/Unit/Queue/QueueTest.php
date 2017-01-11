<?php
/**
 * Created by PhpStorm.
 * User: fabrizio.gargiulo
 * Date: 11/01/17
 * Time: 16:11
 */

use core\Queue\Queue;
use core\Cell\Cell;
use core\Coordinate\Coordinate;

class QueueTest extends \PHPUnit_Framework_TestCase
{
    public function testIsEmpty()
    {
        $q = new Queue();

        $this->assertEquals(true, $q->isEmpty());
    }

    public function testPushCell()
    {
        define('SUDOKU_DEFAULT_CELL_VALUE', '_');

        $q = new Queue();
        $cell = new Cell(new Coordinate(1,1));

        $q->push($cell);

        $this->assertEquals(true, !$q->isEmpty());
    }
}
