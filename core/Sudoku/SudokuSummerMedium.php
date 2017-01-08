<?php

namespace core\Sudoku;


class SudokuSummerMedium extends Sudoku {
	public function __construct()
	{
		parent::__construct();

		$text = "____6_45_
		___48__2_
		_3___7__1
		_14_____7
		__5___3_6
		6__5___9_
		__3_7____
		_8______4
		___2___3_";

		$this->initFromString($text);

		// Extra
		//$this->setValue(3, 4, 1);
		//$this->setValue(7, 2, 7);

		$this->processQueue();


	}
}