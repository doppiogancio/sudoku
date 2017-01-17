<?php

namespace core\Set;

class Row extends Set
{
	static $instance = [];

	/**
	 * @param $number
	 *
	 * @return Row
	 */
	static public function get($number)
	{
		if (empty(self::$instance[$number])) {
			self::$instance[$number] = new Row($number);
		}

		return self::$instance[$number];
	}
}