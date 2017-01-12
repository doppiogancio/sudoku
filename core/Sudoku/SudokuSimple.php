<?php

namespace core\Sudoku;


class SudokuSimple extends Sudoku {
	public function __construct()
	{
		parent::__construct();

		$text = "_2__9_86_
		8_______3
		693__8__2
		__7284_3_
		____6__8_
		5__3__2_7
		_74__56_9
		__89_215_
		_5_6_____";

		$this->initFromString($text);
	}
}