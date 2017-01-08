<?php

namespace core\Sudoku;


class SudokuSummerHard extends Sudoku {
	public function __construct()
	{
		parent::__construct();

		$text = "___7_2___
		___59__27
		2_3_____1
		____18___
		68_______
		_______93
		___92__3_
		8_7____15
		_32______";

		$this->initFromString($text);

		// Extra
		// TODO: far diventare questi numeri una strategia
		$this->setValue(3, 4, 1);
		/*
		$this->setValue(7, 3, 2);

		$this->setValue(7, 6, 1);
		$this->setValue(8, 6, 7);
		$this->setValue(9, 3, 7);
		$this->setValue(9, 5, 6);
		*/

		$this->processQueue();
	}
}