<?php
/**
 * Created by PhpStorm.
 * User: fabrizio.gargiulo
 * Date: 11/01/17
 * Time: 16:32
 */


use core\Cell\Cell;
use core\Coordinate\Coordinate;
use core\Exception\WrongValueException;

class CellTest extends PHPUnit_Framework_TestCase
{
    public function testCellDefaults()
    {
        $row = 1;
        $column = 2;
        $candidate = 3;

        $cell = new Cell(new Coordinate($row, $column));

        $this->assertEquals(range(1,9), array_values($cell->getCandidates()));
        $this->assertEquals(9, $cell->countCandidates());
        $this->assertTrue($cell->hasCandidates());
        $this->assertTrue($cell->hasCandidate($candidate));

        $this->assertEquals(SUDOKU_DEFAULT_CELL_VALUE, $cell->getValue());
        $this->assertFalse($cell->hasValue());


        $this->assertEquals($row, $cell->getCoordinate()->getRow());
        $this->assertEquals($column, $cell->getCoordinate()->getColumn());

        return $cell;
    }

    /**
     * @depends testCellDefaults
     *
     * @param Cell $cell
     *
     * @return Cell
     */
    public function testDeleteCandidate(Cell $cell)
    {
        $cell->deleteCandidate(9);

        $this->assertEquals(range(1,8), $cell->getCandidates());

        $cell->deleteCandidate(1);
        $cell->deleteCandidate(2);

        $this->assertEquals(range(3,8), array_values($cell->getCandidates()));

        $cell->deleteCandidate(4);
        $cell->deleteCandidate(6);
        $cell->deleteCandidate(7);

        $this->assertEquals([3,5,8], array_values($cell->getCandidates()));

        return $cell;
    }

    /**
     * @depends testCellDefaults
     * @param Cell $cell
     * @expectedException \core\Exception\WrongValueException
     */
    public function testSetWrongValue(Cell $cell)
    {
        $cell->setValue(1);

        $this->assertEquals(1, $cell->getValue());
        $this->assertEquals([], $cell->getCandidates());
    }

    /**
     * @depends testCellDefaults
     *
     * @param Cell $cell
     */
    public function testSetValue(Cell $cell)
    {
        $cell->setValue(5);

        $this->assertEquals(5, $cell->getValue());
        $this->assertEquals([], $cell->getCandidates());
    }


}
