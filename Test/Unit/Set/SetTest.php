<?php

use core\Set\Set;
use core\Cell\Cell;
use core\Coordinate\Coordinate;

class SetTest extends PHPUnit_Framework_TestCase
{
	public function testDelCazzo()
	{
		$this->assertEquals(1,1);
	}

	public function atestAddCells()
	{
		$set = new \core\Set\Region();

		$cell15 = new Cell(new Coordinate(1, 5));
		$cell36 = new Cell(new Coordinate(3, 6));

		$set->addCell($cell15);
		$set->addCell($cell36);


		$this->assertEquals($set->getCells(), [
			$cell15,
			$cell36,
			3
		]);

		return $set;
	}

	/**
	 * @param Set $set
	 *
	 * @depends testAddCell
	 */
	public function atestDeleteCell(Set $set)
	{
		$cells = $set->getCells();
		$set->removeCell($cells[0]);

		$this->assertEquals($set->getCells(), [
			1 => $cells[1]
		]);
	}

	public function testCellSetValue()
	{
		$set = new Set();

		$cell15 = new Cell(new Coordinate(1, 5));
		$cell36 = new Cell(new Coordinate(3, 6));
		$cell42 = new Cell(new Coordinate(4, 2));

		$set->addCell($cell15);
		$set->addCell($cell36);
		$set->addCell($cell42);

		$cell36->setValue(3);

		$setCells = $set->getCells();

		$this->assertEquals($cell15->getCoordinate()->getRow(), $setCells[0]->getCoordinate()->getRow());
		$this->assertEquals($cell15->getCoordinate()->getColumn(), $setCells[0]->getCoordinate()->getColumn());
		$this->assertEquals($cell42->getCoordinate()->getRow(), $setCells[2]->getCoordinate()->getRow());
		$this->assertEquals($cell42->getCoordinate()->getColumn(), $setCells[2]->getCoordinate()->getColumn());
	}
}