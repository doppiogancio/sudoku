<?php

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
}