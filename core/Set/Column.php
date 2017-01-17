<?php

namespace core\Set;

class Column extends Set
{
	static $instance = [];

	/**
	 * @param $number
	 *
	 * @return Column
	 */
	static public function get($number)
	{
		if (empty(self::$instance[$number])) {
			self::$instance[$number] = new Column($number);
		}

		return self::$instance[$number];
	}
}