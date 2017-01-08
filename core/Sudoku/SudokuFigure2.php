<?php

namespace core\Sudoku;


class SudokuFigure2 extends Sudoku {
	public function __construct()
	{
		parent::__construct();

		$this->setValues([
			[1, 1, 3],
			[9, 1, 4],
			[8, 1, 9],

			[6, 2, 1],
			[8, 2, 5],
			[5, 2, 6],
			[3, 2, 8],

			[7, 3, 3],
			[6, 3, 5],
			[1, 3, 7],

			[3, 4, 2],
			[4, 4, 3],
			[9, 4, 5],

			[5, 5, 4],
			[4, 5, 6],

			[1, 6, 5],
			[4, 6, 7],
			[2, 6, 8],

			//Sette
			[5, 7, 3],
			[7, 7, 5],
			[9, 7, 7],

			[1, 8, 2],
			[8, 8, 4],
			[4, 8, 5],
			[7, 8, 9],

			[7, 9, 1],
			[9, 9, 6],
			[2, 9, 7],
		]);

		//print_r($this->q);
		$this->processQueue();
		//print_r($this->q);
	}
}