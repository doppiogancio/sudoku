<?php

use core\Set\Set;
use core\Cell\Cell;
use core\Coordinate\Coordinate;
use core\Set\Region;


class RegionTest extends PHPUnit_Framework_TestCase
{
	public function regionProvider()
	{
		return [
			[ 1, 3, 1 ],
			[ 1, 4, 2 ],
			[ 1, 9, 3 ],
			[ 5, 3, 4 ],
			[ 4, 5, 5 ],
			[ 6, 7, 6 ],
			[ 9, 1, 7 ],
			[ 8, 6, 8 ],
			[ 9, 9, 9 ]
		];
	}

	static public function getIdByCoordinate($row, $column)
	{
		$width = 3;

		$x = ceil($row / $width);
		$y = ceil($column / $width);

		return $y + 3 * ($x - 1);
	}

	/**
	 * @dataProvider regionProvider
	 */
	public function testGetID($row, $column, $expectedRegion)
	{
		$this->assertEquals($expectedRegion, self::getIdByCoordinate($row, $column));
	}

	public function testLineOfCandidates()
    {
        $region7 = new Region();

        $cell71 = new Cell(new Coordinate(7, 1));
        $cell81 = new Cell(new Coordinate(8, 1));
        $cell91 = new Cell(new Coordinate(9, 1));

        $cell72 = new Cell(new Coordinate(7, 2));
        $cell82 = new Cell(new Coordinate(8, 2));
        $cell92 = new Cell(new Coordinate(9, 2));

        $cell73 = new Cell(new Coordinate(7, 3));
        $cell83 = new Cell(new Coordinate(8, 3));
        $cell93 = new Cell(new Coordinate(9, 3));

        $region7->addCell($cell71);
        $region7->addCell($cell81);
        $region7->addCell($cell91);

        $region7->addCell($cell72);
        $region7->addCell($cell82);
        $region7->addCell($cell92);

        $region7->addCell($cell73);
        $region7->addCell($cell83);
        $region7->addCell($cell93);

        $cell71->setValue(1);
        $cell81->setValue(2);
        $cell91->setValue(3);

        $cell92->setValue(6);

        $cell73->setValue(7);
        $cell83->setValue(8);
        $cell93->setValue(9);


        foreach ($region7->getCells() as $cell) {
            print_r($cell->getCandidates());
        }

    }
}