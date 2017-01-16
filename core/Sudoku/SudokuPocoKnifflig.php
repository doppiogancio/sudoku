<?php

namespace core\Sudoku;


class SudokuPocoKnifflig extends Sudoku {
	public function __construct()
	{
		parent::__construct();

		$text = "______7__
		__8476_2_
		_____5_84
		9______4_
		_71___36_
		_6______5
		69_8_____
		_8_5346__
		__7______";

		//26

		$this->initFromString($text);

		// Extra
		$this->getCell(1, 9)->setValue(6);
		$this->getCell(3, 3)->setValue(6);
		$this->getCell(3, 1)->setValue(7);
	}
}