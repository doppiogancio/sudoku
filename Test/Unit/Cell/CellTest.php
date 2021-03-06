<?php

use core\Cell\Cell;
use core\Coordinate\Coordinate;

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
	 * @depends testDeleteCandidate
	 *
	 * @param Cell $cell
	 *
	 */
	public function testDeleteLastCandidate(Cell $cell)
	{
		$cell->deleteCandidate(3);
		$cell->deleteCandidate(5);

		$cell->deleteCandidate(8);
	}

    /**
     * @param Cell $cell
     */
    public function testSetWrongValue()
    {
	    $cell = new Cell(new Coordinate(7, 8));
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
	    $row = 1;
	    $column = 2;
	    $value = 5;

	    $cell = new Cell(new Coordinate($row, $column));
        $cell->setValue($value);

        $this->assertEquals($value, $cell->getValue());
        $this->assertEquals([], $cell->getCandidates());
    }


}
