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

		$this->processQueue();

		// Extra
		$this->setValue(6, 1, 9);
		$this->setValue(6, 3, 3);
		$this->setValue(7, 3, 1);

		//print_r($this->q);

		//print_r($this->q);
	}
}