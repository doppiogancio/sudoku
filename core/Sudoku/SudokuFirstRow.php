<?php

namespace core\Sudoku;


class SudokuFirstRow extends Sudoku {
	public function __construct()
	{
		parent::__construct();

		$this->setValues([
			[9, 1, 1],
			[7, 1, 2],
			[1, 1, 3],

			[2, 1, 4],
			[4, 1, 5],
			[3, 1, 6],

			[5, 1, 7],
			[8, 1, 8],

		]);
	}
}