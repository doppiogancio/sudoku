<?php

namespace core\Set;

use core\Coordinate\Coordinate;

class Region extends Set
{
	static public function getOriginByPosition($position)
	{
		return new Coordinate(
			ceil(($position-1)/3),
			ceil($position/3)
		);
	}

	static public function getIdByCoordinate($row, $column)
	{
		$width = 3;

		$x = ceil($row / $width);
		$y = ceil($column / $width);

		return $y + 3 * ($x - 1);
	}
}