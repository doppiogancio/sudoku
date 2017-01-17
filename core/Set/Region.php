<?php

namespace core\Set;

use core\Coordinate\Coordinate;


class Region extends Set
{
	static $instance = [];

	/**
	 * @param $number
	 *
	 * @return Region
	 */
	static public function get($number)
	{
		if (empty(self::$instance[$number])) {
			self::$instance[$number] = new Region($number);
		}

		return self::$instance[$number];
	}

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