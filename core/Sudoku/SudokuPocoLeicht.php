<?php

namespace core\Sudoku;


class SudokuPocoLeicht extends Sudoku {
	public function __construct()
	{
		parent::__construct();

		$text = "_8_____2_
		_5_8_3_7_
		1___6___9
		_976_154_
		_4_____9_
		_654_273_
		9___7___8
		_7_2_4_6_
		_1_____5_";

		$this->initFromString($text);
	}
}