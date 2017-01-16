<?php

namespace core\Sudoku;

use core\Cell\Cell;

class SudokuSummerExpert extends Sudoku
{
	public function __construct()
	{
		parent::__construct();

		$text = "__6_____4
		___86_73_
		_4_35___2
		17_4__6__
		_9_____8_
		__8__6_17
		2___81_4_
		_67_43___
		8_____3__";


		$text = "_____1___
		1_____356
		2__4_3___
		_1_______
		___1__562
		47_6_____
		__9_3____
		_3__5_2__
		__5__9__7";

		$this->initFromString($text);

		Cell::getInstance(2,2)->setValue(8);
	}
}