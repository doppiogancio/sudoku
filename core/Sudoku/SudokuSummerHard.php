<?php

namespace core\Sudoku;


class SudokuSummerHard extends Sudoku {
	public function __construct()
	{
		parent::__construct();

		$text = "_9____1__
		7_______3
		_6______4
		__2_518__
		_3___6__9
		___4___1_
		__85_____
		1___84_9_
		_2__3___1";

		$this->initFromString($text);
	}
}